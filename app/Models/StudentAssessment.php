<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        "assessment_aspect_id",
        "student_id",
        "assessment",
        "company_score",
        "teacher_score"
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function assessment_aspect() {
        return $this->belongsTo(AssessmentAspect::class);
    }
}
