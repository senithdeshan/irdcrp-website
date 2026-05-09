<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_videos', function (Blueprint $table): void {
            $table->id();
            $table->string('title', 120);
            $table->string('section_key', 40)->index();
            $table->string('youtube_url', 255);
            $table->string('youtube_id', 20)->index();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_videos');
    }
};

