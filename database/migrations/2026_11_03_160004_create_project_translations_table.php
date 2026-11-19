<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('locale', 5);
            $table->string('title');
            $table->text('summary');
            $table->text('description')->nullable();
            $table->text('context')->nullable();
            $table->text('problem')->nullable();
            $table->text('solution')->nullable();
            $table->text('contributions')->nullable();
            $table->text('features')->nullable();
            $table->string('cover_alt')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->timestamps();

            $table->unique(['project_id', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_translations');
    }
};
