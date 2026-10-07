<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@jpcsilva.com')],
            [
                'name'     => 'John Paul Silva',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'Admin@2024!')),
            ]
        );
        $this->command->info('✅ Admin user ready: ' . env('ADMIN_EMAIL', 'admin@jpcsilva.com'));
    }
}
