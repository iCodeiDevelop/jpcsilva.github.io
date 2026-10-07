<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Certification;

class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        Certification::truncate();

        $certs = [
            [
                'name'           => 'Licensed Professional Teacher',
                'issuer'         => 'Professional Regulation Commission (PRC)',
                'issued_at'      => '2018-01-01',
                'expires_at'     => null,
                'credential_id'  => '',
                'credential_url' => 'https://www.prc.gov.ph',
                'skills_covered' => ['Teaching', 'Curriculum Design', 'Educational Assessment'],
                'is_visible'     => true,
                'sort_order'     => 1,
            ],
            [
                'name'           => 'ITIL® 4 Foundation',
                'issuer'         => 'AXELOS / PeopleCert',
                'issued_at'      => '2022-01-01',
                'expires_at'     => null,
                'credential_id'  => '',
                'credential_url' => 'https://www.axelos.com/certifications/itil-service-management',
                'skills_covered' => ['IT Service Management', 'ITSM', 'Service Value System', 'IT Operations'],
                'is_visible'     => true,
                'sort_order'     => 2,
            ],
            [
                'name'           => 'Computer System Servicing NC II',
                'issuer'         => 'Technical Education and Skills Development Authority (TESDA)',
                'issued_at'      => '2017-01-01',
                'expires_at'     => null,
                'credential_id'  => '',
                'credential_url' => 'https://www.tesda.gov.ph',
                'skills_covered' => ['Hardware Servicing', 'Network Setup', 'OS Installation', 'Computer Maintenance'],
                'is_visible'     => true,
                'sort_order'     => 3,
            ],
        ];

        foreach ($certs as $cert) {
            Certification::create($cert);
        }

        $this->command->info('Certifications seeded (' . count($certs) . ' records)');
    }
}
