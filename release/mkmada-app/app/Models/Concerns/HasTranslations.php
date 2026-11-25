<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * Pour les modèles qui ont une relation « translations » (une ligne par langue).
 *
 * Repli : langue courante, puis langue par défaut (français), sinon null.
 */
trait HasTranslations
{
    public function translation(?string $locale = null): ?Model
    {
        $translations = $this->loadMissing('translations')->translations;

        return $translations->firstWhere('locale', $locale ?? app()->getLocale())
            ?? $translations->firstWhere('locale', config('locales.default'));
    }

    public function translate(string $attribute, ?string $locale = null): mixed
    {
        return $this->translation($locale)?->{$attribute};
    }

    public function hasTranslation(string $locale): bool
    {
        return $this->loadMissing('translations')->translations->contains('locale', $locale);
    }
}
