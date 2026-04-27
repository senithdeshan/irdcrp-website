<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('key_leaders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->string('image')->nullable();
            $table->string('role_en');
            $table->string('role_si')->nullable();
            $table->string('role_ta')->nullable();
            $table->text('org_en');
            $table->text('org_si')->nullable();
            $table->text('org_ta')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('key_leaders');
    }
};
