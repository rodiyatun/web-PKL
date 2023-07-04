<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPracticePlace extends Model
{
    use HasFactory;

    protected $fillable = [
        "practice_place_id",
        "student_id",
    ];

    public function student() {
        return $this->belongsTo(Student::class)->where('deleted_at', null);
    }

    public function practice_place() {
        return $this->belongsTo(PracticePlace::class);
    }
}
