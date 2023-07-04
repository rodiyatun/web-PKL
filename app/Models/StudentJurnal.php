<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentJurnal extends Model
{
    use HasFactory;

    protected $fillable = [
        "student_id",
        "title",
        "description",
        "image"
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
