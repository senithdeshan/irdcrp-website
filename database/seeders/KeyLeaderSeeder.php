<?php

namespace Database\Seeders;

use App\Models\KeyLeader;
use Illuminate\Database\Seeder;

/**
 * Seeds key leaders from config/irdcrp.php `key_leaders` (message keys) with empty images.
 * Run: php artisan db:seed --class=KeyLeaderSeeder
 */
class KeyLeaderSeeder extends Seeder
{
    public function run(): void
    {
        if (KeyLeader::query()->exists()) {
            return;
        }

        $rows = config('irdcrp.key_leaders', []);
        if ($rows === []) {
            return;
        }

        foreach ($rows as $index => $cfg) {
            $roleKey = $cfg['role'] ?? '';
            $orgKey = $cfg['org'] ?? '';
            if ($roleKey === '' || $orgKey === '') {
                continue;
            }

            KeyLeader::create([
                'sort_order' => $index + 1,
                'group' => $cfg['group'] ?? 'key_leader',
                'is_active' => true,
                'image' => null,
                'role_en' => trans('messages.'.$roleKey, [], 'en'),
                'role_si' => trans('messages.'.$roleKey, [], 'si'),
                'role_ta' => trans('messages.'.$roleKey, [], 'ta'),
                'org_en' => trans('messages.'.$orgKey, [], 'en'),
                'org_si' => trans('messages.'.$orgKey, [], 'si'),
                'org_ta' => trans('messages.'.$orgKey, [], 'ta'),
            ]);
        }
    }
}
