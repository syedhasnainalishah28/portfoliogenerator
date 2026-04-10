<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
    private function allowedTemplateKeys(): array
    {
        return array_map(fn ($i) => "template_{$i}", range(1, 50));
    }

    public function store(Request $request)
    {
        $dynamicFields = is_string($request->dynamic_fields) 
            ? json_decode($request->dynamic_fields, true) 
            : ($request->dynamic_fields ?? []);

        // Flatten any JSON strings inside dynamic_fields (like skills/projects)
        foreach ($dynamicFields as $key => $value) {
            if (is_string($value) && (str_starts_with($value, '[') || str_starts_with($value, '{'))) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $dynamicFields[$key] = $decoded;
                }
            }
        }

        $validator = Validator::make([
            'template_key' => $request->template_key,
            'dynamic_fields' => $dynamicFields,
        ], [
            'template_key' => ['required', 'in:' . implode(',', $this->allowedTemplateKeys())],
            'dynamic_fields' => ['required', 'array'],
            'dynamic_fields.full_name' => ['nullable', 'string', 'max:100'],
            'dynamic_fields.email' => ['nullable', 'email', 'max:120'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $fields = $dynamicFields; // Use the full array, not just validated subset

        $imagePath = null;
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            if (isset($images['hero_image'])) {
                $imagePath = $images['hero_image']->store('portfolio-heroes', 'public');
            }
        }

        $portfolio = Portfolio::create([
            'user_id' => $request->user()?->id,
            'full_name' => strip_tags($fields['full_name'] ?? 'Portfolio'),
            'title' => isset($fields['title']) ? strip_tags($fields['title']) : null,
            'bio' => isset($fields['bio']) ? strip_tags($fields['bio']) : '',
            'email' => $fields['email'] ?? 'temp@example.com',
            'phone' => isset($fields['phone']) ? strip_tags($fields['phone']) : null,
            'whatsapp_link' => $fields['whatsapp_link'] ?? null,
            'template_key' => $request->template_key,
            'primary_color' => $fields['primary_color'] ?? '#000000',
            'secondary_color' => $fields['secondary_color'] ?? '#000000',
            'background_color' => $fields['background_color'] ?? '#ffffff',
            'font_family' => $fields['font_family'] ?? 'Inter',
            'hero_image_size' => $fields['hero_image_size'] ?? 340,
            'hero_image_path' => $imagePath,
            'skills' => $fields['skills'] ?? [],
            'projects' => $fields['projects'] ?? [],
            'dynamic_fields' => $fields,
        ]);

        return response()->json([
            'message' => 'Portfolio saved successfully.',
            'portfolio_id' => $portfolio->id,
        ], 201);
    }
}
