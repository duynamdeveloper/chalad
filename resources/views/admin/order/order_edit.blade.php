@extends('layouts.app')
@section('content')
    <section class="container" style="padding-top:30px;">
        {{--  Page Header  --}}

        {{--  End Page Header  --}}

        {{--  Page Body  --}}
        <div class=row>
            {{--  Right Panel  --}}
            <div class="col-md-3" style="padding-right: 0px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-success">
                                <div class="box-header text-center">
                                    <h4>ORDER No: #{{$order->order_no}} </h4>
                                    <div class="box-body text-center">
                                        <div class="btn-group" id="state-btn-group">
                                            <button type="button" class="btn btn-{{$order->state_bootstrap_class}}">{{ $order->state_name }}</button>
                                            <button type="button" class="btn btn-{{$order->state_bootstrap_class}} dropdown-toggle" data-toggle="dropdown">
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#" class="label label-default" id="pending_status_btn">Pending</a></li>
                                                <li><a href="#" class="label label-success" id="confirm_create_shipment">Confirm</a></li>
                                                <li><a href="#" class="label label-danger" id="cancel_status_btn">Cancel</a></li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="box box-body">
                                <div class="box-header text-center"><h3 class="box-title">CUSTOMER DETAILS</h3></div>
                                <hr>
                                @include('admin.order.partials.customer_information')

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="box box-body">
                                Order Created By <strong>{{$order->user->real_name}}</strong>


                            </div>
                        </div>
                    </div>
                </div>



            </div>
            {{--  End Right Panel  --}}
            {{--  Left Panel  --}}
            <div class="col-md-9">
                <div class="box box-success">
                    <ul class="nav nav-tabs text-center" id="navTab" style="margin-bottom:0px;">
                        <li class="active"><a data-toggle="tab" href="#orderTab" aria-expanded="true">Order<br><span style="font-size:12px;"><em>(Complete)</em></a></li>
                        <li><a data-toggle="tab" href="#paymentTab">Payment<br><span style="font-size:12px;"><em>(Awaiting Confirmation)</em></a></li>
                        <li><a data-toggle="tab" href="#shipmentTab">Shipment<br><span style="font-size:12px;"><em>(None)</em></a></li>

                    </ul>
                </div>


                <div class="tab-content">
                    <div id="orderTab" class="tab-pane fade in active">
                        @include('admin.order.partials.order_detail')
                    </div>
                    <div id="paymentTab" class="tab-pane fade">
                        @include('admin.order.partials.payment')
                    </div>
                    <div id="shipmentTab" class="tab-pane fade">
                        @include('admin.shipment.includes.manageShipmentPanel')
                    </div>

                </div>
            </div>
        </div>

        {{--  End Page Body  --}}
    </section>



@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function(){

            function formatState (item) {
                console.log(item);
                if (!item.id) { return item.text; }
                var $item = $(
                    '<span>' + item.text + '</span>'
                );
                console.log($item);
                return $item;
            }

        });



        var DATE_FORMAT_TYPE = '{{Session::get('date_format_type')}}';
        var order_no = {{$order->order_no}};
        var exist_payments = {!! $order->payment_due !!};
        var exist_shipments = {!! count($order->shipments) !!};
        var order_status = {{$order->order_status}};
        //console.log(exist_payments);
    </script>
    <script type="text/javascript" src="{{asset('/dist/js/pages/shipment/manage-shipment.js')}}"></script>
    <script type="text/javascript" src="{{asset('/dist/js/pages/order/order-edit.js')}}"></script>
    <script type="text/javascript" src="{{asset('/public/dist/js/pages/shipment/manage-shipment.js')}}"></script>
    <script type="text/javascript" src="{{asset('/public/dist/js/pages/order/order-edit.js')}}"></script>
@endsection