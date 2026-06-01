<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('key_leaders', function (Blueprint $table) {
            $table->string('group', 32)->default('key_leader')->after('sort_order')->index();
        });
    }

    public function down(): void
    {
        Schema::table('key_leaders', function (Blueprint $table) {
            $table->dropIndex(['group']);
            $table->dropColumn('group');
        });
    }
};
