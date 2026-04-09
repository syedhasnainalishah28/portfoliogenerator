<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class PortfolioDownloadController extends Controller
{
    public function download(Request $request, Portfolio $portfolio)
    {
        if ((int) $portfolio->user_id !== (int) $request->user()->id) {
            abort(403);
        }

        if (!class_exists(ZipArchive::class)) {
            return response()->json(['message' => 'ZIP extension is unavailable on server.'], 500);
        }

        $token = Str::uuid()->toString();
        $baseTempPath = storage_path("app/temp");
        if (!is_dir($baseTempPath)) mkdir($baseTempPath, 0775, true);

        $buildPath = $baseTempPath . DIRECTORY_SEPARATOR . "portfolio-{$portfolio->id}-{$token}";
        $templateSourcePath = resource_path("templates/" . $portfolio->template_key);

        if (!is_dir($templateSourcePath)) {
            // Fallback for user's existing template directory if not in resouces
            $templateSourcePath = base_path($portfolio->template_key);
            if (!is_dir($templateSourcePath)) {
                // Hard fallback to template_1 if everything fails
                $templateSourcePath = resource_path("templates/template_1");
            }
        }

        // 1. Recursive Copy Template to Build Path
        $this->recursiveCopy($templateSourcePath, $buildPath);

        // 2. Prepare Assets (Hero Image)
        $assetsPath = $buildPath . DIRECTORY_SEPARATOR . 'assets';
        if (!is_dir($assetsPath)) mkdir($assetsPath, 0775, true);
        
        if ($portfolio->hero_image_path && Storage::disk('public')->exists($portfolio->hero_image_path)) {
            $imageContent = Storage::disk('public')->get($portfolio->hero_image_path);
            file_put_contents($assetsPath . DIRECTORY_SEPARATOR . 'hero.jpg', $imageContent);
        }

        // 3. Process All HTML files and Replace Placeholders
        $placeholders = $this->getPlaceholders($portfolio);
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($buildPath));
        foreach ($files as $file) {
            if ($file->isFile() && $file->getExtension() === 'html') {
                $content = file_get_contents($file->getRealPath());
                foreach ($placeholders as $key => $value) {
                    $content = str_replace("[[{$key}]]", $value, $content);
                }
                file_put_contents($file->getRealPath(), $content);
            }
        }

        // 4. Create ZIP
        $zipPath = $baseTempPath . DIRECTORY_SEPARATOR . "portfolio-{$portfolio->id}-{$token}.zip";
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($buildPath), \RecursiveIteratorIterator::LEAVES_ONLY);
            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($buildPath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
        }

        // 5. Cleanup temp folder (optional but recommended)
        // Note: deleteFileAfterSend handles the zip, but we should clean the directory manually or via a job
        
        return response()->download($zipPath, "portfolio-{$portfolio->id}.zip")->deleteFileAfterSend(true);
    }

    private function getPlaceholders(Portfolio $portfolio): array
    {
        $nameParts = explode(' ', trim($portfolio->full_name));
        $initials = '';
        if (count($nameParts) >= 2) {
            $initials = strtoupper(substr($nameParts[0], 0, 1) . '.' . substr($nameParts[count($nameParts)-1], 0, 1));
        } else {
            $initials = strtoupper(substr($portfolio->full_name, 0, 2));
        }

        $skillsHtml = '';
        foreach ($portfolio->skills as $skill) {
            $skillsHtml .= '<div class="glass-panel px-4 py-3 rounded-xl border border-white/10 hover:border-primary/50 transition-all flex items-center justify-center text-center group">
                <span class="text-sm font-bold tracking-tight group-hover:scale-110 transition-transform">' . e($skill) . '</span>
            </div>';
        }

        $projectsHtml = '';
        foreach ($portfolio->projects as $project) {
            $linkHtml = !empty($project['link']) ? '<a href="' . e($project['link']) . '" target="_blank" class="text-primary font-black uppercase text-[10px] tracking-widest mt-4 inline-block hover:opacity-70">View Project &nearr;</a>' : '';
            $projectsHtml .= '<div class="glass-panel p-8 rounded-[32px] border border-white/5 hover:border-primary/20 transition-all group">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                        <i class="fa-solid fa-folder-open text-xs"></i>
                    </div>
                    <h4 class="text-xl font-black italic tracking-tighter">' . e($project['name']) . '</h4>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">' . e($project['description']) . '</p>
                ' . $linkHtml . '
            </div>';
        }

        return [
            'FULL_NAME' => e($portfolio->full_name),
            'FULL_NAME_INITIALS' => $initials,
            'TITLE' => e($portfolio->title),
            'BIO' => e($portfolio->bio),
            'BIO_EXTENDED' => e($portfolio->bio),
            'EMAIL' => e($portfolio->email),
            'PHONE' => e($portfolio->phone ?? 'Not provided'),
            'WHATSAPP_LINK' => e($portfolio->whatsapp_link ?? '#'),
            'PRIMARY_COLOR' => $portfolio->primary_color,
            'SKILLS_HTML' => $skillsHtml,
            'PROJECTS_HTML' => $projectsHtml,
        ];
    }

    private function recursiveCopy($src, $dst)
    {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ($file = readdir($dir))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recursiveCopy($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
}
