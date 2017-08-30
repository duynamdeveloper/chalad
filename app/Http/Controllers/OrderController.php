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
}
