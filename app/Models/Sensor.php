<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    //
    
    protected $table = "sensors";

    protected $fillable = ["id", "status", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];
    

}
