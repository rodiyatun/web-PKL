<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherPlace extends Model
{
    use HasFactory;

    protected $fillable = [
        "practice_place_id",
        "teacher_id",
    ];

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function practice_place() {
        return $this->belongsTo(PracticePlace::class);
    }
}
