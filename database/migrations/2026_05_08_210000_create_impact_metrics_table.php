<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('impact_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('label');
            $table->string('value');
            $table->unsignedInteger('count_target')->nullable();
            $table->string('helper')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('impact_metrics')->insert([
            [
                'key' => 'districts',
                'label' => 'Districts',
                'value' => '11',
                'count_target' => 11,
                'helper' => 'Implementation districts across Sri Lanka',
                'sort_order' => 10,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'beneficiaries',
                'label' => 'Total Beneficiaries',
                'value' => '57,500',
                'count_target' => 57500,
                'helper' => 'People expected to benefit from project interventions',
                'sort_order' => 20,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'investment',
                'label' => 'Total Investment',
                'value' => 'USD 105 Million',
                'count_target' => null,
                'helper' => 'Financing envelope for resilient agriculture development',
                'sort_order' => 30,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'projects',
                'label' => 'Total Projects',
                'value' => '34',
                'count_target' => 34,
                'helper' => 'Priority investments and field-level activities',
                'sort_order' => 40,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('impact_metrics');
    }
};
