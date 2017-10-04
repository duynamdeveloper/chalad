<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PurchaseShipment extends Model
{
    protected $table = "purchase_shipments";
    protected $appends = ["state_name","state_label"];

     public function item(){
        return $this->hasOne('App\Model\Item','stock_id','stock_id');
    }
    public function purchase(){
    	$this->belongsTo('App\Model\Purchase','order_no','order_no');
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
}
