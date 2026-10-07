<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ── Hero ──────────────────────────────────────────
            ['key' => 'hero_greeting',       'value' => "Hi, I'm John Paul 👋",                         'group' => 'hero'],
            ['key' => 'hero_headline',       'value' => 'IT Consultant & Systems Analyst',               'group' => 'hero'],
            ['key' => 'hero_tagline',        'value' => 'I help organisations plan, build, and run technology that actually works — from Davao City to the world.', 'group' => 'hero'],
            ['key' => 'hero_cta_primary',    'value' => 'View My Work',                                  'group' => 'hero'],
            ['key' => 'hero_cta_secondary',  'value' => 'Get In Touch',                                  'group' => 'hero'],

            // ── About ─────────────────────────────────────────
            ['key' => 'about_bio',           'value' => "I'm John Paul C. Silva — IT consultant, systems analyst, and educator based in Davao City, Philippines. With over 8 years of experience spanning IT management, systems design, and professional training, I bridge the gap between complex technology and real-world business outcomes.\n\nAs Assistant Director of the Information and Communications Technology Center at San Pedro College and founder of a freelance consultancy targeting international clients, I've delivered technology solutions ranging from digital literacy programs for indigenous communities to enterprise systems for SMEs.\n\nWhether you need an IT strategy review, a thorough systems analysis, a technical report written to professional standards, or a training program your team will actually use — I'm available and ready to help.", 'group' => 'about'],
            ['key' => 'about_tagline',       'value' => 'ITIL v4 Certified · Licensed Professional Teacher · Computer System Servicing NC II', 'group' => 'about'],
            ['key' => 'availability_status', 'value' => 'open',                                           'group' => 'about'],
            ['key' => 'availability_note',   'value' => 'Open to freelance and contract projects — Philippines & worldwide', 'group' => 'about'],
            ['key' => 'resume_url',          'value' => '',                                                'group' => 'about'],

            // ── Profile ───────────────────────────────────────
            ['key' => 'full_name',           'value' => 'John Paul C. Silva',                             'group' => 'profile'],
            ['key' => 'display_name',        'value' => 'John Paul Silva',                                'group' => 'profile'],
            ['key' => 'title',               'value' => 'IT Consultant & Systems Analyst',                'group' => 'profile'],
            ['key' => 'location',            'value' => 'Davao City, Philippines',                        'group' => 'profile'],
            ['key' => 'email',               'value' => 'hello@jpcsilva.com',                             'group' => 'profile'],
            ['key' => 'timezone',            'value' => 'PHT (UTC+8)',                                    'group' => 'profile'],

            // ── Services (5 selected — no Laravel Dev) ────────
            ['key' => 'services', 'value' => json_encode([
                [
                    'icon'  => 'monitor',
                    'title' => 'IT Consulting',
                    'desc'  => 'Strategic IT advice for SMEs and institutions — infrastructure reviews, technology roadmaps, vendor evaluation, and process improvement. Helping you make smart technology decisions.',
                ],
                [
                    'icon'  => 'git-branch',
                    'title' => 'Systems Analysis & Design',
                    'desc'  => 'End-to-end systems analysis from requirements elicitation to solution design. Deliverables include SRS documents, ERDs, DFDs, and architecture recommendations aligned with your business goals.',
                ],
                [
                    'icon'  => 'file-text',
                    'title' => 'Technical Writing',
                    'desc'  => 'Clear, professional technical documentation — user manuals, SRS documents, API references, failure assessment reports, research papers, and training materials that non-technical stakeholders can actually understand.',
                ],
                [
                    'icon'  => 'presentation',
                    'title' => 'IT Training & Facilitation',
                    'desc'  => 'Hands-on training programs for MS Office, Google Workspace, Zoom, and custom business software. Curriculum design, module development, and facilitation — including inclusive programs for non-technical audiences.',
                ],
                [
                    'icon'  => 'clipboard-list',
                    'title' => 'IT Project Management',
                    'desc'  => 'End-to-end project coordination from planning to go-live. Requirements gathering, stakeholder communication, risk management, and delivery oversight using ITIL-aligned best practices.',
                ],
            ]), 'group' => 'about'],

            // ── Social ────────────────────────────────────────
            ['key' => 'github_url',    'value' => 'https://github.com/jpcsilva',                  'group' => 'social'],
            ['key' => 'linkedin_url',  'value' => 'https://linkedin.com/in/johnpaulcsilva',        'group' => 'social'],
            ['key' => 'facebook_url',  'value' => '',                                              'group' => 'social'],
            ['key' => 'twitter_url',   'value' => '',                                              'group' => 'social'],
            ['key' => 'upwork_url',    'value' => '',                                              'group' => 'social'],

            // ── SEO ───────────────────────────────────────────
            ['key' => 'meta_title',       'value' => 'John Paul Silva | IT Consultant & Systems Analyst — Davao City', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'ITIL v4-certified IT consultant and systems analyst based in Davao City, Philippines. Available for IT consulting, systems analysis, technical writing, and project management — local and worldwide.', 'group' => 'seo'],
            ['key' => 'meta_keywords',    'value' => 'IT consultant Philippines, systems analyst Davao, technical writer Philippines, IT project manager, ITIL certified Philippines, IT consulting Davao City', 'group' => 'seo'],
            ['key' => 'og_image',         'value' => '',                                           'group' => 'seo'],

            // ── Contact ───────────────────────────────────────
            ['key' => 'contact_heading',    'value' => "Let's Work Together",                      'group' => 'contact'],
            ['key' => 'contact_subheading', 'value' => 'Have an IT challenge or a project in mind? I read every message and respond within 24 hours.', 'group' => 'contact'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        $this->command->info('✅ Settings seeded — ' . count($settings) . ' records');
    }
}
