<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->string('institution');
            $table->date('started_on')->nullable();
            $table->date('ended_on')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('education_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('education_id')->constrained('educations')->cascadeOnDelete();
            $table->string('locale', 5);
            // Diplôme ou intitulé de la formation.
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->unique(['education_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('education_translations');
        Schema::dropIfExists('educations');
    }
};
