<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentAspect extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "is_active"
    ];

    public function assessment() {
        return $this->hasMany(StudentAssessment::class);
    }
}
