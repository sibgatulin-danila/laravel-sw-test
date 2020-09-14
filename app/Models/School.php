<?php

namespace App\Models;

class School extends Authenticatable
{
    protected $fillable = [
        'name', 
        'address', 
        'foundation_date',
        'closing_date',
    ];
    protected $hidden = [
    ];
    protected $casts = [
    ];

    public function students_count()
    {
        return $this->hasMany(User::class, 'school_id');
    }
}
