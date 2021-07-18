<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{    
    
    //
    
    protected $table = "wishlists";

    protected $fillable = ["id", "user_id", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];

    public function user() {
        //
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    
    public function products() {
        //
        return $this->belongsToMany("App\Models\Product", "wishlists_products", "wishlist_id", "product_id");
    }

}
