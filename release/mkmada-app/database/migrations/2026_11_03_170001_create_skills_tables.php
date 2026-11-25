<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('skill_category_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skill_category_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('name');
            $table->timestamps();

            $table->unique(['skill_category_id', 'locale']);
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            // On ne supprime pas une catégorie qui contient encore des compétences.
            $table->foreignId('skill_category_id')->constrained()->restrictOnDelete();
            $table->string('name');
            // Niveau de 1 à 5, saisi depuis l'administration. Vide tant qu'il n'est pas renseigné.
            $table->unsignedTinyInteger('level')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skills');
        Schema::dropIfExists('skill_category_translations');
        Schema::dropIfExists('skill_categories');
    }
};
