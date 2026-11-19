<?php

namespace Tests\Feature;

use Tests\TestCase;

class DesignSystemTest extends TestCase
{
    public function test_layout_declares_the_app_locale_and_the_page_title(): void
    {
        $this->withoutVite();

        $view = $this->blade('<x-layouts.app title="Accueil">Contenu</x-layouts.app>');

        $view->assertSee('<html lang="'.app()->getLocale().'"', false);
        $view->assertSee('Accueil | '.config('app.name'));
        $view->assertSee('id="contenu"', false);
        $view->assertSee('Contenu');
    }

    public function test_button_renders_a_link_when_given_an_href(): void
    {
        $view = $this->blade('<x-ui.button href="/projects">Voir les projets</x-ui.button>');

        $view->assertSee('<a href="/projects"', false);
        $view->assertSee('Voir les projets');
        $view->assertDontSee('<button', false);
    }

    public function test_button_renders_a_native_button_without_href(): void
    {
        $view = $this->blade('<x-ui.button>Envoyer</x-ui.button>');

        $view->assertSee('<button', false);
        $view->assertSee('type="button"', false);
    }

    public function test_button_ghost_variant_changes_the_style(): void
    {
        $primary = (string) $this->blade('<x-ui.button href="#">A</x-ui.button>');
        $ghost = (string) $this->blade('<x-ui.button href="#" variant="ghost">A</x-ui.button>');

        $this->assertStringContainsString('bg-accent', $primary);
        $this->assertStringContainsString('bg-surface', $ghost);
        $this->assertStringNotContainsString('bg-accent', $ghost);
    }

    public function test_badge_renders_its_content_and_supports_the_accent_tone(): void
    {
        $default = (string) $this->blade('<x-ui.badge>Laravel</x-ui.badge>');
        $accent = (string) $this->blade('<x-ui.badge tone="accent">Laravel</x-ui.badge>');

        $this->assertStringContainsString('Laravel', $default);
        $this->assertStringNotContainsString('bg-accent', $default);
        $this->assertStringContainsString('bg-accent', $accent);
    }

    public function test_meter_exposes_its_value_to_assistive_technologies(): void
    {
        $html = (string) $this->blade('<x-ui.meter label="Laravel" :value="3" :max="5" />');

        $this->assertStringContainsString('role="meter"', $html);
        $this->assertStringContainsString('aria-valuenow="3"', $html);
        $this->assertStringContainsString('aria-valuemax="5"', $html);
        $this->assertSame(3, substr_count($html, 'data-filled="true"'));
        $this->assertSame(2, substr_count($html, 'data-filled="false"'));
    }

    public function test_meter_keeps_the_value_within_bounds(): void
    {
        $tooHigh = (string) $this->blade('<x-ui.meter label="A" :value="9" :max="5" />');
        $tooLow = (string) $this->blade('<x-ui.meter label="A" :value="-2" :max="5" />');

        $this->assertSame(5, substr_count($tooHigh, 'data-filled="true"'));
        $this->assertSame(0, substr_count($tooLow, 'data-filled="true"'));
        $this->assertStringContainsString('aria-valuenow="0"', $tooLow);
    }

    public function test_section_heading_uses_the_requested_level(): void
    {
        $view = $this->blade('<x-ui.section-heading title="Projets" level="1">Une sélection</x-ui.section-heading>');

        $view->assertSee('<h1', false);
        $view->assertSee('Projets');
        $view->assertSee('Une sélection');
    }

    public function test_project_card_links_to_the_project_and_lists_technologies(): void
    {
        $view = $this->blade(
            '<x-ui.project-card title="Mortal Kombat Madagascar" summary="Plateforme communautaire." href="/fr/projects/mkmada" :technologies="[\'Laravel\', \'Livewire\']" />'
        );

        $view->assertSee('Mortal Kombat Madagascar');
        $view->assertSee('href="/fr/projects/mkmada"', false);
        $view->assertSee('Laravel');
        $view->assertSee('Livewire');
        $view->assertDontSee('<img', false);
    }

    public function test_project_card_renders_a_lazy_image_with_alternative_text(): void
    {
        $view = $this->blade(
            '<x-ui.project-card title="Cleanlyst" summary="Services." href="#" image="/storage/cleanlyst.webp" alt="Capture de Cleanlyst" />'
        );

        $view->assertSee('src="/storage/cleanlyst.webp"', false);
        $view->assertSee('loading="lazy"', false);
        $view->assertSee('alt="Capture de Cleanlyst"', false);
    }
}
