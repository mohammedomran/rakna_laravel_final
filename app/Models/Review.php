<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    
    protected $table = "reviews";

    protected $fillable = ["id", "user_id", "stars", "review", "status", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];


    public function user() {
        //
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    

}
