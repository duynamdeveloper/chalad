<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\EmailController;
use App\Model\Orders;
use App\Http\Requests;
use App\Model\Sales;
use App\Model\Shipment;
use DB;
use PDF;
use Session;

class SalesOrderController extends Controller
{
    public function __construct(Orders $orders, Sales $sales, Shipment $shipment, EmailController $email)
    {
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
        $data['sub_menu'] = 'order/list';
        $data['salesData'] = $this->order->getAllSalesOrderData(null, null, null, null, null);
        //return response()->json($data['salesData']);
        //die;
        return view('admin.salesOrder.orderList', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderFiltering()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';

        $data['location'] = $location = isset($_GET['location']) ? $_GET['location'] : null;
        $data['customer'] = $customer = isset($_GET['customer']) ? $_GET['customer'] : null;
        $data['item'] = $item = isset($_GET['product']) ? $_GET['product'] : null;

        $data['customerList'] = DB::table('debtors_master')->select('debtor_no', 'name')->where(['inactive'=>0])->get();
        $data['locationList'] = DB::table('location')->select('loc_code', 'location_name')->get();
        $data['productList'] = DB::table('item_code')->where(['inactive'=>0,'deleted_status'=>0])->select('stock_id', 'description')->get();
        
        $fromDate = DB::table('sales_orders')->select('ord_date')->where('trans_type', SALESORDER)->orderBy('ord_date', 'asc')->first();
        
        if (isset($_GET['from'])) {
            $data['from'] = $from = $_GET['from'];
        } else {
            $data['from'] = $from = formatDate(date("d-m-Y", strtotime($fromDate->ord_date)));
        }
        
        if (isset($_GET['to'])) {
            $data['to'] = $to = $_GET['to'];
        } else {
            $data['to'] = $to = formatDate(date('d-m-Y'));
        }

       
        
        $data['salesData'] = $this->order->getAllSalseOrder($from, $to, $location, $customer, $item);
        
        return view('admin.salesOrder.orderListFilter', $data);
    }

    /**
     * Show the form for creating a new resource.
     **/
    public function customer_mobile_no($mobile_no)
    {
        $customerData = DB::table('debtors_master')->where(['inactive'=>0,'debtor_no'=>$mobile_no])->get();
        return $customerData;
    }
    public function create()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';
        $data['customerData'] = DB::table('debtors_master')->where(['inactive'=>0])->get();
        $data['locData'] = DB::table('location')->get();
        $data['vat'] = DB::table('item_tax_types')->get();

        $data['payments'] = DB::table('payment_terms')->get();

        $data['salesType'] = DB::table('sales_types')->select('sales_type', 'id', 'defaults')->get();
         // d($data['salesType'],1);
        $order_count = DB::table('sales_orders')->where('trans_type', SALESORDER)->count();

        if ($order_count>0) {
            $orderReference = DB::table('sales_orders')->where('trans_type', SALESORDER)->select('reference')->orderBy('order_no', 'DESC')->first();
            $ref = explode("-", $orderReference->reference);
            $data['order_count'] = (int) $ref[1];
        } else {
            $data['order_count'] = 0 ;
        }
        
        $vattax = DB::table('item_tax_types')->get();

        $taxTypeList = DB::table('item_tax_types')->get();
        $taxOptions = '';
        $selectStart = "<select class='form-control taxList' name='tax_id[]'>";
        $selectEnd = "</select>";
        
        foreach ($taxTypeList as $key => $value) {
            $taxOptions .= "<option value='".$value->id."' taxrate='".$value->tax_rate."'>".$value->name.'('.$value->tax_rate.')'."</option>";
        }

        $data['tax_type'] = $selectStart.$taxOptions.$selectEnd;
        //d($data['tax_type'],1);
        return view('admin.salesOrder.orderAdd', $data);
    }

