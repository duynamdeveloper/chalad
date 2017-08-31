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
                            <h3>Menu 1</h3>
                            <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                            <div id="shipmentTab" class="tab-pane fade">
                            <h3>Menu 2</h3>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
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
    </script>
    <script type="text/javascript" src="{{asset('public/dist/js/pages/order/order-edit.js')}}"></script>
@endsection