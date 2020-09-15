<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade', 
        'class', 
        'school_id',
        'user_id_from',
        'user_id_to',
    ];
    protected $hidden = [
    ];
    protected $casts = [
    ];

    public function user_from()
    {
        return $this->hasOne(User::class, 'user_id_from');
    }

    public function user_to()
    {
        return $this->hasOne(User::class, 'user_id_to');
    }

    public function school_id()
    {
        return $this->hasOne(School::class, 'school_id');
    }
}
