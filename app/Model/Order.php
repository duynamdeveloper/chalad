<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Payment;
use App\Model\Shipment;
class Order extends Model
{
    protected $table = 'sales_orders';
    protected $primaryKey = 'order_no';
    public function details()
    {
        return  $this->hasMany('App\Model\OrderDetail', 'order_no');
    }
    public function payments()
    {
        return $this->hasMany('App\Model\Payment', 'order_no');
    }
    public function shipments()
    {
        return $this->hasMany('App\Model\Shipment','order_no');
    }
    public function getOrderStatusAttribute($status){
        if($status == 0){
            return "Cancelled";
        }else if($status==2){
            if($this->existPendingPayments()){
                return "Awaiting Confirmation";
            }else{
                return "Pending";
            }
        }else if($status == 1){
            return "Confirm";
        }
        return "Unknown State";
    }
    public function existPendingPayments(){
        
        $state = Payment::where('sale_orders_no',$this->getKey())->where('status',0)->get();
        if(empty($state)){
            return false;
        }
        return true;
    }
    public function existReadyToShipShipment(){
        $state = Shipment::where('shipment');
    }
}
