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
        'user_id',
        'subject_id',
    ];
    protected $hidden = [
    ];
    protected $casts = [
    ];

    public function user_from()
    {
        return $this->belongsTo(User::class, 'user_id_from');
    }

    public function user_to()
    {
        return $this->belongsTo(User::class, 'user_id_to');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
