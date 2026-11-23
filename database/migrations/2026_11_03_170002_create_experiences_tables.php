<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            // Entreprise ou contexte (freelance, projet personnel, etc.).
            $table->string('company')->nullable();
            $table->date('started_on')->nullable();
            $table->date('ended_on')->nullable();
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });

        Schema::create('experience_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experience_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('role');
            $table->text('missions')->nullable();
            $table->timestamps();

            $table->unique(['experience_id', 'locale']);
        });

        Schema::create('experience_technology', function (Blueprint $table) {
            $table->foreignId('experience_id')->constrained()->cascadeOnDelete();
            $table->foreignId('technology_id')->constrained()->cascadeOnDelete();

            $table->primary(['experience_id', 'technology_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experience_technology');
        Schema::dropIfExists('experience_translations');
        Schema::dropIfExists('experiences');
    }
};
