<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_images', function (Blueprint $table): void {
            $table->id();
            $table->string('slot')->unique();
            $table->string('title');
            $table->string('caption')->nullable();
            $table->string('image_path')->nullable();
            $table->string('fallback_path')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $now = now();
        DB::table('home_images')->insert([
            [
                'slot' => 'hero_slide_1',
                'title' => 'Hero slide 1',
                'caption' => 'Climate-smart agriculture - resilient landscapes and productive farming systems across project areas.',
                'fallback_path' => '/images/hero/sky.jpeg',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slot' => 'hero_slide_2',
                'title' => 'Hero slide 2',
                'caption' => 'Quality harvests from the field - growers proudly showcase fresh, healthy produce.',
                'fallback_path' => '/images/hero/hero-home-02.png',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slot' => 'hero_slide_3',
                'title' => 'Hero slide 3',
                'caption' => 'Vegetable farming and resilient livelihoods - vibrant fields and inclusive rural development.',
                'fallback_path' => '/images/hero/hero-home-03.png',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slot' => 'hero_slide_4',
                'title' => 'Hero slide 4',
                'caption' => 'Organised plots from above - good agricultural practices and productive land use.',
                'fallback_path' => '/images/hero/hero-home-04.png',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slot' => 'hero_slide_5',
                'title' => 'Hero slide 5',
                'caption' => 'Plantation and coconut livelihoods - carrying the harvest with pride.',
                'fallback_path' => '/images/hero/hero-home-05.png',
                'sort_order' => 5,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slot' => 'hero_slide_6',
                'title' => 'Hero slide 6',
                'caption' => 'Hands-on cultivation - high-value crops like chillies grown with care in the field.',
                'fallback_path' => '/images/hero/hero-home-06.png',
                'sort_order' => 6,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slot' => 'hero_slide_7',
                'title' => 'Hero slide 7',
                'caption' => 'On-farm equipment and green practices - processing biomass for climate-smart agriculture.',
                'fallback_path' => '/images/hero/hero-home-07.png',
                'sort_order' => 7,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('home_images');
    }
};
