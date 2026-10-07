<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('description');
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();         // array of image paths
            $table->json('tech_stack');                  // ["Laravel","MySQL",...]
            $table->json('links')->nullable();           // {"live":"...","github":"...","case_study":"..."}
            $table->string('category')->default('web');  // web, mobile, systems, data, devops
            $table->string('client')->nullable();
            $table->date('completed_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->integer('views')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->index(['is_published', 'is_featured', 'sort_order']);
        });
    }
    public function down(): void { Schema::dropIfExists('projects'); }
};
