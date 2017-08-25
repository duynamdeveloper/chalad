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

class QuoteController extends Controller
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
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'quote/list';
        $data['salesData'] = DB::table('quote_cust_info')->get();
        
        return view('admin.quote.quoteList', $data);
    }
    public function quote_cust_info($quote_id)
    {
        $data = DB::table('quote_cust_info')->where('id','=',$quote_id)->get();
        return view('admin.quote.payment_cust_info')->with('data',$data);
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

    /**
     * Update the specified resource in storage.
     **/
    public function update(Request $request)
    {
        $userId = \Auth::user()->id;
       $this->validate($request, [
            'phone'=>'required',
            'quote_id'=>'required',
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
        $quote_id = $request->quote_id;
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

        \DB::table('quote_cust_info')->where('id','=',$quote_id)->update($quote_cust_info);
        
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
            
            DB::table('quote_details')->where('quote_id','=',$quote_id)->where('item_id','=',$itemIds[$i])->update($quote_details  [$i]);
        }
        //dd($quote_id);
        if(!empty($quote_id)){
            \Session::flash('success',trans('message.success.update_success'));
            return redirect()->intended('quote/list/');
        }

    }

    /**
     * Remove the specified resource from storage.
     **/
    public function destroy($id)
    {
        if(isset($id)) {
            $record = \DB::table('quote_cust_info')->where('id','=', $id)->delete();
           
                // Delete shipment information
                DB::table('quote_details')->where('quote_id','=', $id)->delete();
               
                \Session::flash('success',trans('message.success.delete_success'));
                return redirect()->intended('quote/list');
        
        }
    }

    public function search(Request $request)
    {
           
            $data = array();
            $data['status_no'] = 0;
            $data['message']   ='No Item Found!';
            $data['items'] = array();

            $item = DB::table('stock_master')
            ->where('stock_master.description','LIKE','%'.$request->search.'%')
            ->where(['stock_master.inactive'=>0,'stock_master.deleted_status'=>0])
            ->leftJoin('item_tax_types','item_tax_types.id','=','stock_master.tax_type_id')
            ->leftJoin('item_code','stock_master.stock_id','=','item_code.stock_id')
            ->select('stock_master.*','item_tax_types.tax_rate','item_tax_types.id as tax_id','item_code.id')
            ->get();

            if(!empty($item)){
                
                $data['status_no'] = 1;
                $data['message']   ='Item Found';
                 $qtyOnHand = 0;
                $i = 0;
                foreach ($item as $key => $value) {
                    $itemPriceValue = DB::table('sale_prices')->where(['stock_id'=>$value->stock_id,'sales_type_id'=>$request['salesTypeId']])
                                    ->select('price')->first();
                    $itemSalesPrice = DB::table('item_code')->where(['stock_id'=>$value->stock_id])
                                   ->select('special_price','weight')->first();
                    
                    $weight = $itemSalesPrice->weight;

                    if(!isset($itemPriceValue)){
                        
                        
                        $itemSalesPriceValue = $itemSalesPrice->special_price ;

                    }else{
                        $itemSalesPriceValue = $itemPriceValue->price;
                    }

                    $product_stock_id = $value->stock_id;
                    /*======= Stock of the product */
                    
                         $itemList = DB::select(DB::raw("
                             
                            SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
                                FROM (SELECT * FROM stock_master as stm WHERE  stm.inactive=0 AND stm.deleted_status = 0 and stm.stock_id = '$product_stock_id' 
                                ) item

                                LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
                                ON sp.stock_id = item.stock_id

                                LEFT JOIN(SELECT stock_id,sum(qty)as qty FROM stock_moves GROUP BY stock_id)sm
                                ON sm.stock_id = item.stock_id

                                LEFT JOIN(SELECT `item_code` as stock_id,SUM(`unit_price`*`qty_invoiced`) as price,SUM(`qty_invoiced`) as received_qty FROM `purch_order_details` GROUP BY `item_code` )pod
                                ON pod.stock_id = item.stock_id
                                                ")); 
                          $qtyOnHand = 0;
                         foreach ($itemList as $key => $item) {            
                                $qtyOnHand += $item->available_qty;                               
                            }
                            
                        $return_arr[$i]['stock'] = $qtyOnHand;
                    /*=======End of Stock ============*/

                    //$return_arr[$i]['stock'] = 10;
                    
                    $return_arr[$i]['id'] = $value->id;
                    $return_arr[$i]['stock_id'] = $value->stock_id;
                    $return_arr[$i]['description'] = $value->description;
                    $return_arr[$i]['units'] = $value->units;
                    $return_arr[$i]['price'] = $itemSalesPriceValue;
                    $return_arr[$i]['tax_rate'] = 0;
                    $return_arr[$i]['tax_id'] = $value->tax_id;
                    $return_arr[$i]['weight'] = $weight;
                    

                    $i++;
                }
                //echo json_encode($return_arr);
                 $data['items'] = $return_arr;
            }
            //dd($data);
            echo json_encode($data);
            exit;            
    }

    /**
    * Return quantity validation result
    */
    public function quantityValidation(Request $request){
        $data = array();
        $location = $request['location_id'];
        $setItem = $request['qty'];

        $item_code = DB::table('item_code')->where("id",$request['id'])->select('stock_id')->first();
        
        $availableItem = $this->order->stockValidate($location,$item_code->stock_id);
      
        if($setItem>$availableItem){
            $data['availableItem'] = $availableItem;
            $data['message'] = "Insufficient item quantity. Available quantity is : ".$availableItem;
            $data['tag'] = 'insufficient';
            $data['status_no'] = 0; 
        }else{
            $data['status_no'] = 1;
        }

        return json_encode($data);
    }
    /**
    * Check reference no if exists
    */
    public function referenceValidation(Request $request){
        
        $data = array();
        $ref = $request['ref'];
        $result = DB::table('sales_orders')->where("reference",$ref)->first();

        if(count($result)>0){
            $data['status_no'] = 1; 
        }else{
            $data['status_no'] = 0;
        }

        return json_encode($data);       
    }

    /**
    * Return customer Branches by customer id
    */
    public function customerBranches(Request $request){
        $debtor_no = $request['debtor_no'];
        $data['status_no'] = 0;
        $branchs = '';
        $result = DB::table('cust_branch')->select('debtor_no','branch_code','br_name')->where('debtor_no',$debtor_no)->orderBy('br_name','ASC')->get();
        if(!empty($result)){
            $data['status_no'] = 1;
            foreach ($result as $key => $value) {
            $branchs .= "<option value='".$value->branch_code."'>".$value->br_name."</option>";  
        }
        $data['branchs'] = $branchs; 
       }
        return json_encode($data);
    }

    /**
    * Preview of order details
    * @ params order_no
    **/

    public function viewOrder($orderNo){

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'quote/list';

        $data['taxType'] = $this->sale->calculateTaxRow($orderNo);
        $data['customerData'] = DB::table('debtors_master')->get();
        $data['locData'] = DB::table('location')->get();
        $data['saleData'] = DB::table('sales_orders')->where('order_no', '=', $orderNo)->first();
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo,$data['saleData']->from_stk_loc);
        
        $data['branchs'] = DB::table('cust_branch')->select('debtor_no','branch_code','br_name')->where('debtor_no',$data['saleData']->debtor_no)->orderBy('br_name','ASC')->get();
        $data['payments'] = DB::table('payment_terms')->get();
        $data['invoice_count'] = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->count();
       //d( $data['saleData'],1);
       return view('admin.quote.viewOrder', $data);

    }
   
    /**
     * Contert order to invoice.
     **/
    public function convertOrder(Request $request)
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
        
        //d($request->all(),1);
        $order_id = $request->order_no;
        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;

        $itemCode = DB::table('item_code')->select('id','stock_id','description')->whereIn('id', $itemIds)->get();
        $itemCode = objectToArray($itemCode);
       // d($unitPrice,1);
        foreach ($itemQuantity as $key => $itemQty) {
            $product[$itemIds[$key]] = $itemQty;
        }
       // d($request->all(),1);
        // create salesOrder 
        $salesOrder['debtor_no'] = $request->debtor_no;
        $salesOrder['branch_id'] = $request->branch_id;
        $salesOrder['payment_id']= $request->payment_id;
        $salesOrder['reference'] = $request->reference;
        $salesOrder['order_reference'] = $request->order_reference;
        $salesOrder['comments'] = $request->comments;
        $salesOrder['trans_type'] = SALESINVOICE;
        $salesOrder['ord_date'] = DbDateFormat($request->ord_date);
        $salesOrder['from_stk_loc'] = $request->from_stk_loc;
        $salesOrder['total'] = $request->total;
        $salesOrder['delivery_date'] = date('Y-m-d');
        $salesOrder['created_at'] = date('Y-m-d H:i:s');

        $salesOrderId = \DB::table('sales_orders')->insertGetId($salesOrder);

        for ($i=0; $i < count($itemCode); $i++) {
            foreach ($product as $key => $item) {
                
                if($itemCode[$i]['id'] == $key){
                   
                    // create salesOrderDetail 
                    $salesOrderDetail[$i]['order_no'] = $salesOrderId;
                    $salesOrderDetail[$i]['stock_id'] = $itemCode[$i]['stock_id'];
                    $salesOrderDetail[$i]['description'] = $itemCode[$i]['description'];
                    $salesOrderDetail[$i]['qty_sent'] = $item;
                    $salesOrderDetail[$i]['quantity'] = $item;
                    $salesOrderDetail[$i]['trans_type'] = SALESINVOICE;
                    $salesOrderDetail[$i]['discount_percent'] = $itemDiscount[$i];
                    $salesOrderDetail[$i]['tax_type_id'] = $taxIds[$i];
                    $salesOrderDetail[$i]['unit_price'] = $unitPrice[$i];

                    // create stockMove 
                    $stockMove[$i]['stock_id'] = $itemCode[$i]['stock_id'];
                    
                    $stockMove[$i]['loc_code'] = $request->from_stk_loc;
                    $stockMove[$i]['tran_date'] = DbDateFormat($request->ord_date);
                    $stockMove[$i]['person_id'] = $userId;
                    $stockMove[$i]['reference'] = 'store_out_'.$salesOrderId;
                    $stockMove[$i]['transaction_reference_id'] = $salesOrderId;
                    $stockMove[$i]['qty'] = '-'.$item;
                    $stockMove[$i]['price'] = $unitPrice[$i];
                    $stockMove[$i]['trans_type'] = SALESINVOICE;
                    $stockMove[$i]['order_reference'] = $request->order_reference;
                }
            }
        }

        for ($i=0; $i < count($salesOrderDetail); $i++) { 
            
            DB::table('sales_order_details')->insertGetId($salesOrderDetail[$i]);
            DB::table('stock_moves')->insertGetId($stockMove[$i]);
        }
        DB::table('sales_orders')->where('order_no',$order_id)->update(['invoice_status'=>'full_created']);
        if(!empty($salesOrderId)){
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('sales/list');
        }

    }


    /**
    * Preview of order details
    * @params order_no
    **/

    public function viewQuoteDetails($orderNo){

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'quote/list';

        $data['taxType'] = $this->sale->calculateTaxRow($orderNo);
        $data['customerData'] = DB::table('debtors_master')->get();
        $data['locData'] = DB::table('location')->get();
        $data['saleData'] = DB::table('quote_cust_info')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();
       // d($data['saleData'],1);
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo,$data['saleData']->from_stk_loc);
        $data['branchs'] = DB::table('cust_branch')->select('debtor_no','branch_code','br_name')->where('debtor_no',$data['saleData']->debtor_no)->orderBy('br_name','ASC')->get();
        $data['payments'] = DB::table('payment_terms')->get();
        $data['invoice_count'] = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->count();
        
        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first();        
        //d($data['customerInfo'],1);
        $data['customer_branch'] = DB::table('cust_branch')->where('branch_code',$data['saleData']->branch_id)->first();
        $data['customer_payment'] = DB::table('payment_terms')->where('id',$data['saleData']->payment_id)->first();
      
        $data['invoiceList'] = DB::table('sales_orders')
                                ->where('order_reference',$data['saleData']->reference)
                                ->select('order_no','reference','order_reference','total','paid_amount')
                                ->orderBy('created_at','DESC')
                                ->get();
      
        $data['invoiceQty'] = DB::table('stock_moves')->where(['order_no'=>$orderNo,'trans_type'=>SALESINVOICE])->sum('qty');
        $data['orderQty'] = DB::table('sales_order_details')->where(['order_no'=>$orderNo,'trans_type'=>SALESORDER])->sum('quantity');
        $data['orderInfo']  = DB::table('sales_orders')->where('order_no',$orderNo)->select('reference','order_no')->first();
        $data['paymentsList'] = DB::table('payment_history')
                            ->where(['order_reference'=>$data['orderInfo']->reference])
                            ->leftjoin('payment_terms','payment_terms.id','=','payment_history.payment_type_id')
                            ->select('payment_history.*','payment_terms.name')
                            ->orderBy('payment_date','DESC')
                            ->get();
        $data['shipmentList'] = DB::table('shipment_details')
                            ->select('shipment_details.shipment_id',DB::raw('sum(quantity) as total'))->where(['order_no'=>$orderNo])
                            ->groupBy('shipment_id')
                            ->orderBy('shipment_id','DESC')
                            ->get();
        $shipmentTotal = $this->shipment->getTotalShipmentByOrderNo($orderNo);
        $invoicedTotal = $this->shipment->getTotalInvoicedByOrderNo($orderNo);
        $shipment = (int)abs($invoicedTotal)-$shipmentTotal;
        $data['shipmentStatus'] = ($shipment>0) ? 'available' : 'notAvailable';
        $lang = Session::get('dflt_lang');
        $data['emailInfo'] = DB::table('email_temp_details')->where(['temp_id'=>5,'lang'=>$lang])->select('subject','body')->first();
        return view('admin.quote.viewOrderDetails', $data);
    }

    /**
    * Manual invoice create
    * @params order_no
    **/
    public function manualInvoiceCreate($orderNo){

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice';
        $data['taxType'] = $this->order->calculateTaxRowRestItem($orderNo);
        $data['customerData'] = DB::table('debtors_master')->get();
        $data['locData'] = DB::table('location')->get();
        $data['invoiceData'] = $this->order->getRestOrderItemsByOrderID($orderNo);
        $data['saleData'] = DB::table('sales_orders')->where('order_no', '=', $orderNo)->first();
        $data['branchs'] = DB::table('cust_branch')->select('debtor_no','branch_code','br_name')->where('debtor_no',$data['saleData']->debtor_no)->orderBy('br_name','ASC')->get();
        $data['payments'] = DB::table('payment_terms')->get();
        $invoice_count = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->count();
        
        $data['order_no'] = $orderNo;
        $data['invoiceedItem'] = $this->order->getInvoicedItemsQty($orderNo);
        $data['paymentTerms'] = DB::table('invoice_payment_terms')->get();        
        
        if($invoice_count>0){
        $invoiceReference = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->select('reference')->orderBy('order_no','DESC')->first();

        $ref = explode("-",$invoiceReference->reference);
        $data['invoice_count'] = (int) $ref[1];
        }else{
            $data['invoice_count'] = 0 ;
        }
       // d($data['invoiceData'],1);
        return view('admin.quote.createManualInvoice', $data);

    }

    /**
    * Store manaul invoice
    */
    public function storeManualInvoice(Request $request){
   // d($request->all(),1);
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
       
        $itemQuantity = $request->item_quantity;        
        $itemIds = $request->item_id;
        $itemDiscount = $request->discount;
        $taxIds = $request->tax_id;
        $unitPrice = $request->unit_price;
        
        $stock_id = $request->stock_id;
        $description = $request->description;
       
        foreach ($itemQuantity as $key => $itemQty) {
            $product[$itemIds[$key]] = $itemQty;
        }
       
        // Create salesOrder Invoice start
        $salesOrderInvoice['order_reference_id'] = $request->order_no;
        $salesOrderInvoice['order_reference'] = $request->order_reference;
        $salesOrderInvoice['trans_type'] = SALESINVOICE;
        $salesOrderInvoice['reference'] = $request->reference;
        $salesOrderInvoice['debtor_no'] = $request->debtor_no;
        $salesOrderInvoice['branch_id'] = $request->branch_id;
        $salesOrderInvoice['payment_id']= $request->payment_id;
        $salesOrderInvoice['person_id']= $userId;
        $salesOrderInvoice['comments'] = $request->comments;
        $salesOrderInvoice['ord_date'] = DbDateFormat($request->ord_date);
        $salesOrderInvoice['from_stk_loc'] = $request->from_stk_loc;
        $salesOrderInvoice['total'] = $request->total;
        $salesOrderInvoice['payment_term'] = $request->payment_term;
        $salesOrderInvoice['created_at'] = date('Y-m-d H:i:s');

        $orderInvoiceId = DB::table('sales_orders')->insertGetId($salesOrderInvoice);
        // Create salesOrder Invoice end

        for ($i=0; $i < count($itemIds); $i++) {
            foreach ($product as $key => $item) {
                
                if($itemIds[$i] == $key){
                   
                    // Create salesOrderDetailInvoice Start

                    $salesOrderDetailInvoice[$i]['order_no'] = $orderInvoiceId;
                    $salesOrderDetailInvoice[$i]['stock_id'] = $stock_id[$i];
                    $salesOrderDetailInvoice[$i]['description'] = $description[$i];
                    $salesOrderDetailInvoice[$i]['qty_sent'] = $item;
                    $salesOrderDetailInvoice[$i]['quantity'] = $item;
                    $salesOrderDetailInvoice[$i]['trans_type'] = SALESINVOICE;
                    $salesOrderDetailInvoice[$i]['discount_percent'] = $itemDiscount[$i];
                    $salesOrderDetailInvoice[$i]['tax_type_id'] = $taxIds[$i];
                    $salesOrderDetailInvoice[$i]['unit_price'] = $unitPrice[$i];
                    // Create salesOrderDetailInvoice End

                    // create stockMove 
                    $stockMove[$i]['stock_id'] = $stock_id[$i];
                    $stockMove[$i]['order_no'] = $request->order_no;
                    $stockMove[$i]['loc_code'] = $request->from_stk_loc;
                    $stockMove[$i]['tran_date'] = DbDateFormat($request->ord_date);
                    $stockMove[$i]['person_id'] = $userId;
                    $stockMove[$i]['reference'] = 'store_out_'.$orderInvoiceId;
                    $stockMove[$i]['transaction_reference_id'] = $orderInvoiceId;
                    $stockMove[$i]['qty'] = '-'.$item;
                    $stockMove[$i]['price'] = $unitPrice[$i];
                    $stockMove[$i]['trans_type'] = SALESINVOICE;
                    $stockMove[$i]['order_reference'] = $request->order_reference;
                }
            }
        }

        for ($i=0; $i < count($salesOrderDetailInvoice); $i++) { 
            DB::table('sales_order_details')->insertGetId($salesOrderDetailInvoice[$i]);
            DB::table('stock_moves')->insertGetId($stockMove[$i]);
        }

        if(!empty($orderInvoiceId)){
            \Session::flash('success',trans('message.success.save_success'));
            return redirect()->intended('invoice/view-detail-invoice/'.$request->order_no.'/'.$orderInvoiceId);
        }
    }

    /**
    * Create auto invoice
    *@params order_id
    */

    public function autoInvoiceCreate($orderNo){
        $userId = \Auth::user()->id;
        $invoiceCount = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->count();
        if($invoiceCount>0){
        $invoiceReference = DB::table('sales_orders')->where('trans_type',SALESINVOICE)->select('reference')->orderBy('order_no','DESC')->first();

        $ref = explode("-",$invoiceReference->reference);
        $invoice_count = (int) $ref[1];
        }else{
            $invoice_count = 0 ;
        }

        $invoiceInfos = $this->order->getRestOrderItemsByOrderID($orderNo);
        $orderInfo = DB::table('sales_orders')->where('order_no', '=', $orderNo)->first();

        // Check quantity is available or not on location
        foreach ($invoiceInfos as $key => $res) {
            $availableQty = getItemQtyByLocationName($res->location,$res->stock_id);
            if($availableQty < $res->quantity){
            return redirect()->intended('order/manual-invoice-create/'.$orderNo)->withErrors(['email' => "Item quantity not enough for this invoice !"]);
            }
        }

        $payment_term = DB::table('invoice_payment_terms')->where('defaults',1)->select('id')->first();
        $total = 0;
        $price = 0;
        $discountAmount = 0;
        $priceWithDiscount = 0;
        $taxAmount = 0;
        $priceWithTax = 0;
        foreach ($invoiceInfos as $key => $info) {
            $price = ($info->unit_price * $info->item_rest);
            $discountAmount = (($price * $info->discount_percent)/100);
            $priceWithDiscount = ($price - $discountAmount); 
            $taxAmount = (($priceWithDiscount * $info->tax_rate)/100);
            $priceWithTax = ($priceWithDiscount+$taxAmount);
            $total +=$priceWithTax;
            

        }

        // Create salesOrder Invoice start
        $salesOrderInvoice['order_reference_id'] = $orderNo;
        $salesOrderInvoice['order_reference'] = $orderInfo->reference;
        $salesOrderInvoice['trans_type'] = SALESINVOICE;
        $salesOrderInvoice['reference'] ='INV-'.sprintf("%04d", $invoice_count+1);
        $salesOrderInvoice['debtor_no'] = $orderInfo->debtor_no;
        $salesOrderInvoice['branch_id'] = $orderInfo->branch_id;
        $salesOrderInvoice['person_id']= $userId;
        $salesOrderInvoice['payment_id']= $orderInfo->payment_id;
        $salesOrderInvoice['comments'] = $orderInfo->comments;
        $salesOrderInvoice['ord_date'] = $orderInfo->ord_date;
        $salesOrderInvoice['from_stk_loc'] = $orderInfo->from_stk_loc;
        $salesOrderInvoice['total'] = $total;
        $salesOrderInvoice['payment_term'] = $payment_term->id;
        $salesOrderInvoice['created_at'] = date('Y-m-d H:i:s');        


        $orderInvoiceId = DB::table('sales_orders')->insertGetId($salesOrderInvoice);

        foreach($invoiceInfos as $i=>$invoiceInfo){
            if($invoiceInfo->item_rest>0){
            $salesOrderDetailInvoice['order_no'] = $orderInvoiceId;
            $salesOrderDetailInvoice['stock_id'] = $invoiceInfo->stock_id;
            $salesOrderDetailInvoice['description'] = $invoiceInfo->description;
            $salesOrderDetailInvoice['qty_sent'] = $invoiceInfo->item_rest;
            $salesOrderDetailInvoice['quantity'] = $invoiceInfo->item_rest;
            $salesOrderDetailInvoice['trans_type'] = SALESINVOICE;
            $salesOrderDetailInvoice['discount_percent'] = $invoiceInfo->discount_percent;
            $salesOrderDetailInvoice['tax_type_id'] = $invoiceInfo->tax_type_id;
            $salesOrderDetailInvoice['unit_price'] = $invoiceInfo->unit_price;
            // Create salesOrderDetailInvoice End

            // create stockMove 
            $stockMove['stock_id'] = $invoiceInfo->stock_id;
            $stockMove['order_no'] = $orderNo;
            $stockMove['loc_code'] = $orderInfo->from_stk_loc;
            $stockMove['tran_date'] = date('Y-m-d');
            $stockMove['person_id'] = $userId;
            $stockMove['reference'] = 'store_out_'.$orderInvoiceId;
            $stockMove['transaction_reference_id'] = $orderInvoiceId;
            $stockMove['qty'] = '-'.$invoiceInfo->item_rest;
            $stockMove['price'] = $invoiceInfo->unit_price;
            $stockMove['trans_type'] = SALESINVOICE;
            $stockMove['order_reference'] = $orderInfo->reference;

            DB::table('sales_order_details')->insertGetId($salesOrderDetailInvoice);
            DB::table('stock_moves')->insertGetId($stockMove);
        }
        }
            \Session::flash('success',trans('message.success.save_success'));
            //return redirect()->intended('sales/list');
            return redirect()->intended('invoice/view-detail-invoice/'.$orderNo.'/'.$orderInvoiceId);
    }

    /**
    * Check Item Quantity After Create Invoice
    **/

    public function checkQuantityAfterInvoice(Request $request){
        $data = array();
        $itemCode = DB::table('item_code')->where("id",$request['id'])->select('stock_id')->first();
        
        $location = $request['location_id'];
        $setItemQty = $request['qty'];
        $orderReferenceId = $request['order_no'];
        $orderReference = $request['reference'];
        $stock_id = $itemCode->stock_id;
        $invoicedQty = str_replace('-','',$this->order->getInvoicedQty($orderReferenceId,$stock_id,$location,$orderReference)); 

        if((int)$invoicedQty > $setItemQty){
            $data['status_no'] = 0;
            $data['message']   = 'No'; 
        }else{
            $data['status_no'] = 1;
            $data['message']   = 'Yes'; 
        }
        //d($data,1);
        return json_encode($data);
    }

    /**
    * Preview of order details
    * @params order_no
    **/

    public function orderPdf($orderNo){
        $data['taxInfo'] = $this->sale->calculateTaxRow($orderNo);
        $data['saleData'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo,$data['saleData']->from_stk_loc);
        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first();
       // return view('admin.quote.orderPdf', $data);
        $pdf = PDF::loadView('admin.quote.orderPdf', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('order_'.time().'.pdf',array("Attachment"=>0));
    }
    public function orderPrint($orderNo){
        $data['taxInfo'] = $this->sale->calculateTaxRow($orderNo);
        $data['saleData'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location','location.loc_code','=','sales_orders.from_stk_loc')
                            ->select("sales_orders.*","location.location_name")
                            ->first();
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo,$data['saleData']->from_stk_loc);
        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no',$orderNo)
                             ->leftjoin('debtors_master','debtors_master.debtor_no','=','sales_orders.debtor_no')
                             ->leftjoin('cust_branch','cust_branch.branch_code','=','sales_orders.branch_id')
                             ->leftjoin('countries','countries.id','=','cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no','debtors_master.name','debtors_master.phone','debtors_master.email','cust_branch.br_name','cust_branch.br_address','cust_branch.billing_street','cust_branch.billing_city','cust_branch.billing_state','cust_branch.billing_zip_code','cust_branch.billing_country_id','cust_branch.shipping_street','cust_branch.shipping_city','cust_branch.shipping_state','cust_branch.shipping_zip_code','cust_branch.shipping_country_id','countries.country')                            
                             ->first();
       // return view('admin.quote.orderPdf', $data);
        $pdf = PDF::loadView('admin.quote.orderPrint', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('order_'.time().'.pdf',array("Attachment"=>0));
    
        return view('admin.quote.orderPrint', $data);
    }
    /**
    * Send email to customer for Invoice information
    */
    public function sendOrderInformationByEmail(Request $request){
        $this->email->sendEmail($request['email'],$request['subject'],$request['message']);
        \Session::flash('success',trans('message.email.email_send_success'));
        return redirect()->intended('order/view-order-details/'.$request['order_id']);
    }

}
