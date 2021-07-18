<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //
    
    protected $table = "banners";

    protected $fillable = ["id", "image", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];
    

}
