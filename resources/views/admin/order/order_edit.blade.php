@extends('layouts.app')
@section('content')
    <section class="container-fluid">
        {{--  Page Header  --}}
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header text-center">
                        <h4>ORDER No: #{{$order->order_no}} </h4>
                        <h4 id="order_status_label"> {!! $order->label_state !!}</h4>
                    </div>
                </div>
            </div>
        </div>
       {{--  End Page Header  --}}

       {{--  Page Body  --}}
       <div class=row>
            {{--  Left Panel  --}}
            <div class="col-md-8">
                <div class="box box-success">
                    <div class="box box-body">
                        <ul class="nav nav-tabs text-center" id="navTab">
                            <li class="active"><a data-toggle="tab" href="#customerTab">Customer</a></li>
                            <li><a data-toggle="tab" href="#orderTab">Order</a></li>
                            <li><a data-toggle="tab" href="#shipmentTab">Shipment</a></li>
                             <li><a data-toggle="tab" href="#paymentTab">Payment</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="customerTab" class="tab-pane fade in active">
                                @include('admin.order.partials.customer_information')
                            </div>
                            <div id="orderTab" class="tab-pane fade">
                                @include('admin.order.partials.order_detail')
                            </div>
                            <div id="shipmentTab" class="tab-pane fade">
                                @include('admin.shipment.includes.manageShipmentPanel')
                            </div>
                             <div id="paymentTab" class="tab-pane fade">
                                @include('admin.order.partials.payment')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--  End left panel  --}}

            {{--  Right Panel  --}}
            <div class="col-md-4" style="padding-left: 0px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header text-center"><h4>ACTION</h4></div>
                                <hr>
                                <div class="box-body text-center">
                                    <div class="btn-group">
                                        <button class="btn btn-danger" id="cancel_status_btn">Cancel</button>
                                        <button class="btn btn-default" id="pending_status_btn">Pending</button>
                                        <button class="btn btn-info" id="confirm_status_btn">Confirm</button>
                                       
                                    </div>
                                   
                                   <div class="btn-group" style="margin-top: 15px">
                                    <button class="btn btn-success" id="confirm_create_shipment">Confirm + Create Shipment</button>
                                   </div>
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{--  Payment  --}}


            </div>
            {{--  End Right Panel  --}}
       </div>
       {{--  End Page Body  --}}
    </section>



@endsection
@section('js')
        <script type="text/javascript">
        $(document).ready(function(){
            $(".select2").select2();
        });
        var DATE_FORMAT_TYPE = '{{Session::get('date_format_type')}}';
        var order_no = {{$order->order_no}};
        var exist_payments = {!! $order->payment_due !!};
        var exist_shipments = {!! count($order->shipments) !!};
        var order_status = {{$order->order_status}};
        console.log(exist_payments);
    </script>
   
    <script type="text/javascript" src="{{asset('/public/dist/js/pages/shipment/manage-shipment.js')}}"></script>
     <script type="text/javascript" src="{{asset('/public/dist/js/pages/order/order-edit.js')}}"></script>
@endsection