<?php

namespace Tests\Feature;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
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
            ->assertSee('À propos de moi')
            ->assertSee('Je construis des expériences web')
            ->assertSee('Voir les projets');

        $this->get('/en')
            ->assertSee('About me')
            ->assertSee('I build web experiences that stand up to the real world.')
            ->assertSee('View projects')
            ->assertDontSee('À propos de moi');
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

    public function test_resume_pdf_can_be_downloaded_when_configured(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('resume/cv.pdf', '%PDF-1.4');
        Setting::set('resume.path', 'resume/cv.pdf');

        $this->get('/fr/resume/download')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf');
    }
}
