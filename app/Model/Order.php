<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Payment;
use App\Model\Shipment;
use DB;
class Order extends Model
{
    protected $table = 'sales_orders';
    protected $primaryKey = 'order_no';
    protected $appends = ['state_name','label_state','ready_to_ship_quantity','shipped_quantity','order_quantity','paid_amount','payment_due','state_bootstrap_class'];
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
        return $this->hasMany('App\Model\Shipment','order_no','order_no');
    }
    public function customer(){
        return $this->belongsTo('App\Model\Customer','debtor_no','debtor_no');
    }
    public function getPaymentDueAttribute(){
        $payments = Payment::where('order_no',$this->getKey())->where('status',0)->get();
        return count($payments);
    }
    public function getStateNameAttribute(){
        $status = $this->order_status;
        if($status == 0){
            return "Cancelled";
        }else if($status==2){
            if($this->existPendingPayments()){
                return "Awaiting Confirmation";
            }else{
                return "Pending";
            }
        }else if($status == 1){
            if($this->existReadyToShipShipment()){
                return "Ready to ship";
            }else if($this->checkAllPaymentArePaid() && $this->checkAllShipmentHaveTracking()){
                return "Complete";
            }else{
                return "Processing";
            }
        }
        return "Unknown State";
    }
    public function getLabelStateAttribute(){
        $status = $this->order_status;
        if($status == 0){
            return '<span class="label label-danger">Cancelled</span>';
        }else if($status==2){
            if($this->existPendingPayments()){
                return '<span class="label label-warning">Awaiting Confirmation</span>';
            }else{
                return '<span class="label label-default">Pending</span>';
            }
        }else if($status == 1){
            if($this->existReadyToShipShipment()){
                return '<span class="label label-info">Ready to ship</span>';
            }else if($this->checkAllPaymentArePaid() && $this->checkAllShipmentHaveTracking()){
                return '<span class="label label-success">Complete</span>';
            }else{
                return '<span class="label label-warning">Processing</span>';
            }
        }
        return '<span class="label label-danger">Unknown State</span>';
    }
    public function getStateBootstrapClassAttribute(){
        $status = $this->order_status;
        if($status == 0){
            return "danger";
        }else if($status==2){
            if($this->existPendingPayments()){
                return 'warning';
            }else{
                return 'default';
            }
        }else if($status == 1){
            if($this->existReadyToShipShipment()){
                return 'info';
            }else if($this->checkAllPaymentArePaid() && $this->checkAllShipmentHaveTracking()){
                return 'success';
            }else{
                return 'warning';
            }
        }
        return '<span class="label label-danger">Unknown State</span>';
    }
    public function existPendingPayments(){
        
        $state = Payment::where('order_no',$this->getKey())->where('status',0)->get();
        if(empty($state)){
            return false;
        }
        return true;
    }
    public function existReadyToShipShipment(){
        $shipment = Shipment::where('order_no',$this->getKey())->where('tracking_number',null)->get();
        if(!$shipment->isEmpty()){
            return true;
        }
        return false;
    }
    public function checkAllPaymentArePaid(){
        $payments = Payment::where('order_no',$this->getKey())->get();
        $amount = 0;
        if(!$payments->isEmpty()){
            foreach($payments as $payment){
                if($payment->status==1){
                    $amount += $payment->amount;
                }
            }
            if($amount >= $this->total){
                return true;
            }
            return false;
        }
        return false;
       
    }
    public function getPaidAmountAttribute(){
        $payments = Payment::where('order_no',$this->getKey())->where('status',1)->get();
        $amount = 0;
        if(!$payments->isEmpty()){
            foreach($payments as $payment){
                if($payment->status==1){
                    $amount += $payment->amount; 
                }
            }
            
        }
        return $amount;
       
    }
    public function checkAllShipmentHaveTracking(){
        $shipmentsNotHaveTracking = Shipment::where('order_no',$this->getKey())->whereNull('tracking_number')->get();
        $shipmentsHaveTracking = Shipment::where('order_no',$this->getKey())->whereNotNull('tracking_number')->get(); 
        if(!$shipmentsNotHaveTracking->isEmpty()){
            return false;
        }else{
            if(!$shipmentsHaveTracking->isEmpty()){
                return true;
            }
            return false;
        }
        return false;
    }
    public function getReadyToShipQuantityAttribute(){
        $quantity = DB::table('shipment_details')->select(DB::raw('SUM(quantity) as total_quantity'))->where('order_no',$this->getKey())->where('status',0)->groupBy('order_no')->first();
        if(!empty($quantity)){
            return $quantity->total_quantity;
        }
        return 0;
        
    }
    public function getShippedQuantityAttribute(){
        $quantity = DB::table('shipment_details')->select(DB::raw('SUM(quantity) as total_quantity'))->where('order_no',$this->getKey())->where('status',1)->groupBy('order_no')->first();
        if(!empty($quantity)){
            return $quantity->total_quantity;
        }
        return 0;
        
    }
    public function getOrderQuantityAttribute(){
        $quantity = DB::table('sales_order_details')->select(DB::raw('SUM(quantity) as total_quantity'))->where('order_no',$this->getKey())->groupBy('order_no')->first();
        if(!empty($quantity)){
            return $quantity->total_quantity;
        }
        return 0;
    }
    public function user(){
        return $this->hasOne('App\User','id','person_id');
    }

}
