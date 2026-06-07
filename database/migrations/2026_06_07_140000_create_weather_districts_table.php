<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather_districts', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name_en');
            $table->string('name_si')->nullable();
            $table->string('name_ta')->nullable();
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $sort = 0;
        foreach (config('irdcrp.weather_areas', []) as $area) {
            if (! is_array($area) || ! filled($area['id'] ?? null)) {
                continue;
            }

            $names = is_array($area['name'] ?? null) ? $area['name'] : [];

            \DB::table('weather_districts')->insert([
                'slug' => (string) $area['id'],
                'name_en' => (string) ($names['en'] ?? $area['id']),
                'name_si' => $names['si'] ?? null,
                'name_ta' => $names['ta'] ?? null,
                'latitude' => (float) ($area['lat'] ?? 0),
                'longitude' => (float) ($area['lon'] ?? 0),
                'image' => $area['image'] ?? null,
                'sort_order' => $sort++,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('weather_districts');
    }
};
