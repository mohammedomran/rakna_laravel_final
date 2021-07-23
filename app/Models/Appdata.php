<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appdata extends Model
{
    //
    
    protected $table = "app_data";

    protected $fillable = ["id", "item", "value", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];
    

}
