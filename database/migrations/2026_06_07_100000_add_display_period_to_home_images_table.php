<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_images', function (Blueprint $table) {
            $table->date('display_from')->nullable()->after('is_active');
            $table->date('display_until')->nullable()->after('display_from');
        });
    }

    public function down(): void
    {
        Schema::table('home_images', function (Blueprint $table) {
            $table->dropColumn(['display_from', 'display_until']);
        });
    }
};
