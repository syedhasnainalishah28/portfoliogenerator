<?php

namespace App\Helpers;

use App\Models\Portfolio;
use Illuminate\Support\Facades\Storage;

class TemplateHelper
{
    /**
     * Generates an array of [[PLACEHOLDER]] => replacement values for a specific template.
     */
    public static function buildPlaceholders(string $templateKey, array $fieldsData, ?string $heroImageBase64 = null): array
    {
        $placeholders = [];
        $merged = $fieldsData;
        
        // Ensure defaults from fields.json are present
        $jsonPath = resource_path("templates/{$templateKey}/fields.json");
        if (file_exists($jsonPath)) {
            $manifest = json_decode(file_get_contents($jsonPath), true);
            if (isset($manifest['fields']) && is_array($manifest['fields'])) {
                foreach ($manifest['fields'] as $field) {
                    $name = $field['name'];
                    if (!isset($merged[$name]) || $merged[$name] === null || $merged[$name] === '') {
                        $merged[$name] = $field['default'] ?? '';
                    }
                }
            }
        }
        
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

        // Image Handling
        if ($heroImageBase64) {
            // Usually we'd map this, template 1 image isn't currently dynamic but if it becomes dynamic, here it is.
            $placeholders['HERO_IMAGE_SRC'] = $heroImageBase64;
        }

        // Basic HTML fallback
        $skillsHtml = '';
        $skills = $merged['skills'] ?? [];
        if (is_array($skills)) {
            foreach ($skills as $skill) {
                $skillText = is_string($skill) ? $skill : json_encode($skill);
                $skillsHtml .= '<span class="inline-block px-3 py-1 bg-opacity-20 bg-gray-500 rounded-full text-sm mr-2 mb-2">' . e($skillText) . '</span>';
            }
        }
        $placeholders['SKILLS_HTML'] = $skillsHtml;

        // Generic Projects HTML
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
                    $pName = $project['name'] ?? '';
                    $pDesc = $project['description'] ?? '';
                    $pLink = $project['link'] ?? '';
                    
                    if ($templateKey === 'template_1') {
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
                        if ($pLink) {
                            $projectsHtml .= '<a href="' . e($pLink) . '" target="_blank" class="text-gray-500 hover:' . $badgeTxt . ' transition-colors"><i class="fas fa-external-link-alt"></i></a>';
                        }
                        $projectsHtml .= '</div>
            </div>
            <h3 class="font-orbitron text-lg text-white mb-2">' . e($pName) . '</h3>
            <p class="text-gray-400 text-sm mb-4">' . e($pDesc) . '</p>
          </div>
        </div>';
                    } else {
                        // Generic
                        $projectsHtml .= '<div style="margin-bottom: 20px; padding: 15px; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px;">';
                        $projectsHtml .= '<h3 style="font-weight:bold; margin-bottom:10px;">' . e($pName) . '</h3>';
                        $projectsHtml .= '<p style="opacity:0.8; font-size:14px; margin-bottom:10px;">' . e($pDesc) . '</p>';
                        if ($pLink) {
                            $projectsHtml .= '<a href="' . e($pLink) . '" target="_blank" style="color: inherit; text-decoration: underline;">View Project</a>';
                        }
                        $projectsHtml .= '</div>';
                    }
                    $projIdx++;
                }
            }
        }
        $placeholders['PROJECTS_HTML'] = $projectsHtml;

        // Template 1 Specialized HTML
        $techSkillsHtml = '';
        if ($templateKey === 'template_1') {
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
                    $sName = trim($parts[0] ?? 'Skill');
                    $sPct = trim($parts[1] ?? '80');
                    $colorStyle = sprintf($colors[$colorIdx % count($colors)], $sPct);
                    $techSkillsHtml .= '<div>
              <div class="flex justify-between mb-2"><span class="text-gray-300 text-sm">' . e($sName) . '</span><span class="text-neon-cyan text-sm">' . e($sPct) . '%</span></div>
              <div class="w-full bg-dark-700 rounded h-1"><div class="skill-bar" ' . $colorStyle . '></div></div>
            </div>';
                    $colorIdx++;
                }
            }
        }
        $placeholders['TECH_SKILLS_HTML'] = $techSkillsHtml;

        $serviceCardsHtml = '';
        if ($templateKey === 'template_1') {
            $services = $merged['service_cards'] ?? [];
            
            // Hero badges from service cards (use first 3)
            $placeholders['HERO_BADGE_1'] = 'React';
            $placeholders['HERO_BADGE_2'] = 'Node.js';
            $placeholders['HERO_BADGE_3'] = 'MongoDB';
            
            if (is_array($services)) {
                if (isset($services[0])) { $parts = explode('|', $services[0]); $placeholders['HERO_BADGE_1'] = trim($parts[1] ?? 'React'); }
                if (isset($services[1])) { $parts = explode('|', $services[1]); $placeholders['HERO_BADGE_2'] = trim($parts[1] ?? 'Node.js'); }
                if (isset($services[2])) { $parts = explode('|', $services[2]); $placeholders['HERO_BADGE_3'] = trim($parts[1] ?? 'MongoDB'); }

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
                    $sTitle = trim($parts[1] ?? 'Service');
                    $sub = trim($parts[2] ?? 'Category');
                    
                    $s = $styles[$styleIdx % count($styles)];
                    $sh = $shadows[$styleIdx % count($shadows)];
                    
                    $boxStyle = $styleIdx % 4 === 3 ? 'style="border:1px solid #bf00ff; box-shadow:0 0 15px #bf00ff44"' : '';
                    $iconStyle = $styleIdx % 4 === 3 ? 'style="color:#bf00ff; text-shadow:0 0 15px #bf00ff"' : 'style="text-shadow:0 0 15px ' . $sh . '"';
                    $baseClass = $styleIdx % 4 === 3 ? '' : explode(' ', $s)[0];
                    $textColor = $styleIdx % 4 === 3 ? '' : explode(' ', $s)[1];
                    
                    $serviceCardsHtml .= '<div class="' . $baseClass . ' card-hover rounded-xl p-6 bg-dark-800/60 backdrop-blur text-center section-reveal" ' . $boxStyle . '>
          <i class="' . e($icon) . ' text-5xl ' . $textColor . ' mb-4" ' . $iconStyle . '></i>
          <div class="font-orbitron text-sm text-white">' . e($sTitle) . '</div>
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
}
