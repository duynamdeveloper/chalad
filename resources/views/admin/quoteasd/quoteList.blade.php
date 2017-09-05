@extends('layouts.app')
@section('content')

    <!-- Main content -->
    <section class="content">

    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-10">
           <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.quote_orders') }}</div>
          </div> 
          <div class="col-md-2">
            @if(!empty(Session::get('order_add')))
              <a href="{{ url('quote/add') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.form.add_new_quote') }}</a>
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
                    <th>{{ trans('message.table.quote') }} #</th>
                    <th>{{ trans('message.table.customer_name') }}</th>
                    <th>{{ trans('message.extra_text.phone') }}</th>
                    <th>{{ trans('message.form.channel_id') }}</th>
                    <th>{{ trans('message.form.channel') }}</th>
                   
                    <th>{{ trans('message.table.total') }}</th>
                    <th>{{ trans('message.table.quote_date') }}</th>
                    <th width="5%">{{ trans('message.table.action') }}</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($salesData as $data)
                 
                  <tr>
                    <td><a href='{{ url("quote/edit/$data->id") }}'>{{$data->id }}</a></td>
                    <td>{{$data->name }}</td>
                    <td>{{$data->phone }}</td>
                    <td>{{$data->channel_id }}</td>
                    <td>{{$data->channel }}</td>
                    
                    <td>{{$data->total }}</td>
                    <td>{{$data->create_time }}</td>
                    <td>
                    
                    @if(!empty(Session::get('order_edit')))
                        <a  title="Edit" class="btn btn-xs btn-primary" href='{{ url("quote/edit/$data->id") }}'><span class="fa fa-edit"></span></a> &nbsp;

                    @endif
                    @if(!empty(Session::get('order_delete')))
                        <form method="POST" action="{{ url("quote/delete/$data->id") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                            
                            <button title="delete" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_quote') }}" data-message="{{ trans('message.invoice.delete_quote_confirm') }}">
                                <i class="glyphicon glyphicon-trash"></i> 
                            </button>
                        </form>
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
        "targets": 7,
        "orderable": false
        } ],

        "language": '{{Session::get('dflt_lang')}}',
        "pageLength": '{{Session::get('row_per_page')}}'
    });
    
  });

    </script>
@endsection