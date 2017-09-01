
                            <div class="box box-success">
                                <div class="box-header text-center"><h4>PAYMENT</h4></div>
                                <div class="box-body">
                                   <button class="btn btn-info" data-toggle="modal" data-target="#addPaymentModal">Add New Payment</button>
                                   <table class="table table-bordered" id="paymentTable">
          <thead>
            <tr class="text-center">
            <th class="text-center"><input type="checkbox" id="cb-check-all" /></th>
              <th class="text-center">ID</th>
              <th class="text-center">Date</th>
              <th class="text-center">Method</th>
              <th class="text-center">Attached</th>
              <th class="text-center">Amount</th>
              <th class="text-center">Status</th>
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
           @if(!empty($order->payments))
           @foreach($order->payments as $payment)
           <tr payment-id="{{$payment->id}}">
           <td width="3%" class="text-center"><input type="checkbox" value="{{$payment->id}}" class="cb-payment" /></td>
            <td width="5%" class="text-center">{{$payment->id}}</td>
            <td width="15%" class="text-center">{{$payment->payment_date }}</td>
            <td width="10%" class="text-center">{{$payment->method }}</td>
            <td width="10%" class="text-center"><a href="{{ url('public/uploads/paymentPic/'.$payment->file) }}">{!! substr($payment->file,1,4)!!}</a></td>
            <td width="10%" class="text-center">{{$payment->amount}}</td>
            <td width="10%" class="text-center">{!! $payment->state_label  !!}</td>
            <td width="15%" class="text-center">
                <button class="btn btn-xs btn-info edit_payment" title="edit" payment-id="{{$payment->id}}"><i class="glyphicon glyphicon-pencil"></i></button>
                <button class="btn btn-xs btn-default pending_payment" title="pending" payment-id="{{$payment->id}}"><i class="glyphicon glyphicon-off"></i></button>
                <button class="btn btn-xs btn-success confirm_payment" title="confirm" payment-id="{{$payment->id}}"><i class="glyphicon glyphicon-check"></i></button>
                <button class="btn btn-xs btn-danger delete_payment" title="delete" payment-id="{{$payment->id}}"><i class="glyphicon glyphicon-trash"></i></button>
            </td>
          </tr>
          @endforeach
          @endif
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5"><button class="btn btn-danger" id="deleteMultiPayment"><i class="glyphicon glyphicon-trash"></i> Delete</button>
            <button class="btn btn-default" id="pendingMultiPayment"><i class="glyphicon glyphicon-trash"></i> Pending</button>
            <button class="btn btn-success" id="confirmMultiPayment"><i class="glyphicon glyphicon-check"></i> Confirm</button></td>
        </tr>
            
        </tfoot>
      </table>
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
