<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('news', function (Blueprint $table) {
        $table->id();
        $table->string('title_en');
        $table->string('title_si')->nullable();
        $table->string('title_ta')->nullable();
        $table->text('content_en');
        $table->text('content_si')->nullable();
        $table->text('content_ta')->nullable();
        $table->string('image')->nullable();
        $table->date('published_date')->nullable();
        $table->string('status')->default('draft');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
