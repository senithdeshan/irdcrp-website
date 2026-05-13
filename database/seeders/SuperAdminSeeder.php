<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Create or refresh the locked website maintenance admin account.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => config('irdcrp.super_admin.login')],
            [
                'name' => config('irdcrp.super_admin.name'),
                'password' => Hash::make(config('irdcrp.super_admin.password')),
                'email_verified_at' => now(),
            ],
        );
    }
}
