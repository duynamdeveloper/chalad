<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderDetail;

class OrderController extends Controller
{
    public function index(){
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';
        $orders = Order::with(['details','shipments'])->where('order_no',3)->first();
        print_r($orders->order_status);
       // return view("admin.order.order_add",$data);
    }
}
