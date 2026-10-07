<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Experience;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        Experience::truncate();

        $experiences = [
            [
                'position'        => 'Assistant Director',
                'company'         => 'Information and Communications Technology Center (ICTC)',
                'company_url'     => 'https://www.spc.edu.ph',
                'location'        => 'San Pedro College, Davao City',
                'is_remote'       => false,
                'employment_type' => 'full-time',
                'start_date'      => '2018-01-01',
                'end_date'        => null,
                'is_current'      => true,
                'description'     => 'Lead the ICT Center operations, oversee institutional technology systems, and coordinate digital initiatives across the college. Manage IT infrastructure, conduct technology training programs, and support faculty and students with digital tools and resources.',
                'highlights'      => [
                    'Managed college-wide IT infrastructure serving 3,000+ students and faculty',
                    'Led conduct of Digital Literacy trainings including programs for indigenous communities (Matigsalug tribe, Marilog District)',
                    'Spearheaded development and evaluation of institutional information systems',
                    'Conducted Excel, MS Office, Google Workspace, and Zoom training programs',
                    'Coordinated client satisfaction surveys for continuous service improvement',
                ],
                'tech_used'       => ['PHP', 'MySQL', 'Laravel', 'Microsoft Office', 'Google Workspace', 'Network Management'],
                'sort_order'      => 1,
            ],
            [
                'position'        => 'Part-Time Instructor',
                'company'         => 'San Pedro College',
                'company_url'     => 'https://www.spc.edu.ph',
                'location'        => 'Davao City, Philippines',
                'is_remote'       => false,
                'employment_type' => 'part-time',
                'start_date'      => '2019-01-01',
                'end_date'        => null,
                'is_current'      => true,
                'description'     => 'Teach IT-related subjects to undergraduate students, develop course materials, and mentor students in practical software development and IT concepts.',
                'highlights'      => [
                    'Deliver engaging lectures on information technology, systems analysis, and web development',
                    'Develop comprehensive course materials and assessment tools',
                    'Mentor students on capstone and thesis projects',
                    'Integrate industry-standard tools and practices into the curriculum',
                ],
                'tech_used'       => ['PHP', 'MySQL', 'HTML/CSS', 'JavaScript', 'MS Office'],
                'sort_order'      => 2,
            ],
            [
                'position'        => 'Freelance IT Consultant & Developer',
                'company'         => 'Dominate TechSolutions',
                'company_url'     => '',
                'location'        => 'Davao City, Philippines (Remote)',
                'is_remote'       => true,
                'employment_type' => 'freelance',
                'start_date'      => '2020-01-01',
                'end_date'        => null,
                'is_current'      => true,
                'description'     => 'Provide IT consulting, Laravel web development, systems analysis, and technical writing services to SME clients locally and internationally.',
                'highlights'      => [
                    'Developed custom Laravel web applications for business clients',
                    'Produced SRS documents, technical reports, and failure assessments',
                    'Delivered IT consulting for system evaluation and process improvement',
                    'Targeting US, Australian, and European client markets for freelance services',
                ],
                'tech_used'       => ['Laravel', 'PHP', 'MySQL', 'HTML5', 'Tailwind CSS', 'Git'],
                'sort_order'      => 3,
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::create($exp);
        }

        $this->command->info('Experiences seeded (' . count($experiences) . ' records)');
    }
}
