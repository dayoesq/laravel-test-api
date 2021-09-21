<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected const VERIFIED_USER = 1;
    protected const UNVERIFIED_USER = 0;

    protected const ADMIN_USER = true;
    protected const REGULAR_USER = false;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_token',
        'admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Determines wether admin or regular user
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->admin === User::ADMIN_USER;
    }

    /**
     * Determines wether user is verified or not
     *
     * @return boolean
     */
    public function isVerified() 
    {
        return $this->verified === User::VERIFIED_USER;
    }

    /**
     * Generates random token
     *
     * @return string
     */
    public static function generateRandomToken()
    {
        return bin2hex(random_bytes(10));
    }
}
