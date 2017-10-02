@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="text-info">Create New Order</h3>
        </div>
        <div class="box-body">

           <form class="form-horizontal">
             <div class="row">
                <div class="col-md-6">
                    <form class="form-horizontal customer_form" autocomplete="offs" id="customer_form">
                        <div class="form-group">
                            <label class="control-label col-md-4">Select Customer</label>
                            <div class="col-md-8">
                                <select class="select2 form-control" name="customer_id" id="sel_customer">
                                    <option value="null">Choose an option</option>
                                    <option value="-1">CREATE NEW CUSTOMER</option>
                                    @foreach($customers as $customer)
                                    <option value="{{ $customer->debtor_no }}">{{ $customer->name }} (Phone: {{$customer->phone}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control customer-form" name="customer_name" id="inp_customer_name" placeholder="Enter Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Phone</label>
                        <div class="col-md-8">  
                            <input type="text" class="form-control customer-form" name="customer_phone" id="inp_customer_phone" placeholder="Enter Phone Number" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Email</label>
                        <div class="col-md-8">
                            <input type="text"  class="form-control customer-form" name="customer_email" id="inp_customer_email" placeholder="Enter Email">
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                   <div class="form-group">
                    <label class="control-label col-md-4">Channel</label>
                    <div class="col-md-8">
                     <input type="text" class="form-control customer-form" name="customer_channel" id="inp_customer_channel" placeholder="Enter Channel" >
                 </div>
             </div>
             <div class="form-group">
                <label class="control-label col-md-4 ">Channel ID</label>
                <div class="col-md-8">
                    <select class="select2 form-control customer-form" name="channel_id" id="sel_channel_id">
                        <option value="">{{ trans('message.form.select_one') }}</option>
                        <option value="facebook">{{ trans('message.extra_text.facebook') }}</option>
                        <option value="twitter">{{ trans('message.extra_text.twitter') }}</option>
                        <option value="lazada">{{ trans('message.extra_text.lazada') }}</option>
                        <option value="line">{{ trans('message.extra_text.line') }}</option>
                    </select>
                </div>
            </div>

        </form>
    </div>
</div>

</div>

<div class="box box-success" id="orderForm">
    <div class="box-body">
        <div class="row">
            <form class="form-horizontal" id="shipping_billing_form" method="get" action="{{url('/order/updateaddress')}}" >
                <input type="hidden" name="order_no">
                <div class="col-md-6">
                    <h4 class="text-info"><strong>{{ trans('message.invoice.shipping_address') }}</strong></h4>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.form.name') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="shipping_name" id="shipping_name" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_street" name="shipping_street" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_city" name="shipping_city" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_state" name="shipping_state" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_zip_code" name="shipping_zip_code" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                        <div class="col-sm-9">
                            <select class="form-control select2" name="shipping_country_id" id="shipping_country_id">
                                <option value="">{{ trans('message.form.select_one') }}</option>
                                @foreach ($countries as $data)

                                <option value="{{$data->code}}" >{{$data->country}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">Phone:</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone" required>
                        </div>
                    </div>
                </div>

                <!--End Shippind Address Form-->
                <!--Billing Address-->
                <div id="different_billing_address_div" class="col-md-6">
                    <div class="form-title">
                        <h4 class="text-info text-left" style="font-weight: bold;">Billing Address</h4><span class="text-info" style="font-size: 18px;"><input type="checkbox" name="billing_address_the_same_as_shipping_address" id="cbxBillingEqualShipping"  > Different Billing Address?</span>


                    </div>
                    <div id="billing_form" hidden>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.name') }}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_name"  id="billing_name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_street" id="billing_street" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_city"  id="billing_city" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_state"  id="billing_state" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_zip_code" id="billing_zip_code" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                            <div class="col-sm-8">
                                <select class="form-control select2" name="billing_country_id" id="billing_country_id">
                                    <option value="">{{ trans('message.form.select_one') }}</option>
                                    @foreach ($countries as $data)

                                    <option value="{{$data->code}}">{{$data->country}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <!--End Billing Address -->



            </form>
        </div>

    </div>
</div>

<div class="box box-success">
    <div class="box-body">

        <h4 class="text-info"><strong>Order Details</strong></h4>
        <div class="form-group">

            <div class="col-md-3">Search :</div>
            <div class="col-md-4">

                <input class="form-control" id="inp_live_search">

                <div id="livesearch" hidden>

                    <ul>
                        <li><img src="{{asset('public/img/loading-icon.gif')}}" width="50px" height="50px"> Loading...</li>
                        {{--<li><img src="{{asset('/uploads/itemPic/hpprobook.jpg')}}"><span class="pull-right">HP Probook</span></li>--}}
                        {{--<li><img src="{{asset('/uploads/itemPic/hpprobook.jpg')}}"><span class="pull-right">HP Probook</span></li>--}}

                    </ul>
                </div>
            </div>

        </div>

        <!-- End Select Product -->

        <!-- Product Table -->


        <div class="col-md-12">
            <table class="table table-reponsive info" id="product_table" >
                <thead>
                    <th></th>
                    <th>Name</th>

                    <th>Quantity</th>
                    <th>Price (B)</th>
                    <th>Amount (B)</th>
                    <th>Action</th>
                </thead>
                <tbody>

                </tbody>
                <tfoot hidden>
                    <tr class="static_rows">
                        <td colspan="5"><strong>Sub Total</strong></td>
                        <td colspan="2" id="subTotal" style="font-weight:bold" class="text-left"></td>
                    </tr>

                    <tr class="static_rows">
                        <td colspan="5"><strong>Shipping Method</strong></td>
                        <td>
                            <select name="shipping_method" class="form-control" id="sel_shipping_method">
                                <option>Select One</option>
                                <option value="EMS">EMS</option>
                                <option value="Registered">Registered</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="static_rows">
                        <td colspan="5"><strong>Shipping Cost</strong></td>
                        <td>
                            <input class="form-control" id="shipping_cost" readonly>
                        </td>
                    </tr>
                    <tr class="static_rows">
                        <td colspan="5"><strong>Discount Amount</strong></td>
                        <td>
                            <input class="form-control" id="discount_amount" type="number" name="discount_amount">
                        </td>
                    </tr>
                    <tr class="static_rows">
                        <td colspan="5" ><strong>TAX</strong></td>
                        <td>
                            <select class="form-control" name="tax" id="sel_tax">
                                <option value="-1">Select One</option>
                                @foreach($tax_types as $tax_type)
                                <option value="{{$tax_type->tax_rate}}">{{$tax_type->name}}</option>
                                @endforeach
                            </select>
                        </td>

                    </tr>
                    <tr class="static_rows">
                        <td colspan="5"><strong>Tax Amount</strong></td>
                        <td>
                            <input class="form-control" id="tax_amount" value="0" readonly >
                        </td>
                    </tr>
                    <tr class="static_rows">
                        <td colspan="5"><strong>Grand Total</strong></td>
                        <td>
                            <input class="form-control" id="grand_total" type="number" name="grand_total">
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>


</div>
<div class="box box-default">
    <div class="box-body">

        <div class="form-group">
           <button class="btn btn-success pull-right next" type="button" id="btnSaveOrder">Save</button>
       </div>
   </div>
</div>

<div id="itemInfoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-blue">
                    <div class="widget-user-image" id="item-modal-image">
                        <img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="Item Avatar">
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username" id="item-modal-name"></h3>
                    <h5 class="widget-user-desc" id="item-modal-category"></h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li><a href="#">Stock On Hand <span class="pull-right" id="item-modal-stock-on-hand">31</span></a></li>
                        <li><a href="#">Weight <span class="pull-right" id="item-modal-weight">5</span></a></li>
                        <li><a href="#">Quantity/Pack <span class="pull-right" id="item-modal-quantity-pack">12</span></a></li>

                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $(".select2").select2();
    });
</script>
<script type="text/javascript" src="{{asset('/dist/js/pages/order/order-add.js')}}"></script>
<<<<<<< HEAD
=======
<script type="text/javascript" src="{{asset('public/dist/js/pages/order/order-add.js')}}"></script>
>>>>>>> 35f51e18b78218e73b7b0166df26b2164bba40bb
@endsection