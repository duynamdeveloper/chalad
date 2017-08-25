@extends('layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">

    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-9">
           <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.shipping_cost') }}</div>
          </div> 
          <div class="col-md-3">
            @if(!empty(Session::get('order_add')))
              <a href="{{ url('shipping/add') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.form.add_new_shipping_cost') }}</a>
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
                    
                    <li>
                      <a href="{{url("order/filtering")}}" >{{ trans('message.extra_text.filter') }}</a>
                    </li>

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
                   
                    <th>{{ trans('message.invoice.method') }}</th>
                    <th align="center">{{ trans('message.invoice.from_weight') }}</th>
                    <th align="right">{{ trans('message.invoice.to_weight') }}</th>
                    <th align="right">{{ trans('message.invoice.cost') }}</th>
                   <th width="5%">{{ trans('message.table.action') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($shippingData as $data)
                 
                  <tr>
                    <td>{{$data->method }}</td>
                    <td align="right">{{ $data->weight_from }}</td>
                    <td align="right">{{ $data->weight_to }}</td>
                    <td align="right">{{ $data->cost }}</td>
                    <td>
                    
                    @if(!empty(Session::get('order_edit')))
                        <a  title="Edit" class="btn btn-xs btn-primary" href='{{ url("shipping_order/edit/$data->id") }}'><span class="fa fa-edit"></span></a> &nbsp;
                        <a  title="Delete" class="btn btn-xs btn-primary" href='{{ url("shipping_order/delete/$data->id") }}'><span class="fa fa-trash"></span></a> &nbsp;

                    @endif
                   
                    </td>
                  </tr>
                 
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

  $(function () {
    $("#orderList").DataTable({
      "order": [],
      "columnDefs": [ {
        "targets": 4,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection