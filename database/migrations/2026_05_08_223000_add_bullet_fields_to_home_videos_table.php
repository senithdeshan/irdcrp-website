<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_videos', function (Blueprint $table): void {
            $table->string('bullet_one', 255)->nullable()->after('title');
            $table->string('bullet_two', 255)->nullable()->after('bullet_one');
            $table->string('bullet_three', 255)->nullable()->after('bullet_two');
        });
    }

    public function down(): void
    {
        Schema::table('home_videos', function (Blueprint $table): void {
            $table->dropColumn(['bullet_one', 'bullet_two', 'bullet_three']);
        });
    }
};

