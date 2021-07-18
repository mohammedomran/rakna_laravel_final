<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branchimage extends Model
{
    //
    
    protected $table = "branchimages";

    protected $fillable = ["id", "product_id", "image", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];

    public function product() {
        //
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    

}
