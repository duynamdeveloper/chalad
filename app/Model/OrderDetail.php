<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ShipmentDetail;
class OrderDetail extends Model
{
    protected $table = "sales_order_details";
    protected $appends = ['pending_quantity'];
    public function order(){
        return $this->belongsTo('App\Model\Order','order_no','order_no');
    }
    public function item(){
        return $this->hasOne('App\Model\Item','stock_id','stock_id');
    }
    public function getPendingQuantityAttribute(){
        $shipment_details = ShipmentDetail::where('stock_id',$this->stock_id)->where('order_no',$this->order_no)->get();
        $shipment_quantity = 0;
        if(!empty($shipment_details)){
            foreach($shipment_details as $detail){
                $shipment_quantity += $detail->quantity;
            }
            $pending_quantity = $this->quantity - $shipment_quantity;
            return $pending_quantity;
        }
        return 0;
        
    }
}
