<?php

namespace Tests\Feature;

use Tests\TestCase;

class LocalesConfigTest extends TestCase
{
    public function test_french_is_the_default_language(): void
    {
        $this->assertSame('fr', config('locales.default'));
        $this->assertSame(config('locales.default'), config('app.locale'));
    }

    public function test_french_and_english_are_supported(): void
    {
        $this->assertSame(['fr', 'en'], config('locales.supported'));
    }

    public function test_fallback_locale_is_a_supported_language(): void
    {
        $this->assertContains(config('app.fallback_locale'), config('locales.supported'));
    }

    public function test_every_supported_language_has_a_label(): void
    {
        foreach (config('locales.supported') as $locale) {
            $this->assertArrayHasKey($locale, config('locales.labels'));
        }
    }
}
