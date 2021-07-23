<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    //
    
    protected $table = "otps";

    protected $fillable = ["id", "user_id", "otp", "status", "place",  "created_at", "updated_at"];

    protected $hidden = ["updated_at"];
    
    
    public function user() {
        //
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
