<?php

namespace Tests\Feature;

use App\Models\Project;
use Database\Seeders\InitialContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectsPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->seed(InitialContentSeeder::class);
    }

    public function test_homepage_displays_only_the_featured_projects(): void
    {
        $this->get('/fr')
            ->assertOk()
            ->assertSee('Mortal Kombat Madagascar')
            ->assertSee('Cleanlyst')
            ->assertSee("Plateforme d'enchères")
            ->assertSee('Gestion des ressources, utilisateurs et opérations')
            ->assertDontSee('Edentalflow');
    }

    public function test_projects_page_displays_all_published_projects_in_order(): void
    {
        $response = $this->get('/fr/projects')->assertOk();
        $html = $response->getContent();

        $this->assertSame(8, Project::published()->count());
        $this->assertSame(
            [
                'mortal-kombat-madagascar',
                'cleanlyst',
                'edentalflow',
                'reseau-soa',
                'vente-infrastructures-reseau',
                'plateforme-encheres',
                'location-materiel-evenementiel',
                'investissement-immobilier-corse',
            ],
            Project::ordered()->pluck('slug')->all()
        );
        $this->assertStringContainsString('Mortal Kombat Madagascar', $html);
        $this->assertStringContainsString('Cleanlyst', $html);
        $this->assertStringContainsString('Edentalflow', $html);
        $this->assertStringContainsString('Réseau Soa', $html);
    }

    public function test_project_site_links_are_rendered_only_when_present(): void
    {
        $this->get('/fr/projects')
            ->assertSee('https://mortalkombatmadagascar.gamer.free/', false)
            ->assertSee('https://cleanlyst.42web.io/', false)
            ->assertSee('target="_blank" rel="noopener noreferrer"', false)
            ->assertDontSee('Voir le code');
    }
}
