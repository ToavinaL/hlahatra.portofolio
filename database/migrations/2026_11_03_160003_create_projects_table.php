<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('cover_image')->nullable();
            $table->string('project_url')->nullable();
            $table->string('repository_url')->nullable();
            $table->date('started_on')->nullable();
            $table->date('ended_on')->nullable();
            // Nature de ma participation : personnel, équipe, maintenance. Vide tant que je ne l'ai pas précisée.
            $table->string('involvement')->nullable();
            $table->string('status')->default('draft')->index();
            $table->boolean('is_featured')->default(false);
            // Projet encore en développement : ne doit pas être présenté comme terminé.
            $table->boolean('is_ongoing')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
