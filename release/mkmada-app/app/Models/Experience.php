<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\ExperienceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Experience extends Model
{
    /** @use HasFactory<ExperienceFactory> */
    use HasFactory, HasTranslations;

    protected $fillable = ['company', 'started_on', 'ended_on', 'is_current'];

    protected function casts(): array
    {
        return [
            'started_on' => 'date',
            'ended_on' => 'date',
            'is_current' => 'boolean',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ExperienceTranslation::class);
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    /** Du plus récent au plus ancien. */
    public function scopeLatestFirst(Builder $query): void
    {
        $query->orderByDesc('started_on');
    }

    protected function role(): Attribute
    {
        return Attribute::get(fn () => $this->translate('role'));
    }
}
