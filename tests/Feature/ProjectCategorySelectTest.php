<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectCategorySelectTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_creation_displays_translated_category_names(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $category = Category::factory()->create();
        $category->translations()->create(['locale' => 'fr', 'name' => 'Sites vitrines']);
        $category->translations()->create(['locale' => 'en', 'name' => 'Showcase websites']);

        app()->setLocale('fr');

        $response = $this->actingAs($admin)->get('/admin/projets/create');

        $response->assertOk();
    }
}
