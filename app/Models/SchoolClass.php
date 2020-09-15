<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'school_classes';
    protected $fillable = [
        'number', 
        'symbol', 
        'school_id',
    ];
    protected $hidden = [
    ];
    protected $casts = [
    ];
    
    public function school()
    {
        return $this->hasOne(School::class, 'school_id');
    }

    public function timetables()
    {
        return $this->belongsTo(Timetable::class, 'school_class_id');
    }
}
