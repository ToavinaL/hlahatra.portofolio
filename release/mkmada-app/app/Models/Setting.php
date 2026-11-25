<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Paramètres généraux et SEO, au format clé / valeur.
 *
 * Une valeur peut être un texte simple, ou un tableau par langue : ['fr' => '...', 'en' => '...'].
 */
class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected function casts(): array
    {
        return ['value' => 'json'];
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return static::where('key', $key)->first()?->value ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /** Valeur dans la langue demandée, avec repli sur la langue par défaut. */
    public static function localized(string $key, ?string $locale = null, mixed $default = null): mixed
    {
        $value = static::get($key);

        if (! is_array($value)) {
            return $value ?? $default;
        }

        return $value[$locale ?? app()->getLocale()]
            ?? $value[config('locales.default')]
            ?? $default;
    }
}