    /**
     * Store a newly created resource in storage.
     **/
    public function store(Request $request)
    {
        $userId = \Auth::user()->id;
        $this->validate($request, [
            'reference'=>'required|unique:sales_orders',
            //'ord_date' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'channel' => 'required',
        ]);
        //dd($request->all());
//d(SALESORDER,1);
        if (($request->debtor_no == -1)) {
              $name  = $request->name;
              $phone = $request->phone;
              /*$this->validate($request, [
            'phone'=>'required|unique:debtors_master'
            
            ]);*/
              $channel = $request->channel;
              $channel_id = $request->channel_id;
              $email = $request->email;
              $created_at =  date('Y-m-d H:i:s');
              $insertedDebtor_no = DB::table('debtors_master')->InsertGetId(['name'=>$name,'phone'=>$phone,'channel_name'=>$channel,
                                                    'channel_id'=>$channel_id,'email'=>$email,'created_at'=>$created_at]);
              //get the latest Debtor
        }
        //dd($request->all());
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
        if (($request->debtor_no == -1)) {
            $salesOrder['debtor_no'] = $insertedDebtor_no;
        } else {
            $salesOrder['debtor_no'] = $request->debtor_no;
        }
         /*if debtor is new, it will save the value -1*/
        $salesOrder['branch_id'] = $request->debtor_no;
        $salesOrder['person_id']= $userId;
        $salesOrder['reference'] = $request->reference;
        $salesOrder['comments'] = $request->comments;
        $salesOrder['trans_type'] = SALESORDER;
        //$salesOrder['ord_date'] = DbDateFormat($request->ord_date);
        $salesOrder['ord_date'] = date('Y-m-d H:i:s');
        $salesOrder['total'] = $request->total;
        $salesOrder['created_at'] = date('Y-m-d H:i:s');

        /*Sales Modification*/
         $salesOrder['item_tax'] = $request->item_tax;
         $salesOrder['total_weight'] = $request->total_weight;
         $salesOrder['shipping_method'] = $request->shipping_method;
         $salesOrder['shipping_cost'] = $request->shipping_cost;
         $salesOrder['discount_amnount'] = $request->discount_amnount;
        /*ENd of Sales Modification*/
       
        // d($salesOrder,1);
        $salesOrderId = \DB::table('sales_orders')->insertGetId($salesOrder);

        for ($i=0; $i < count($itemIds); $i++) {
            foreach ($product as $key => $item) {
                if ($itemIds[$i] == $key) {
                    // create salesOrderDetail
                    $salesOrderDetail[$i]['order_no'] = $salesOrderId;
                    $salesOrderDetail[$i]['stock_id'] = $stock_id[$i];
                    $salesOrderDetail[$i]['description'] = $description[$i];
                    $salesOrderDetail[$i]['qty_sent'] = 0;
                    $salesOrderDetail[$i]['quantity'] = $item;
                    $salesOrderDetail[$i]['trans_type'] = SALESORDER;
                    $salesOrderDetail[$i]['discount_percent'] = 0;
                    $salesOrderDetail[$i]['tax_type_id'] = 0;
                    $salesOrderDetail[$i]['unit_price'] = $unitPrice[$i];
                }
            }
        }

        for ($i=0; $i < count($salesOrderDetail); $i++) {
            DB::table('sales_order_details')->insertGetId($salesOrderDetail[$i]);
        }

        if (!empty($salesOrderId)) {
            \Session::flash('success', trans('message.success.save_success'));
            return redirect()->intended('order/view-order-details/'.$salesOrderId);
        }
    }

    /**
     * Show the form for editing the specified resource.
     **/
    public function edit($orderNo)
    {
        $data['menu'] = 'sales';
        $data['countries'] = DB::table('countries')->get();
        $data['sub_menu'] = 'order/list';
        $data['taxType'] = $this->order->calculateTaxRow($orderNo);
        $data['customerData'] = DB::table('debtors_master')->get();
        $data['vat'] = DB::table('item_tax_types')->get();
        $data['locData'] = DB::table('location')->get();
        $data['invoiceData'] = $this->order->getSalseInvoiceByID($orderNo);
        $data['saleData'] = DB::table('sales_orders')->where('order_no', '=', $orderNo)
                            ->join('debtors_master', 'debtors_master.debtor_no', '=', 'sales_orders.debtor_no')
                            ->select('sales_orders.*', 'debtors_master.name', 'debtors_master.phone', 'debtors_master.channel_id', 'debtors_master.channel_name', 'debtors_master.email')
                            ->first();

        $data['payments'] = DB::table('sale_orders_payment')->where('sale_orders_no', $orderNo)->get();
        $data['branchs'] = DB::table('cust_branch')->select('debtor_no', 'branch_code', 'br_name')->where('debtor_no', $data['saleData']->debtor_no)->orderBy('br_name', 'ASC')->get();
        //$data['payments'] = DB::table('payment_terms')->get();
        $data['invoicedItem'] = DB::table('stock_moves')->where(['order_no'=>$orderNo])->lists('stock_id');
        $data['salesType'] = DB::table('sales_types')->select('sales_type', 'id')->get();

        //d($data['invoiceData'],1);

        $taxTypeList = DB::table('item_tax_types')->get();
        $taxOptions = '';
        $selectStart = "<select class='form-control taxList' name='tax_id_new[]'>";
        $selectEnd = "</select>";
        
        foreach ($taxTypeList as $key => $value) {
            $taxOptions .= "<option value='".$value->id."' taxrate='".$value->tax_rate."'>".$value->name.'('.$value->tax_rate.')'."</option>";
        }
        $data['tax_type_new'] = $selectStart.$taxOptions.$selectEnd;
        $data['tax_types'] = $taxTypeList;
        return view('admin.salesOrder.orderEdit', $data);
    }

