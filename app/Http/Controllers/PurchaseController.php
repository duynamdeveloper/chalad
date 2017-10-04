<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Purchase;
use App\Http\Requests;
use DB;
use PDF;
use App\Model\Supplier;
use App\Model\PurchaseOrderDetail;
use App\Model\PurchasePayment;
use App\Model\PurchaseShipment;
class PurchaseController extends Controller
{
    public function __construct() {
     /**
     * Set the database connection. reference app\helper.php
     */   
        //selectDatabase();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'purchase';
        $data['purchData'] = (new Purchase)->getAllPurchOrder();
        return view('admin.purchase.purch_list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['menu'] = 'purchase';
        $data['tax_types'] = DB::table('item_tax_types')->get();
        $data['suppliers'] = Supplier::all();
        $data['countries'] = DB::table('countries')->get();
        return view('admin.purchase.purchase_add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = \Auth::user()->id;

        $supplier_data = $request->supplier;
        $items = $request->items;
        $shipping_cost = $request->shipping_cost;
        $grand_total = $request->grand_total;

        $supplier_data = json_decode($supplier_data);
        $items = json_decode($items);

        if($supplier_data->id == -1){
            $supplier = new Supplier();
            $supplier->name = $supplier_data->name;
            $supplier->phone = $supplier_data->phone;
            $supplier->email = $supplier_data->email;
            $supplier->address = $supplier_data->address;
            $supplier->city = $supplier_data->city;
            $supplier->state = $supplier_data->state;
            $supplier->zip_code = $supplier_data->zip_code;
            $supplier->country = $supplier_data->country;
            $supplier->save();
            $supplier_id = $supplier->id;
        }else{
            $supplier_id = $supplier_data->id;
        }

        $last_purchase_id = DB::table('purch_orders')->max('order_no');
        $purchase = new Purchase();

        $purchase->supplier_id = $supplier_id;
        $purchase->ord_date = date('Y-m-d');
        $purchase->total = $request->grand_total;
        $purchase->shipping_cost = $request->shipping_cost;
        $purchase->user_id = $user_id;

        $purchase->save();

        $purchase_id = $purchase->order_no;

        DB::table('purch_order_details')->where('order_no',$purchase_id)->delete();
        foreach($items as $item){
            if(!is_null($item)){
                $orderDetail = new PurchaseOrderDetail();
                $orderDetail->order_no = $purchase_id;
                $orderDetail->stock_id = $item->item_id;
                $orderDetail->item_name = $item->name;
                $orderDetail->quantity = $item->qty;
                $orderDetail->unit_price = $item->price;
                $orderDetail->save();
            }
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['menu'] = 'purchase';
        $data['purchase'] = Purchase::find($id);

        return view('admin.purchase.purchase_edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $user_id = \Auth::user()->id;
        $purchase_id = $request->purchase_id;
        $items = $request->items;
        $shipping_cost = $request->shipping_cost;
        $grand_total = $request->grand_total;

        $items = json_decode($items);


      
        $purchase = Purchase::find($purchase_id);
        $purchase->total = $request->grand_total;
        $purchase->shipping_cost = $request->shipping_cost;
        $purchase->user_id = $user_id;

        $purchase->update();

        DB::table('purch_order_details')->where('order_no',$purchase_id)->delete();
        foreach($items as $item){
            if(!is_null($item)){
                $orderDetail = new PurchaseOrderDetail();
                $orderDetail->order_no = $purchase_id;
                $orderDetail->stock_id = $item->item_id;
                $orderDetail->item_name = $item->name;
                $orderDetail->quantity = $item->qty;
                $orderDetail->unit_price = $item->price;
                $orderDetail->save();
            }
        }

    }
    public function addPayment(Request $request){
         $payment = new PurchasePayment();
        $payment->order_no = $request->order_no;
        $payment->method = $request->payment_type;
        $payment->supplier_id = $request->payment_supplier_id;
        $payment->amount = $request->payment_amount;
        $payment->payment_date = date("Y-m-d", strtotime($request->payment_date));
        if ($request->hasFile('payment_image')) {
            $image = $request->file('payment_image');
            $imageName = 'img_'.time().$image->getClientOriginalName();
            $imagePath = 'uploads/paymentPic/';
            $image->move(base_path().'/public/'.$imagePath, $imageName);
            $imageUrl = $imageName;
            $payment->file = $imageUrl;
        } else {
            $payment->file = "404";
        }
        $payment->save();
        \Session::flash('success', trans('message.success.save_success'));
        return redirect()->intended('/purchase/edit/'.$payment->order_no);
    }
    public function editPayment(Request $request){
        $payment = PurchasePayment::find($request->payment_id);
       
        $payment->method = $request->payment_type;
      
        $payment->amount = $request->payment_amount;
        $payment->payment_date = date("Y-m-d", strtotime($request->payment_date));
        if ($request->hasFile('payment_image')) {
            $image = $request->file('payment_image');
            $imageName = 'img_'.time().$image->getClientOriginalName();
            $imagePath = 'uploads/paymentPic/';
            $image->move(base_path().'/public/'.$imagePath, $imageName);
            $imageUrl = $imageName;
            $payment->file = $imageUrl;
        }
        
        $payment->update();
        \Session::flash('success', trans('message.success.save_success'));
        return redirect()->intended('/purchase/edit/'.$payment->order_no);
    }
    public function saveShipment(Request $request){
        $data = $request->data;
        $purchase_id = $request->purchase_id;
        $data = json_decode($data);

        if($data->shipment_id == -1){
            $shipment = new PurchaseShipment();
            $shipment->stock_id = $data->stock_id;
            $shipment->quantity = $data->quantity;
            $shipment->order_no = $purchase_id;
            $shipment->tracking = $data->tracking;
            $shipment->date_arrival =  DbDateFormat($data->date_arrival);
            $shipment->save();

            return response()->json(['state'=>true, 'shipment'=>$shipment]);
        }else{
            $shipment = PurchaseShipment::find($data->shipment_id);
            $shipment->stock_id = $data->stock_id;
            $shipment->order_no = $purchase_id;
            $shipment->quantity = $data->quantity;
            $shipment->tracking = $data->tracking;
            $shipment->date_arrival =  DbDateFormat($data->date_arrival);
            $shipment->update();

            return response()->json(['state'=>true, 'shipment'=>$shipment]);
        }

    }
    public function markShipped(Request $request){
        $shipment_id = $request->shipment_id;
        $shipment = PurchaseShipment::find($shipment_id);
        $shipment->status = 1;
        $shipment->update();
        return response()->json(['state'=>true,'shipment'=>$shipment]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(isset($id)) {
            $record = \DB::table('purch_orders')->where('order_no', $id)->first();
            if($record) {
                DB::table('purch_orders')->where('order_no', '=', $record->order_no)->delete();
                DB::table('purch_order_details')->where('order_no', '=', $record->order_no)->delete();
                DB::table('stock_moves')->where('reference', '=', 'store_in_'.$record->order_no)->delete();
                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('purchase/list');
            }
        }
    }

    public function pdfview($id, $r='')
    {
        $supp_id = \DB::table('purch_orders')->where('order_no', $id)->first();
        $data['supplierData'] = \DB::table('suppliers')->where('supplier_id', $supp_id->supplier_id)->first();
        $data['invoiceData'] = \DB::table('purch_order_details')->where('order_no', $id)->get();
        
        $data['id'] = $id;

        $pdf = PDF::loadView('pdfviewIn', $data);
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->stream('invoice_check_in_'.time().'.pdf',array("Attachment"=>0));
    }

    public function searchItem(Request $request)
    {
        
            $data = array();
            $data['status_no'] = 0;
            $data['message']   ='No Item Found!';
            $data['items'] = array();

            $item = DB::table('stock_master')->where('stock_master.description','LIKE','%'.$request->search.'%')
            ->where(['stock_master.inactive'=>0,'stock_master.deleted_status'=>0])
            ->leftJoin('purchase_prices', 'stock_master.stock_id', '=', 'purchase_prices.stock_id')
            ->leftJoin('item_tax_types','item_tax_types.id','=','stock_master.tax_type_id')
            ->leftJoin('item_code','item_code.stock_id','=','stock_master.stock_id')
            ->select('stock_master.*','purchase_prices.price','item_code.id','item_tax_types.tax_rate','item_tax_types.id as tax_id')
            ->get();

            if($item){

                $data['status_no'] = 1;
                $data['message']   ='Item Found';
                $i = 0;

                foreach ($item as $key => $value) {
                    $return_arr[$i]['id'] = $value->id;
                    $return_arr[$i]['stock_id'] = $value->stock_id;
                    $return_arr[$i]['description'] = $value->description;
                    $return_arr[$i]['units'] = $value->units;
                    $return_arr[$i]['price'] = $value->price;
                    $return_arr[$i]['tax_rate'] = $value->tax_rate;
                    $return_arr[$i]['tax_id'] = $value->tax_id;
                    $i++;
                }
                $data['items'] = $return_arr;
                //echo json_encode($return_arr);
            }
            echo json_encode($data);
            exit;     
    }

    /**
    *View Purchase details
    */
    public function viewPurchaseInvoiceDetail($id){
        $data['menu'] = 'purchase';
        $data['taxType'] = (new Purchase)->calculateTaxRow($id);
        $data['invoiceItems'] = (new Purchase)->getPurchaseInvoiceByID($id);
       
        $data['purchData'] = DB::table('purch_orders')
                            ->where('order_no', '=', $id)
                            ->leftJoin('suppliers','suppliers.supplier_id','=','purch_orders.supplier_id')
                            ->leftJoin('location','location.loc_code','=','purch_orders.into_stock_location')
                            ->select('purch_orders.*','suppliers.supp_name','suppliers.email','suppliers.address','suppliers.contact','suppliers.city','suppliers.state','suppliers.zipcode','suppliers.country','location.location_name')
                            ->first();
      //d($data['purchData'],1);
        return view('admin.purchase.purchaseInvoiceDetails', $data);       
    }
    
    /**
    *View Purchase details
    */
    public function invoicePdf($id){
        $data['taxType'] = (new Purchase)->calculateTaxRow($id);
        $data['invoiceItems'] = (new Purchase)->getPurchaseInvoiceByID($id);
       
        $data['purchData'] = DB::table('purch_orders')
                            ->where('order_no', '=', $id)
                            ->leftJoin('suppliers','suppliers.supplier_id','=','purch_orders.supplier_id')
                            ->select('purch_orders.*','suppliers.supp_name','suppliers.email','suppliers.address','suppliers.contact','suppliers.city','suppliers.state','suppliers.zipcode','suppliers.country')
                            ->first();
        //return view('admin.purchase.invoicePdf', $data);
        $pdf = PDF::loadView('admin.purchase.invoicePdf', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('purchase_invoice_'.time().'.pdf',array("Attachment"=>0));               
    }
    
    /**
    *Print Purchase details
    */
    public function invoicePrint($id){
        $data['taxType'] = (new Purchase)->calculateTaxRow($id);
        $data['invoiceItems'] = (new Purchase)->getPurchaseInvoiceByID($id);
       
        $data['purchData'] = DB::table('purch_orders')
                            ->where('order_no', '=', $id)
                            ->leftJoin('suppliers','suppliers.supplier_id','=','purch_orders.supplier_id')
                            ->select('purch_orders.*','suppliers.supp_name','suppliers.email','suppliers.address','suppliers.contact','suppliers.city','suppliers.state','suppliers.zipcode','suppliers.country')
                            ->first();
        //return view('admin.purchase.printPdf', $data);

        $pdf = PDF::loadView('admin.purchase.invoicePrint', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('purchase_invoice_'.time().'.pdf',array("Attachment"=>0));       
    }
    /**
    * Check reference no if exists
    */
    public function referenceValidation(Request $request){
        
        $data = array();
        $ref = $request['ref'];
        $result = DB::table('purch_orders')->where("reference",$ref)->first();

        if(count($result)>0){
            $data['status_no'] = 1; 
        }else{
            $data['status_no'] = 0;
        }

        return json_encode($data);       
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Filtering()
    {
        $data['menu'] = 'purchase';
        $data['supplier'] =  'all';
        $data['stock_id'] =  'all';

        $data['suppliers'] = DB::table('suppliers')
                             ->select('supplier_id as id','supp_name as name')->get();
        $data['items']     = DB::table('item_code')
                              ->select('stock_id','description as name')->get();

        if(empty($_GET)){
        $data['purchData'] = (new Purchase)->getAllPurchOrder();
        $from              = DB::table('purch_orders')->select('ord_date')
                             ->orderBy('ord_date','asc')->first();
       if(!empty($from)){
        $data['from'] = formatDate($from->ord_date);
       }else{
        $data['from'] = formatDate(date('d-m-Y'));
       }
        $data['to'] = formatDate(date('d-m-Y'));
     }else{

        $from = $_GET['from'];
        $to   = $_GET['to'];
        $supplier_id = $_GET['supplier'];
        $stock_id = $_GET['item'];

        if ( $supplier_id == 'all' && $stock_id == 'all' ){
           $data['purchData'] = (new Purchase)->getAllPurchOrderFiltering($from,$to,'all','all');
        }elseif ($supplier_id != 'all' && $stock_id == 'all') {
           $data['purchData'] = (new Purchase)->getAllPurchOrderFiltering($from,$to,$supplier_id,'all');
        }
        elseif ($supplier_id == 'all' && $stock_id != 'all') {
           $data['purchData'] = (new Purchase)->getAllPurchOrderFiltering($from,$to,'all',$stock_id);
        }
        elseif ($supplier_id != 'all' && $stock_id != 'all') {
           $data['purchData'] = (new Purchase)->getAllPurchOrderFiltering($from,$to,$supplier_id,$stock_id);
        }

        $data['from'] =  $_GET['from'];
        $data['to'] =  $_GET['to'];
        $data['supplier'] =  $_GET['supplier'];
        $data['stock_id'] =  $_GET['item'];


     }


     return view('admin.purchase.filtering_list', $data);
    }

}
