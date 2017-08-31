<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\EmailController;
use App\Model\Shipment;
use App\Model\ShipmentDetail;
use App\Model\Item;
use App\Model\StockMovement;
use App\Http\Requests;
use App\Model\Orders;
use App\Model\Order;
use DB;
use PDF;
use Session;

class ShipmentController extends Controller
{
    public function __construct(
        Shipment $shipment,
        EmailController $email,
        Item $item,
        Orders $order,
        StockMovement $stock_move
    ) {

         /**
     * Set the database connection. reference app\helper.php
     */
        //selectDatabase();
         $this->shipment = $shipment;
         $this->email = $email;
         $this->item = $item;
         $this->order = $order;
         $this->stock_move = $stock_move;
    }

    public function index()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'shipment/list';
        $data['shipmentList'] = $this->shipment->getAllshipment();
        return view('admin.shipment.shipmentList', $data);
    }

    /**
    *Shipment filtering
    */

    public function shipmentFiltering()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'shipment/list';
        $data['statuses'] = array('packed'=>'Packed' ,'delivered'=>'Delivered');
        $data['customer'] = $customer = isset($_GET['customer']) ? $_GET['customer'] : null;
        $data['status'] = $status = isset($_GET['status']) ? $_GET['status'] : 'all';

        $data['customerList'] = DB::table('debtors_master')->select('debtor_no', 'name')->where(['inactive'=>0])->get();

        $fromDate = DB::table('shipment')->select('packed_date')->orderBy('packed_date', 'asc')->first();

        if (isset($_GET['from'])) {
            $data['from'] = $from = $_GET['from'];
        } else {
            $data['from'] = $from = formatDate(date("d-m-Y", strtotime($fromDate->packed_date)));
        }

        if (isset($_GET['to'])) {
            $data['to'] = $to = $_GET['to'];
        } else {
             $data['to'] = $to = formatDate(date('d-m-Y'));
        }


        $data['shipmentList'] = $this->shipment->shipmentFiltering($from, $to, $customer, $status);
        return view('admin.shipment.shipmentFilterList', $data);
    }
    /**
     * Show the form for creating a new shipment.
     */

    public function createShipment($orderNo)
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'shipment/list';
        $data['taxType'] = $this->shipment->calculateTaxRow($orderNo);
        $data['orderInfo'] = DB::table('sales_orders')
        ->leftjoin('cust_branch', 'cust_branch.branch_code', '=', 'sales_orders.branch_id')
        ->where('order_no', '=', $orderNo)
        ->first();
        $data['invoicedItems'] = DB::table('stock_moves')->where(['order_no'=>$orderNo,'trans_type'=>SALESINVOICE])->groupBy('stock_id')->lists('stock_id');
        $data['shipmentItem'] = $this->shipment->getInvoicedItemsByOrderID($orderNo);

        $invoicedTotal = $this->shipment->getTotalInvoicedByOrderNo($orderNo);
        $shipmentTotal = $this->shipment->getTotalShipmentByOrderNo($orderNo);
        $shipment = (int)abs($invoicedTotal)-$shipmentTotal;

        $data['shipmentStatus'] = ($shipment>0) ? 'available' : 'notAvailable';

        return view('admin.shipment.createShipment', $data);
    }

    /**
     * Update the specified resource in storage.
     **/
    public function storeShipment(Request $request)
    {

        $this->validate($request, [
        'packed_date' => 'required',
        ]);

        $orderNo = $request->order_no;
        $reference = $request->reference;

        $itemQty = $request->item_quantity;
        $stockIds = $request->stock_id;
        $itemIds = $request->item_id;
        $taxIds  = $request->tax_id;
        $discount  = $request->discount;
        $unitPrice  = $request->unit_price;

        // update sales_order table

        $shipmentData['order_no'] =  $orderNo;

        $shipmentData['trans_type'] =  DELIVERYORDER;
        $shipmentData['packed_date'] = DbDateFormat($request->packed_date);
        $shipmentData['comments'] = $request->comments;
        $shipmentId = DB::table('shipment')->insertGetId($shipmentData);

        DB::table('sales_orders')->where(['order_no'=>$orderNo,'reference'=>$reference])->update(['version'=>1]);

        $shipmentQty = array();
        $shipmentHistory = array();
        foreach ($stockIds as $key => $stockId) {
            $shipmentQty[$key]['stock_id'] = $stockId;
            $shipmentQty[$key]['shipment_qty'] = $itemQty[$key];
            $shipmentHistory[$key]['shipment_id'] =  $shipmentId;
            $shipmentHistory[$key]['order_no'] =  $orderNo;
            $shipmentHistory[$key]['stock_id'] =  $stockId;
            $shipmentHistory[$key]['tax_type_id'] =  $taxIds[$key];
            $shipmentHistory[$key]['discount_percent'] =  $discount[$key];
            $shipmentHistory[$key]['unit_price'] =  $unitPrice[$key];
            $shipmentHistory[$key]['quantity'] =  $itemQty[$key];
        }

        if (count($shipmentQty)>0) {
            foreach ($shipmentQty as $itemInfo) {
                 $previousShipmentQty = DB::table('sales_order_details')->where(['order_no'=>$orderNo,'trans_type'=>SALESORDER,'stock_id'=>$itemInfo['stock_id']])->sum('shipment_qty');
                 $shipmentQuantity = ($previousShipmentQty + $itemInfo['shipment_qty']);
                 DB::table('sales_order_details')->where(['order_no'=>$orderNo,'trans_type'=>SALESORDER,'stock_id'=>$itemInfo['stock_id']])->update(['shipment_qty'=>$shipmentQuantity]);
            }
        }

        if (count($shipmentHistory)>0) {
            for ($i=0; $i < count($shipmentHistory); $i++) {
                DB::table('shipment_details')->insert($shipmentHistory[$i]);
            }
        }

        \Session::flash('success', trans('message.success.save_success'));
        return redirect()->intended('shipment/view-details/'.$orderNo.'/'.$shipmentId);
    }

    public function storeAutoShipment($orderNo)
    {
        $shipmentItem = $this->shipment->getAvailableItemsByOrderID($orderNo);

        $shipmentData['order_no'] =  $orderNo;
        $shipmentData['trans_type'] =  DELIVERYORDER;
        $shipmentData['comments'] = 'Auto shipment';
        $shipmentData['packed_date'] = date('Y-m-d');
        $shipmentId = DB::table('shipment')->insertGetId($shipmentData);

        DB::table('sales_orders')->where(['order_no'=>$orderNo])->update(['version'=>1]);
        $shipmentQty = array();
        $shipmentHistory = array();
        foreach ($shipmentItem as $key => $item) {
            $shipmentQty[$key]['stock_id'] = $item->stock_id;
            $shipmentQty[$key]['shipment_qty'] = ((int)abs($item->item_invoiced)-$item->item_shipted);

               // Array for shipmentHistory
            $shipmentHistory[$key]['shipment_id'] =  $shipmentId;
            $shipmentHistory[$key]['order_no'] =  $orderNo;
            $shipmentHistory[$key]['stock_id'] =  $item->stock_id;
            $shipmentHistory[$key]['tax_type_id'] =  $item->tax_type_id;
            $shipmentHistory[$key]['discount_percent'] =  $item->discount_percent;
            $shipmentHistory[$key]['unit_price'] =  $item->unit_price;
            $shipmentHistory[$key]['quantity'] =  ((int)abs($item->item_invoiced)-$item->item_shipted);
        }

        if (count($shipmentQty)>0) {
            foreach ($shipmentQty as $itemInfo) {
                $previousShipmentQty = DB::table('sales_order_details')->where(['order_no'=>$orderNo,'trans_type'=>SALESORDER,'stock_id'=>$itemInfo['stock_id']])->sum('shipment_qty');
                $shipmentQuantity = ($previousShipmentQty + $itemInfo['shipment_qty']);
                DB::table('sales_order_details')->where(['order_no'=>$orderNo,'trans_type'=>SALESORDER,'stock_id'=>$itemInfo['stock_id']])->update(['shipment_qty'=>$shipmentQuantity]);
            }
        }

        if (count($shipmentHistory)>0) {
            for ($i=0; $i < count($shipmentHistory); $i++) {
                DB::table('shipment_details')->insert($shipmentHistory[$i]);
            }
        }

        \Session::flash('success', trans('message.success.save_success'));
        return redirect()->intended('shipment/view-details/'.$orderNo.'/'.$shipmentId);
    }

    public function StatusChange(Request $request)
    {
          $data = array();
          $data['status_no'] = 0;

          $shipment_id = $request['id'];
          $updated = DB::table('shipment')->where('id', $shipment_id)->update(['status'=>1,'delivery_date'=>date('Y-m-d')]);
        if ($updated) {
            $data['status_no'] = 1;
        }
          return $data;
    }

    public function makeDelivery($order_no, $shipment_id)
    {
          DB::table('shipment')->where('id', $shipment_id)->update(['status'=>1,'delivery_date'=>date('Y-m-d')]);

          \Session::flash('success', trans('message.success.save_success'));
          return redirect()->intended('shipment/view-details/'.$order_no.'/'.$shipment_id);
    }

    /**
    * Delete shipment by shipment id
    * @params shipment_id
    */
    public function destroy($shipment_id)
    {
        $shipments = DB::table('shipment')
        ->where('shipment.id', $shipment_id)
        ->leftjoin('shipment_details', 'shipment_details.shipment_id', '=', 'shipment.id')
        ->select('shipment_details.id', 'shipment_details.order_no', 'shipment_details.stock_id', 'shipment_details.quantity')
        ->get();
        foreach ($shipments as $key => $shipment) {
            $qty = DB::table('sales_order_details')
            ->where(['order_no'=>$shipment->order_no,'stock_id'=>$shipment->stock_id])
            ->sum('shipment_qty');
            $newQty = ($qty-$shipment->quantity);
            $updated = DB::table('sales_order_details')
            ->where(['order_no'=>$shipment->order_no,'stock_id'=>$shipment->stock_id])
            ->update(['shipment_qty'=>$newQty]);
        
            DB::table('shipment_details')->where(['id'=>$shipment->id])->delete();
        }

        DB::table('shipment')->where(['id'=>$shipment_id])->delete();
      
        \Session::flash('success', trans('message.success.delete_success'));
        return redirect()->intended('shipment/list');
    }

    /**
    * Details shipment by shipment id
    * @params shipment_id
    */
    public function shipmentDetails($order_no, $shipment_id)
    {
        $data = array();
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'shipment/list';
        $data['taxInfo'] = $this->shipment->calculateTaxForDetail($shipment_id);
        $data['shipmentItem'] = DB::table('shipment')
        ->where('shipment.id', $shipment_id)
        ->leftjoin('shipment_details', 'shipment_details.shipment_id', '=', 'shipment.id')
        ->leftjoin('item_code', 'shipment_details.stock_id', '=', 'item_code.stock_id')
        ->leftjoin('item_tax_types', 'item_tax_types.id', '=', 'shipment_details.tax_type_id')
        ->select('shipment_details.*', 'item_code.description', 'item_tax_types.tax_rate')
        ->orderBy('shipment_details.quantity', 'DESC')
        ->get();
        $data['customerInfo']  = DB::table('sales_orders')
        ->where('sales_orders.order_no', $order_no)
        ->leftjoin('debtors_master', 'debtors_master.debtor_no', '=', 'sales_orders.debtor_no')
        ->leftjoin('cust_branch', 'cust_branch.branch_code', '=', 'sales_orders.branch_id')
        ->leftjoin('countries', 'countries.id', '=', 'cust_branch.shipping_country_id')
        ->select('debtors_master.name', 'debtors_master.phone', 'debtors_master.email', 'cust_branch.br_name', 'cust_branch.br_address', 'cust_branch.shipping_street', 'cust_branch.shipping_city', 'cust_branch.shipping_state', 'cust_branch.shipping_zip_code', 'countries.country', 'cust_branch.shipping_country_id')
        ->first();
        $data['shipment']   = DB::table('shipment')
        ->where('id', $shipment_id)
        ->first();

      // Right side info
        $data['orderInfo']  = DB::table('sales_orders')
        ->leftjoin('location', 'location.loc_code', '=', 'sales_orders.from_stk_loc')
        ->where('order_no', $order_no)
        ->select('sales_orders.reference', 'sales_orders.order_no', 'location.location_name')
        ->first();
        $data['invoiceList'] = DB::table('sales_orders')
        ->where('order_reference', $data['orderInfo']->reference)
        ->select('order_no', 'reference', 'order_reference', 'total', 'paid_amount')
        ->orderBy('created_at', 'DESC')
        ->get();
        $data['invoiceQty'] = DB::table('stock_moves')->where(['order_no'=>$order_no,'trans_type'=>SALESINVOICE])->sum('qty');
        $data['orderQty'] = DB::table('sales_order_details')->where(['order_no'=>$order_no,'trans_type'=>SALESORDER])->sum('quantity');

        $data['paymentsList'] = DB::table('payment_history')
        ->where(['order_reference'=>$data['orderInfo']->reference])
        ->leftjoin('payment_terms', 'payment_terms.id', '=', 'payment_history.payment_type_id')
        ->select('payment_history.*', 'payment_terms.name')
        ->orderBy('payment_date', 'DESC')
        ->get();
        $data['shipmentList'] = DB::table('shipment_details')
        ->select('shipment_details.shipment_id', DB::raw('sum(quantity) as total'))->where(['order_no'=>$order_no])
        ->groupBy('shipment_id')
        ->orderBy('shipment_id', 'DESC')
        ->get();
      //d($data['orderInfo'],1);
        $shipmentTotal = $this->shipment->getTotalShipmentByOrderNo($order_no);

        $invoicedTotal = $this->shipment->getTotalInvoicedByOrderNo($order_no);
        $shipment = (int)abs($invoicedTotal)-(int)abs($shipmentTotal);

        $data['shipmentStatus'] = ($shipment>0) ? 'available' : 'notAvailable';

      
        if ($data['shipment']->status == 0) {
            $temp_id = 6;
        } else {
            $temp_id = 2;
        }
        $lang = Session::get('dflt_lang');
        $data['emailInfo'] = DB::table('email_temp_details')->where(['temp_id'=>$temp_id,'lang'=>$lang])->select('subject', 'body')->first();

      //d($data['customerInfo'],1);
        return view('admin.shipment.shipmentDetails', $data);
    }

    public function pdfMake($orderNo, $shipmentId)
    {

        $data['taxInfo'] = $this->shipment->calculateTaxForDetail($shipmentId);
        $data['shipmentItem'] = DB::table('shipment')
        ->where('shipment.id', $shipmentId)
        ->leftjoin('shipment_details', 'shipment_details.shipment_id', '=', 'shipment.id')
        ->leftjoin('item_code', 'shipment_details.stock_id', '=', 'item_code.stock_id')
        ->leftjoin('item_tax_types', 'item_tax_types.id', '=', 'shipment_details.tax_type_id')
        ->select('shipment_details.*', 'item_code.description', 'item_tax_types.tax_rate')
        ->orderBy('shipment_details.quantity', 'DESC')
        ->get();
        $data['customerInfo']  = DB::table('sales_orders')
        ->where('sales_orders.order_no', $orderNo)
        ->leftjoin('debtors_master', 'debtors_master.debtor_no', '=', 'sales_orders.debtor_no')
        ->leftjoin('cust_branch', 'cust_branch.branch_code', '=', 'sales_orders.branch_id')
        ->leftjoin('countries', 'countries.id', '=', 'cust_branch.shipping_country_id')
        ->select('debtors_master.name', 'debtors_master.phone', 'debtors_master.email', 'cust_branch.br_name', 'cust_branch.br_address', 'cust_branch.shipping_street', 'cust_branch.shipping_city', 'cust_branch.shipping_state', 'cust_branch.shipping_zip_code', 'countries.country', 'cust_branch.shipping_country_id')
        ->first();
        $data['shipment']   = DB::table('shipment')->where('id', $shipmentId)->select('id', 'status', 'delivery_date')->first();
        $data['order_no']   = $orderNo;

        $pdf = PDF::loadView('admin.shipment.shipmentDetailpdf', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('shipment_'.time().'.pdf', array("Attachment"=>0));
    }

    /**
    * Print of shipment details
    */

    public function shipmentPrint($orderNo, $shipmentId)
    {

        $data['taxInfo'] = $this->shipment->calculateTaxForDetail($shipmentId);
        $data['shipmentItem'] = DB::table('shipment')
        ->where('shipment.id', $shipmentId)
        ->leftjoin('shipment_details', 'shipment_details.shipment_id', '=', 'shipment.id')
        ->leftjoin('item_code', 'shipment_details.stock_id', '=', 'item_code.stock_id')
        ->leftjoin('item_tax_types', 'item_tax_types.id', '=', 'shipment_details.tax_type_id')
        ->select('shipment_details.*', 'item_code.description', 'item_tax_types.tax_rate')
        ->orderBy('shipment_details.quantity', 'DESC')
        ->get();
        $data['customerInfo']  = DB::table('sales_orders')
        ->where('sales_orders.order_no', $orderNo)
        ->leftjoin('debtors_master', 'debtors_master.debtor_no', '=', 'sales_orders.debtor_no')
        ->leftjoin('cust_branch', 'cust_branch.branch_code', '=', 'sales_orders.branch_id')
        ->leftjoin('countries', 'countries.id', '=', 'cust_branch.shipping_country_id')
        ->select('debtors_master.name', 'debtors_master.phone', 'debtors_master.email', 'cust_branch.br_name', 'cust_branch.br_address', 'cust_branch.shipping_street', 'cust_branch.shipping_city', 'cust_branch.shipping_state', 'cust_branch.shipping_zip_code', 'countries.country', 'cust_branch.shipping_country_id')
        ->first();
      //d($data['customerInfo'],1);
        $data['shipment']   = DB::table('shipment')->where('id', $shipmentId)->select('id', 'status', 'delivery_date')->first();
        $data['order_no']   = $orderNo;
      //d($data['shipment'],1);
        $pdf = PDF::loadView('admin.shipment.shipmentDetailPrint', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('shipment_'.time().'.pdf', array("Attachment"=>0));
    }

    /**
    * Edit shipment by shipment_id
    */
    public function edit($shipmentId)
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'shipment/list';
        $data['shipment_id'] = $shipmentId;
        $data['taxInfo'] = $this->shipment->calculateTaxForDetail($shipmentId);
        $data['shipmentItem'] = DB::table('shipment')
        ->where('shipment.id', $shipmentId)
        ->leftjoin('shipment_details', 'shipment_details.shipment_id', '=', 'shipment.id')
        ->leftjoin('item_code', 'shipment_details.stock_id', '=', 'item_code.stock_id')
        ->leftjoin('item_tax_types', 'item_tax_types.id', '=', 'shipment_details.tax_type_id')
        ->select('shipment_details.*', 'item_code.description', 'item_code.id as item_id', 'item_tax_types.tax_rate')
        ->orderBy('shipment_details.quantity', 'DESC')
        ->get();
        $shipment = DB::table('shipment')
        ->where('id', $shipmentId)
        ->select('order_no')
        ->first();
      
        $data['orderInfo'] = DB::table('sales_orders')
        ->leftjoin('cust_branch', 'cust_branch.branch_code', '=', 'sales_orders.branch_id')
        ->where('order_no', '=', $shipment->order_no)
        ->first();
      //d($data['orderInfo'],1);
        return view('admin.shipment.editShipment', $data);
    }

    public function shipmentQuantityValidation(Request $request)
    {
        $data['status_no'] = 0;
        $data['message'] = 'Not Available';

        $orderNo = $request['order_no'];
        $shipmentId = $request['shipment_id'];
        $stock_id = $request['stock_id'];
        $shifted_qty = $request['shifted_qty'];
        $new_qty = $request['new_qty'];
      
        $invoicedItemQtyInfo = (int)abs(DB::table("stock_moves")->where(['order_no'=>$orderNo,'stock_id'=>$stock_id])->groupBy('order_no')->sum('qty'));
        $shipmentItemQtyInfo = DB::table("sales_order_details")->where(['order_no'=>$orderNo,'stock_id'=>$stock_id])->sum('shipment_qty');
        $availableQty = ($invoicedItemQtyInfo-$shipmentItemQtyInfo+$shifted_qty);
        if ($availableQty>$new_qty || $availableQty==$new_qty) {
            $data['status_no'] = 1;
            $data['message'] = 'Available';
        }
        return json_encode($data);
    }
    
    /**
    *Update shipment by shipment id
    */
    public function update(Request $request)
    {
        $shipmentId = $request['shipment_id'];
        $orderInfo  = DB::table('shipment')->where('id', $shipmentId)->select('order_no')->first();
        $stockIds = $request['stock_id'];
        $quantityPrevious = $request['previous_qty'];
        $quantityNew = $request['item_quantity'];
        $orderNo = $request['order_no'];

        foreach ($stockIds as $key => $stockId) {
            $qtyShifted = DB::table('sales_order_details')->where(['stock_id'=>$stockIds[$key],'order_no'=>$orderNo[$key]])->sum('shipment_qty');
            if ($quantityPrevious[$key]>$quantityNew[$key]) {
                $qtyNew = ($qtyShifted+$quantityNew[$key]-$quantityPrevious[$key]);
                if ($quantityNew[$key] == 0) {
                    DB::table('shipment_details')->where(['shipment_id'=>$shipmentId,'stock_id'=>$stockIds[$key],'order_no'=>$orderNo[$key]])->delete();
                }
            } elseif ($quantityPrevious[$key]<$quantityNew[$key]) {
                $qtyNew = ($qtyShifted+$quantityNew[$key]-$quantityPrevious[$key]);
            } elseif ($quantityPrevious[$key]==$quantityNew[$key]) {
                $qtyNew = $qtyShifted;
            }

            DB::table('sales_order_details')->where(['stock_id'=>$stockIds[$key],'order_no'=>$orderNo[$key]])->update(['shipment_qty'=>$qtyNew]);
            DB::table('shipment_details')->where(['shipment_id'=>$shipmentId,'stock_id'=>$stockIds[$key],'order_no'=>$orderNo[$key]])->update(['quantity'=>$quantityNew[$key]]);
        }

        \Session::flash('success', trans('message.success.save_success'));
        return redirect()->intended('shipment/view-details/'.$orderInfo->order_no.'/'.$shipmentId);
    }

    /**
    * Send email to customer for shipment information
    */
    public function sendShipmentInformationByEmail(Request $request)
    {
        $this->email->sendEmail($request['email'], $request['subject'], $request['message']);
        \Session::flash('success', trans('message.email.email_send_success'));
        return redirect()->intended('shipment/view-details/'.$request['order_id'].'/'.$request['shipment_id']);
    }

    /**
    * Manage shipment module
    * @author: Nam Nguyen (Email: duynam.dev223@gmail.com Skype: duynam.dev)
    *
    */
    public function manageShipment()
    {
        $data = array();
        $data['confirmedOrders'] = DB::table('sales_orders')->where('order_status', 1)->get();
      
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'shipment/list';
        return view('admin.shipment.manageShipment', $data);
    }
    /**
    * Get shipment by order_no
    * @author: Nam Nguyen
    * @param: $order_no
    * @return: $shipment
    **/
    public function getShipmentByOrderNo(Request $request)
    {
        $order_no = $request->order_no;
      //$order_no = 3;
        $shipments = $this->shipment->getShipmentByOrderNo($order_no, 'PL', true);
     
        return response()->json(['state'=>true, 'shipments'=>$shipments]);
    }
    /**
    * @author: Nam Nguyen
    **/

    public function manualAllocate(Request $request)
    {

        $data = $request->data;
        $order_no = $request->order_no;
        $shipment_id = $request->shipment_id;
     //return response()->json(['data'=>$shipment_id]);
        $location_id = "PL";

        if ($shipment_id==-1) {
            $shipment = new Shipment();
            $shipment->order_no = $order_no;
            $shipment->trans_type = DELIVERYORDER;
            $shipment->save();
            foreach ($data as $key => $detail) {
                 $orderDetail = OrderDetail::where('order_no',$order_no)->where('stock_id',$detail[0])->first();
                 $add_packed_qty = 0;
                if ($unpacked_qty>$detail[1]) {
                    $add_packed_qty = $detail[1];
                } else {
                    $add_packed_qty = $unpacked_qty;
                }

       
                 $data = array(
                   'stock_id' =>$detail['0'],
                   'packed_qty' => $add_packed_qty
                   );
                  // var_dump($data);
                 array_push($insertShipmentDetailsData, $data);
            }
            $this->shipment->createShipment($order_no, $insertShipmentDetailsData);
        }
        $this->shipment->updateOrderPackedShippedQty($order_no);
        return response()->json($data);
    }
    public function automaticAllocateShipment(Request $request)
    {
         //$order_no = $request->order_no;
         $order_no = 29;
         $order = Order::find($order_no);
         $details = $order->details;
         $shipment = Shipment::where('order_no', $order_no)->where('tracking_number', null)->first();
        if (empty($shipment) && !empty($details)) {
            $new_shipment = new Shipment();
            $new_shipment->order_no = $order_no;
            $new_shipment->trans_type =   DELIVERYORDER;
            $new_shipment->save();
            foreach ($details as $detail) {
                $shipment_detail = new ShipmentDetail();
                $item = Item::where('stock_id',$detail->stock_id)->first();

                $shipment_detail->shipment_id = $new_shipment->id;
                $shipment_detail->order_no = $order_no;
                $shipment_detail->stock_id = $detail->stock_id;
                $shipment_detail->unit_price = $detail->unit_price;
                if($detail->pending_quantity > $item->stock_on_hand){
                  $packed_qty = $item->stock_on_hand;
                }else{
                  $packed_qty = $detail->pending_quantity;
                }
                $shipment_detail->quantity = $packed_qty;
                //var_dump($shipment_detail);
                $shipment_detail->save();
            }
            $this->stock_move->updateStockMoveWithShipment($new_shipment->id);
        } else {
            foreach($details as $detail){
              $shipmentDetail = ShipmentDetail::where('stock_id',$detail->stock_id)->where('shipment_id',$shipment->id)->first();
              $item = Item::where('stock_id',$detail->stock_id)->first();
              if($detail->pending_quantity>0){
                if(empty($shipmentDetail)){
                  $shipmentDetail = new ShipmentDetail();
                  $shipmentDetail->shipment_id = $shipment->id;
                  $shipmentDetail->order_no = $order_no;
                  $shipmentDetail->unit_price = $detail->unit_price;
                  $shipmentDetail->stock_id = $detail->stock_id;
                  if($detail->pending_quantity > $item->stock_on_hand){
                    $packed_qty = $item->stock_on_hand;
                  }else{
                    $packed_qty = $detail->pending_quantity;
                  }
                  $shipmentDetail->quantity = $packed_qty;
                  $shipmentDetail->save();
                }else{
                  if($detail->pending_quantity > $item->stock_on_hand){
                    $packed_qty = $item->stock_on_hand;
                  }else{
                    $packed_qty = $detail->pending_quantity;
                  }
                  $shipmentDetail->quantity = $shipmentDetail->quantity + $packed_qty;
                  $shipmentDetail->update();
                }
              }
            }
            $this->stock_move->updateStockMoveWithShipment($shipment->id);
        }
        return response()->json(['state'=>true]);
    }
    public function automaticAllocateShipment666(Request $request)
    {
         $order_no = $request->order_no;
         $state = true;
         $msg = "";

           //$order_no = 3;
         $location_id = "PL";
         $orderDetails = DB::table('sales_order_details')->where('order_no', $order_no)->get();
         $shipment = $this->shipment->getShipmentByOrderNo($order_no, $location_id, $unshippedState = true);
        if ($shipment==null) {
            $insertShipmentDetailsData = array();

            if ($orderDetails!==null) {
                foreach ($orderDetails as $key => $orderDetail) {
                    $add_packed_qty = $this->order->calculateAdditionalPackedQuantity($order_no, $orderDetail->stock_id, $location_id);
                    $data = array(
                    'stock_id' =>$orderDetail->stock_id,
                    'packed_qty' => $add_packed_qty
                    );
                       // var_dump($data);
                    array_push($insertShipmentDetailsData, $data);
                }
            }
            $this->shipment->createShipment($order_no, $insertShipmentDetailsData);
        } else {
             $shipment = $shipment['shipments'][0];
            foreach ($shipment['details'] as $shipmentDetail) {
                $add_packed_qty = $this->order->calculateAdditionalPackedQuantity($order_no, $shipmentDetail['stock_id'], $location_id);
                DB::table('shipment_details')->where('id', $shipmentDetail['id'])->increment('packed_qty', $add_packed_qty);
            }
                $this->stock_move->updateStockMoveWithShipment($shipment['id']);
        }
         $this->shipment->updateOrderPackedShippedQty($order_no);
    }
    public function validateAdditionalPackingQuantity(Request $request)
    {
          $order_no = $request->order_no;
          $stock_id = $request->stock_id;
          $location_id = 'PL';
          $unpacked_qty = $this->order->calculateAdditionalPackedQuantity($order_no, $stock_id, $location_id);
          return response()->json(['quantity'=>$unpacked_qty]);
    }
    public function addTrackingNumber(Request $request)
    {
          $shipment_id = $request->shipment_id;
          $tracking_number = $request->tracking_number;
          $shipping_method = $request->shipping_method;
        if ($tracking_number=="") {
            $tracking_number = null;
            $shipping_method = null;
        }
          $this->shipment->addTrackingNumber($shipment_id, $tracking_number, $shipping_method);
          return response()->json(['state'=>true]);
    }
    public function getDataForManualAllocate(Request $request)
    {
          $order_no = $request->order_no;
          $location_id = "PL";
  
        $fetchModeBefore = DB::getFetchMode();
        DB::setFetchMode(\PDO::FETCH_ASSOC);
        $data = DB::table('sales_order_details')->where('order_no', $order_no)->get();
        DB::setFetchMode($fetchModeBefore);
        foreach ($data as $key => $orderDetail) {
            $stock_qty = $this->item->stock_validate($location_id, $orderDetail['stock_id']);
            if ($stock_qty==null) {
                $data[$key]['stock_qty'] = 0;
            } else {
                $data[$key]['stock_qty'] = $stock_qty->total;
            }
        }
        return response()->json(['exist_state'=>false,'data'=>$data]);
    }
    public function removeShipment(Request $request)
    {
        $shipment_id = $request->shipment_id;
        $query_state = $this->shipment->removeShipment($shipment_id);
        return response()->json(['state'=>$query_state]);
    }
    public function editShipment(Request $request)
    {
         $data = $request->data;
         $order_no = $request->order_no;
         $data = json_decode($data);
         $shipment_id = $request->shipment_id;
        foreach ($data as $key => $detail) {
            $shipment_detail = DB::table("shipment_details")->where('id', $detail->shipment_detail_id)->first();
            $curr_packed_qty = $shipment_detail->packed_qty;
            if ($detail->packed_qty <= $curr_packed_qty) {
                $new_packed_qty = $detail->packed_qty;
            } else {
                $unpacked_qty =  $this->order->calculateAdditionalPackedQuantity($order_no, $shipment_detail->stock_id, "PL");
                if ($detail->packed_qty - $curr_packed_qty > $unpacked_qty) {
                    $new_packed_qty = $curr_packed_qty+$unpacked_qty;
                } else {
                    $new_packed_qty = $detail->packed_qty;
                }
            }
            DB::table('shipment_details')->where('id', $detail->shipment_detail_id)->update(['packed_qty'=>$new_packed_qty]);
        }
         $this->stock_move->updateStockMoveWithShipment($shipment_id);
         $this->shipment->updateOrderPackedShippedQty($request->order_no);
         return response()->json(['state'=>true]);
    }
}
