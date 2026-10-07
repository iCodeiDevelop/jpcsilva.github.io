<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->string('company');
            $table->string('company_url')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_remote')->default(false);
            $table->string('employment_type')->default('full-time');
            $table->date('start_date');
            $table->date('end_date')->nullable();       // null = present
            $table->boolean('is_current')->default(false);
            $table->text('description')->nullable();
            $table->json('highlights')->nullable();     // array of bullet strings
            $table->json('tech_used')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->index('start_date');
        });
    }
    public function down(): void { Schema::dropIfExists('experiences'); }
};
