<?php

namespace Database\Factories;

use App\Enums\ProjectStatus;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug(3),
            'status' => ProjectStatus::Draft,
            'is_featured' => false,
            'is_ongoing' => false,
            'sort_order' => 0,
        ];
    }

    public function published(): static
    {
        return $this->state(['status' => ProjectStatus::Published]);
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }
}
