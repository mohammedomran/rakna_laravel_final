<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servo extends Model
{
    //
    
    protected $table = "servos";

    protected $fillable = ["id", "status", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];
    

}
