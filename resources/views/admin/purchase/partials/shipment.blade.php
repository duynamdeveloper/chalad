<fieldset id="shipment_field">


    <div class="box box-success">
        <div class="box-body text-center">
            <h3>
               Shipment
                <button class="btn btn-success pull-left previous" type="submit" id="1btnSaveAddress">Back</button></h3>



        </div>
    </div>
    <!-- Payment Summary -->
<div class="order_summary_container">
    @include('admin.purchase.partials.order_summary')
    <!--End Payment Summary -->
</div>




    <div class="box box-success">
        <div class="col-md-12"><h5 class="text-info"><strong>Shipped Orders</strong></h5>
        </div>
        <div class="box-body">
        <div class="form-group">

            <div class="col-md-3">Add new shipment :</div>
            <div class="col-md-4">

                <select class="form-control select2" id="sel_shipment_product">
                      <option value="-1">Select a product</option>
                    @foreach($purchase->details as $detail)
                      
                        <option value="{{ $detail->stock_id }}">{{ $detail->item->name }}</option>
                    @endforeach
                </select>

            </div>

        </div>
            <table class="table table-bordered" id="shipmentTable">
                <thead>
                <tr class="text-center">
                    <th class="text-center"></th>
                    <th class="text-center">Stock Id</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Tracking</th>
                    <th class="text-center">Estimated Date Arrival</th>
                    <th class="text-center" width="15%">Status</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($purchase->shipments))
                    @foreach($purchase->shipments as $shipment)
                        <tr shipment-id="{{$shipment->id}}">
                            <td width="15%" class="text-center"><img height="100px" width="100px" src="{{asset('public/uploads/itemPic'.$shipment->item->item_image)}}"></td>
                            <td>{{$shipment->stock_id}}</td>
                            <td width="5%" class="text-center">{{$shipment->item->name }}</td>
                            <td width="10%" class="text-center"><input type="text" name="inp_qty" class="inp_qty form-control" value="{{$shipment->quantity }}"></td>
                         
                            <td width="10%" class="text-center"><input type="text" name="tracking" class="inp_tracking form-control" value="{{$shipment->tracking}}"></td>
                            <td width="20%" class="text-center"><input name="date_arrival" class="datetime date_arrival form-control text-center" value="{{$shipment->date_arrival}}"></td>
                            <td width="5%" class="text-center">{!! $shipment->state_label !!}</td>
                            <td width="15%" class="text-center">
                               <span class="glyphicon glyphicon-floppy-disk icon-control save-shipment text-primary"></span><span class="glyphicon glyphicon-check mark-shipped icon-control text-success"></span><span class="glyphicon glyphicon-remove icon-control remove-shipment text-danger"></span>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>


    </div>
    <div class="box box-success">
        <div class="box-body">

            <div class="form-group">
                <button class="btn btn-success pull-right next ready_to_ship_btn" type="button">Ready to Ship</button>
                <button class="btn btn-success pull-left previous" type="button">Back</button>
            </div>
        </div>
    </div>


    <!--Add Payment Modal-->

    <div class="modal fade" id="addPaymentModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4  class="text-left text-info">Add Payment On: {{ trans('message.table.order_no')}} #{{$purchase->order_no}}</h4>
                </div>
                <div class="modal-body">
                    <form role="form" class="form-horizontal" method="post" action="{{ url('purchase/addpayment') }}" enctype="multipart/form-data">
                        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                        <input type="hidden" name="order_no" value="{{ $purchase->order_no }}" id="saleOrderNo">
                        <input type="hidden" name="payment_supplier_id" value="{{ $purchase->supplier_id }}">

                        <div class="form-group">
                            <label class="control-label col-sm-3">Payment Type:</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="payment_type">
                                    <option value="">Select Payment Type</option>
                                    <option value="cash">Cash</option>
                                    <option value="bank">Bank</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Amount:</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="payment_amount" placeholder="amount" required="">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Paid On:</label>
                            <div class="col-sm-8">
                                <input name="payment_date" class="form-control" placeholder="" type="text" required="">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">Picture</label>
                            <div class="col-sm-8">
                                <input class="form-control input-file-field" name="payment_image" type="file">
                            </div>
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default btn-success pull-right" id="submitPayment">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  Edit Payment Modal  --}}

    <div class="modal fade" id="editPaymentModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4  class="text-left text-info">Edit Payment On: {{ trans('message.table.order_no')}} #{{$purchase->order_no}}</h4>
                </div>
                <div class="modal-body">
                    <form role="form" class="form-horizontal" method="post" action="{{ url('purchase/editpayment') }}" enctype="multipart/form-data">
                        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                        <input type="hidden" name="order_no" value="{{ $purchase->order_no }}" id="saleOrderNo">
                        <input type="hidden" name="payment_supplier_id" value="{{ $purchase->supplier_id}}">
                        <input type="hidden" name="payment_id" id="inp_payment_id">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Payment Type:</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" id="payment_type_id" name="payment_type">
                                    <option value="">Select Payment Type</option>
                                    <option value="cash">Cash</option>
                                    <option value="bank">Bank</option>
                                </select>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Amount:</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="payment_amount" placeholder="amount" id="payment_amount" required="">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Paid On:</label>
                            <div class="col-sm-8">
                                <input name="payment_date" class="form-control" id="payment_date" placeholder="" type="text" required="">

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="inputEmail3">Picture</label>
                            <div class="col-sm-8">
                                <input class="form-control input-file-field" name="payment_image" type="file">
                            </div>
                        </div>



                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default btn-success pull-right" id="submitPayment">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</fieldset>