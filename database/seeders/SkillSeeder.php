<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        Skill::truncate();

        $skills = [
            // Backend
            ['name'=>'PHP',           'category'=>'backend',  'proficiency'=>90, 'hex_color'=>'#8892BF', 'years_experience'=>8,  'is_featured'=>true,  'sort_order'=>1],
            ['name'=>'Laravel',       'category'=>'backend',  'proficiency'=>88, 'hex_color'=>'#FF2D20', 'years_experience'=>5,  'is_featured'=>true,  'sort_order'=>2],
            ['name'=>'Node.js',       'category'=>'backend',  'proficiency'=>65, 'hex_color'=>'#339933', 'years_experience'=>2,  'is_featured'=>false, 'sort_order'=>3],
            ['name'=>'REST API',      'category'=>'backend',  'proficiency'=>85, 'hex_color'=>'#2563eb', 'years_experience'=>5,  'is_featured'=>false, 'sort_order'=>4],

            // Frontend
            ['name'=>'HTML5',         'category'=>'frontend', 'proficiency'=>92, 'hex_color'=>'#E34F26', 'years_experience'=>8,  'is_featured'=>true,  'sort_order'=>5],
            ['name'=>'CSS3 / Tailwind','category'=>'frontend','proficiency'=>85, 'hex_color'=>'#06B6D4', 'years_experience'=>5,  'is_featured'=>true,  'sort_order'=>6],
            ['name'=>'JavaScript',    'category'=>'frontend', 'proficiency'=>78, 'hex_color'=>'#F7DF1E', 'years_experience'=>5,  'is_featured'=>false, 'sort_order'=>7],
            ['name'=>'Bootstrap',     'category'=>'frontend', 'proficiency'=>88, 'hex_color'=>'#7952B3', 'years_experience'=>6,  'is_featured'=>false, 'sort_order'=>8],
            ['name'=>'Alpine.js',     'category'=>'frontend', 'proficiency'=>70, 'hex_color'=>'#8BC0D0', 'years_experience'=>1,  'is_featured'=>false, 'sort_order'=>9],

            // Database
            ['name'=>'MySQL',         'category'=>'database', 'proficiency'=>90, 'hex_color'=>'#4479A1', 'years_experience'=>8,  'is_featured'=>true,  'sort_order'=>10],
            ['name'=>'PostgreSQL',    'category'=>'database', 'proficiency'=>65, 'hex_color'=>'#336791', 'years_experience'=>2,  'is_featured'=>false, 'sort_order'=>11],
            ['name'=>'Database Design','category'=>'database','proficiency'=>85, 'hex_color'=>'#47A248', 'years_experience'=>7,  'is_featured'=>false, 'sort_order'=>12],

            // DevOps & Tools
            ['name'=>'Git / GitHub',  'category'=>'devops',   'proficiency'=>88, 'hex_color'=>'#F05032', 'years_experience'=>6,  'is_featured'=>true,  'sort_order'=>13],
            ['name'=>'Linux (Ubuntu)','category'=>'devops',   'proficiency'=>75, 'hex_color'=>'#E95420', 'years_experience'=>5,  'is_featured'=>false, 'sort_order'=>14],
            ['name'=>'Docker (basic)','category'=>'devops',   'proficiency'=>55, 'hex_color'=>'#2496ED', 'years_experience'=>1,  'is_featured'=>false, 'sort_order'=>15],

            // Tools & Software
            ['name'=>'MS Office Suite','category'=>'tools',   'proficiency'=>95, 'hex_color'=>'#D83B01', 'years_experience'=>10, 'is_featured'=>false, 'sort_order'=>16],
            ['name'=>'Google Workspace','category'=>'tools',  'proficiency'=>92, 'hex_color'=>'#4285F4', 'years_experience'=>7,  'is_featured'=>false, 'sort_order'=>17],
            ['name'=>'Adobe Photoshop','category'=>'design',  'proficiency'=>78, 'hex_color'=>'#31A8FF', 'years_experience'=>6,  'is_featured'=>false, 'sort_order'=>18],
            ['name'=>'Adobe Premiere','category'=>'design',   'proficiency'=>72, 'hex_color'=>'#9999FF', 'years_experience'=>5,  'is_featured'=>false, 'sort_order'=>19],
            ['name'=>'Canva',         'category'=>'design',   'proficiency'=>90, 'hex_color'=>'#00C4CC', 'years_experience'=>5,  'is_featured'=>false, 'sort_order'=>20],

            // Soft Skills
            ['name'=>'Technical Writing',      'category'=>'soft', 'proficiency'=>90, 'hex_color'=>'#6366f1', 'years_experience'=>8, 'is_featured'=>true,  'sort_order'=>21],
            ['name'=>'Training & Facilitation','category'=>'soft', 'proficiency'=>92, 'hex_color'=>'#10b981', 'years_experience'=>7, 'is_featured'=>true,  'sort_order'=>22],
            ['name'=>'Project Management',     'category'=>'soft', 'proficiency'=>85, 'hex_color'=>'#f59e0b', 'years_experience'=>6, 'is_featured'=>false, 'sort_order'=>23],
            ['name'=>'Systems Analysis',       'category'=>'soft', 'proficiency'=>88, 'hex_color'=>'#8b5cf6', 'years_experience'=>7, 'is_featured'=>true,  'sort_order'=>24],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }

        $this->command->info('Skills seeded (' . count($skills) . ' records)');
    }
}
