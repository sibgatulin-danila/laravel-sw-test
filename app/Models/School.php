<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $appends = [
        'students_count',
    ];

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

    public function getStudentsCountAttribute()
    {
        $nSchoolId = $this->id;
        return User::whereRoleId(UserType::Student)
            ->whereHas('school_class', function ($obQuery) use ($nSchoolId) {
                $obQuery->whereSchoolId($nSchoolId);
            })
            ->count();
    }

    public function school_classes()
    {
        return $this->hasMany(SchoolClass::class, 'school_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'school_id');
    }
}
