<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('programmes', function (Blueprint $table) {
            $table->foreignId('project_component_id')
                ->nullable()
                ->after('slug')
                ->constrained('project_components')
                ->nullOnDelete();

            $table->index('project_component_id');
        });

        $componentOneId = DB::table('project_components')
            ->where('component_number', 1)
            ->value('id');

        if ($componentOneId) {
            DB::table('programmes')->update(['project_component_id' => $componentOneId]);
        }
    }

    public function down(): void
    {
        Schema::table('programmes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('project_component_id');
        });
    }
};
