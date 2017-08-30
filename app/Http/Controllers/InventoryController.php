<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\EmailController;
use App\Model\Orders;
use App\Http\Requests;
use App\Model\Sales;
use App\Model\Shipment;
use Image;
use Input;
use Validator;
use DB;
use PDF;
use Session;

class InventoryController extends Controller
{
    public function __construct(Orders $orders,Sales $sales,Shipment $shipment,EmailController $email){
     /**
     * Set the database connection. reference app\helper.php
     */   
        //selectDatabase();
        $this->order = $orders;
        $this->sale = $sales;
        $this->shipment = $shipment;
        $this->email = $email;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['menu'] = 'inventory';
        $data['sub_menu'] = 'inventory/inventory_view_adjust';
        $data['salesData'] = DB::table('quote_cust_info')->get();
        
        return view('admin.quote.quoteList', $data);
    }
    public function inventory_view_adjust()
    {
        $data['menu'] = 'inventory';
        $data['sub_menu'] = 'inventory/inventory_view_adjust';
        //$data = DB::table('quote_cust_info')->get();
        return view('admin.inventory.inventory_view_adjust',$data);
    }
    /**
     * Store a newly created Item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return redirection Item list page view
     */

    public function save_quote_payment(Request $request)
    {
        $this->validate($request, [
            'quote_id' => 'required',
            'payment_image' => 'mimes:jpeg,bmp,png',
            'payment_type_id' =>'required'
        ]);
        
        $data['quote_id'] = $request->quote_id;
       // $data['quote_id'] = $request->quote_id;
        //$data['customer_name'] = $request->customer_name;
        $data['payment_method'] = $request->payment_type_id;
        $data['create_time'] = date("Y-m-d", strtotime($request->payment_date));
        $data['amount'] = $request->amount;
        //dd(date("Y-m-d", strtotime($request->payment_date)));
        $pic = $request->file('payment_image');

        if (isset($pic)) {
          $destinationPath = public_path('uploads/Quote_recipt_Pic/');
          $filename = $pic->getClientOriginalName();
          $img = Image::make($request->file('payment_image')->getRealPath());

          $img->resize(400,400, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$filename);
          
          $data['payment_image'] = $filename;
        }
        DB::table('quote_payment')->insertGetId($data);
        
        DB::table('quote_cust_info')->where('id','=',$request->quote_id)->increment('payment_made',$request->amount);
         //DB::table('quote_cust_info')->where('id','=',$request->quote_id)->update(['status'=>$request->status]);
        if(!empty($data)){
            $quote_id = $request->quote_id;
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('quote/edit/'.$quote_id);
        }
        
    }
    public function quote_payment_add()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'quote/payment';
        $data['transaction_id'] = uniqid('QUOTE-',true);
        $data['quote'] = DB::table('quote_cust_info')->select('id')->get();
        return view('admin.quote.quote_payment_add',$data);
    }
    public function quote_payment()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'quote/payment';
        $data['salesData'] = DB::table('quote_cust_info')->get();
        return view('admin.quote.payment_index',$data);
    }
    public function shipping_cost_price($weight,$method)
    {
        $cost = DB::table('shipping_cost')->select('cost')
                ->where('weight_from','>=',$weight)
                ->where('weight_to','<=',$weight)->where('method','=',$method)->first();

        if (empty($cost))
            $cost=0;
        else
            $cost=$cost->cost;
         return ($cost);
    }
    public function mobile_search($mobile_id)
    {
        //dd($mobile_id);
        $mobile = DB::table('debtors_master AS dm')
                    ->select('dm.name','dm.phone','cb.billing_street','cb.billing_city','cb.billing_state','cb.billing_zip_code','cb.billing_country_id','cb.shipping_street','cb.shipping_city','cb.shipping_state','cb.shipping_zip_code','cb.shipping_country_id','cb.channel_id','cb.channel')
                    ->where('phone' ,'LIKE','%'.$mobile_id.'%' )
                    ->join('cust_branch AS cb','cb.debtor_no','=','dm.debtor_no')
                    ->get();
        //dd(  json_encode($mobile));
         return view('admin.quote.autosuggestion')->with('mobile',$mobile);  
    }
    public function fill_data($mobile)
    {
        if($mobile == 'add_new_customer')
        {
            $countries = DB::table('countries')->get();
            return view('admin.quote.autofill_null')->with('countries',$countries);
        }
        else
        {
        $mobile = DB::table('debtors_master AS dm')
                    ->select('dm.name','dm.phone','cb.billing_street','cb.shipping_name','cb.billing_city','cb.billing_state','cb.billing_zip_code','cb.billing_country_id','cb.shipping_street','cb.shipping_city','cb.shipping_state','cb.shipping_zip_code','cb.shipping_country_id','cb.channel_id','cb.channel')
                    ->where('phone' ,'LIKE','%'.$mobile.'%' )
                    ->join('cust_branch AS cb','cb.debtor_no','=','dm.debtor_no')
                    ->get();
                     $countries = DB::table('countries')->get();
        return view('admin.quote.autofill')->with('mobile',$mobile)->with('countries',$countries);
        }
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderFiltering()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'quote/list';

        $data['location'] = $location = isset($_GET['location']) ? $_GET['location'] : NULL;
        $data['customer'] = $customer = isset($_GET['customer']) ? $_GET['customer'] : NULL;
        $data['item'] = $item = isset($_GET['product']) ? $_GET['product'] : NULL;

        $data['customerList'] = DB::table('debtors_master')->select('debtor_no','name')->where(['inactive'=>0])->get();
        $data['locationList'] = DB::table('location')->select('loc_code','location_name')->get();
        $data['productList'] = DB::table('item_code')->where(['inactive'=>0,'deleted_status'=>0])->select('stock_id','description')->get();
        
        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type',SALESORDER)->orderBy('ord_date','asc')->first();
        
        if(isset($_GET['from'])){
            $data['from'] = $from = $_GET['from'];
        }else{
           $data['from'] = $from = formatDate(date("d-m-Y", strtotime($fromDate->ord_date))); 
        }
        
        if(isset($_GET['to'])){
            $data['to'] = $to = $_GET['to'];
        }else{
            $data['to'] = $to = formatDate(date('d-m-Y'));
        }

       
        
        $data['salesData'] = $this->order->getAllSalseOrder($from, $to, $location, $customer, $item);
        
        return view('admin.quote.orderListFilter', $data);
    }

    /**
     * Show the form for creating a new resource.
     **/
    public function create()
    {
         $data['menu'] = 'customer';
        $data['customerData'] = DB::table('debtors_master')->orderBy('debtor_no', 'desc')->get();
        $data['totalBranch'] = DB::table('cust_branch')->count();
        $data['customerCount'] = DB::table('debtors_master')->count();
        $data['customerActive'] = DB::table('debtors_master')->where('inactive', 0)->count();
        $data['customerInActive'] = DB::table('debtors_master')->where('inactive', 1)->count();
         $data['menu'] = 'customer';
        $data['countries'] = DB::table('countries')->get();
        $data['sales_types'] = DB::table('sales_types')->get();

        
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'quote/list';
        //$data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->get();
        $data['locData'] = DB::table('location')->get();
        
        $data['payments'] = DB::table('payment_terms')->get();

        $data['salesType'] = DB::table('sales_types')->select('sales_type','id','defaults')->get();
       // d($data['salesType'],1);
        $order_count = DB::table('sales_orders')->where('trans_type',SALESORDER)->count();

        if($order_count>0){
        $orderReference = DB::table('sales_orders')->where('trans_type',SALESORDER)->select('reference')->orderBy('order_no','DESC')->first();
        $ref = explode("-",$orderReference->reference);
        $data['order_count'] = (int) $ref[1];
        }else{
            $data['order_count'] = 0 ;
        }

        $taxTypeList = DB::table('item_tax_types')->get();
        $taxOptions = '';
        $selectStart = "<select class='form-control taxList' name='tax_id[]'>";
        $selectEnd = "</select>";
        
        foreach ($taxTypeList as $key => $value) {
            $taxOptions .= "<option value='".$value->id."' taxrate='".$value->tax_rate."'>".$value->name.'('.$value->tax_rate.')'."</option>";          
        }

        $data['tax_type'] = $selectStart.$taxOptions.$selectEnd;
        //d($data['tax_type'],1);
        return view('admin.quote.quoteAdd', $data);
    }
    public function quote_save(Request $request)
    {
        $userId = \Auth::user()->id;
       $this->validate($request, [
            'phone'=>'required',
            'name' => 'required',
            'channel_id' => 'required',
            'channel' => 'required',
            'stock_id' => 'required',
            'description' => 'required',
            'item_quantity' => 'required',
        ]);
//d(SALESORDER,1);
        //dd($request->all());
    
        $total = $request->total;
       $shipping_method  =$request->shipping_method;
      $total_weight = $request->total_weight;
       if($request->input('is_vat')=='on')
            $vat=1;
        else
            $vat=0;

        $quote_cust_info['name']        = $request->name;       
         $quote_cust_info['phone']        = $request->phone;  
         
        $quote_cust_info['channel_id']  = $request->channel_id;
        $quote_cust_info['channel']     = $request->channel;
        $quote_cust_info['bill_street'] = $request->bill_street;
        $quote_cust_info['bill_city'] = $request->bill_city;
        $quote_cust_info['bill_state'] = $request->bill_state;
        $quote_cust_info['bill_zipCode'] = $request->bill_zipCode;        
        $quote_cust_info['bill_country_id'] = $request->bill_country_id;
        $quote_cust_info['shipping_name'] = $request->shipping_name;
        $quote_cust_info['ship_street'] = $request->ship_street;
        $quote_cust_info['ship_city'] = $request->ship_city;
        $quote_cust_info['ship_state'] = $request->ship_state;
        $quote_cust_info['ship_zipCode'] = $request->ship_zipCode;
        $quote_cust_info['ship_country_id'] = $request->ship_country_id;
        $quote_cust_info['create_time'] = date('Y-m-d H:i:s');
        
        $quote_cust_info['total_weight'] = $total_weight;
           $quote_cust_info['shipping_method'] = $shipping_method;
           $quote_cust_info['total'] = $total;
           $quote_cust_info['is_vat'] = $vat;


        $itemQuantity = $request->item_quantity;
        $itemIds = $request->item_id;
        $item_weight = $request->item_weight;
        $stock_id = $request->stock_id;
        $stock = $request->stock;
        $product_name= $request->description;
        
        $item_quantity= $request->item_quantity;
        
        $comments = $request->comments;
         $unit_price = $request->unit_price;
         $discount= $request->discount;
            $item_price = $request->item_price;
         
        $created_at = date('Y-m-d H:i:s');

        $quote_id = \DB::table('quote_cust_info')->insertGetId($quote_cust_info);
        
        foreach ($itemQuantity as $key => $itemQty) {
            $product[$itemIds[$key]] = $itemQty;
        }
        
       

        for ($i=0; $i < count($itemIds); $i++) {
            foreach ($product as $key => $item) {
                
                if($itemIds[$i] == $key){
                    // create salesOrderDetail 
                    $quote_details[$i]['quote_id'] = $quote_id;
                    $quote_details[$i]['stock_id'] = $stock_id[$i];
                    
                     $quote_details[$i]['stock'] = $stock[$i];
                    $quote_details[$i]['product_name'] = $product_name[$i];
                    $quote_details[$i]['item_quantity'] = $item_quantity[$i];
                    $quote_details[$i]['item_id'] = $itemIds[$i];
                    $quote_details[$i]['item_weight'] = $item_weight[$i];
                    $quote_details[$i]['comments'] = $comments;
                    $quote_details[$i]['unit_price'] = $unit_price[$i];
                    $quote_details[$i]['discount'] = $discount[$i];
                    $quote_details[$i]['item_price'] = $item_price[$i];                    
                   $quote_details[$i]['created_at'] = $created_at;
                }
            }
        }

        for ($i=0; $i < count($quote_details); $i++) { 
            
            DB::table('quote_details')->insertGetId($quote_details  [$i]);
        }
        //dd($quote_id);
        if(!empty($quote_id)){
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('quote/list/');
        }

    }
    /**
     * Store a newly created resource in storage.
     **/
    public function store(Request $request)
    {
        $userId = \Auth::user()->id;
        $this->validate($request, [
            'reference'=>'required|unique:sales_orders',
            'from_stk_loc' => 'required',
            'ord_date' => 'required',
            'debtor_no' => 'required',
            'branch_id' => 'required',
            'payment_id' => 'required',
            'item_quantity' => 'required',
        ]);
//d(SALESORDER,1);
        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;
        $description = $request->description;
        $stock_id = $request->stock_id;

        foreach ($itemQuantity as $key => $itemQty) {
            $product[$itemIds[$key]] = $itemQty;
        }

        // create salesOrder 
        $salesOrder['debtor_no'] = $request->debtor_no;
        $salesOrder['branch_id'] = $request->branch_id;
        $salesOrder['payment_id']= $request->payment_id;
        $salesOrder['person_id']= $userId;
        $salesOrder['reference'] = $request->reference;
        $salesOrder['comments'] = $request->comments;
        $salesOrder['trans_type'] = SALESORDER;
        $salesOrder['ord_date'] = DbDateFormat($request->ord_date);
        $salesOrder['from_stk_loc'] = $request->from_stk_loc;
        $salesOrder['total'] = $request->total;
        $salesOrder['created_at'] = date('Y-m-d H:i:s');
       // d($salesOrder,1);
        $salesOrderId = \DB::table('sales_orders')->insertGetId($salesOrder);

        for ($i=0; $i < count($itemIds); $i++) {
            foreach ($product as $key => $item) {
                
                if($itemIds[$i] == $key){
                    // create salesOrderDetail 
                    $salesOrderDetail[$i]['order_no'] = $salesOrderId;
                    $salesOrderDetail[$i]['stock_id'] = $stock_id[$i];
                    $salesOrderDetail[$i]['description'] = $description[$i];
                    $salesOrderDetail[$i]['qty_sent'] = 0;
                    $salesOrderDetail[$i]['quantity'] = $item;
                    $salesOrderDetail[$i]['trans_type'] = SALESORDER;
                    $salesOrderDetail[$i]['discount_percent'] = $itemDiscount[$i];
                    $salesOrderDetail[$i]['tax_type_id'] = $taxIds[$i];
                    $salesOrderDetail[$i]['unit_price'] = $unitPrice[$i];
                }
            }
        }

        for ($i=0; $i < count($salesOrderDetail); $i++) { 
            
            DB::table('sales_order_details')->insertGetId($salesOrderDetail[$i]);
        }

        if(!empty($salesOrderId)){
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('order/view-order-details/'.$salesOrderId);
        }

    }

    /**
     * Show the form for editing the specified resource.
     **/
    public function edit($quoteNo)
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'quote/list';
        $data['countries'] = DB::table('countries')->get();
        $data['quote_cust_info'] = DB::table('quote_cust_info')->where('id','=',$quoteNo)->get();
        $data['quote_details'] = DB::table('quote_details')->where('quote_id','=',$quoteNo)->get();        
        $data['quote_payment'] = DB::table('quote_payment')->where('quote_id','=',$quoteNo)->get();
        $item_quantity = DB::table('quote_details')->select(DB::raw('sum(item_quantity) as user_count'))->where('quote_id','=',$quoteNo)->get();
        $item_quantity=$item_quantity[0]->user_count;
        $data['item_quantity']=$item_quantity;
        $paid_amount = DB::table('quote_payment')->select(DB::raw('sum(amount) as amount'))->where('quote_id','=',$quoteNo)->get();
        $paid_amount = $paid_amount[0]->amount;
        $data['paid_amount']=$paid_amount;
        return view('admin.quote.quoteEdit', $data);
    }


}
