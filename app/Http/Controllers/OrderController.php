<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Customer;
use App\Model\Item;
use DB;

class OrderController extends Controller
{
    public function index()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';
        $data['customers'] = Customer::all();
        $data['items'] = Item::all();
        $data['tax_types'] = DB::table('item_tax_types')->get();
       // $orders = Order::with(['details','shipments'])->where('order_no',3)->first();
    
        return view("admin.order.order_add", $data);
    }
    public function getShippingCost(Request $request)
    {
        $weight = $request->weight;
        $shipping_method = $request->shipping_method;
        //$weight = 100;
       // $shipping_method = "Registered";
        $shipping = DB::table('shipping_cost')->where('method', $shipping_method)->where('weight_to', '<=', $weight)
                                            ->where('weight_from', '>=', $weight)->first();
        
       
        if (!empty($shipping)) {
            return response()->json(['state'=>true,'cost'=>$shipping->cost]);
        }
        return response()->json(['state'=>false,'cost'=>0]);
    }
    public function create(Request $request){

        $userId = \Auth::user()->id;

        $items = $request->items;
        $items = json_decode($items);
        $customer = $request->customer;
        $customer = json_decode($customer);
        $shipping_cost = $request->shipping_cost;
        $discount_amount = $request->discount_amount;
        $total_fee = $request->total_fee;
        $item_tax = $request->item_tax;
        $customer_id = $customer->id;
        if($customer->id == -1){
            $newCustomer = new Customer();
            $newCustomer->name = $customer->name;
            $newCustomer->email = $customer->email;
            $newCustomer->phone = $customer->phone;
            $newCustomer->channel_name = $customer->channel_name;
            $newCustomer->channel_id = $customer->channel_id;
            $newCustomer->save();
            $customer_id = $newCustomer->debtor_no;
        }

        $order = new Order();
        $order->debtor_no = $customer_id;
        $order->branch_id = $customer_id;
        $order->person_id = $userId;
        $order->ord_date = date('Y-m-d');
        $order->total = $total_fee;
        $order->item_tax = $item_tax;
        $order->shipping_cost = $shipping_cost;
        $order->discount_amount = $discount_amount;
        $order->trans_type = SALESORDER;
        
        $order->save();
        $order_no = $order->order_no;

        foreach($items as $item){
            $orderDetail = new OrderDetail();
            $orderDetail->order_no = $order_no;
            $orderDetail->trans_type = SALESORDER;
            $orderDetail->stock_id = $item->item_id;
            $orderDetail->unit_price = $item->price;
            $orderDetail->quantity = $item->qty;
            $orderDetail->description = $item->name;
            $orderDetail->save();

        }
        return response()->json($order);
    }
    public function edit($order_no){
        $order = Order::where('order_no',$order_no)->with(['details','payments','shipments'])->first();
        return view('admin.order.order_edit');
    }
}
