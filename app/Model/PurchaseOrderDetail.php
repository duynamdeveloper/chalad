<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $table = "purch_order_details";

    public function item(){
        return $this->hasOne('App\Model\Item','stock_id','stock_id');
    }
}
