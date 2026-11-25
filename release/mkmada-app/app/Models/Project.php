<?php

namespace App\Models;

use App\Enums\Involvement;
use App\Enums\ProjectStatus;
use App\Models\Concerns\HasTranslations;
use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    /** @use HasFactory<ProjectFactory> */
    use HasFactory, HasTranslations;

    protected $fillable = [
        'category_id',
        'slug',
        'cover_image',
        'project_url',
        'repository_url',
        'started_on',
        'ended_on',
        'involvement',
        'status',
        'is_featured',
        'is_ongoing',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'started_on' => 'date',
            'ended_on' => 'date',
            'involvement' => Involvement::class,
            'status' => ProjectStatus::class,
            'is_featured' => 'boolean',
            'is_ongoing' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProjectTranslation::class);
    }

    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('status', ProjectStatus::Published);
    }

    public function scopeFeatured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderByDesc('started_on');
    }

    protected function title(): Attribute
    {
        return Attribute::get(fn () => $this->translate('title'));
    }

    protected function summary(): Attribute
    {
        return Attribute::get(fn () => $this->translate('summary'));
    }
}
