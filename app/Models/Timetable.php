<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = 'timetables';
    protected $fillable = [
        'school_class_id', 
        'subject',
        'datetime',
    ];
    protected $hidden = [
    ];
    protected $casts = [
    ];
}
