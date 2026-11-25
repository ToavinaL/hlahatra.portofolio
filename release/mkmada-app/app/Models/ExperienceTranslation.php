<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExperienceTranslation extends Model
{
    protected $fillable = ['locale', 'role', 'missions'];

    public function experience(): BelongsTo
    {
        return $this->belongsTo(Experience::class);
    }
}
