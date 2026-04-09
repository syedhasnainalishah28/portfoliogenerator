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
        $data = $portfolio->toArray();
        $dynamicFields = $data['dynamic_fields'] ?? [];
        $merged = array_merge($data, $dynamicFields);
        
        return \App\Helpers\TemplateHelper::buildPlaceholders($portfolio->template_key, $merged);
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
