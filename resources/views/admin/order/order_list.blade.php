@extends('layouts.app')
@section('content')

<!-- Main content -->
<section class="content container">

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
        <a href='#pending_tab' data-toggle="tab">Pending ({!! count($pending_orders) !!})</a>
      </li>
	  <li>
        <a href='#ready_to_ship_tab' data-toggle="tab">Ready to Ship({!! count($ready_to_ship_orders) !!})</a>
      </li>
	  <li>
        <a href='#shipped_tab' data-toggle="tab">Shipped ({!! count($shipped_orders) !!})</a>
      </li>
	  <!--<li>
        <a href='#completed_tab' data-toggle="tab">Complete ({!! count($completed_orders) !!})</a>
      </li>-->
	  <li>
        <a href='#cancelled_tab' data-toggle="tab">Cancelled ({!! count($cancelled_orders) !!})</a>
      </li>
{{-- 
      <li>
        <a href="{{url("order/filtering")}}" >{{ trans('message.extra_text.filter') }}</a>
      </li> --}}

    </ul>
    <div class="tab-content">
  <div id="pending_tab" class="tab-pane fade in active">
    @include('admin.order.sub-partials.order_list_table')
  </div>
  <div id="ready_to_ship_tab" class="tab-pane fade">
    @include('admin.order.sub-partials.readytoship_list_table')
  </div>
  <div id="shipped_tab" class="tab-pane fade">
     @include('admin.order.sub-partials.shipped_list_table')
  </div>
  <div id="completed_tab" class="tab-pane fade">
   @include('admin.order.sub-partials.completed_list_table')
  </div>
  <div id="cancelled_tab" class="tab-pane fade">
     @include('admin.order.sub-partials.cancelled_list_table')
  </div>
</div>
  </div>
</div>
<!--Filtering Box End-->




</section>

@include('layouts.includes.message_boxes')

@endsection

@section('js')
<script src="{{asset('public/plugins/bootstrap-table/bootstrap-table.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/bootstrap-table/bootstrap-table.css')}}">
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
<script src="{{asset('public/dist/js/pages/order/order-list.js')}}"></script>

@endsection