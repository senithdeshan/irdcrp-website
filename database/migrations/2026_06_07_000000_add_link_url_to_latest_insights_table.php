<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('latest_insights', function (Blueprint $table) {
            $table->string('link_url', 500)->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('latest_insights', function (Blueprint $table) {
            $table->dropColumn('link_url');
        });
    }
};
