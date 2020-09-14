<?php

namespace App\Models;

use App\Enums\UserSexType;
use App\Enums\UserType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'password',
        'sex',
        'role_id',
        'birthday',

        // students attributes
        'school_id',
        
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getSexAttribute($sValue)
    {
        if ($sValue) {
            return UserSexType::fromValue($sValue);
        }
    }

    public function getRoleAttribute($sValue)
    {
        if ($sValue) {
            return UserType::fromValue($sValue);
        }
    }

    public function setPasswordAttribute($sValue)
    {
        if ($sValue) {
            $this->attributes['password'] = Hash::make($sValue);
        }
    }
}
