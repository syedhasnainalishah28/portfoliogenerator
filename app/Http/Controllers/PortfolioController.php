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
        $request->merge([
            'skills' => is_string($request->skills) ? json_decode($request->skills, true) : $request->skills,
            'projects' => is_string($request->projects) ? json_decode($request->projects, true) : $request->projects,
        ]);

        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string', 'max:100'],
            'title' => ['nullable', 'string', 'max:120'],
            'bio' => ['required', 'string', 'max:5000'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['nullable', 'string', 'max:30'],
            'whatsapp_link' => ['nullable', 'url', 'max:255'],
            'template_key' => ['required', 'in:' . implode(',', $this->allowedTemplateKeys())],
            'primary_color' => ['required', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'secondary_color' => ['nullable', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'background_color' => ['nullable', 'regex:/^#[a-fA-F0-9]{6}$/'],
            'font_family' => ['nullable', 'string'],
            'hero_image_size' => ['required', 'integer', 'min:220', 'max:520'],
            'skills' => ['nullable', 'array', 'max:20'],
            'skills.*' => ['nullable', 'string', 'max:100'],
            'projects' => ['nullable', 'array', 'max:10'],
            'projects.*.name' => ['nullable', 'string', 'max:100'],
            'projects.*.description' => ['nullable', 'string', 'max:500'],
            'projects.*.link' => ['nullable', 'url', 'max:255'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $imagePath = null;
        if ($request->hasFile('hero_image')) {
            $imagePath = $request->file('hero_image')->store('portfolio-heroes', 'public');
        }

        $portfolio = Portfolio::create([
            'user_id' => $request->user()?->id,
            'full_name' => strip_tags($data['full_name']),
            'title' => isset($data['title']) ? strip_tags($data['title']) : null,
            'bio' => strip_tags($data['bio']),
            'email' => $data['email'],
            'phone' => isset($data['phone']) ? strip_tags($data['phone']) : null,
            'whatsapp_link' => $data['whatsapp_link'] ?? null,
            'template_key' => $data['template_key'],
            'primary_color' => $data['primary_color'],
            'secondary_color' => $data['secondary_color'] ?? '#000000',
            'background_color' => $data['background_color'] ?? '#ffffff',
            'font_family' => $data['font_family'] ?? 'Inter',
            'hero_image_size' => $data['hero_image_size'],
            'hero_image_path' => $imagePath,
            'skills' => array_map('strip_tags', $data['skills'] ?? []),
            'projects' => array_map(function (array $project): array {
                return [
                    'name' => strip_tags($project['name'] ?? ''),
                    'description' => strip_tags($project['description'] ?? ''),
                    'link' => $project['link'] ?? null,
                ];
            }, $data['projects'] ?? []),
        ]);

        return response()->json([
            'message' => 'Portfolio saved successfully.',
            'portfolio_id' => $portfolio->id,
        ], 201);
    }
}
