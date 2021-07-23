<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;


    protected $table = "users";


    protected $fillable = ["id", "first_name", "last_name", "mobile", "email", "profile_pic", "password", "created_at", "updated_at"];

    protected $hidden = ["password", "updated_at"];


    
    public function orders() {
        //
        return $this->hasMany('App\Models\Order', 'user_id');
    }

    public function otps() {
        //
        return $this->hasMany('App\Models\Otp', 'user_id');
    }

    public function addresses() {
        //
        return $this->hasMany('App\Models\Address', 'user_id');
    }
    
    public function reviews() {
        //
        return $this->hasMany('App\Models\Review', 'user_id');
    }

    
    public function complaints() {
        //
        return $this->hasMany('App\Models\Complaint', 'user_id');
    }

    public function wishlist() {
        //
        return $this->hasOne('App\Models\Wishlist', 'user_id');
    }


    // Rest omitted for brevity

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
}