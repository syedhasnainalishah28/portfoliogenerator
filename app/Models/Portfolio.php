<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    protected $fillable = [
        'user_id',
        'full_name',
        'title',
        'bio',
        'email',
        'phone',
        'whatsapp_link',
        'template_key',
        'primary_color',
        'secondary_color',
        'background_color',
        'font_family',
        'hero_image_size',
        'hero_image_path',
        'skills',
        'projects',
        'dynamic_fields',
    ];

    protected $casts = [
        'skills' => 'array',
        'projects' => 'array',
        'dynamic_fields' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