    /**
     * Update the specified resource in storage.
     **/
    public function update(Request $request)
    {

        $userId = \Auth::user()->id;
        $order_no = $request->order_no;
        $this->validate($request, [
            'order_no' => 'required',
            'reference' => 'required'
        ]);
        
        if (($request->debtor_no == -1)) {
            $name  = $request->name;
            $phone = $request->phone;
            /*$this->validate($request, [
            'phone'=>'required|unique:debtors_master'
            
            ]);*/
            $channel = $request->channel;
            $channel_id = $request->channel_id;
            $email = $request->email;
            $created_at =  date('Y-m-d H:i:s');
            DB::table('debtors_master')->Insert(['name'=>$name,'phone'=>$phone,'channel_name'=>$channel,
                                                'channel_id'=>$channel_id,'email'=>$email,'created_at'=>$created_at]);
        }

        $itemQty = $request->item_quantity;
        $itemIds = $request->item_id;
        $unitPrice = $request->unit_price;
      
        $itemPrice = $request->item_price;
        $stock_id = $request->stock_id;
        $description = $request->description;

        // update sales_order table
        $salesOrder['ord_date'] = DbDateFormat($request->ord_date);
        $salesOrder['debtor_no'] = $request->debtor_no;
        $salesOrder['trans_type'] = SALESORDER;
        $salesOrder['branch_id'] = $request->debtor_no;
        $salesOrder['payment_id'] = 1;
       
        $salesOrder['from_stk_loc'] = 1;
        $salesOrder['comments'] = $request->comments;
        $salesOrder['total'] = $request->total;
        $salesOrder['updated_at'] = date('Y-m-d H:i:s');
        //d($salesOrder,1);
         /*Sales Modification*/
         $salesOrder['item_tax'] = $request->item_tax;
         $salesOrder['total_weight'] = $request->total_weight;
         $salesOrder['shipping_method'] = $request->shipping_method;
         $salesOrder['shipping_cost'] = $request->shipping_cost;
         $salesOrder['discount_amnount'] = $request->discount_amnount;
         
         $salesOrder['billing_name'] = $request->billing_name;
         $salesOrder['billing_street'] = $request->billing_street;
         $salesOrder['billing_city'] = $request->billing_city;
         $salesOrder['billing_state'] = $request->billing_state;
         $salesOrder['billing_zip_code'] = $request->billing_zip_code;
         $salesOrder['billing_country_id'] = $request->billing_country_id;

         $salesOrder['shipping_name'] = $request->shipping_name;
         $salesOrder['shipping_street'] = $request->shipping_street;
         $salesOrder['shipping_city'] = $request->shipping_city;
         $salesOrder['shipping_state'] = $request->shipping_state;
         $salesOrder['shipping_zip_code'] = $request->shipping_zip_code;
         $salesOrder['shipping_country_id'] = $request->shipping_country_id;
        /*ENd of Sales Modification*/

        DB::table('sales_orders')->where('order_no', $order_no)->update($salesOrder);
        if (count($itemQty)>0) {
            $invoiceData = $this->order->getSalseInvoiceByID($order_no);
            $invoiceData = objectToArray($invoiceData);
            
            for ($i=0; $i<count($invoiceData); $i++) {
                if (!in_array($invoiceData[$i]['item_id'], $itemIds)) {
                    DB::table('sales_order_details')->where([['order_no','=',$invoiceData[$i]['order_no']],['stock_id','=',$invoiceData[$i]['stock_id']],])->delete();
                }
            }

            
            foreach ($itemQty as $key => $value) {
                $product[$itemIds[$key]] = $value;
            }

            for ($i=0; $i < count($itemIds); $i++) {
                foreach ($product as $key => $value) {
                    if ($itemIds[$i] == $key) {
                        // update sales_order_details table
                        $salesOrderDetail[$i]['stock_id'] = $stock_id[$i];
                        $salesOrderDetail[$i]['description'] = $description[$i];
                        $salesOrderDetail[$i]['unit_price'] = $unitPrice[$i];
                        $salesOrderDetail[$i]['qty_sent'] = $value;
                        $salesOrderDetail[$i]['trans_type'] = SALESORDER;
                        $salesOrderDetail[$i]['quantity'] = $value;
                        $salesOrderDetail[$i]['discount_percent'] = 0;
                    }
                }
            }
           // d($salesOrderDetail,1);
            for ($i=0; $i < count($salesOrderDetail); $i++) {
                DB::table('sales_order_details')->where(['stock_id'=>$salesOrderDetail[$i]['stock_id'],'order_no'=>$order_no])->update($salesOrderDetail[$i]);
            }
        } else {
            $invoiceData = $this->order->getSalseInvoiceByID($order_no);
            $invoiceData = objectToArray($invoiceData);
            
            for ($i=0; $i<count($invoiceData); $i++) {
                DB::table('sales_order_details')->where([['order_no','=',$invoiceData[$i]['order_no']],['stock_id','=',$invoiceData[$i]['stock_id']],])->delete();
            }
            DB::table('sales_orders')->where('order_no', '=', $order_no)->delete();
        }

        if (isset($request->item_quantity_new)) {
            $itemQty = $request->item_quantity_new;
            $itemIdsNew = $request->item_id_new;
            $unitPriceNew = $request->unit_price_new;
            $taxIdsNew = $request->tax_id_new;
            $itemDiscountNew = $request->discount_new;
            $itemPriceNew = $request->item_price_new;
            $descriptionNew = $request->description_new;
            $stock_id_new = $request->stock_id_new;

            foreach ($itemQty as $key => $newItem) {
                $productNew[$itemIdsNew[$key]] = $newItem;
            }
            
            for ($i=0; $i < count($itemIdsNew); $i++) {
                foreach ($productNew as $key => $value) {
                    if ($itemIdsNew[$i] == $key) {
                        // Insert new sales order detail
                        $salesOrderDetailNew[$i]['trans_type'] = SALESORDER;
                        $salesOrderDetailNew[$i]['order_no'] = $order_no;
                        $salesOrderDetailNew[$i]['stock_id'] = $stock_id_new[$i];
                        $salesOrderDetailNew[$i]['description'] = $descriptionNew[$i];
                        $salesOrderDetailNew[$i]['qty_sent'] = $value;
                        $salesOrderDetailNew[$i]['quantity'] = $value;
                        $salesOrderDetailNew[$i]['discount_percent'] = 0;
                        $salesOrderDetailNew[$i]['tax_type_id'] = 0;
                        $salesOrderDetailNew[$i]['unit_price'] = $itemPriceNew[$i];
                    }
                }
            }
           // d($salesOrderDetail,1);
            for ($i=0; $i < count($salesOrderDetailNew); $i++) {
                DB::table('sales_order_details')->insertGetId($salesOrderDetailNew[$i]);
            }
        }

        \Session::flash('success', trans('message.success.save_success'));
         return redirect()->intended('order/view-order-details/'.$order_no);
    }

