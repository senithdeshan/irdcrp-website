<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->string('status', 32)->default('published');
            $table->timestamps();

            $table->index('status');
            $table->index('sort_order');
        });

        DB::table('faqs')->insert([
            [
                'question' => 'What is the Integrated Rurban Development and Climate Resilience Project?',
                'answer' => 'IRDCRP supports climate-smart agriculture, rural livelihoods, resilient natural resource management, sector services, and project coordination for targeted communities in Sri Lanka.',
                'sort_order' => 1,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Where can I find project documents?',
                'answer' => 'Use the Resources menu and open Documents to view published reports, forms, and official public files.',
                'sort_order' => 2,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Where are procurement notices published?',
                'answer' => 'Procurement opportunities are available under Announcements, then Procurement.',
                'sort_order' => 3,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'How can I submit a complaint or grievance?',
                'answer' => 'Open GRM from the main navigation and complete the complaint form with your contact details and message.',
                'sort_order' => 4,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Where can I find vacancies?',
                'answer' => 'Vacancy notices are listed under Announcements, then Vacancy.',
                'sort_order' => 5,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'How can I contact the project team?',
                'answer' => 'Use Contact Us in the navigation to view contact details and send a support message.',
                'sort_order' => 6,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
