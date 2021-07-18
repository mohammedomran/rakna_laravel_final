<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    //
    
    protected $table = "bills";

    protected $fillable = ["id", "shipment_id", "price", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];

    public function shipment() {
        //
        return $this->belongsTo('App\Models\Shipment', 'shipment_id');
    }
    

}
