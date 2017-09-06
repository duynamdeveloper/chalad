<!--Select Product-->
<form class="form-horizontal" id="shipping_billing_form" method="post" action="{{url('/order/update')}}" >
<div class="box box-success">
    <div class="box-body">
        <div class="row">

                <input type="hidden" name="order_no" value="{{$order->order_no}}">
                <div class="col-md-6">
                    <h4 class="text-info"><strong>{{ trans('message.invoice.shipping_address') }}</strong></h4>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.form.name') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="shipping_name" id="shipping_name" value="{{ $order->shipping_name }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_street" name="shipping_street" value="{{ $order->shipping_street }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_city" name="shipping_city" value="{{ $order->shipping_city }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_state" name="shipping_state" value="{{ $order->shipping_state }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_zip_code" name="shipping_zip_code" value="{{ $order->shipping_zip_code }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                        <div class="col-sm-9">
                            <select class="form-control select2" name="shipping_country_id" id="shipping_country_id">
                                <option value="">{{ trans('message.form.select_one') }}</option>
                                @foreach ($countries as $data)

                                    <option value="{{$data->code}}" @if($data->code == $order->shipping_country_id) selected="true" @endif>{{$data->country}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">Phone:</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_zip_code" name="shipping_zip_code" value="{{ $order->phone }}" required>
                        </div>
                    </div>
                </div>

                <!--End Shippind Address Form-->
                <!--Billing Address-->
                <div id="different_billing_address_div" class="col-md-6">
                    <div class="form-title">
                        <h4 class="text-info text-left" style="font-weight: bold;">Billing Address</h4><span class="text-info" style="font-size: 18px;"><input type="checkbox" name="billing_address_the_same_as_shipping_address" id="cbxBillingEqualShipping"> Different Billing Address?</span>


                    </div>
                    <div style="display:none;">
                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.name') }}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_name"  id="billing_name" required value="{{ $order->billing_name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_street" id="billing_street" required value="{{ $order->billing_street }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_city"  id="billing_city" required value="{{ $order->billing_city }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_state"  id="billing_state" value="{{ $order->billing_state }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_zip_code" id="billing_zip_code" value="{{ $order->billing_zip_code }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                            <div class="col-sm-8">
                                <select class="form-control select2" name="billing_country_id" id="billing_country_id">
                                    <option value="">{{ trans('message.form.select_one') }}</option>
                                    @foreach ($countries as $data)

                                        <option value="{{$data->code}}" @if($data->code=== $order->billing_country_id) selected="true" @endif>{{$data->country}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="billing_country_id" id="hidden_billing_country_id" disabled>
                        </div>
                    </div>
                </div>

                <!--End Billing Address -->




        </div>

    </div>
</div>
</form>
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
                    @foreach($order->details as $detail)
                        <tr class="item-row" item-id="{{$detail->stock_id}}">
                            <td><img width="50px" height="50px" src="{{asset('/public/uploads/itemPic/'.$detail->item->item_image)}}"></td>
                            <td>{{$detail->item->description}}</td>

                            <td><input type="text" name="quantity" value="{{$detail->quantity}}" class="form-control text-center inp_qty"></td>
                            <td><input type="text" name="price" value="{{$detail->unit_price}}" class="form-control text-center inp_price"></td>
                            <td>
                                <input type="text" name="amount" value="{!! ($detail->unit_price)*($detail->quantity) !!}" class="form-control text-center" readonly><input type="hidden" name="item_weight" value="{{ $detail->item->weight }}">
                            </td>
                            <td>
                                <span class="glyphicon glyphicon-trash text-danger removebtn" item-id="{{$detail->stock_id}}" style="cursor:pointer; font-size:18px"></span>
                                <span class="glyphicon glyphicon-info-sign text-info infobtn" item-id="{{$detail->stock_id}}" style="cursor:pointer; font-size:18px"></span>

                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="static_rows">
                        <td colspan="5"><strong>Sub Total</strong></td>
                        <td colspan="2" id="subTotal" style="font-weight:bold" class="text-left"></td>
                    </tr>

                    <tr class="static_rows">
                        <td colspan="5"><strong>Shipping Method</strong></td>
                        <td>
                            <select name="shipping_method" class="form-control" id="sel_shipping_method">
                                <option>Select One</option>
                                <option value="EMS" @if($order->shipping_method == "EMS") selected @endif>EMS</option>
                                <option value="Registered"  @if($order->shipping_method == "Registered") selected @endif>Registered</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="static_rows">
                        <td colspan="5"><strong>Shipping Cost</strong></td>
                        <td>
                            <input class="form-control" id="shipping_cost" readonly value="{{$order->shipping_cost}}">
                        </td>
                    </tr>
                    <tr class="static_rows">
                        <td colspan="5"><strong>Discount Amount</strong></td>
                        <td>
                            <input class="form-control" id="discount_amount" type="number" name="discount_amount" value="{{$order->discount_amount}}">
                        </td>
                    </tr>
                    <tr class="static_rows">
                        <td colspan="5" ><strong>TAX</strong></td>
                        <td>
                            <select class="form-control" name="tax" id="sel_tax">
                                <option value="-1">Select One</option>
                                @foreach($tax_types as $tax_type)
                                    <option value="{{$tax_type->tax_rate}}" @if($order->item_tax == $tax_type->tax_rate) selected @endif>{{$tax_type->name}}</option>
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
                            <input class="form-control" id="grand_total" type="text" name="grand_total" value="0" readonly>
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
                <button class="btn btn-success pull-right btnSave" type="submit" id="btnSaveOrder">Save</button>
            </div>
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