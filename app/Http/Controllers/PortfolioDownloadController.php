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
        $placeholders = [];
        
        // Extract standard fields
        $data = $portfolio->toArray();
        $dynamicFields = $data['dynamic_fields'] ?? [];
        
        // Merge them together, prioritizing dynamic_fields
        $merged = array_merge($data, $dynamicFields);
        
        foreach ($merged as $key => $value) {
            if (is_string($value) || is_numeric($value)) {
                $placeholders[strtoupper($key)] = e((string) $value);
            }
        }

        // Special handling for initials
        $name = $merged['full_name'] ?? 'P F';
        $nameParts = explode(' ', trim($name));
        $initials = '';
        if (count($nameParts) >= 2) {
            $initials = strtoupper(substr($nameParts[0], 0, 1) . '.' . substr($nameParts[count($nameParts)-1], 0, 1));
        } else {
            $initials = strtoupper(substr($name, 0, 2));
        }
        $placeholders['FULL_NAME_INITIALS'] = $initials;

        // Add basic HTML for backward compatibility (skills/projects)
        $skillsHtml = '';
        $skills = $merged['skills'] ?? [];
        if (is_array($skills)) {
            foreach ($skills as $skill) {
                $skillText = is_string($skill) ? $skill : json_encode($skill);
                $skillsHtml .= '<span class="inline-block px-3 py-1 bg-opacity-20 bg-gray-500 rounded-full text-sm mr-2 mb-2">' . e($skillText) . '</span>';
            }
        }
        $placeholders['SKILLS_HTML'] = $skillsHtml;

        $projectsHtml = '';
        $projects = $merged['projects'] ?? [];
        if (is_array($projects)) {
            foreach ($projects as $project) {
                if (is_array($project)) {
                    $name = $project['name'] ?? '';
                    $desc = $project['description'] ?? '';
                    $link = $project['link'] ?? '';
                    $projectsHtml .= '<div style="margin-bottom: 20px; padding: 15px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px;">';
                    $projectsHtml .= '<h3 style="font-weight:bold; margin-bottom:10px;">' . e($name) . '</h3>';
                    $projectsHtml .= '<p style="opacity:0.8; font-size:14px; margin-bottom:10px;">' . e($desc) . '</p>';
                    if ($link) {
                        $projectsHtml .= '<a href="' . e($link) . '" target="_blank" style="color: inherit; text-decoration: underline;">View Project</a>';
                    }
                    $projectsHtml .= '</div>';
                }
            }
        }
        $placeholders['PROJECTS_HTML'] = $projectsHtml;

        return $placeholders;
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
