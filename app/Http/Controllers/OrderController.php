<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Customer;
use App\Model\Item;
use App\Model\Payment;
use App\Model\Shipment;
use DB;

class OrderController extends Controller
{

    public function index()
    {
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';
        $data['orders'] = Order::all();
        //$shipment = Shipment::where('order_no',10)->where('tracking_number',null)->get();
        //return response()->json($data['salesData']);
        //die;
        //var_dump($shipment->isEmpty());
        return view('admin.salesOrder.orderList', $data);
    }
    public function create()
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
    public function save(Request $request)
    {

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
        if ($customer->id == -1) {
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

        foreach ($items as $item) {
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
    public function edit($order_no)
    {
        $data['order'] = Order::where('order_no', $order_no)->with(['details','payments','shipments','customer'])->first();
        $data['menu'] = 'sales';
        $data['sub_menu'] = 'order/list';
        $data['countries'] = DB::table('countries')->get();
        $data['items'] = Item::all();
        $data['tax_types'] = DB::table('item_tax_types')->get();
        //var_dump($data['items']);
        return view('admin.order.order_edit', $data);
    }
    public function update(Request $request)
    {
        $userId = \Auth::user()->id;

        $items = $request->items;
        $order_no = $request->order_no;
        $items = json_decode($items);
        $shipping_cost = $request->shipping_cost;
        $discount_amount = $request->discount_amount;
        $total_fee = $request->total_fee;
        $item_tax = $request->item_tax;

        $order = Order::where('order_no', $order_no)->first();

        $order->billing_name = $request->billing_name;
        $order->billing_street = $request->billing_street;
        $order->billing_city = $request->billing_city;
        $order->billing_state = $request->billing_state;
        $order->billing_zip_code = $request->billing_zip_code;
        $order->billing_country_id = $request->billing_country_id;

        $order->shipping_name= $request->shipping_name;
        $order->shipping_street = $request->shipping_street;
        $order->shipping_city= $request->shipping_city;
        $order->shipping_state = $request->shipping_state;
        $order->shipping_zip_code = $request->shipping_zip_code;
        $order->shipping_country_id = $request->shipping_country_id;

        $order->person_id = $userId;
        $order->ord_date = date('Y-m-d');
        $order->total = $total_fee;
        $order->item_tax = $item_tax;
        $order->shipping_cost = $shipping_cost;
        $order->discount_amount = $discount_amount;
        $order->trans_type = SALESORDER;

        $order->save();
        $order_no = $order->order_no;
        DB::table('sales_order_details')->where('order_no', $order_no)->delete();
        foreach ($items as $item) {
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
    public function updateAddress(Request $request)
    {
        $order_no = $request->order_no;
        $order = Order::where('order_no', $order_no)->first();

        $order->billing_name = $request->billing_name;
        $order->billing_street = $request->billing_street;
        $order->billing_city = $request->billing_city;
        $order->billing_state = $request->billing_state;
        $order->billing_zip_code = $request->billing_zip_code;
        $order->billing_country_id = $request->billing_country_id;

        $order->shipping_name= $request->shipping_name;
        $order->shipping_street = $request->shipping_street;
        $order->shipping_city= $request->shipping_city;
        $order->shipping_state = $request->shipping_state;
        $order->shipping_zip_code = $request->shipping_zip_code;
        $order->shipping_country_id = $request->shipping_country_id;

        $order->update();

        return redirect('order/edit/'.$order->order_no);
    }
    public function addPayment(Request $request)
    {
        $payment = new Payment();
        $payment->order_no = $request->order_no;
        $payment->method = $request->payment_type;
        $payment->debtor_no = $request->payment_debtorNo;
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
        return redirect()->intended('/order/edit/'.$payment->order_no);
    }
    public function deletePayment(Request $request)
    {
        $payment_id = $request->payment_id;
        $payment = Payment::find($payment_id);
        $payment->delete();
        return response()->json(['state'=>true]);
    }
    public function deleteMultiPayment(Request $request)
    {
        $list = $request->list;
        $i = 0;
        foreach ($list as $payment_id) {
            $payment = Payment::find($payment_id);
            $payment->delete();
            $i++;
        }
        return response()->json(['state'=>true,'number'=>$i]);
    }
    public function updateStatusMultiPayment(Request $request)
    {
        $list = $request->list;
        $status = $request->state;
        $i = 0;
        if (count($list>0)) {
            foreach ($list as $payment_id) {
                $payment = Payment::find($payment_id);
                $payment->status = $status;
                $payment->update();
                $i++;
            }
            return response()->json(['state'=>true,'number'=>$i]);
        }
        return response()->json(['state'=>false,'number'=>$i]);
    }
    public function updateStatusPayment(Request $request)
    {

        $status = $request->state;
        $payment_id = $request->payment_id;

        $payment = Payment::find($payment_id);
        $payment->status = $status;
        $payment->update();

        return response()->json(['state'=>true]);
    }
    public function updateStatus(Request $request){
        $order_no = $request->order_no;
        $status = $request->status;
        $order = Order::where('order_no',$order_no)->first();
        $order->order_status = $status;
        $order->update();
        return response()->json(['state'=>true,'label'=>$order->label_state]);
    }
    public function editPayment(Request $request){
        $payment_id = $request->payment_id;
        $payment = Payment::find($payment_id);
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
        } else {
            $payment->file = "404";
        }
        $payment->update();
        return redirect()->intended('/order/edit/'.$payment->order_no);
    }
}
