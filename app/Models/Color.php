<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    //
    
    protected $table = "colors";

    protected $fillable = ["id", "color", "code", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];

    public function products() {
        //
        return $this->belongsToMany('App\Models\Product', 'colors_products', 'color_id', 'product_id');
    }
    

}
