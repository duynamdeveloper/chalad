<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShipmentDetail extends Model
{
    protected $table = 'shipment_details';

    public function shipment(){
        return $this->belongsTo('App\Model\Shipment');
    }
    public function item(){
        return $this->hasOne('App\Model\Item','stock_id','stock_id');
    }
}
