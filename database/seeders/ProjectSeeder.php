<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::truncate();

        $projects = [
            [
                'title'             => 'WiFi Captive Portal Management System',
                'slug'              => 'wifi-captive-portal-system',
                'short_description' => 'A Laravel-based captive portal system providing controlled guest WiFi access with real-time session tracking, bandwidth management, and an intuitive admin dashboard.',
                'description'       => "## Overview\n\nBuilt a complete WiFi captive portal management system to replace manual guest network access at an institutional setting. The system provides seamless user authentication, real-time session monitoring, and granular bandwidth controls.\n\n## Key Features\n\n- **Guest Authentication** — Voucher-based and credential-based login flows\n- **Session Management** — Real-time tracking of active users, session duration, and data usage\n- **Bandwidth Controls** — Per-user and per-group bandwidth policies\n- **Admin Dashboard** — Live monitoring, usage analytics, and user management\n- **Automated Disconnection** — Session expiry and policy enforcement\n- **Usage Reports** — Daily and weekly bandwidth and user reports\n\n## Technical Challenges\n\nThe primary challenge was integrating with network-level controls (router APIs) while keeping the web interface responsive and real-time. Implemented long-polling for live session updates and a background job for automated session cleanup.\n\n## Outcome\n\nSignificantly reduced IT staff workload in managing guest network access, improved security posture, and provided actionable usage data for infrastructure planning.",
                'tech_stack'        => ['Laravel', 'PHP', 'MySQL', 'Bootstrap', 'JavaScript', 'Redis', 'Linux'],
                'links'             => ['github' => '', 'live' => '', 'case_study' => ''],
                'category'          => 'systems',
                'client'            => 'Institutional (San Pedro College)',
                'completed_at'      => '2024-03-01',
                'is_featured'       => true,
                'is_published'      => true,
                'sort_order'        => 1,
                'meta_title'        => 'WiFi Captive Portal System | John Paul Silva',
                'meta_description'  => 'Laravel-based captive portal system for institutional WiFi management with real-time session tracking and bandwidth controls.',
            ],
            [
                'title'             => 'Accounting Information System (AIS)',
                'slug'              => 'accounting-information-system',
                'short_description' => 'A full-featured double-entry accounting web application built with Laravel — covering general ledger, AR/AP, payroll, bank reconciliation, and financial reporting.',
                'description'       => "## Overview\n\nDesigned and developed a comprehensive Accounting Information System following Philippine Financial Reporting Standards (PFRS). The system replaces manual spreadsheet-based accounting for small to medium enterprises.\n\n## Modules\n\n- **General Ledger** — Double-entry bookkeeping with full audit trail\n- **Chart of Accounts** — Hierarchical account structure (5 levels)\n- **Accounts Receivable** — Invoice generation, payment tracking, aging reports\n- **Accounts Payable** — Vendor bills, purchase orders, payment runs\n- **Bank Reconciliation** — Statement import (CSV) and transaction matching\n- **Payroll** — Philippine statutory deductions (SSS, PhilHealth, Pag-IBIG, BIR)\n- **Fixed Assets** — Depreciation schedules (SL, DB, SYD methods)\n- **Financial Reports** — Balance Sheet, Income Statement, Cash Flow, Trial Balance\n\n## Architecture\n\nBuilt on Laravel 11 with MVC + Service Layer pattern. Role-based access control (Admin, Finance Manager, Accountant, Clerk). All monetary values stored as DECIMAL(15,2). ACID-compliant transactions for all financial operations.\n\n## Outcome\n\nProduction-ready system with complete SRS documentation, ERD, DFD diagrams, and API documentation.",
                'tech_stack'        => ['Laravel 11', 'PHP 8.3', 'MySQL', 'Blade', 'Tailwind CSS', 'Alpine.js', 'DomPDF', 'Laravel Excel'],
                'links'             => ['github' => '', 'live' => '', 'case_study' => ''],
                'category'          => 'systems',
                'client'            => 'SME (Philippines)',
                'completed_at'      => '2024-06-01',
                'is_featured'       => true,
                'is_published'      => true,
                'sort_order'        => 2,
                'meta_title'        => 'Accounting Information System | John Paul Silva',
                'meta_description'  => 'Full-featured Laravel accounting system with double-entry bookkeeping, payroll, and PFRS-compliant financial reporting.',
            ],
            [
                'title'             => 'Digital Literacy Program — Matigsalug Community',
                'slug'              => 'digital-literacy-program-matigsalug',
                'short_description' => 'Designed and delivered a comprehensive Digital Literacy Program for the Matigsalug indigenous community in Marilog District, Davao City — complete with Bisaya-language training materials.',
                'description'       => "## Project Overview\n\nLed the design and delivery of a Digital Literacy Program for the Matigsalug indigenous people (IP) community in Marilog District, Davao City — adhering to the Free, Prior, and Informed Consent (FPIC) requirements under RA 8371 (IPRA).\n\n## What I Built\n\n- **Bisaya-language training compendium** covering MS Word, PowerPoint, and Excel modules\n- **PowerPoint presentation decks** tailored for low digital-literacy audiences\n- **Assessment instruments** — pre/post evaluation forms, Likert-scale surveys\n- **Certificates of Completion** and official program documentation\n- **Research instruments** — data collection tools for program evaluation\n\n## Curriculum Design\n\nModules were designed using cognitive load theory principles — simplified language, visual-first instruction, and culturally relevant examples. All materials were translated to Bisaya with community liaison support.\n\n## Impact\n\nSuccessfully trained indigenous community members in basic digital tools, contributing to their participation in the digital economy. Program outcomes documented in a formal research study following ethical research standards.",
                'tech_stack'        => ['Microsoft Word', 'PowerPoint', 'Excel', 'Canva', 'Google Forms', 'Research Design'],
                'links'             => ['github' => '', 'live' => '', 'case_study' => ''],
                'category'          => 'web',
                'client'            => 'Matigsalug IP Community / ICTC',
                'completed_at'      => '2023-12-01',
                'is_featured'       => true,
                'is_published'      => true,
                'sort_order'        => 3,
                'meta_title'        => 'Digital Literacy Program for Indigenous Community | John Paul Silva',
                'meta_description'  => 'Bilingual digital literacy training program designed and delivered for the Matigsalug indigenous community in Davao City.',
            ],
            [
                'title'             => 'Portfolio Management System',
                'slug'              => 'portfolio-management-system',
                'short_description' => 'This portfolio website itself — a full-stack Laravel CMS with an admin panel for managing projects, skills, experience, blog posts, and contact messages.',
                'description'       => "## Overview\n\nBuilt this portfolio from scratch as both a professional showcase and a demonstration of Laravel development capabilities. The system includes a public-facing portfolio and a full content management admin panel.\n\n## Features\n\n- **Admin CMS** — Manage all portfolio content without touching code\n- **Projects CRUD** — Rich descriptions, tech stack, screenshots, links\n- **Skills Management** — Categorized with proficiency levels and reordering\n- **Experience Timeline** — Visual timeline with highlights and tech tags\n- **Blog Module** — Markdown-supported posts with tags and SEO\n- **Contact Form** — Rate-limited with email notification\n- **SEO Management** — Meta tags, OG images, slugs per entity\n- **Dark Mode** — System-aware theme switching\n\n## Tech Highlights\n\nBuilt with Laravel 11, Tailwind CSS, and Alpine.js. Minimal dependencies, fast page loads, and easy to self-host on shared hosting.",
                'tech_stack'        => ['Laravel 11', 'PHP', 'MySQL', 'Tailwind CSS', 'Alpine.js', 'Blade'],
                'links'             => ['github' => 'https://github.com/jpsilva/portfolio', 'live' => 'https://johnpaulsilva.dev'],
                'category'          => 'web',
                'client'            => 'Personal Project',
                'completed_at'      => '2024-07-01',
                'is_featured'       => false,
                'is_published'      => true,
                'sort_order'        => 4,
                'meta_title'        => 'Portfolio CMS | John Paul Silva',
                'meta_description'  => 'Laravel-powered portfolio website with full CMS capabilities for managing projects, skills, blog, and contact messages.',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }

        $this->command->info('Projects seeded (' . count($projects) . ' records)');
    }
}
