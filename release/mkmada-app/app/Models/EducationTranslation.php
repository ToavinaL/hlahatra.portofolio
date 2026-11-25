<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EducationTranslation extends Model
{
    protected $fillable = ['locale', 'title', 'description'];

    public function education(): BelongsTo
    {
        return $this->belongsTo(Education::class);
    }
}
