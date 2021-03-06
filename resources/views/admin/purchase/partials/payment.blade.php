<fieldset id="payment_field">


    <div class="box box-success">
        <div class="box-body text-center">
            <h3><button class="btn btn-success pull-right next ready_to_ship_btn" type="submit" id="1btnSaveAddress">Ready to Ship</button>
                Payment Details
                <button class="btn btn-success pull-left previous" type="submit" id="1btnSaveAddress">Back</button></h3>



        </div>
    </div>
    <!-- Payment Summary -->
<div class="order_summary_container">
    @include('admin.purchase.partials.order_summary')
    <!--End Payment Summary -->
</div>




    <div class="box box-success">
        <div class="col-md-12"><h5 class="text-info"><strong>Payment Summary</strong><button class="btn btn-success pull-right" data-toggle="modal" data-target="#addPaymentModal">Add Payment</button></h5>
        </div>
        <div class="box-body">

            <table class="table table-bordered" id="paymentTable">
                <thead>
                <tr class="text-center">
                    <th class="text-center">ID</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Method</th>
                    <th class="text-center">Attached</th>
                    <th class="text-center">Amount</th>
                    <th class="text-center" width="15%">Status</th>
                    <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($purchase->payments))
                    @foreach($purchase->payments as $payment)
                        <tr payment-id="{{$payment->id}}">
                            <td width="5%" class="text-center">{{$payment->id}}</td>
                            <td width="15%" class="text-center">{{$payment->payment_date }}</td>
                            <td width="10%" class="text-center">{{$payment->method }}</td>
                            <td width="10%" class="text-center"><a href="{{ url('public/uploads/paymentPic/'.$payment->file) }}">{!! substr($payment->file,1,4)!!}</a></td>
                            <td width="10%" class="text-center">{{$payment->amount}}</td>
                            <td width="10%" class="text-center"><div class="btn-group">
                                    <button type="button" class="btn btn-{{$payment->state_bootstrap_class}} stateBtn">{{ $payment->state_name }}</button>
                                    <button type="button" class="btn btn-{{$payment->state_bootstrap_class}} dropdown-toggle dropDownBtn" data-toggle="dropdown">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" class="label label-default pending_payment" payment-id="{{$payment->id}}">Pending</a></li>
                                        <li><a href="#" class="label label-success confirm_payment" payment-id="{{$payment->id}}">Confirm</a></li>
                                    </ul>
                                </div></td>
                            <td width="15%" class="text-center">
                                <button class="btn btn-xs btn-info edit_payment" title="edit" payment-id="{{$payment->id}}"><i class="glyphicon glyphicon-pencil"></i></button>

                                <button class="btn btn-xs btn-danger delete_payment" title="delete" payment-id="{{$payment->id}}"><i class="glyphicon glyphicon-trash"></i></button>
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