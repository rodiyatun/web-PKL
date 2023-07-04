<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPresence extends Model
{
    use HasFactory;


    protected $fillable = [
        "student_id",
        "type",
        "image_presence",
        "longitude",
        "latitude",
        "ip_address",
        "region",
        "user_agent"
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
