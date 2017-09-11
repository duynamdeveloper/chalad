<div id="paymentHistoryModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="width: 80%;">
      
      <div class="modal-body">
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
                            <td width="10%" class="text-center">{!! $payment->state_label !!}</td>
                          
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>


    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>