<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procurement_notices', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('notice_type')->default('notice');
            $table->date('published_date')->nullable();
            $table->date('closing_date')->nullable();
            $table->string('status')->default('draft');
            $table->json('documents')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procurement_notices');
    }
};
