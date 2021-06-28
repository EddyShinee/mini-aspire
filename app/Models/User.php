<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'name',
        'family_name',
        'middle_name',
        'last_name',
        'card_id',
        'phone_number',
        'birthday',
        'sex',
        'email',
        'email_verified_at',
        'password',
        'status',
        'remember_token',
    ];

    public function generateJwt()
    {
        try {

            $token = JWTAuth::fromUser($this, ['id' => $this->authToken]);

        } catch (JWTException $e) {
            return false;
        }

        return $token;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setNameAttribute($family_name, $middle_name, $last_name)
    {
        if($middle_name != "") {
            $this->attributes['name'] = $family_name. " " . $middle_name . " " . $last_name;
        } else {
            $this->attributes['name'] = $family_name. " " . $last_name;
        }
    }

}
