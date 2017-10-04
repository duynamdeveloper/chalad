<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    protected $table = 'purchase_orders_payment';
    protected $appends = ['state_name','state_label','state_bootstrap_class'];

    public function purchase(){
    	return $this->belongsTo('App\Model\Purchase','order_no','order_no');
    }
    public function getStateNameAttribute(){
    $status = $this->status;
    if($status == 0){
      return "Pending";
    }else if($status == 1){
      return "Confirmed";
    }else{
      return "Unknown";
    }
  }
  public function getStateLabelAttribute(){
    $status = $this->status;
    if($status == 0){
      return '<label class="label label-default">Pending</label>';
    }else if($status == 1){
      return '<label class="label label-success">Confirm</label>';
    }else{
      return "Unknown";
    }
  }
    public function getStateBootstrapClassAttribute(){
        $status = $this->status;
        if($status == 0){
            return 'default';
        }else if($status == 1){
            return 'success';
        }else{
            return "danger";
        }
    }
}
