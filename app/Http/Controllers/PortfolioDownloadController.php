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
            $projIdx = 0;
            $projStyles = [
                ['neon-border', '', 'text-neon-cyan', 'from-neon-cyan/20'],
                ['neon-border-green', 'text-neon-green', 'text-neon-green', 'from-neon-green/20'],
                ['neon-border-pink', 'text-neon-pink', 'text-neon-pink', 'from-neon-pink/20'],
            ];
            foreach ($projects as $project) {
                if (is_array($project)) {
                    $name = $project['name'] ?? '';
                    $desc = $project['description'] ?? '';
                    $link = $project['link'] ?? '';
                    
                    if ($portfolio->template_key === 'template_1') {
                        $ps = $projStyles[$projIdx % 3];
                        $border = $ps[0];
                        $badgeTxt = $ps[1] ? $ps[1] : 'text-neon-cyan';
                        $iconClr = $ps[2];
                        $grad = $ps[3];
                        
                        $projectsHtml .= '<div class="' . $border . ' card-hover rounded-xl overflow-hidden bg-dark-800/60 backdrop-blur section-reveal">
          <div class="h-48 bg-gradient-to-br ' . $grad . ' to-dark-900 flex items-center justify-center">
            <i class="fas fa-rocket text-6xl ' . $iconClr . '" style="text-shadow:0 0 20px currentColor"></i>
          </div>
          <div class="p-6">
            <div class="flex items-center justify-between mb-3">
              <span class="' . $badgeTxt . ' font-orbitron text-xs">WEB APP</span>
              <div class="flex gap-2">';
                        if ($link) {
                            $projectsHtml .= '<a href="' . e($link) . '" target="_blank" class="text-gray-500 hover:' . $badgeTxt . ' transition-colors"><i class="fas fa-external-link-alt"></i></a>';
                        }
                        $projectsHtml .= '</div>
            </div>
            <h3 class="font-orbitron text-lg text-white mb-2">' . e($name) . '</h3>
            <p class="text-gray-400 text-sm mb-4">' . e($desc) . '</p>
          </div>
        </div>';
                    } else {
                        // Generic
                        $projectsHtml .= '<div style="margin-bottom: 20px; padding: 15px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px;">';
                        $projectsHtml .= '<h3 style="font-weight:bold; margin-bottom:10px;">' . e($name) . '</h3>';
                        $projectsHtml .= '<p style="opacity:0.8; font-size:14px; margin-bottom:10px;">' . e($desc) . '</p>';
                        if ($link) {
                            $projectsHtml .= '<a href="' . e($link) . '" target="_blank" style="color: inherit; text-decoration: underline;">View Project</a>';
                        }
                        $projectsHtml .= '</div>';
                    }
                    $projIdx++;
                }
            }
        }
        $placeholders['PROJECTS_HTML'] = $projectsHtml;

        // Specialized Template 1 HTML
        $techSkillsHtml = '';
        if ($portfolio->template_key === 'template_1') {
            $techSkills = $merged['tech_skills'] ?? [];
            if (is_array($techSkills)) {
                $colors = [
                    'style="width:%s%%"', 
                    'style="width:%s%%; background:linear-gradient(90deg,#39ff14,#00f5ff)"',
                    'style="width:%s%%; background:linear-gradient(90deg,#bf00ff,#ff006e)"',
                    'style="width:%s%%; background:linear-gradient(90deg,#ff006e,#bf00ff)"'
                ];
                $colorIdx = 0;
                foreach ($techSkills as $skill) {
                    $parts = explode(':', $skill);
                    $name = trim($parts[0] ?? 'Skill');
                    $pct = trim($parts[1] ?? '80');
                    $colorStyle = sprintf($colors[$colorIdx % count($colors)], $pct);
                    $techSkillsHtml .= '<div>
              <div class="flex justify-between mb-2"><span class="text-gray-300 text-sm">' . e($name) . '</span><span class="text-neon-cyan text-sm">' . e($pct) . '%</span></div>
              <div class="w-full bg-dark-700 rounded h-1"><div class="skill-bar" ' . $colorStyle . '></div></div>
            </div>';
                    $colorIdx++;
                }
            }
        }
        $placeholders['TECH_SKILLS_HTML'] = $techSkillsHtml;

        $serviceCardsHtml = '';
        if ($portfolio->template_key === 'template_1') {
            $services = $merged['service_cards'] ?? [];
            if (is_array($services)) {
                $styles = [
                    'neon-border text-neon-cyan', 
                    'neon-border-green text-neon-green', 
                    'neon-border-pink text-neon-pink', 
                    'border border-[#bf00ff] shadow-[0_0_15px_#bf00ff44] text-[#bf00ff]'
                ];
                $shadows = ['#00f5ff', '#39ff14', '#ff006e', '#bf00ff'];
                
                $styleIdx = 0;
                foreach ($services as $service) {
                    $parts = explode('|', $service);
                    $icon = trim($parts[0] ?? 'fas fa-code');
                    $title = trim($parts[1] ?? 'Service');
                    $sub = trim($parts[2] ?? 'Category');
                    
                    $s = $styles[$styleIdx % count($styles)];
                    $sh = $shadows[$styleIdx % count($shadows)];
                    
                    // The first three use specific classes for the border, the 4th uses inline style.
                    // For simplicity, we just apply the class and color.
                    $boxStyle = $styleIdx % 4 === 3 ? 'style="border:1px solid #bf00ff; box-shadow:0 0 15px #bf00ff44"' : '';
                    $iconStyle = $styleIdx % 4 === 3 ? 'style="color:#bf00ff; text-shadow:0 0 15px #bf00ff"' : 'style="text-shadow:0 0 15px ' . $sh . '"';
                    $baseClass = $styleIdx % 4 === 3 ? '' : explode(' ', $s)[0];
                    $textColor = $styleIdx % 4 === 3 ? '' : explode(' ', $s)[1];
                    
                    $serviceCardsHtml .= '<div class="' . $baseClass . ' card-hover rounded-xl p-6 bg-dark-800/60 backdrop-blur text-center section-reveal" ' . $boxStyle . '>
          <i class="' . e($icon) . ' text-5xl ' . $textColor . ' mb-4" ' . $iconStyle . '></i>
          <div class="font-orbitron text-sm text-white">' . e($title) . '</div>
          <div class="text-gray-500 text-xs mt-1">' . e($sub) . '</div>
        </div>';
                    $styleIdx++;
                }
            }
        }
        $placeholders['SERVICE_CARDS_HTML'] = $serviceCardsHtml;
        
        $placeholders['TYPING_TEXTS'] = is_array($merged['typing_texts'] ?? '') ? implode(',', $merged['typing_texts']) : ($merged['typing_texts'] ?? 'Full Stack Developer');

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
