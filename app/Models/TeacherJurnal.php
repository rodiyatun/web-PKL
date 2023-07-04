<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherJurnal extends Model
{
    use HasFactory;

    protected $fillable = [
        "student_id",
        "title",
        "description",
        "teacher_id",
        "image"
    ];

    public function teacher() {
        return $this->belongsTo(Teacher::class);

    }

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
