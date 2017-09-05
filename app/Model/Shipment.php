<?php

namespace App\Model;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Model\Item;
use App\Model\StockMovement;
use App\Model\Order;
class Shipment extends Model
{
	protected $table = 'shipment';
  protected $remainingItems;

  public function details(){
    return $this->hasMany('App\Model\ShipmentDetail');
  }
  public function order(){
    return $this->belongsTo('App\Model\Order','order_no','order_no');
  }
  public function getAllshipment()
  { 
    $data = DB::table('shipment')
    ->leftJoin('shipment_details', 'shipment.id', '=', 'shipment_details.shipment_id')
    ->leftJoin('sales_orders','sales_orders.order_no','=','shipment_details.order_no')
    ->leftJoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
    ->select('shipment_details.shipment_id','sales_orders.reference','sales_orders.order_no as order_id','debtors_master.name','shipment.packed_date','shipment.status','debtors_master.debtor_no', DB::raw('sum(shipment_details.quantity) as total_shipment'))
    ->groupBy('shipment_details.shipment_id')
    ->orderBy('shipment.packed_date','DESC')
    ->get();
    return $data;
  }

  

  public function shipmentFiltering($from, $to, $customer, $status)
  { 
    $from = DbDateFormat($from);
    $to = DbDateFormat($to);
    $conditions = array();

    if($customer){
      $conditions['debtors_master.debtor_no'] = $customer;
    }
    if($status !='all'){
      $conditions['shipment.status'] = ($status=='packed') ? 0 : 1;
    }


    $data = DB::table('shipment')
    ->leftJoin('shipment_details', 'shipment.id', '=', 'shipment_details.shipment_id')
    ->leftJoin('sales_orders','sales_orders.order_no','=','shipment_details.order_no')
    ->leftJoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
    ->select('shipment_details.shipment_id','sales_orders.reference','sales_orders.order_no as order_id','debtors_master.name','shipment.packed_date','shipment.status','debtors_master.debtor_no', DB::raw('sum(shipment_details.quantity) as total_shipment'))
    ->groupBy('shipment_details.shipment_id')
    ->where('shipment.packed_date','>=',$from)
    ->where('shipment.packed_date','<=',$to)
    ->where($conditions)
    ->orderBy('shipment.packed_date','DESC')
    ->get();
    return $data;
  }

  public function getShipmentItemByOrderID($orderNo)
  {
    $data = DB::table('sales_order_details')
    ->where(['order_no'=>$orderNo])
    ->leftJoin('item_code', 'sales_order_details.stock_id', '=', 'item_code.stock_id')
    ->leftJoin('item_tax_types', 'item_tax_types.id','=','sales_order_details.tax_type_id')
    ->select('sales_order_details.*', 'item_code.id as item_id','item_tax_types.tax_rate')
    ->get();

    return $data;
  }


  public function getInvoicedItemsByOrderID($orderNo)
  {
    $data = DB::select(DB::raw("select so.*,COALESCE(sm.iqty,0) as item_invoiced,ic.id as item_id,itt.tax_rate from (SELECT * FROM `sales_order_details` where order_no = $orderNo)so left join (select stock_id, sum(qty) as iqty from stock_moves where order_no = $orderNo group by stock_id)sm on so.stock_id = sm.stock_id left join item_code as ic on ic.stock_id = so.stock_id left join item_tax_types as itt on itt.id = so.tax_type_id"));
    return $data;
  }

  public function calculateTaxRow($orderNo){
    $tax_rows = DB::select(DB::raw("select so.*,COALESCE(sm.iqty,0) as item_invoiced,COALESCE(sis.sqty,0) as item_shipted,ic.id as item_id,itt.tax_rate from (SELECT * FROM `sales_order_details` where order_no = $orderNo)so left join (select stock_id, sum(qty) as iqty from stock_moves where order_no = $orderNo group by stock_id)sm on so.stock_id = sm.stock_id left join item_code as ic on ic.stock_id = so.stock_id left join item_tax_types as itt on itt.id = so.tax_type_id left join (select stock_id, sum(quantity) as sqty from shipment_details where order_no = $orderNo group by stock_id)sis on so.stock_id = sis.stock_id"));      
   // d($tax_rows,1);
    $data = array();
    foreach($tax_rows as $k=>$result){
      $data[$k]['tax_amount'] = (((int)abs($result->item_invoiced)-$result->item_shipted)*$result->unit_price*$result->tax_rate)/100;
      $data[$k]['tax_rate']   = $result->tax_rate;
    }

    $tax_amount = [];
    $tax_rate   =[];
    $i=0;
    foreach ($data as $key => $value) {
     if(isset($tax_amount[$value['tax_rate']])){
       $tax_amount[strval($value['tax_rate'])] +=$value['tax_amount'];
     }else{
       $tax_amount[strval($value['tax_rate'])] =$value['tax_amount'];
     }

   }

   return $tax_amount;
 }

