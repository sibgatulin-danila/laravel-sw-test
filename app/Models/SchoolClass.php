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
        return $this->belongsTo(School::class, 'school_id');
    }
}
