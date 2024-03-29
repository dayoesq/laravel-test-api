<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Transformers\UserTransformer;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public UserTransformer | string $transformer = UserTransformer::class;

    const VERIFIED_USER = 1;
    const UNVERIFIED_USER = 0;

    const ADMIN_USER = true;
    const REGULAR_USER = false;

    protected $table = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
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
     * Determines whether admin or regular user
     *
     * @return boolean
     */
    public function isAdmin(): bool
    {
        return $this->admin === User::ADMIN_USER;
    }

    /**
     * Determines whether user is verified or not
     *
     * @return boolean
     */
    public function isVerified(): bool
    {
        return $this->verified === User::VERIFIED_USER;
    }

    /**
     * Generates random token
     *
     * @return string
     * @throws Exception
     */
    public static function generateRandomToken(): string
    {
       try {
           return bin2hex(random_bytes(10));
       } catch (Exception $e) {
           throw new Exception('Token generation failed ' . $e->getMessage(), 500);
       }
    }

    /**
     * Hash password
     *
     * @param $password
     * @return string
     * @throws Exception
     */
    public static function hash_password($password): string
    {
        try {
            return password_hash($password, PASSWORD_DEFAULT, ['cost' => '10']);
        } catch (Exception $e) {
            throw new Exception('Failed to hash password ' . $e->getMessage(), 500);
        }
    }

    /**
     * Setter for name attribute
     *
     */
    protected function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    /**
     * Getter for name attribute
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return ucwords($this->attributes['name']);
    }

    /**
     * Setter for email attribute
     *
     *
     */
    protected function setEmailAttribute($email): void
    {
        $this->attributes['email'] = strtolower($email);
    }

    /**
     * Getter for email attribute
     *
     * @return string
     */
    public function getEmailAttribute(): string
    {
        return $this->attributes['email'];
    }

}
