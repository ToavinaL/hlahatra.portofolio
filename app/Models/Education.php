<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\EducationFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Education extends Model
{
    /** @use HasFactory<EducationFactory> */
    use HasFactory, HasTranslations;

    // Laravel considère « education » comme invariable au pluriel : on fixe le nom prévu au cahier des charges.
    protected $table = 'educations';

    protected $fillable = ['institution', 'started_on', 'ended_on', 'sort_order'];

    protected function casts(): array
    {
        return [
            'started_on' => 'date',
            'ended_on' => 'date',
        ];
    }

    public function translations(): HasMany
    {
        return $this->hasMany(EducationTranslation::class);
    }

    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderByDesc('started_on');
    }

    protected function title(): Attribute
    {
        return Attribute::get(fn () => $this->translate('title'));
    }
}
