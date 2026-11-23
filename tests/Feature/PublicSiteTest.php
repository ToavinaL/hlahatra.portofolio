<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    /**
     * @return array<string, array{string, string}>
     */
    public static function pages(): array
    {
        $cases = [];

        foreach (['fr', 'en'] as $locale) {
            foreach (['', '/projects', '/resume', '/contact'] as $path) {
                $cases["{$locale}{$path}"] = [$locale, $path];
            }
        }

        return $cases;
    }

    public function test_root_redirects_to_the_default_language(): void
    {
        $this->get('/')->assertRedirect('/fr');
    }

    #[DataProvider('pages')]
    public function test_every_public_page_is_available_in_every_language(string $locale, string $path): void
    {
        $this->get("/{$locale}{$path}")
            ->assertOk()
            ->assertSee('<html lang="'.$locale.'"', false);
    }

    public function test_unsupported_language_is_not_found(): void
    {
        $this->get('/de')->assertNotFound();
        $this->get('/fr/about')->assertNotFound();
        $this->get('/de/about')->assertNotFound();
        $this->get('/fr/experience')->assertNotFound();
        $this->get('/fr/skills')->assertNotFound();
        $this->get('/fr/education')->assertNotFound();
    }

    public function test_home_page_is_translated(): void
    {
        $this->get('/fr')
            ->assertSee('Développeur Web Full Stack')
            ->assertSee('Voir les projets');

        $this->get('/en')
            ->assertSee('Full Stack Web Developer')
            ->assertSee('View projects')
            ->assertDontSee('Développeur Web Full Stack');
    }

    public function test_navigation_links_stay_in_the_current_language(): void
    {
        $this->get('/en')
            ->assertSee('href="'.url('/en/projects').'"', false)
            ->assertSee('href="'.url('/en/contact').'"', false);
    }

    public function test_navigation_marks_the_current_page(): void
    {
        $html = $this->get('/fr/resume')->getContent();

        // Une fois dans la navigation desktop, une fois dans le menu mobile.
        $this->assertSame(2, substr_count($html, 'aria-current="page"'));
    }

    public function test_language_switcher_keeps_the_current_page(): void
    {
        $this->get('/en/resume')
            ->assertSee('href="'.url('/fr/resume').'"', false)
            ->assertSee('hreflang="fr"', false)
            ->assertSee('hreflang="en"', false);
    }
}
