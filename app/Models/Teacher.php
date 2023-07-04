<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "user_id", "nik", 'gender', 'date_birth', 'place_birth', 'gender', 'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
