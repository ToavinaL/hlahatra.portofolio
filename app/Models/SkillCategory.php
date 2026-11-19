<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\SkillCategoryFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillCategory extends Model
{
    /** @use HasFactory<SkillCategoryFactory> */
    use HasFactory, HasTranslations;

    protected $fillable = ['slug', 'sort_order'];

    public function translations(): HasMany
    {
        return $this->hasMany(SkillCategoryTranslation::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class)->orderBy('sort_order');
    }

    protected function name(): Attribute
    {
        return Attribute::get(fn () => $this->translate('name'));
    }
}
