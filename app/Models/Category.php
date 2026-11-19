<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory, HasTranslations;

    protected $fillable = ['slug', 'sort_order'];

    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    protected function name(): Attribute
    {
        return Attribute::get(fn () => $this->translate('name'));
    }
}