 public function getTotalShipmentByOrderNo($orderNo){

   $total = DB::table('shipment')
   ->leftJoin('shipment_details','shipment.id','=','shipment_details.shipment_id')
   ->where(['shipment.order_no'=> $orderNo])
   ->groupBy('shipment_details.order_no')
   ->sum('shipment_details.quantity');
 //d($total,1);
   return $total;

 }

 public function getTotalInvoicedByOrderNo($orderNo){
  $total = DB::table('stock_moves')->where('order_no',$orderNo)->groupBy('order_no')->sum('qty');
  return $total;  
}

public function getAvailableItemsByOrderID($orderNo){
  $items = DB::select(DB::raw("select so.*,COALESCE(sm.iqty,0) as item_invoiced,COALESCE(sis.sqty,0) as item_shipted,ic.id as item_id,itt.tax_rate from (SELECT * FROM `sales_order_details` where order_no = $orderNo)so left join (select stock_id, sum(qty) as iqty from stock_moves where order_no = $orderNo group by stock_id)sm on so.stock_id = sm.stock_id left join item_code as ic on ic.stock_id = so.stock_id left join item_tax_types as itt on itt.id = so.tax_type_id left join (select stock_id, sum(quantity) as sqty from shipment_details where order_no = $orderNo group by stock_id)sis on so.stock_id = sis.stock_id"));      
  return $items;
}

public function calculateTaxForDetail($shipment_id){
  $tax_amount = [];
  $tax_rate   =[];
  $price      = 0;
  $discount   = 0;
  $discountPriceAmount = 0;
  $i=0;
  $tax = DB::table('shipment_details')
  ->where('shipment_details.shipment_id',$shipment_id)
  ->leftjoin('item_tax_types','item_tax_types.id','=','shipment_details.tax_type_id')
  ->select('shipment_details.*','item_tax_types.tax_rate')
  ->get();

  $data = array();
  foreach($tax as $k=>$result){
    $price = ($result->quantity*$result->unit_price);
    $discount =  ($result->discount_percent*$price)/100;
    $discountPriceAmount = ($price-$discount);

    $data[$k]['tax_amount'] = ($discountPriceAmount*$result->tax_rate)/100;
    $data[$k]['tax_rate']   = $result->tax_rate;
  }
  foreach ($data as $key => $value) {
   if(isset($tax_amount[$value['tax_rate']])){
     $tax_amount[strval($value['tax_rate'])] +=$value['tax_amount'];
   }else{
     $tax_amount[strval($value['tax_rate'])] =$value['tax_amount'];
   }
 }
   // d($tax_amount,1);
 return $tax_amount;
}

public function getAllStockTransferByUserId($from, $to, $source, $destination, $id){
  $from = DbDateFormat($from);
  $to = DbDateFormat($to);

  if($source=='all' && $destination=='all'){
    $data = DB::table('stock_transfer')
    ->where('person_id',$id)
    ->whereDate('transfer_date','>=', $from)
    ->whereDate('transfer_date','<=', $to)
    ->orderBy('transfer_date','DESC')
    ->get(); 
  }else if( $source !='all' && $destination !='all' ){
    $data = DB::table('stock_transfer')
    ->where(['person_id'=>$id,'source'=>$source,'destination'=>$destination])
    ->whereDate('transfer_date','>=', $from)
    ->whereDate('transfer_date','<=', $to)
    ->orderBy('transfer_date','DESC')
    ->get(); 
  }else if( $source =='all' && $destination !='all' ){
    $data = DB::table('stock_transfer')
    ->where(['person_id'=>$id,'destination'=>$destination])
    ->whereDate('transfer_date','>=', $from)
    ->whereDate('transfer_date','<=', $to)
    ->orderBy('transfer_date','DESC')
    ->get(); 
  }else if( $source !='all' && $destination =='all' ){
    $data = DB::table('stock_transfer')
    ->where(['person_id'=>$id,'source'=>$source])
    ->whereDate('transfer_date','>=', $from)
    ->whereDate('transfer_date','<=', $to)
    ->orderBy('transfer_date','DESC')
    ->get(); 
  }

  return $data;
}
  /**
  * Find shipment by order_no
  * @author: Nam Nguyen
  * @param: $order_no
  * @return: $data
  **/
  public function getShipmentByOrderNo($order_no, $location_id,$unshipped_state=false){
    $itemObject = new Item();
    $fetchModeBefore = DB::getFetchMode();
    DB::setFetchMode(\PDO::FETCH_ASSOC);
    if($unshipped_state==true){
      $data['shipments'] = DB::table('shipment')->where('order_no',$order_no)->where('tracking_number',null)->get();
    }else{
      $data['shipments'] = DB::table('shipment')->where('order_no',$order_no)->get();
    }
    
    if(count($data['shipments'])>0){
      foreach ($data['shipments'] as $s_key => $shipment) {
        # code...

        $data['shipments'][$s_key]['details'] = DB::table('shipment_details')->where('shipment_id', $shipment['id'])->get();
        foreach ($data['shipments'][$s_key]['details'] as $key => $detail) {
          $stock = DB::table('item_code')->where('stock_id', $detail['stock_id'])->first();
          $stock_order_qty = DB::table('sales_order_details')->where('order_no', $order_no)->where('stock_id',$detail['stock_id'])->select('quantity')->first();
          $stock['order_qty'] = $stock_order_qty['quantity'];
          $stock_qty = $itemObject->stock_validate($location_id, $stock['stock_id']);
          $stock['stock_qty'] = $stock_qty['total'];
          $stock_order_qty = DB::table('sales_order_details')->where('order_no', $order_no)->where('stock_id',$stock['stock_id'])->select('quantity')->first();
          $stock['stock_order_qty'] = $stock_order_qty['quantity'];
          $data['shipments'][$s_key]['details'][$key]['item'] = $stock;
        
       //  $test = array(
       //      "test"=>1,
       //      'tested'=>2
       //    );
       // $data['details'][$key]['tesst']=$test;
        }

      }
      DB::setFetchMode($fetchModeBefore);
      return $data;
    }
    DB::setFetchMode($fetchModeBefore);
    return null;

  }
  public function createShipment($order_no, $shipmentDetails){
    if($shipmentDetails!==null){
     $shipment['order_no'] = $order_no;
     $shipment['trans_type'] = '301';
     $shipment['status'] = 0;
     $shipment['packed_date'] = null;
     $shipment['created_at'] = date('Y-m-d H:i:s');
     $shipmentId = DB::table('shipment')->insertGetId($shipment);
     foreach ($shipmentDetails as $key => $detail) {
      $data['shipment_id']  = $shipmentId;
      $data['order_no'] = $order_no;
      $data['stock_id'] = $detail['stock_id'];
      $data['packed_qty'] = $detail['packed_qty'];
      $data['created_at'] = date('Y-m-d H:i:s');
      DB::table('shipment_details')->insert($data);
    }
    $stock_move = new StockMovement();
    $stock_move->updateStockMoveWithShipment($shipmentId);

  }

}
  public function addTrackingNumber($shipment_id,$tracking_number, $shipping_method){
    $shipment = DB::table('shipment')->where('id',$shipment_id)->first();
    $shipmentDetails = DB::table('shipment_details')->where('shipment_id',$shipment_id)->get();
    $stock_move = new StockMovement();
    if($tracking_number !== null){
      
      foreach($shipmentDetails as $detail){
      DB::table('shipment_details')->where('id',$detail->id)->update(['packed_qty'=>0,'shipped_qty'=>$detail->packed_qty]);
    
    } 

    }else{
      foreach($shipmentDetails as $detail){
      DB::table('shipment_details')->where('id',$detail->id)->update(['packed_qty'=>$detail->shipped_qty,'shipped_qty'=>0]);
    
    } 
    }
    $stock_move->updateStockMoveWithShipment($shipment_id);
    $this->updateOrderPackedShippedQty($shipment->order_no);
    DB::table('shipment')->where('id',$shipment_id)->update(['tracking_number'=>$tracking_number,'shipping_method'=>$shipping_method]);
  }
  public function removeShipment($shipment_id){
    $shipment = Shipment::find($shipment_id);
    $shipmentDetails = DB::table('shipment_details')->where('shipment_id',$shipment->id)->get();
    $query_state = true;
    if($shipmentDetails!==null){
      foreach ($shipmentDetails as $detail) {
      $orderDetail = DB::table('sales_order_details')->where('order_no',$shipment->order_no)->where('stock_id',$detail->stock_id)->first();
      $packed_qty = $this->subtractionReturnPositiveInt($orderDetail->packed_qty,$detail->packed_qty);
      $shipped_qty = $this->subtractionReturnPositiveInt($orderDetail->shipped_qty,$detail->shipped_qty);
     
      $query_state = DB::table('shipment_details')->where('id',$detail->id)->delete();
    }
    $this->updateOrderPackedShippedQty($shipment->order_no);
    }
    
    $query_state = $shipment->delete();
    $stock_move = new StockMovement();
    $stock_move->removeShipment($shipment_id);
    return $query_state;
  }
  public function updateOrderPackedShippedQty($order_no){
    $orderDetails = DB::table('sales_order_details')->where('order_no',$order_no)->get();
    foreach($orderDetails as $detail){
      $data = DB::table('shipment_details')->select(DB::raw('SUM(packed_qty) as packed_qty,SUM(shipped_qty) as shipped_qty'))->where('order_no',$order_no)->where('stock_id',$detail->stock_id)->groupBy('stock_id')->first();
      if($data!==null){
        DB::table('sales_order_details')->where('order_no',$order_no)->where('stock_id',$detail->stock_id)->update(['packed_qty'=>$data->packed_qty,'shipped_qty'=>$data->shipped_qty]);
      }else{
        DB::table('sales_order_details')->where('order_no',$order_no)->where('stock_id',$detail->stock_id)->update(['packed_qty'=>0,'shipped_qty'=>0]);
      }
     // 

    }
  }
  //Return zero if Subtraction'equal smaller than 0
  function subtractionReturnPositiveInt($number_one, $number_two){
    $equal = $number_one - $number_two;
    if($equal<0){
      return 0;
    }
    return $equal;
  }


}
