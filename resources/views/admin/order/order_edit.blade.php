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
									<div class="label label-default" id="pending_status_btn">Status : Pending</div>

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
						<div class="col-md-12">
                            <div class="box box-body">
							<button type="button" class="btn btn-block btn-danger">Cancel Order</button>
                    </div>
                </div>
                    </div>
                </div>



            </div>
            {{--  End Right Panel  --}}
            {{--  Left Panel  --}}
            <div class="col-md-9">
                <div class="box box-success col-md-12">
				<ul class="list-inline">
				<li class="active"><a data-toggle="tab" href="#orderTab" aria-expanded="true"><h3>Order</h3></a></li>
				<li>></li>
				<li><a data-toggle="tab" href="#paymentTab"><h3>Payment</h3></a></li>
				<li>></li>
				<li><a data-toggle="tab" href="#shipmentTab"><h3>Shipment</h3></a></li>
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