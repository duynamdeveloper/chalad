<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = "sales_order_details";

    public function order(){
        $this->belongsTo('App\Model\Order','order_no','order_no');
    }
}
