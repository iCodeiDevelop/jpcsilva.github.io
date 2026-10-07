<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        Blog::truncate();

        $posts = [
            [
                'title'          => 'Getting Started with ITIL 4: A Practical Guide for IT Professionals',
                'slug'           => 'getting-started-itil-4-practical-guide',
                'excerpt'        => 'ITIL 4 transformed how I think about IT service management. Here\'s what I learned from certification and how it applies to real-world IT operations.',
                'content'        => "# Getting Started with ITIL 4\n\nAfter completing my ITIL 4 Foundation certification, I want to share the key concepts that changed how I approach IT service delivery at ICTC, San Pedro College.\n\n## What is ITIL 4?\n\nITIL 4 (IT Infrastructure Library, version 4) is a globally recognized framework for IT Service Management (ITSM). Unlike its predecessors, ITIL 4 is flexible, practical, and integrates well with modern methodologies like Agile and DevOps.\n\n## The Service Value System\n\nThe core of ITIL 4 is the **Service Value System (SVS)**, which describes how all components and activities work together to enable value creation.\n\nKey components:\n- **Guiding Principles** — Universal recommendations that guide organizations\n- **Governance** — How the organization is directed and controlled\n- **Service Value Chain** — The operational model for creating, delivering, and improving services\n- **Practices** — Sets of resources for performing work\n- **Continual Improvement** — Recurring activities to ensure performance meets expectations\n\n## The 7 Guiding Principles\n\n1. **Focus on value** — Everything the organization does should link back to value for stakeholders\n2. **Start where you are** — Don't start from scratch; leverage what you already have\n3. **Progress iteratively with feedback** — Work in smaller iterations with feedback loops\n4. **Collaborate and promote visibility** — Work together across teams and share information\n5. **Think and work holistically** — No service stands alone\n6. **Keep it simple and practical** — Use minimum steps to accomplish goals\n7. **Optimize and automate** — Use technology to eliminate repetitive work\n\n## Applying ITIL 4 in a College IT Center\n\nAt ICTC, we applied these principles to improve our helpdesk operations:\n\n- Defined clear service catalog entries for faculty and student requests\n- Implemented incident categorization and priority levels\n- Created a knowledge base to reduce repeat tickets\n- Established change management procedures for critical system updates\n\n## Is ITIL 4 Worth It for Filipino IT Professionals?\n\nAbsolutely. The certification demonstrates a commitment to professional development and is recognized by international clients and employers. If you're targeting freelance clients in the US, AU, or EU markets — having ITIL on your credentials adds significant credibility.\n\n## Next Steps\n\nIf you're considering ITIL 4, start with the Foundation exam. Study the ITIL 4 Foundation book from AXELOS, take practice exams on platforms like MeasureUp, and consider joining online study groups. The exam is 40 questions, 60-minute pass mark of 65%.",
                'tags'           => ['ITIL', 'IT Service Management', 'Certifications', 'Professional Development'],
                'status'         => 'published',
                'is_featured'    => true,
                'reading_time'   => 8,
                'published_at'   => now()->subDays(14),
                'meta_title'     => 'Getting Started with ITIL 4 | John Paul Silva',
                'meta_description'=> 'A practical guide to ITIL 4 certification and how to apply its frameworks in real IT operations. Written by an ITIL-certified IT professional from the Philippines.',
            ],
            [
                'title'          => 'Building Your First Laravel Application: From Zero to Deployed',
                'slug'           => 'first-laravel-application-zero-to-deployed',
                'excerpt'        => 'Laravel remains the top PHP framework for a reason. This guide walks through building and deploying your first real Laravel app — from local setup to shared hosting.',
                'content'        => "# Building Your First Laravel Application\n\nLaravel is hands-down the best PHP framework for building modern web applications. After 5+ years of Laravel development, here's the guide I wish I had when starting out.\n\n## Why Laravel?\n\n- Elegant, expressive syntax\n- Built-in authentication, queues, events, broadcasting\n- Eloquent ORM makes database work a pleasure\n- Massive ecosystem (Livewire, Filament, Jetstream, Horizon)\n- Strong community and excellent documentation\n- Perfect for freelance — fast to build, easy to maintain\n\n## Prerequisites\n\n- PHP 8.2+\n- Composer\n- MySQL or PostgreSQL\n- Basic PHP knowledge\n\n## Step 1: Install Laravel\n\n```bash\ncomposer create-project laravel/laravel my-app\ncd my-app\nphp artisan serve\n```\n\n## Step 2: Configure Your .env\n\n```env\nAPP_NAME=\"My Application\"\nAPP_URL=http://localhost:8000\nDB_CONNECTION=mysql\nDB_DATABASE=my_app_db\nDB_USERNAME=root\nDB_PASSWORD=\n```\n\n## Step 3: Create Your First Model, Migration, Controller\n\n```bash\nphp artisan make:model Post -mrc\n```\n\nThis creates a Model, Migration, Resource Controller in one command.\n\n## Step 4: Define Your Schema\n\n```php\n// database/migrations/..._create_posts_table.php\npublic function up(): void {\n    Schema::create('posts', function (Blueprint $table) {\n        $table->id();\n        $table->string('title');\n        $table->string('slug')->unique();\n        $table->text('content');\n        $table->boolean('is_published')->default(false);\n        $table->timestamps();\n    });\n}\n```\n\n## Step 5: Run Migrations\n\n```bash\nphp artisan migrate\n```\n\n## Step 6: Build Your Views with Blade\n\nLaravel's Blade templating makes building UI fast and clean. Combine with Tailwind CSS for rapid UI development.\n\n## Deploying to Shared Hosting\n\nMost hosting providers (Hostinger, Namecheap) support Laravel:\n\n1. Upload files (exclude `node_modules`, `vendor`)\n2. Set document root to `/public`\n3. Run `composer install --no-dev` via SSH or hosting file manager\n4. Set up `.env` with production values\n5. Run `php artisan migrate --force` and `php artisan config:cache`\n\n## Tips for Filipino Freelancers\n\nIf you're using Laravel to serve international clients, make sure your hosting supports PHP 8.2+. Hostinger Philippines plans are affordable and support modern Laravel. For production apps with higher traffic, move to a DigitalOcean or Vultr VPS.",
                'tags'           => ['Laravel', 'PHP', 'Web Development', 'Deployment', 'Tutorial'],
                'status'         => 'published',
                'is_featured'    => true,
                'reading_time'   => 12,
                'published_at'   => now()->subDays(7),
                'meta_title'     => 'Building Your First Laravel Application | John Paul Silva',
                'meta_description'=> 'Step-by-step guide to building and deploying your first Laravel PHP application — from local setup to shared hosting deployment.',
            ],
        ];

        foreach ($posts as $post) {
            Blog::create($post);
        }

        $this->command->info('Blog posts seeded (' . count($posts) . ' records)');
    }
}
