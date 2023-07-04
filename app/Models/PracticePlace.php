<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PracticePlace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "user_id",
        "name",
        "address",
        "pic",
        "email",
        "phone"
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function student() {
        return $this->hasMany(StudentPracticePlace::class);
    }
}
