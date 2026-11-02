<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EducationQualification extends Model
{
    protected $fillable = [
        'degree',
        'institution',
        'field_of_study',
        'start_year',
        'end_year',
        'grade',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
