<h3>Payment Details</h3>

<div class="box box-success">
    <div class="box-body">

                    <div class="form-group">
							  <button class="btn btn-success pull-right" type="submit" id="btnSaveAddress">Ready to Ship</button>
							  <button class="btn btn-success pull-left" type="submit" id="btnSaveAddress">Back</button>
                    </div>
           </div>
		   </div>
<!-- Payment Summary -->
	<div class="box box-success">
                            <div class="box-body">
<div class="row">
                        <div class="col-md-4">
             <h5 class="text-info"><strong>Ship To</strong></h5>

             <div class="form-group">
              <p class="col-sm-12 text-left" for="inputEmail3">Name<br>
			  Street Address, City<br>State ZIPCODE<br>COUNTRY<br><br>Phone: 0988251927
			  </p>

            </div>



          </div>
		  <div class="col-md-4">

		  <h5 class="text-info"><strong>Bill To</strong></h5>

             <div class="form-group">
              <p class="col-sm-12 text-left" for="inputEmail3">Name<br>
			  Street Address, City<br>State ZIPCODE<br>COUNTRY<br><br>Phone: 0988251927
			  </p>

            </div>



          </div>

		   <div class="col-md-4">

		  <h4 class="text-info"><strong>Payment Due:</strong></h4>
		  <h3>1000 Baht</h3>
		   <button class="btn btn-info" data-toggle="modal" data-target="#addPaymentModal">Make New Payment</button>




          </div>

          <!--End Shippind Address Form-->




            </div>

</div>
</div>



<!--End Payment Summary -->

<div class="box box-success">
                            <div class="box-body">
<div class="row">
                        <div class="col-md-12">
             <h5 class="text-info"><strong>Order Summary</strong></h5>
                                <table class="table table-reponsive info" id="product_table" >
                                    <thead>
										<th></th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Price (B)</th>
                                        <th>Amount (B)</th>
                                    </thead>
                                    <tbody>
                                        @foreach($order->details as $detail)
                                            <tr class="item-row" item-id="{{$detail->stock_id}}">
											<td><img width="50px" height="50px" src="{{asset('/public/uploads/itemPic/'.$detail->item->item_image)}}"></td>
                                            <td>{{$detail->item->description}}</td>
                                            <td>{{$detail->quantity}}</td>
                                            <td>{{$detail->unit_price}}</td>
                                            <td>{!! ($detail->unit_price)*($detail->quantity) !!} </td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="static_rows">
                                        <td colspan="4"><strong>Sub Total</strong></td>
                                        <td colspan="2" id="subTotal"  class="text-left">1000</td>
                                    </tr>

                                        <tr class="static_rows">
                                        <td colspan="4"><strong>Shipping Cost</strong></td>
                                        <td class="text-left">
                                           {{$order->shipping_cost}}
                                        </td>
                                    </tr>
                                        <tr class="static_rows">
                                        <td colspan="4"><strong>Discount Amount</strong></td>
                                        <td  class="text-left">
                                            {{$order->discount_amount}}
                                        </td>
                                    </tr>

                                    <tr class="static_rows">
                                        <td colspan="4"><strong>Tax Amount</strong></td>
                                        <td class="text-left">
                                            0
                                        </td>
                                    </tr>
                                    <tr class="static_rows">
                                        <td colspan="4"><strong>Grand Total</strong></td>
                                        <td class="text-left">
                                            1000
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>



          </div>


          <!--End Shippind Address Form-->




            </div>

</div>
</div>



<div class="box box-success">
    <div class="col-md-12"><h5 class="text-info"><strong>Payment Summary</strong></h5>
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
            @if(!empty($order->payments))
                @foreach($order->payments as $payment)
                    <tr payment-id="{{$payment->id}}">
                        <td width="5%" class="text-center">{{$payment->id}}</td>
                        <td width="15%" class="text-center">{{$payment->payment_date }}</td>
                        <td width="10%" class="text-center">{{$payment->method }}</td>
                        <td width="10%" class="text-center"><a href="{{ url('public/uploads/paymentPic/'.$payment->file) }}">{!! substr($payment->file,1,4)!!}</a></td>
                        <td width="10%" class="text-center">{{$payment->amount}}</td>
                        <td width="10%" class="text-center"><div class="btn-group" id="state-btn-group">
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
							  <button class="btn btn-success pull-right" type="submit" id="btnSaveAddress">Ready to Ship</button>
							  <button class="btn btn-success pull-left" type="submit" id="btnSaveAddress">Back</button>
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
                <h4  class="text-left text-info">Add Payment On: {{ trans('message.table.order_no')}} #{{$order->reference}}</h4>
            </div>
            <div class="modal-body">
                <form role="form" class="form-horizontal" method="post" action="{{ url('order/addpayment') }}" enctype="multipart/form-data">
                    <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                    <input type="hidden" name="order_no" value="{{ $order->order_no }}" id="saleOrderNo">
                    <input type="hidden" name="payment_debtorNo" value="{{ $order->debtor_no }}">

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
                <h4  class="text-left text-info">Add Payment On: {{ trans('message.table.order_no')}} #{{$order->reference}}</h4>
            </div>
            <div class="modal-body">
                <form role="form" class="form-horizontal" method="post" action="{{ url('order/editpayment') }}" enctype="multipart/form-data">
                    <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                    <input type="hidden" name="order_no" value="{{ $order->order_no }}" id="saleOrderNo">
                    <input type="hidden" name="payment_debtorNo" value="{{ $order->debtor_no }}">
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
