<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    //
    
    protected $table = "shipments";

    protected $fillable = ["id", "vendor_id", "price", "created_at", "updated_at"];

    protected $hidden = ["updated_at"];

    public function vendor() {
        //
        return $this->belongsTo('App\Models\Vendor', 'vendor_id');
    }

    public function bills() {
        //
        return $this->hasMany('App\Models\Bill', 'shipment_id');
    }
    

}
