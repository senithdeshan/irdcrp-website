<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_area_districts', function (Blueprint $table) {
            $table->id();
            $table->string('district');
            $table->text('ds_divisions')->nullable();
            $table->text('focus')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        $rows = $this->rowsToImport();

        foreach ($rows as $index => $row) {
            if (! filled($row['district'] ?? null) && ! filled($row['ds_divisions'] ?? null) && ! filled($row['focus'] ?? null)) {
                continue;
            }

            DB::table('project_area_districts')->insert([
                'district' => (string) ($row['district'] ?? ''),
                'ds_divisions' => $row['ds_divisions'] ?? null,
                'focus' => $row['focus'] ?? null,
                'sort_order' => $index,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('project_area_districts');
    }

    /**
     * @return list<array{district?: string, ds_divisions?: string, focus?: string}>
     */
    private function rowsToImport(): array
    {
        if (Schema::hasTable('site_settings')) {
            $json = DB::table('site_settings')->where('key', 'project_areas')->value('value');

            if (filled($json)) {
                $saved = json_decode($json, true);

                if (is_array($saved['table_rows'] ?? null) && $saved['table_rows'] !== []) {
                    return $saved['table_rows'];
                }
            }
        }

        return [
            [
                'district' => 'To be updated',
                'ds_divisions' => 'To be updated',
                'focus' => 'Climate Resilience / Agriculture / Livestock',
            ],
            [
                'district' => 'To be updated',
                'ds_divisions' => 'To be updated',
                'focus' => 'Community Development / Livelihoods',
            ],
            [
                'district' => 'To be updated',
                'ds_divisions' => 'To be updated',
                'focus' => 'Infrastructure / Natural Resources',
            ],
        ];
    }
};
