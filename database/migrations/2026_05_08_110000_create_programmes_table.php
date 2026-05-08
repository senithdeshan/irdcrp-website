<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programmes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->string('status', 32)->default('published');
            $table->timestamps();

            $table->index('status');
            $table->index('sort_order');
        });

        DB::table('programmes')->insert([
            [
                'title' => 'Climate Smart Agronomic Improvements Programme',
                'slug' => 'climate-smart-agronomic-improvements-programme',
                'summary' => 'Climate-smart field practices and technologies that help producers adapt to changing conditions.',
                'description' => 'This programme promotes practical agronomic improvements, efficient field management, and climate-smart technologies to improve production resilience and farm productivity.',
                'image' => 'images/hero/hero-home-01.png',
                'sort_order' => 1,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Climate Smart Farmer Training School',
                'slug' => 'climate-smart-farmer-training-school',
                'summary' => 'Field-based farmer learning spaces for demonstration, knowledge sharing, and practical skills.',
                'description' => 'This programme supports farmer training and extension through demonstration sites, peer learning, and climate-smart production practices.',
                'image' => 'images/hero/hero-home-04.png',
                'sort_order' => 2,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Climate Smart Home Gardening Programme',
                'slug' => 'climate-smart-home-gardening-programme',
                'summary' => 'Household-level food production and nutrition support through resilient home gardens.',
                'description' => 'This programme promotes home gardening, women and youth participation, and diversified household production using climate-smart methods.',
                'image' => 'images/hero/hero-home-03.png',
                'sort_order' => 3,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Climate Smart Seeds Production Programme',
                'slug' => 'climate-smart-seeds-production-programme',
                'summary' => 'Improved seed systems and quality production support for stronger local value chains.',
                'description' => 'This programme supports seed production, farmer entrepreneurship, and access to better planting material for climate-resilient agriculture.',
                'image' => 'images/hero/hero-home-05.png',
                'sort_order' => 4,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Climate Smart Water and Field Monitoring Programme',
                'slug' => 'climate-smart-water-and-field-monitoring-programme',
                'summary' => 'Field monitoring tools and water-use information for better decisions in project areas.',
                'description' => 'This programme strengthens field-level monitoring, climate information use, and more efficient management of water and production systems.',
                'image' => 'images/weather/implementation-area.png',
                'sort_order' => 5,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Climate Smart Market Linkage Programme',
                'slug' => 'climate-smart-market-linkage-programme',
                'summary' => 'Producer connections to services, buyers, value addition, and inclusive rural enterprise.',
                'description' => 'This programme helps producers improve value addition, market access, and enterprise development through stronger service and buyer linkages.',
                'image' => 'images/hero/hero-home-02.png',
                'sort_order' => 6,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('programmes');
    }
};
