<?php

namespace Tests\Feature;

use App\Models\Experience;
use Database\Seeders\ExperienceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExperienceHomepageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_homepage_displays_every_experience(): void
    {
        $recent = Experience::factory()->create(['company' => 'A2Mi', 'started_on' => '2022-10-01', 'ended_on' => '2023-10-01']);
        $recent->translations()->create(['locale' => 'fr', 'role' => 'Développeur Web Fullstack', 'missions' => 'Projet réseau']);

        $freelance = Experience::factory()->create(['company' => 'Freelance', 'started_on' => null]);
        $freelance->translations()->create(['locale' => 'fr', 'role' => 'Développeur Freelance', 'missions' => 'Projet e-sport']);

        $this->get('/fr')
            ->assertOk()
            ->assertSee('A2Mi')
            ->assertSee('Développeur Web Fullstack')
            ->assertSee('Freelance')
            ->assertSee('Développeur Freelance');
    }

    public function test_homepage_orders_experiences_from_most_recent_to_oldest(): void
    {
        $old = Experience::factory()->create(['company' => 'Ancienne', 'started_on' => '2019-01-01']);
        $old->translations()->create(['locale' => 'fr', 'role' => 'Ancien rôle']);

        $recent = Experience::factory()->create(['company' => 'Récente', 'started_on' => '2024-01-01']);
        $recent->translations()->create(['locale' => 'fr', 'role' => 'Rôle récent']);

        $html = $this->get('/fr')->assertOk()->getContent();

        $this->assertLessThan(strpos($html, 'Ancienne'), strpos($html, 'Récente'));
    }

    public function test_homepage_displays_experience_titles_without_project_missions(): void
    {
        $this->seed(ExperienceSeeder::class);

        $this->get('/fr')
            ->assertOk()
            ->assertSee('A2Mi')
            ->assertSee('Développeur Web Fullstack')
            ->assertSee('Freelance')
            ->assertSee('Développeur Freelance')
            ->assertDontSee('Plateforme de vente aux enchères en ligne');
    }
}
