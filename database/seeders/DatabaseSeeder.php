<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingSeeder::class,
            SkillSeeder::class,
            ExperienceSeeder::class,
            CertificationSeeder::class,
            ProjectSeeder::class,
            BlogSeeder::class,
        ]);
    }
}
