<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\ProjectTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectTranslation>
 */
class ProjectTranslationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'locale' => 'fr',
            'title' => fake()->sentence(3),
            'summary' => fake()->sentence(),
        ];
    }
}
