<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('category', 32)->default('photos')->after('title');
            $table->string('media_type', 32)->default('image')->after('category');
            $table->string('file_path')->nullable()->after('image');
            $table->string('external_url')->nullable()->after('file_path');
            $table->text('description')->nullable()->after('external_url');
            $table->string('status', 32)->default('published')->after('description');

            $table->index('category');
            $table->index('status');
        });

        DB::table('galleries')->update([
            'category' => 'photos',
            'media_type' => 'image',
            'status' => 'published',
        ]);

        DB::statement('UPDATE galleries SET file_path = image WHERE file_path IS NULL');
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['status']);
            $table->dropColumn([
                'category',
                'media_type',
                'file_path',
                'external_url',
                'description',
                'status',
            ]);
        });
    }
};
