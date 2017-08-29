<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Customer;
use App\Model\Item;

class OrderController extends Controller
{
    public function index(){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';
        $data['customers'] = Customer::all();
        $data['items'] = Item::all();
       // $orders = Order::with(['details','shipments'])->where('order_no',3)->first();
    
        return view("admin.order.order_add",$data);
    }
}
