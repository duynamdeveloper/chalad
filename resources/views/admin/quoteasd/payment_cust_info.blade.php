@foreach($data as $data)
<div class="form-group">
  <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.table.customer_name') }}</label>

  <div class="col-sm-8">
    <input type="text" class="form-control" value="{{$data->name}}" readonly>
  </div>
</div>

<div class="form-group">
  <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.table.total_amt') }}</label>

  <div class="col-sm-8">
    <input type="text" class="form-control" value="{{number_format($data->total,2)}}" readonly>
  </div>
</div>
<div class="form-group">
  <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.table.paid_amt') }}</label>

  <div class="col-sm-8">
    <input type="text" class="form-control" value="{{number_format($data->payment_made,2)}}" readonly>
  </div>
</div>
@endforeach