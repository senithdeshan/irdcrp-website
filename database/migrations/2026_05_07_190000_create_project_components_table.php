<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_components', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('component_number');
            $table->string('title');
            $table->string('budget')->nullable();
            $table->string('beneficiaries')->nullable();
            $table->text('description');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->string('status', 32)->default('published');
            $table->timestamps();

            $table->index('status');
            $table->index('sort_order');
        });

        DB::table('project_components')->insert([
            [
                'component_number' => 1,
                'title' => 'Promotion of Climate-Smart Production, Value Addition, and Inclusive Access to Markets',
                'budget' => 'US$45 million: IDA US$30 million, local beneficiaries US$15 million',
                'beneficiaries' => 'Approximately 10,000 small- and medium-scale producers',
                'description' => 'Component 1 will directly benefit small- and medium-scale producers engaged in the agriculture, plantation, livestock, and fisheries sectors. It will provide technical assistance and access to finance to enhance value addition, improve market linkages, and support youth and women entrepreneurs in developing enterprises related to agricultural services.',
                'sort_order' => 1,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'component_number' => 2,
                'title' => 'Integrated Management of Natural Resources for Climate Resilience',
                'budget' => 'US$55 million',
                'beneficiaries' => 'Around 380,000 people in targeted cascade landscapes',
                'description' => 'Recognizing the critical need to improve irrigation systems and water use efficiency, Component 2 will improve the sustainability of natural resource management in targeted cascade landscapes. It will also address gender disparities by facilitating the active participation of female farmers and ensuring equitable access to project benefits.',
                'sort_order' => 2,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'component_number' => 3,
                'title' => 'Strengthening the Enabling Environment for Sectoral Growth',
                'budget' => 'IDA US$13 million and GoSL US$1 million',
                'beneficiaries' => 'Broad range of producers, including export-oriented enterprises',
                'description' => 'This component will enhance the delivery of sector services, focusing on public goods and the quality of data and sector information systems. It will promote better planning, informed decision-making, and efficient resource utilization across the agri-food sector.',
                'sort_order' => 3,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'component_number' => 4,
                'title' => 'Project Management, Monitoring & Learning',
                'budget' => 'IDA US$2 million and GoSL US$2 million',
                'beneficiaries' => 'Implementing agencies, PMU, stakeholders, and project communities',
                'description' => 'This component will support overall management, implementation, and supervision of project activities, including capacity building, monitoring and evaluation, communication, knowledge dissemination, and continuous learning. It will ensure effective coordination among implementing agencies through a dedicated Project Management Unit within the Ministry of Agriculture, Livestock, Lands, and Irrigation.',
                'sort_order' => 4,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'component_number' => 5,
                'title' => 'Contingent Emergency Response Component',
                'budget' => 'US$0 million',
                'beneficiaries' => 'Communities affected by an eligible crisis or emergency, as needed',
                'description' => 'This component will support the provision of immediate response to an eligible crisis or emergency. It provides flexibility for rapid response in the event of a natural or man-made disaster or crisis that may lead to significant adverse economic or social impacts.',
                'sort_order' => 5,
                'status' => 'published',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('project_components');
    }
};
