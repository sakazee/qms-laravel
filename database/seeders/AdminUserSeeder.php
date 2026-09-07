<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $emails = array_filter([
            config('superadmin.email'),
            'demo@qurbani.app',
        ]);

        foreach ($emails as $email) {
            User::withTrashed()->where('email', $email)->update(['role' => User::ROLE_ADMIN]);
        }

        $this->command->info('✅ Super admin role assigned for: '.implode(', ', $emails));
    }
}
