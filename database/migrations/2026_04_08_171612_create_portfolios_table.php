<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 100);
            $table->string('title', 120)->nullable();
            $table->text('bio');
            $table->string('email', 120);
            $table->string('phone', 30)->nullable();
            $table->string('whatsapp_link', 255)->nullable();
            $table->string('template_key', 30);
            $table->string('primary_color', 20)->default('#4f46e5');
            $table->string('secondary_color', 20)->default('#06b6d4');
            $table->string('background_color', 20)->default('#0b1020');
            $table->string('font_family', 60)->default('Inter');
            $table->unsignedSmallInteger('hero_image_size')->default(340);
            $table->string('hero_image_path')->nullable();
            $table->json('skills');
            $table->json('projects');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
