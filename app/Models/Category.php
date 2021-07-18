<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    
    protected $table = "categories";

    protected $fillable = ["id", "name", "description", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];

    public function products() {
        //
        return $this->hasMany('App\Models\Product', 'category_id');
    }
    

}
