<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nisn', 'birth_place','birth_date', 'major_id', 'user_id'
    ];

    public function user() { //Karena relasi ke User, anda dapat buat function ini untuk relasinya
        return $this->belongsTo(User::class); //Pahami dahulu apa itu BelongsTo, Many To Many, One to Many, Many to One atau One to One
    }

    public function major() {
        return $this->belongsTo(Major::class);
    }

    public function student_du(){
        return $this->hasOne(StudentPracticePlace::class);
    }

    public function student_assesment() {
        return $this->hasMany(StudentAssessment::class);
    }
}