    /**
     * Remove the specified resource from storage.
     **/
    public function destroy($id)
    {
        if (isset($id)) {
            $record = \DB::table('sales_orders')->where('order_no', $id)->first();
            if ($record) {
                // Delete shipment information
                DB::table('shipment')->where('order_no', '=', $record->order_no)->delete();
                DB::table('shipment_details')->where('order_no', '=', $record->order_no)->delete();

                 // Delete Payment information
                DB::table('payment_history')->where('order_reference', '=', $record->reference)->delete();

                // Delete invoice information
                $invoice = \DB::table('sales_orders')->where('order_reference_id', $record->order_no)->first();
                
               // d($invoice,1);
                DB::table('sales_orders')->where('order_reference_id', '=', $record->order_no)->delete();
                if (!empty($invoice)) {
                    DB::table('sales_order_details')->where('order_no', '=', $invoice->order_no)->delete();
                }
                // Delete order information
                DB::table('sales_orders')->where('order_no', '=', $record->order_no)->delete();
                DB::table('sales_order_details')->where('order_no', '=', $record->order_no)->delete();

                 // Delete Stock information
                DB::table('stock_moves')->where('order_no', '=', $record->order_no)->delete();

                \Session::flash('success', trans('message.success.delete_success'));
                return redirect()->intended('order/list');
            }
        }
    }

