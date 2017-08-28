<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Payment;
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
            if($this->checkIfExistPendingPayments()){
                return "Awaiting Confirmation";
            }else{
                return "Pending";
            }
        }else if($status == 1){
            return "Confirm";
        }
        return "Nothing";
    }
    public function checkIfExistPendingPayments(){
        
        $state = Payment::where('sale_orders_no',$this->getKey())->where('status',0)->get();
        if(empty($state)){
            return false;
        }
        return true;
    }
}
