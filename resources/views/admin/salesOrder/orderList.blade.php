@extends('layouts.app')
@section('content')

<!-- Main content -->
<section class="content">

  <div class="box box-default">
    <div class="box-body">
      <div class="row">
        <div class="col-md-10">
         <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.sales_orders') }}</div>
       </div> 
       <div class="col-md-2">
        @if(!empty(Session::get('order_add')))
        <a href="{{ url('order/add') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.form.add_new_order') }}</a>
        @endif
      </div>
    </div>
  </div>
</div>
<div class="box">
  <div class="box-body">
    <ul class="nav nav-tabs cus" role="tablist">

      <li  class="active">
        <a href='{{url("order/list")}}' >{{ trans('message.extra_text.all') }}</a>
      </li>
{{-- 
      <li>
        <a href="{{url("order/filtering")}}" >{{ trans('message.extra_text.filter') }}</a>
      </li> --}}

    </ul>
  </div>
</div>
<!--Filtering Box End-->


<div class="box">
  <div class="box-body">
    <div class="table-responsive">
      <table id="orderList" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th><input type="checkbox"></th>
            <th>{{ trans('message.table.order') }} #</th>
            <th>{{ trans('message.table.ord_date') }}</th>
            <th>{{ trans('message.table.customer_name') }}</th>

            <th>{{ trans('message.invoice.packed') }}</th>
            <th>{{ trans('message.table.shipped') }}</th>
            <th>{{ trans('message.invoice.paid') }}</th>
            <th>{{ trans('message.table.total') }}</th>

            <th>{{ trans('message.table.shipped_status') }}</th>
          
            <th width="5%">Status</th>
            <th width="5%">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($salesData as $data)
          @if($data->order_qty>0)
          <tr>
          <td><input type="checkbox"></td>
            <td><a href="{{URL::to('/')}}/order/view-order-details/{{$data->order_no}}">{{$data->reference }}</a></td>
            <td>{{formatDate($data->ord_date)}}</td>
            <td><a href="{{URL::to('/')}}/customer/edit/{{$data->debtor_no}}">{{ $data->name }}</a></td>





            @if( $data->packed_qty == 0 || $data->packed_qty==null)

            <td>0/{{ $data->order_qty }}</span></td>
            @else
            <td>{{$data->packed_qty}}/{{ $data->order_qty }}</td>

            @endif
            @if( $data->shipped_qty == 0 || $data->shipped_qty==null)

            <td>0/{{ $data->order_qty }}</span></td>
            @else
            <td>{{$data->shipped_qty}}/{{ $data->order_qty }}</td>

            @endif

            @if( $data->paid_amount == 0 || $data->paid_amount==null)
            <td>0/{{$data->total }}</td>
            @else
            <td>{{ $data->paid_amount}}/{{$data->total }}</td>

            @endif


            <td>{{ Session::get('currency_symbol').number_format($data->total,2,'.',',') }}</td>
            <td>
              @if($data->packed_qty>0)
              <span class="label label-info">Ready to ship</span>
              @elseif($data->shipped_qty!==null && $data->order_qty!==null && abs($data->order_qty-$data->shipped_qty)==0)
              <span class="label label-success">Shipped</span>
              @else
              <span class="label label-default">Pending</span>
              
              @endif
            </td>
            <td>
            @if($data->order_status==0)
            <span class="label label-warning">Canceled</span>
            
            @elseif($data->order_status==1)
            <span class="label label-success">Confirmed</span>
            
            @else
            <span class="label label-default">Pending</span>
            @endif
            </td>
            <td>

              @if(!empty(Session::get('order_edit')))
              <a  title="Edit" class="btn btn-xs btn-primary" href='{{ url("order/edit/$data->order_no") }}'><span class="fa fa-edit"></span></a> &nbsp;

              @endif
              @if(!empty(Session::get('order_delete')))
              <form method="POST" action="{{ url("order/delete/$data->order_no") }}" accept-charset="UTF-8" style="display:inline">
                {!! csrf_field() !!}

                <button title="delete" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_order') }}" data-message="{{ trans('message.invoice.delete_order_confirm') }}">
                  <i class="glyphicon glyphicon-trash"></i> 
                </button>
              </form>
              @endif
            </td>
          </tr>
          @endif
          @endforeach
        </tfoot>
      </table>
    </div>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->

</section>

@include('layouts.includes.message_boxes')

@endsection

@section('js')
<script type="text/javascript">
  $('.select2').select2({});
  $('#from').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: '{{Session::get('date_format_type')}}'
  });

  $('#to').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: '{{Session::get('date_format_type')}}'
  });

  

</script>
@endsection