    public function search(Request $request)
    {
           
            $data = array();
            $data['status_no'] = 0;
            $data['message']   ='No Item Found!';
            $data['items'] = array();

            $item = DB::table('stock_master')
            ->where('stock_master.description', 'LIKE', '%'.$request->search.'%')
            ->where(['stock_master.inactive'=>0,'stock_master.deleted_status'=>0])
            ->leftJoin('item_tax_types', 'item_tax_types.id', '=', 'stock_master.tax_type_id')
            ->leftJoin('item_code', 'stock_master.stock_id', '=', 'item_code.stock_id')
            ->select('stock_master.*', 'item_tax_types.tax_rate', 'item_tax_types.id as tax_id', 'item_code.id', 'item_code.item_image')
            ->get();

        if (!empty($item)) {
            $data['status_no'] = 1;
            $data['message']   ='Item Found';

            $i = 0;
            foreach ($item as $key => $value) {
                $itemPriceValue = DB::table('sale_prices')->where(['stock_id'=>$value->stock_id,'sales_type_id'=>$request['salesTypeId']])->select('price')->first();
                 $itemSalesPrice = DB::table('item_code')->where('stock_id', '=', $value->stock_id)
                               ->select('special_price', 'weight')->first();
                    
                $weight = $itemSalesPrice->weight;

                if (!isset($itemPriceValue)) {
                    $itemSalesPriceValue = $itemSalesPrice->special_price ;
                } else {
                    $itemSalesPriceValue = $itemSalesPrice->special_price;
                }
                $product_stock_id = $value->stock_id;
                /*======= Stock of the product */
                    
                     $itemList = DB::select(DB::raw("
                             
                            SELECT item.stock_id,item.description,COALESCE(sp.price,0) as retail_price,COALESCE(sm.qty,0) as available_qty,COALESCE(pod.received_qty,0) as received_qty,COALESCE(pod.price,0) as cost_amount 
                                FROM (SELECT * FROM stock_master as stm WHERE  stm.inactive=0 AND stm.deleted_status = 0 and stm.stock_id = '$product_stock_id' 
                                ) item

                                LEFT JOIN(SELECT stock_id,price FROM sale_prices WHERE sales_type_id = 1)sp
                                ON sp.stock_id = item.stock_id

                                LEFT JOIN(SELECT stock_id,sum(quantity)as qty FROM stock_movements GROUP BY stock_id)sm
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

                $product_stock_id = $value->stock_id;

                $return_arr[$i]['id'] = $value->id;
                $return_arr[$i]['stock_id'] = $value->stock_id;
                $return_arr[$i]['description'] = $value->description;
                $return_arr[$i]['units'] = $value->units;
                $return_arr[$i]['price'] = $itemSalesPriceValue;
                $return_arr[$i]['tax_rate'] = $value->tax_rate;
                $return_arr[$i]['tax_id'] = $value->tax_id;
                $return_arr[$i]['weight'] = $weight;
                $return_arr[$i]['item_image'] = $value->item_image;
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
    public function quantityValidation(Request $request)
    {
        $data = array();
        $location = $request['location_id'];
        $setItem = $request['qty'];

        $item_code = DB::table('item_code')->where("id", $request['id'])->select('stock_id')->first();
        
        $availableItem = $this->order->stockValidate($location, $item_code->stock_id);
      
        if ($setItem>$availableItem) {
            $data['availableItem'] = $availableItem;
            $data['message'] = "Insufficient item quantity. Available quantity is : ".$availableItem;
            $data['tag'] = 'insufficient';
            $data['status_no'] = 0;
        } else {
            $data['status_no'] = 1;
        }

        return json_encode($data);
    }
    /**
    * Check reference no if exists
    */
    public function referenceValidation(Request $request)
    {
        
        $data = array();
        $ref = $request['ref'];
        $result = DB::table('sales_orders')->where("reference", $ref)->first();

        if (count($result)>0) {
            $data['status_no'] = 1;
        } else {
            $data['status_no'] = 0;
        }

        return json_encode($data);
    }

    /**
    * Return customer Branches by customer id
    */
    public function customerBranches(Request $request)
    {
        $debtor_no = $request['debtor_no'];
        $data['status_no'] = 0;
        $branchs = '';
        $result = DB::table('cust_branch')->select('debtor_no', 'branch_code', 'br_name')->where('debtor_no', $debtor_no)->orderBy('br_name', 'ASC')->get();
        if (!empty($result)) {
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

    public function viewOrder($orderNo)
    {

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';

        $data['taxType'] = $this->sale->calculateTaxRow($orderNo);
        $data['customerData'] = DB::table('debtors_master')->get();
        $data['locData'] = DB::table('location')->get();
        $data['saleData'] = DB::table('sales_orders')->where('order_no', '=', $orderNo)->first();
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo, $data['saleData']->from_stk_loc);
        
        $data['branchs'] = DB::table('cust_branch')->select('debtor_no', 'branch_code', 'br_name')->where('debtor_no', $data['saleData']->debtor_no)->orderBy('br_name', 'ASC')->get();
        $data['payments'] = DB::table('payment_terms')->get();
        $data['invoice_count'] = DB::table('sales_orders')->where('trans_type', SALESINVOICE)->count();
       //d( $data['saleData'],1);
        return view('admin.salesOrder.viewOrder', $data);
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

        $itemCode = DB::table('item_code')->select('id', 'stock_id', 'description')->whereIn('id', $itemIds)->get();
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
                if ($itemCode[$i]['id'] == $key) {
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
        DB::table('sales_orders')->where('order_no', $order_id)->update(['invoice_status'=>'full_created']);
        if (!empty($salesOrderId)) {
            \Session::flash('success', trans('message.success.save_success'));
            return redirect()->intended('sales/list');
        }
    }


    /**
    * Preview of order details
    * @params order_no
    **/

    public function viewOrderDetails($orderNo)
    {

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';

        $data['taxType'] = $this->sale->calculateTaxRow($orderNo);
        $data['customerData'] = DB::table('debtors_master')->get();
        $data['locData'] = DB::table('location')->get();
        $data['saleData'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location', 'location.loc_code', '=', 'sales_orders.from_stk_loc')
                            ->select("sales_orders.*", "location.location_name")
                            ->first();
       // d($data['saleData'],1);
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo, $data['saleData']->from_stk_loc);

        $data['branchs'] = DB::table('cust_branch')->select('debtor_no', 'branch_code', 'br_name')->where('debtor_no', $data['saleData']->debtor_no)->orderBy('br_name', 'ASC')->get();
        $data['payments'] = DB::table('payment_terms')->get();
        $data['invoice_count'] = DB::table('sales_orders')->where('trans_type', SALESINVOICE)->count();
        
        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no', $orderNo)
                             ->leftjoin('debtors_master', 'debtors_master.debtor_no', '=', 'sales_orders.debtor_no')
                             ->leftjoin('cust_branch', 'cust_branch.branch_code', '=', 'sales_orders.branch_id')
                             ->leftjoin('countries', 'countries.id', '=', 'cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no', 'debtors_master.name', 'debtors_master.phone', 'debtors_master.email', 'cust_branch.br_name', 'cust_branch.br_address', 'cust_branch.billing_street', 'cust_branch.billing_city', 'cust_branch.billing_state', 'cust_branch.billing_zip_code', 'cust_branch.billing_country_id', 'cust_branch.shipping_street', 'cust_branch.shipping_city', 'cust_branch.shipping_state', 'cust_branch.shipping_zip_code', 'cust_branch.shipping_country_id', 'countries.country')
                             ->first();
        //d($data['customerInfo'],1);
        $data['customer_branch'] = DB::table('cust_branch')->where('branch_code', $data['saleData']->branch_id)->first();
        $data['customer_payment'] = DB::table('payment_terms')->where('id', $data['saleData']->payment_id)->first();
      
        $data['invoiceList'] = DB::table('sales_orders')
                                ->where('order_reference', $data['saleData']->reference)
                                ->select('order_no', 'reference', 'order_reference', 'total', 'paid_amount')
                                ->orderBy('created_at', 'DESC')
                                ->get();
      
        $data['invoiceQty'] = DB::table('stock_moves')->where(['order_no'=>$orderNo,'trans_type'=>SALESINVOICE])->sum('qty');
        $data['orderQty'] = DB::table('sales_order_details')->where(['order_no'=>$orderNo,'trans_type'=>SALESORDER])->sum('quantity');
        $data['orderInfo']  = DB::table('sales_orders')->where('order_no', $orderNo)->select('reference', 'order_no')->first();
        $data['paymentsList'] = DB::table('payment_history')
                            ->where(['order_reference'=>$data['orderInfo']->reference])
                            ->leftjoin('payment_terms', 'payment_terms.id', '=', 'payment_history.payment_type_id')
                            ->select('payment_history.*', 'payment_terms.name')
                            ->orderBy('payment_date', 'DESC')
                            ->get();
        $data['shipmentList'] = DB::table('shipment_details')
                            ->select('shipment_details.shipment_id', DB::raw('sum(quantity) as total'))->where(['order_no'=>$orderNo])
                            ->groupBy('shipment_id')
                            ->orderBy('shipment_id', 'DESC')
                            ->get();
        $shipmentTotal = $this->shipment->getTotalShipmentByOrderNo($orderNo);
        $invoicedTotal = $this->shipment->getTotalInvoicedByOrderNo($orderNo);
        $shipment = (int)abs($invoicedTotal)-$shipmentTotal;
        $data['shipmentStatus'] = ($shipment>0) ? 'available' : 'notAvailable';
        $lang = Session::get('dflt_lang');
        $data['emailInfo'] = DB::table('email_temp_details')->where(['temp_id'=>5,'lang'=>$lang])->select('subject', 'body')->first();
        return view('admin.salesOrder.viewOrderDetails', $data);
    }

    /**
    * Manual invoice create
    * @params order_no
    **/
    public function manualInvoiceCreate($orderNo)
    {

        $data['menu'] = 'sales';
        $data['sub_menu'] = 'sales/direct-invoice';
        $data['taxType'] = $this->order->calculateTaxRowRestItem($orderNo);
        $data['customerData'] = DB::table('debtors_master')->get();
        $data['locData'] = DB::table('location')->get();
        $data['invoiceData'] = $this->order->getRestOrderItemsByOrderID($orderNo);
        $data['saleData'] = DB::table('sales_orders')->where('order_no', '=', $orderNo)->first();
        $data['branchs'] = DB::table('cust_branch')->select('debtor_no', 'branch_code', 'br_name')->where('debtor_no', $data['saleData']->debtor_no)->orderBy('br_name', 'ASC')->get();
        $data['payments'] = DB::table('payment_terms')->get();
        $invoice_count = DB::table('sales_orders')->where('trans_type', SALESINVOICE)->count();
        
        $data['order_no'] = $orderNo;
        $data['invoiceedItem'] = $this->order->getInvoicedItemsQty($orderNo);
        $data['paymentTerms'] = DB::table('invoice_payment_terms')->get();
        
        if ($invoice_count>0) {
            $invoiceReference = DB::table('sales_orders')->where('trans_type', SALESINVOICE)->select('reference')->orderBy('order_no', 'DESC')->first();

            $ref = explode("-", $invoiceReference->reference);
            $data['invoice_count'] = (int) $ref[1];
        } else {
            $data['invoice_count'] = 0 ;
        }
       // d($data['invoiceData'],1);
        return view('admin.salesOrder.createManualInvoice', $data);
    }

    /**
    * Store manaul invoice
    */
    public function storeManualInvoice(Request $request)
    {
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
                if ($itemIds[$i] == $key) {
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

        if (!empty($orderInvoiceId)) {
            \Session::flash('success', trans('message.success.save_success'));
            return redirect()->intended('invoice/view-detail-invoice/'.$request->order_no.'/'.$orderInvoiceId);
        }
    }

    /**
    * Create auto invoice
    *@params order_id
    */

    public function autoInvoiceCreate($orderNo)
    {
        $userId = \Auth::user()->id;
        $invoiceCount = DB::table('sales_orders')->where('trans_type', SALESINVOICE)->count();
        if ($invoiceCount>0) {
            $invoiceReference = DB::table('sales_orders')->where('trans_type', SALESINVOICE)->select('reference')->orderBy('order_no', 'DESC')->first();

            $ref = explode("-", $invoiceReference->reference);
            $invoice_count = (int) $ref[1];
        } else {
            $invoice_count = 0 ;
        }

        $invoiceInfos = $this->order->getRestOrderItemsByOrderID($orderNo);
        $orderInfo = DB::table('sales_orders')->where('order_no', '=', $orderNo)->first();

        // Check quantity is available or not on location
        foreach ($invoiceInfos as $key => $res) {
            $availableQty = getItemQtyByLocationName($res->location, $res->stock_id);
            if ($availableQty < $res->quantity) {
                return redirect()->intended('order/manual-invoice-create/'.$orderNo)->withErrors(['email' => "Item quantity not enough for this invoice !"]);
            }
        }

        $payment_term = DB::table('invoice_payment_terms')->where('defaults', 1)->select('id')->first();
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

        foreach ($invoiceInfos as $i => $invoiceInfo) {
            if ($invoiceInfo->item_rest>0) {
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
            \Session::flash('success', trans('message.success.save_success'));
            //return redirect()->intended('sales/list');
            return redirect()->intended('invoice/view-detail-invoice/'.$orderNo.'/'.$orderInvoiceId);
    }

    /**
    * Check Item Quantity After Create Invoice
    **/

    public function checkQuantityAfterInvoice(Request $request)
    {
        $data = array();
        $itemCode = DB::table('item_code')->where("id", $request['id'])->select('stock_id')->first();
        
        $location = $request['location_id'];
        $setItemQty = $request['qty'];
        $orderReferenceId = $request['order_no'];
        $orderReference = $request['reference'];
        $stock_id = $itemCode->stock_id;
        $invoicedQty = str_replace('-', '', $this->order->getInvoicedQty($orderReferenceId, $stock_id, $location, $orderReference));

        if ((int)$invoicedQty > $setItemQty) {
            $data['status_no'] = 0;
            $data['message']   = 'No';
        } else {
            $data['status_no'] = 1;
            $data['message']   = 'Yes';
        }
        //d($data,1);
        return json_encode($data);
    }
    /**
    * Create new payment base on sale_orders (The function in Edit Order Page)
    * @author: Nam Nguyen
    **/
    public function addPayment(Request $request)
    {
        $payment['sale_orders_no'] = $request->saleOrderNo;
        $payment['method'] = $request->payment_type;
        $payment['debtor_no'] = $request->payment_debtorNo;
        $payment['amount'] = $request->payment_amount;
        $payment['payment_date'] = date("Y-m-d", strtotime($request->payment_date));
        if ($request->hasFile('payment_image')) {
            $image = $request->file('payment_image');
            $imageName = 'img_'.time().$image->getClientOriginalName();
            $imagePath = 'uploads/paymentPic/';
            $image->move(base_path().'/public/'.$imagePath, $imageName);
            $imageUrl = $imageName;
            $payment['file'] = $imageUrl;
        } else {
            $payment['file'] = "404";
        }
        DB::table('sale_orders_payment')->insertGetId($payment);
        \Session::flash('success', trans('message.success.save_success'));
        return redirect()->intended('/order/edit/'.$payment['sale_orders_no']);
    }


    /**
    * Preview of order details
    * @params order_no
    **/

    public function orderPdf($orderNo)
    {
        $data['taxInfo'] = $this->sale->calculateTaxRow($orderNo);
        $data['saleData'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location', 'location.loc_code', '=', 'sales_orders.from_stk_loc')
                            ->select("sales_orders.*", "location.location_name")
                            ->first();
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo, $data['saleData']->from_stk_loc);
        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no', $orderNo)
                             ->leftjoin('debtors_master', 'debtors_master.debtor_no', '=', 'sales_orders.debtor_no')
                             ->leftjoin('cust_branch', 'cust_branch.branch_code', '=', 'sales_orders.branch_id')
                             ->leftjoin('countries', 'countries.id', '=', 'cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no', 'debtors_master.name', 'debtors_master.phone', 'debtors_master.email', 'cust_branch.br_name', 'cust_branch.br_address', 'cust_branch.billing_street', 'cust_branch.billing_city', 'cust_branch.billing_state', 'cust_branch.billing_zip_code', 'cust_branch.billing_country_id', 'cust_branch.shipping_street', 'cust_branch.shipping_city', 'cust_branch.shipping_state', 'cust_branch.shipping_zip_code', 'cust_branch.shipping_country_id', 'countries.country')
                             ->first();
       // return view('admin.salesOrder.orderPdf', $data);
        $pdf = PDF::loadView('admin.salesOrder.orderPdf', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('order_'.time().'.pdf', array("Attachment"=>0));
    }
    public function orderPrint($orderNo)
    {
        $data['taxInfo'] = $this->sale->calculateTaxRow($orderNo);
        $data['saleData'] = DB::table('sales_orders')
                            ->where('order_no', '=', $orderNo)
                            ->leftJoin('location', 'location.loc_code', '=', 'sales_orders.from_stk_loc')
                            ->select("sales_orders.*", "location.location_name")
                            ->first();
        $data['invoiceData'] = $this->order->getSalseOrderByID($orderNo, $data['saleData']->from_stk_loc);
        $data['customerInfo']  = DB::table('sales_orders')
                             ->where('sales_orders.order_no', $orderNo)
                             ->leftjoin('debtors_master', 'debtors_master.debtor_no', '=', 'sales_orders.debtor_no')
                             ->leftjoin('cust_branch', 'cust_branch.branch_code', '=', 'sales_orders.branch_id')
                             ->leftjoin('countries', 'countries.id', '=', 'cust_branch.shipping_country_id')
                             ->select('debtors_master.debtor_no', 'debtors_master.name', 'debtors_master.phone', 'debtors_master.email', 'cust_branch.br_name', 'cust_branch.br_address', 'cust_branch.billing_street', 'cust_branch.billing_city', 'cust_branch.billing_state', 'cust_branch.billing_zip_code', 'cust_branch.billing_country_id', 'cust_branch.shipping_street', 'cust_branch.shipping_city', 'cust_branch.shipping_state', 'cust_branch.shipping_zip_code', 'cust_branch.shipping_country_id', 'countries.country')
                             ->first();
       // return view('admin.salesOrder.orderPdf', $data);
        $pdf = PDF::loadView('admin.salesOrder.orderPrint', $data);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('order_'.time().'.pdf', array("Attachment"=>0));
    
        return view('admin.salesOrder.orderPrint', $data);
    }
    /**
    * Send email to customer for Invoice information
    */
    public function sendOrderInformationByEmail(Request $request)
    {
        $this->email->sendEmail($request['email'], $request['subject'], $request['message']);
        \Session::flash('success', trans('message.email.email_send_success'));
        return redirect()->intended('order/view-order-details/'.$request['order_id']);
    }

    /**
    * Check if the customer's phone number is exist
    */
    public function checkIfCustomerPhoneNumberExist(Request $request)
    {
        $phone_number = $request->phone_number;
        $check = false;
        $data =DB::table('debtors_master')->where('phone', $phone_number)->first();
        if ($data !== null) {
            $check = true;
        }
        return response()->json(['state'=>$check, 'phone_number'=>$phone_number]);
    }
    /**
    * Update the order's status
    * @param: order_no, new_status
    * @author: Nam Nguyen
    **/
    public function updateStatus(Request $request)
    {
        $order_no = $request->order_no;
        $new_status = $request->new_status;
        DB::table('sales_orders')->where('order_no', $order_no)->update(['order_status'=>$new_status]);
        return response()->json(['state'=>true]);
    }
}
