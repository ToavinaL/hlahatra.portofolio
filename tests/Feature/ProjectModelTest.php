<?php

namespace Tests\Feature;

use App\Enums\Involvement;
use App\Enums\ProjectStatus;
use App\Models\Category;
use App\Models\Project;
use App\Models\ProjectTranslation;
use App\Models\Technology;
use Database\Seeders\InitialContentSeeder;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectModelTest extends TestCase
{
    use RefreshDatabase;

    private function projectWithTranslations(array $locales): Project
    {
        $project = Project::factory()->create();

        foreach ($locales as $locale => $title) {
            $project->translations()->create(['locale' => $locale, 'title' => $title, 'summary' => 'Résumé']);
        }

        return $project->fresh();
    }

    public function test_it_returns_the_translation_of_the_current_language(): void
    {
        $project = $this->projectWithTranslations(['fr' => 'Titre FR', 'en' => 'Title EN']);

        app()->setLocale('fr');
        $this->assertSame('Titre FR', $project->title);

        app()->setLocale('en');
        $this->assertSame('Title EN', $project->title);
    }

    public function test_it_falls_back_to_french_when_the_translation_is_missing(): void
    {
        $project = $this->projectWithTranslations(['fr' => 'Titre FR']);

        app()->setLocale('en');

        $this->assertSame('Titre FR', $project->title);
        $this->assertTrue($project->hasTranslation('fr'));
        $this->assertFalse($project->hasTranslation('en'));
    }

    public function test_it_returns_null_when_no_translation_exists(): void
    {
        $project = Project::factory()->create();

        $this->assertNull($project->title);
    }

    public function test_a_project_cannot_have_two_translations_in_the_same_language(): void
    {
        $project = $this->projectWithTranslations(['fr' => 'Titre']);

        $this->expectException(UniqueConstraintViolationException::class);

        $project->translations()->create(['locale' => 'fr', 'title' => 'Doublon', 'summary' => 'Résumé']);
    }

    public function test_only_published_projects_are_returned_by_the_published_scope(): void
    {
        Project::factory()->published()->count(2)->create();
        Project::factory()->create();

        $this->assertCount(2, Project::published()->get());
    }

    public function test_featured_scope_returns_only_featured_projects(): void
    {
        Project::factory()->featured()->create();
        Project::factory()->count(2)->create();

        $this->assertCount(1, Project::featured()->get());
    }

    public function test_status_and_involvement_are_cast_to_enums(): void
    {
        $project = Project::factory()->create(['involvement' => 'team'])->fresh();

        $this->assertSame(ProjectStatus::Draft, $project->status);
        $this->assertSame(Involvement::Team, $project->involvement);
    }

    public function test_involvement_is_empty_until_it_is_specified(): void
    {
        $this->assertNull(Project::factory()->create()->fresh()->involvement);
    }

    public function test_projects_are_found_by_slug(): void
    {
        $this->assertSame('slug', (new Project)->getRouteKeyName());
    }

    public function test_projects_and_technologies_are_linked_both_ways(): void
    {
        $project = Project::factory()->create();
        $technology = Technology::factory()->create();

        $project->technologies()->attach($technology);

        $this->assertTrue($project->fresh()->technologies->contains($technology));
        $this->assertTrue($technology->fresh()->projects->contains($project));
    }

    public function test_a_project_belongs_to_a_category_with_translated_name(): void
    {
        $category = Category::factory()->create();
        $category->translations()->create(['locale' => 'fr', 'name' => 'Sites vitrines']);
        $category->translations()->create(['locale' => 'en', 'name' => 'Showcase websites']);
        $project = Project::factory()->create(['category_id' => $category->id]);

        app()->setLocale('en');

        $this->assertSame('Showcase websites', $project->category->name);
    }

    public function test_deleting_a_category_keeps_its_projects(): void
    {
        $category = Category::factory()->create();
        $project = Project::factory()->create(['category_id' => $category->id]);

        $category->delete();

        $this->assertNull($project->fresh()->category_id);
    }

    public function test_deleting_a_project_removes_its_dependent_data_but_keeps_technologies(): void
    {
        $project = $this->projectWithTranslations(['fr' => 'Titre', 'en' => 'Title']);
        $project->images()->create(['path' => 'projects/a.webp', 'alt' => ['fr' => 'Capture']]);
        $project->technologies()->attach(Technology::factory()->create());

        $project->delete();

        $this->assertDatabaseCount('project_translations', 0);
        $this->assertDatabaseCount('project_images', 0);
        $this->assertDatabaseCount('project_technology', 0);
        $this->assertDatabaseCount('technologies', 1);
    }

    public function test_images_are_ordered_and_have_alternative_text_per_language(): void
    {
        $project = Project::factory()->create();
        $project->images()->create(['path' => 'b.webp', 'alt' => ['fr' => 'Seconde'], 'sort_order' => 2]);
        $project->images()->create(['path' => 'a.webp', 'alt' => ['fr' => 'Capture', 'en' => 'Screenshot'], 'sort_order' => 1]);

        $first = $project->images()->first();

        $this->assertSame('a.webp', $first->path);

        app()->setLocale('en');
        $this->assertSame('Screenshot', $first->altFor());

        $second = $project->images()->reorder('sort_order', 'desc')->first();
        $this->assertSame('Seconde', $second->altFor());
    }

    public function test_initial_content_seeder_creates_all_projects_as_published(): void
    {
        $this->seed(InitialContentSeeder::class);

        $this->assertSame(8, Project::count());
        $this->assertSame(6, Category::count());
        $this->assertSame(8, Project::published()->count());

        foreach (Project::with('translations', 'technologies')->get() as $project) {
            $this->assertTrue($project->hasTranslation('fr'), $project->slug.' sans traduction française');
            $this->assertTrue($project->hasTranslation('en'), $project->slug.' sans traduction anglaise');
            $this->assertTrue($project->technologies->isNotEmpty(), $project->slug.' sans technologie');
        }

        $this->assertEqualsCanonicalizing(
            ['Symfony 5', 'Stripe', 'Mercure'],
            Project::where('slug', 'plateforme-encheres')->first()->technologies->pluck('name')->all()
        );
    }

    public function test_initial_content_seeder_can_run_twice_without_duplicates(): void
    {
        $this->seed(InitialContentSeeder::class);
        $this->seed(InitialContentSeeder::class);

        $this->assertSame(8, Project::count());
        $this->assertSame(16, ProjectTranslation::count());
        $this->assertSame(11, Technology::count());
    }

    public function test_selected_projects_are_featured(): void
    {
        $this->seed(InitialContentSeeder::class);

        $this->assertEqualsCanonicalizing(
            ['mortal-kombat-madagascar', 'cleanlyst', 'plateforme-encheres', 'vente-infrastructures-reseau'],
            Project::featured()->pluck('slug')->all()
        );
    }
}
