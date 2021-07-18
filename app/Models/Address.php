<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    
    protected $table = "addresses";

    protected $fillable = ["id", "user_id", "address", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];

    public function user() {
        //
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function orders() {
        //
        return $this->hasMany('App\Models\Order', 'address_id');
    }
    

}
