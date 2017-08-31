@extends('layouts.app')
@section('content')
    <section class="container-fluid">
        {{--  Page Header  --}}
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">
                    <div class="box-header text-center">
                        <h4>ORDER No: #{{$order->order_no}}</h4>
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
                        </div>
                    </div>
                </div>
            </div>
            {{--  End left panel  --}}

            {{--  Right Panel  --}}
            <div class="col-md-4"></div>
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
        var order_no = {{$order->order_no}};
    </script>
    <script type="text/javascript" src="{{asset('/dist/js/pages/order/order-edit.js')}}"></script>
    <script type="text/javascript" src="{{asset('/dist/js/pages/shipment/manage-shipment.js')}}"></script>
@endsection