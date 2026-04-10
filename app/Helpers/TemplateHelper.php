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
                $placeholders[strtoupper($key)] = (string) $value;
            }
        }

        // Global Placeholders Initialization (to prevent raw tags in preview)
        $defaults = [
            'HEADER_LOGO' => $merged['header_logo'] ?? 'PORTFOLIO',
            'BTN_HIRE_ME' => $merged['btn_hire_me'] ?? 'Hire Me',
            'BTN_HIRE_ME_LINK' => $merged['btn_hire_me_link'] ?? '#contact',
            'BTN_VIEW_WORK' => $merged['btn_view_work'] ?? 'View Work',
            'BTN_VIEW_WORK_LINK' => $merged['btn_view_work_link'] ?? '#projects',
            'BTN_GET_IN_TOUCH' => $merged['btn_get_in_touch'] ?? 'Get In Touch',
            'BTN_GET_IN_TOUCH_LINK' => $merged['btn_get_in_touch_link'] ?? '#contact',
            'BTN_ABOUT_ME' => $merged['btn_about_me'] ?? 'About Me',
            'BTN_ABOUT_ME_LINK' => $merged['btn_about_me_link'] ?? '#about',
            'BTN_DOWNLOAD_CV' => $merged['btn_download_cv'] ?? 'Download CV',
            'BTN_DOWNLOAD_CV_LINK' => $merged['btn_download_cv_link'] ?? '#',
            'BTN_SEND_MESSAGE' => $merged['btn_send_message'] ?? 'Send Message',
            'FOOTER_LOGO' => $merged['footer_logo'] ?? ($merged['header_logo'] ?? 'PORTFOLIO'),
            'COPYRIGHT_TEXT' => $merged['copyright_text'] ?? '© ' . date('Y') . ' Portfolio'
        ];
        foreach ($defaults as $ph => $def) {
            $placeholders[$ph] = $placeholders[$ph] ?? $def;
        }

        // Stats Normalization
        $placeholders['STATS_1_VAL'] = $merged['stats_1_val'] ?? ($merged['stats_1_value'] ?? '30+');
        $placeholders['STATS_1_LBL'] = $merged['stats_1_lbl'] ?? ($merged['stats_1_label'] ?? 'Projects');
        $placeholders['STATS_2_VAL'] = $merged['stats_2_val'] ?? ($merged['stats_2_value'] ?? '5yr');
        $placeholders['STATS_2_LBL'] = $merged['stats_2_lbl'] ?? ($merged['stats_2_label'] ?? 'Experience');
        $placeholders['STATS_3_VAL'] = $merged['stats_3_val'] ?? ($merged['stats_3_value'] ?? '20+');
        $placeholders['STATS_3_LBL'] = $merged['stats_3_lbl'] ?? ($merged['stats_3_label'] ?? 'Clients');
        $placeholders['STATS_4_VAL'] = $merged['stats_4_val'] ?? '99%';
        $placeholders['STATS_4_LBL'] = $merged['stats_4_lbl'] ?? 'Satisfaction';

        // Initials / Names
        $name = $merged['full_name'] ?? 'P F';
        $firstName = explode(' ', trim($name))[0];
        $placeholders['FULL_NAME_FIRST'] = e($firstName);

        $nameParts = explode(' ', trim($name));
        $initials = '';
        if (count($nameParts) >= 2) {
            $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[count($nameParts)-1], 0, 1));
        } else {
            $initials = strtoupper(substr($name, 0, 2));
        }
        $placeholders['FULL_NAME_INITIALS'] = $initials;

        // Social Ph (Tailored to each layout)
        $socials = [
            'GITHUB' => ['icon' => 'fab fa-github', 'url' => $merged['github_url'] ?? '#'],
            'LINKEDIN' => ['icon' => 'fab fa-linkedin', 'url' => $merged['linkedin_url'] ?? '#'],
            'TWITTER' => ['icon' => 'fab fa-twitter', 'url' => $merged['twitter_url'] ?? '#'],
            'INSTAGRAM' => ['icon' => 'fab fa-instagram', 'url' => $merged['instagram_url'] ?? '#'],
            'DRIBBBLE' => ['icon' => 'fab fa-dribbble', 'url' => $merged['dribbble_url'] ?? '#'],
            'BEHANCE' => ['icon' => 'fab fa-behance', 'url' => $merged['behance_url'] ?? '#'],
            'KAGGLE' => ['icon' => 'fab fa-kaggle', 'url' => $merged['kaggle_url'] ?? '#']
        ];

        foreach ($socials as $key => $data) {
            $html = '';
            $u = e($data['url']);
            $ic = e($data['icon']);
            if ($templateKey === 'template_1') {
                $html = '<a href="' . $u . '" target="_blank" class="w-10 h-10 border border-white/10 rounded-full flex items-center justify-center text-gray-400 hover:text-white hover:border-neon-cyan transition-all"><i class="' . $ic . '"></i></a>';
            } else if ($templateKey === 'template_2') {
                $html = '<a href="' . $u . '" target="_blank" class="text-charcoal/40 hover:text-accent transition-colors text-lg"><i class="' . $ic . '"></i></a>';
            } else if ($templateKey === 'template_3') {
                $html = '<a href="' . $u . '" target="_blank" class="text-white/30 hover:text-brand-orange transition-colors text-xl"><i class="' . $ic . '"></i></a>';
            } else if ($templateKey === 'template_4') {
                $html = '<a href="' . $u . '" target="_blank" class="text-white/30 hover:text-purple-400 text-xl transition-colors"><i class="' . $ic . '"></i></a>';
            } else if ($templateKey === 'template_5') {
                $html = '<a href="' . $u . '" target="_blank" class="w-9 h-9 bg-white/5 hover:bg-blue-500/20 hover:text-blue-400 rounded-lg flex items-center justify-center text-white/50 transition-all text-sm"><i class="' . $ic . '"></i></a>';
            } else {
                $html = '<a href="' . $u . '" target="_blank"><i class="' . $ic . '"></i></a>';
            }
            $placeholders[$key . '_PH'] = $html;
        }

        // Specialized: Marquee (Template 2)
        $marqueeHtml = '';
        $mTexts = $merged['marquee_texts'] ?? ["UI Design", "UX Research", "Branding"];
        if (is_array($mTexts)) {
            foreach ($mTexts as $txt) {
                $marqueeHtml .= '<span class="mx-8">' . e($txt) . '</span><span class="text-warm mx-4">✦</span>';
            }
        }
        $placeholders['MARQUEE_TEXT_HTML'] = $marqueeHtml;

        // Specialized: Code Card Content
        $placeholders['CODE_CARD_CONTENT_HTML'] = $merged['code_card_content_html'] ?? ''; // Kept raw for HTML styling within field or escaped if needed
        
        $jsonCardHtml = '';
        $jsonItems = $merged['code_card_content_json_html'] ?? [];
        if (is_array($jsonItems)) {
            foreach ($jsonItems as $item) {
                $parts = explode('|', $item);
                $jsonCardHtml .= '<div><span class="text-blue-500">"' . e($parts[0] ?? '') . '"</span>: <span class="text-green-600">"' . e($parts[1] ?? '') . '"</span>,</div>';
            }
        }
        $placeholders['CODE_CARD_CONTENT_JSON_HTML'] = $jsonCardHtml;

        // 1. PROJECTS_HTML
        $projectsHtml = '';
        $projects = $merged['projects'] ?? [];
        if (is_array($projects)) {
            $projIdx = 0;
            foreach ($projects as $project) {
                if (!is_array($project)) continue;
                $pNameRaw = trim($project['name'] ?? 'Project Name');
                $pParts = explode('|', $pNameRaw);
                $pIcon = count($pParts) > 1 ? strtolower(trim($pParts[0])) : 'fas fa-rocket';
                $pName = count($pParts) > 1 ? trim($pParts[1]) : $pNameRaw;
                $pDesc = trim($project['description'] ?? 'Short description');
                $pLink = trim($project['link'] ?? '');
                
                if ($templateKey === 'template_1') {
                    $projStyles = [['neon-border', '', 'text-neon-cyan', 'from-neon-cyan/20'],['neon-border-green', 'text-neon-green', 'text-neon-green', 'from-neon-green/20'],['neon-border-pink', 'text-neon-pink', 'text-neon-pink', 'from-neon-pink/20']];
                    $ps = $projStyles[$projIdx % 3];
                    $projectsHtml .= '<div class="' . $ps[0] . ' card-hover rounded-xl overflow-hidden bg-dark-800/60 backdrop-blur section-reveal"><div class="h-48 bg-gradient-to-br ' . $ps[3] . ' to-dark-900 flex items-center justify-center"><i class="' . $pIcon . ' text-6xl ' . $ps[2] . '" style="text-shadow:0 0 20px currentColor"></i></div><div class="p-6"><div class="flex items-center justify-between mb-3"><span class="' . ($ps[1] ?: 'text-neon-cyan') . ' font-orbitron text-xs uppercase tracking-widest">Project ' . ($projIdx+1) . '</span><div class="flex gap-2">' . ($pLink ? '<a href="' . $pLink . '" target="_blank" class="text-gray-500 hover:text-white transition-colors"><i class="fas fa-external-link-alt"></i></a>' : '') . '</div></div><h3 class="font-orbitron text-lg text-white mb-2">' . $pName . '</h3><p class="text-gray-400 text-sm mb-4">' . $pDesc . '</p></div></div>';
                } else if ($templateKey === 'template_2') {
                    $projectsHtml .= '<div class="work-card hover-lift bg-white shadow-sm section-reveal"><div class="img-placeholder h-64 bg-gradient-to-br from-sand to-warm/30 flex items-center justify-center"><i class="' . $pIcon . ' text-6xl text-warm/40"></i></div><div class="p-8"><h3 class="font-playfair text-2xl font-bold text-charcoal mb-3">' . $pName . '</h3><p class="text-charcoal/60 text-sm leading-relaxed">' . $pDesc . '</p>' . ($pLink ? '<a href="' . $pLink . '" target="_blank" class="inline-flex items-center gap-2 text-accent text-sm mt-4 hover:gap-4 transition-all font-medium">View Project <i class="fas fa-arrow-right"></i></a>' : '') . '</div></div>';
                } else if ($templateKey === 'template_3') {
                    $projectsHtml .= '<div class="project-card rounded-3xl p-8 md:p-12 relative overflow-hidden reveal group"><div class="project-number">0' . ($projIdx+1) . '</div><div class="grid md:grid-cols-2 gap-12 items-center"><div class="space-y-6"><h3 class="font-syne text-4xl font-extrabold group-hover:gradient-text transition-all">' . $pName . '</h3><p class="text-white/50 leading-relaxed font-light">' . $pDesc . '</p>' . ($pLink ? '<a href="' . $pLink . '" target="_blank" class="inline-flex items-center gap-2 text-brand-orange hover:gap-4 transition-all">Explore Project <i class="fas fa-arrow-right"></i></a>' : '') . '</div><div class="aspect-video gradient-bg rounded-2xl flex items-center justify-center overflow-hidden"><i class="' . $pIcon . ' text-8xl text-black/20 group-hover:scale-110 transition-transform duration-700"></i></div></div></div>';
                } else if ($templateKey === 'template_4') {
                    $projectsHtml .= '<div class="glass-card rounded-3xl p-6 group"><div class="aspect-video bg-gradient-to-br from-purple-500/20 to-pink-500/20 rounded-2xl mb-6 flex items-center justify-center overflow-hidden"><i class="' . $pIcon . ' text-6xl text-white/20 group-hover:scale-110 transition-transform"></i></div><div class="space-y-4"><h3 class="text-xl font-bold">' . $pName . '</h3><p class="text-white/50 text-sm leading-relaxed">' . $pDesc . '</p>' . ($pLink ? '<a href="' . $pLink . '" target="_blank" class="inline-flex items-center gap-2 text-purple-400 text-sm hover:text-white transition-colors">Launch Code <i class="fas fa-external-link-alt text-[10px]"></i></a>' : '') . '</div></div>';
                } else if ($templateKey === 'template_5') {
                    $projectsHtml .= '<div class="card p-6 enter bg-white group"><div class="flex justify-between items-start mb-4"><div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all"><i class="' . $pIcon . '"></i></div>' . ($pLink ? '<a href="' . $pLink . '" target="_blank" class="text-surface-300 hover:text-blue-600"><i class="fas fa-external-link-alt"></i></a>' : '') . '</div><h3 class="text-lg font-bold text-surface-900 mb-2">' . $pName . '</h3><p class="text-surface-400 text-sm leading-relaxed">' . $pDesc . '</p></div>';
                }
                $projIdx++;
            }
        }
        $placeholders['PROJECTS_HTML'] = $projectsHtml;

        // 2. TECH_SKILLS_HTML
        $techSkillsHtml = '';
        $techSkills = $merged['tech_skills'] ?? [];
        if (is_array($techSkills)) {
            $cIdx = 0;
            foreach ($techSkills as $skill) {
                $parts = explode('|', $skill);
                $sName = trim($parts[0] ?? 'Skill');
                $sPct = trim($parts[1] ?? '80');
                $sClr = trim($parts[2] ?? 'purple'); // T4 Color
                
                if ($templateKey === 'template_1') {
                    $barColors = ['#00f5ff', '#39ff14', '#ff006e', '#bf00ff'];
                    $color = $barColors[$cIdx % 4];
                    $techSkillsHtml .= '<div class="section-reveal"><div class="flex justify-between mb-2"><span class="text-gray-300 text-sm">' . $sName . '</span><span class="text-neon-cyan text-sm">' . $sPct . '%</span></div><div class="w-full bg-dark-700 rounded h-1"><div class="skill-bar" style="width:' . $sPct . '%; background:' . $color . '; box-shadow:0 0 10px ' . $color . '"></div></div></div>';
                } else if ($templateKey === 'template_2') {
                    $techSkillsHtml .= '<div class="section-reveal"><div class="flex justify-between items-end mb-1"><span class="text-charcoal font-medium">' . $sName . '</span><span class="text-accent text-xs">' . $sPct . '%</span></div><div class="w-full bg-sand h-1.5 rounded-full overflow-hidden"><div class="bg-accent h-full transition-all duration-1000" style="width:' . $sPct . '%"></div></div></div>';
                } else if ($templateKey === 'template_4') {
                    $techSkillsHtml .= '<div class="fade-up"><div class="flex justify-between mb-2 text-sm"><span class="text-white/80">' . $sName . '</span><span class="mono-code text-white/40">' . $sPct . '%</span></div><div class="progress-bar"><div class="progress-fill progress-' . $sClr . '" style="width:' . $sPct . '%"></div></div></div>';
                } else if ($templateKey === 'template_5') {
                    $techSkillsHtml .= '<div class="enter"><div class="flex justify-between mb-2"><span class="text-surface-700 font-medium text-sm">' . $sName . '</span><span class="text-blue-600 text-xs font-bold">' . $sPct . '%</span></div><div class="w-full bg-surface-100 h-1.5 rounded-full overflow-hidden"><div class="bg-blue-600 h-full rounded-full" style="width:' . $sPct . '%"></div></div></div>';
                }
                $cIdx++;
            }
        }
        $placeholders['TECH_SKILLS_HTML'] = $techSkillsHtml;

        // 3. SERVICE_CARDS_HTML
        $serviceCardsHtml = '';
        $services = $merged['service_cards'] ?? [];
        if (is_array($services)) {
            foreach ($services as $service) {
                $parts = explode('|', $service);
                $icon = strtolower(trim($parts[0] ?? 'fas fa-code'));
                $sTitle = trim($parts[1] ?? 'Service');
                $sub = trim($parts[2] ?? 'Category');
                
                if ($templateKey === 'template_1') {
                    $serviceCardsHtml .= '<div class="neon-border card-hover rounded-xl p-6 bg-dark-800/60 backdrop-blur text-center section-reveal"><i class="' . e($icon) . ' text-5xl text-neon-cyan mb-4" style="text-shadow:0 0 15px #00f5ff"></i><div class="font-orbitron text-sm text-white">' . e($sTitle) . '</div><div class="text-gray-500 text-xs mt-1">' . e($sub) . '</div></div>';
                } else if ($templateKey === 'template_2') {
                    $serviceCardsHtml .= '<div class="border border-sand p-8 bg-white hover-lift section-reveal group"><div class="w-12 h-12 bg-sand/20 flex items-center justify-center mb-6"><i class="' . e($icon) . ' text-accent text-xl"></i></div><h3 class="font-playfair text-xl font-bold text-charcoal mb-4">' . e($sTitle) . '</h3><p class="text-charcoal/60 text-sm leading-relaxed">' . e($sub) . '</p></div>';
                } else if ($templateKey === 'template_3') {
                    $serviceCardsHtml .= '<div class="project-card rounded-2xl p-6 flex items-center gap-6 reveal group hover:border-brand-orange/40 transition-colors"><div class="w-16 h-16 rounded-xl bg-brand-orange/10 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform"><i class="' . e($icon) . ' text-2xl text-brand-orange"></i></div><div><h4 class="font-syne font-bold text-lg">' . e($sTitle) . '</h4><p class="text-white/40 text-sm">' . e($sub) . '</p></div></div>';
                } else if ($templateKey === 'template_5') {
                    $serviceCardsHtml .= '<div class="skill-badge"><i class="' . e($icon) . '"></i><span>' . e($sTitle) . '</span></div>';
                }
            }
        }
        $placeholders['SERVICE_CARDS_HTML'] = $serviceCardsHtml;

        // 4. EXPERIENCE_HTML
        $expHtml = '';
        $expList = $merged['experience'] ?? [];
        if (is_array($expList)) {
            foreach ($expList as $exp) {
                $parts = explode('|', $exp);
                $dur = trim($parts[0] ?? '');
                $tit = trim($parts[1] ?? 'Position');
                $com = trim($parts[2] ?? 'Company');
                $dsc = trim($parts[3] ?? 'Description');
                
                if ($templateKey === 'template_4') {
                    $expHtml .= '<div class="timeline-item pb-8"><div class="text-xs badge mb-3 inline-block">' . e($dur) . '</div><h3 class="text-xl font-bold mb-1">' . e($tit) . '</h3><div class="text-purple-400 text-sm mb-3">' . e($com) . '</div><p class="text-white/50 text-sm leading-relaxed">' . e($dsc) . '</p></div>';
                } else if ($templateKey === 'template_5') {
                    $isCurrent = (strpos(strtolower($dur), 'present') !== false);
                    $expHtml .= '<div class="exp-item pb-8"><div class="flex items-center gap-3 mb-1"><h3 class="text-lg font-bold text-surface-900">' . e($tit) . '</h3>' . ($isCurrent ? '<span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded font-medium">Current</span>' : '') . '</div><div class="text-blue-600 text-sm font-semibold mb-1">' . e($com) . '</div><div class="text-surface-300 text-xs mb-3">' . e($dur) . '</div><p class="text-surface-400 text-sm leading-relaxed">' . e($dsc) . '</p></div>';
                }
            }
        }
        $placeholders['EXPERIENCE_HTML'] = $expHtml;

        $placeholders['TYPING_TEXTS'] = is_array($merged['typing_texts'] ?? '') ? implode(',', $merged['typing_texts']) : ($merged['typing_texts'] ?? 'Portfolio Generator');

        return $placeholders;
    }
}
