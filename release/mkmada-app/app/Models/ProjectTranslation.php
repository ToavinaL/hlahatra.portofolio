<?php

namespace App\Models;

use Database\Factories\ProjectTranslationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectTranslation extends Model
{
    /** @use HasFactory<ProjectTranslationFactory> */
    use HasFactory;

    protected $fillable = [
        'locale',
        'title',
        'summary',
        'description',
        'context',
        'problem',
        'solution',
        'contributions',
        'features',
        'cover_alt',
        'seo_title',
        'seo_description',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
