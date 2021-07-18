<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Editor extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = "editors";

    protected $fillable = ["id", "first_name", "last_name", "mobile", "email", "profile_pic", "password", "role", "created_at", "updated_at"];

    protected $hidden = ["password", "updated_at"];


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