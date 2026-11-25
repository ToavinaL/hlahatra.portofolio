<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    protected $fillable = ['path', 'alt', 'sort_order'];

    protected function casts(): array
    {
        return ['alt' => 'array'];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /** Texte alternatif dans la langue demandée, avec repli sur la langue par défaut. */
    public function altFor(?string $locale = null): string
    {
        return $this->alt[$locale ?? app()->getLocale()]
            ?? $this->alt[config('locales.default')]
            ?? '';
    }
}
