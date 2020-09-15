<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

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
