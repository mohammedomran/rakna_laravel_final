<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    //
    
    protected $table = "complaints";

    protected $fillable = ["id", "user_id", "order_id", "content", "status", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];


    public function user() {
        //
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function order() {
        //
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
    

}
