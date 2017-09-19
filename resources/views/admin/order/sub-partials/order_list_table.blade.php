<div class="box box-success">
  <div class="box-body">
    <div class="table-responsive">
      <table class="table order-list-table" data-toolbar="#toolbar"
           data-search="true"
           data-show-refresh="true"
           data-show-toggle="true"
           data-show-columns="true"
           data-detail-view="true"
           data-detail-formatter="detailFormatter"
           data-show-pagination-switch="true"
         data-pagination="true"
        
          
<<<<<<< HEAD
            <th width="5%">Status</th>
            <th width="5%">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
          @if(!empty($order->details))
          <tr>
          <td class="text-center"><input type="checkbox"></td>
		  <td class="text-center"><i class="fa fa-plus toggleOrderSummary" order-id="{{$order->order_no}}"></i></td>
		  <td>{{formatDate($order->ord_date)}}</td>
            <td><a href="{{URL::to('/')}}/order/view-order-details/{{$order->order_no}}">#{{$order->order_no }}</a></td>
            
            <td><a href="{{URL::to('/')}}/customer/edit/{{$order->debtor_no}}">{{ $order->customer->name }}</a></td>
<td>{{$order->order_quantity}}</td>
<td>{{$order->total }}</td>
<td>{{$order->customer->channel_name}}</td>
            <td>
              {!! $order->label_state !!}
            </td>
           
            <td style="width:7%;">

              @if(!empty(Session::get('order_edit')))
              <a  title="Edit" class="btn btn-xs btn-primary" href='{{ url("order/edit/$order->order_no") }}'><span class="fa fa-edit"></span></a> &nbsp;

              @endif
              @if(!empty(Session::get('order_delete')))
              <form method="POST" action="{{ url("order/delete/$order->order_no") }}" accept-charset="UTF-8" style="display:inline">
                {!! csrf_field() !!}

                <button title="delete" class="btn btn-xs btn-danger" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_order') }}" data-message="{{ trans('message.invoice.delete_order_confirm') }}">
                  <i class="glyphicon glyphicon-trash"></i> 
                </button>
              </form>
              @endif
            </td>
          </tr>
          <tr class="collapse out" order-id="{{$order->order_no}}">
          <td></td><td colspan="9" id="cellOrderSummary">
            @include('admin.order.sub-partials.order_summary  ')
          </td></tr>
          @endif
          @endforeach
        </tbody>
=======
           data-show-footer="false"
         
           data-url="{{url('order/ajax/pending-order-list')}}"
        >
      <thead>
        <th data-field="state" data-checkbox="true" align="center" valign="middle"></th>
         <th data-field="order_no" data-align="center" data-valign="middle" sortable="true" data-formatter="orderIdFormatter">Order No #</th>
         <th data-field="ord_date" data-align="right" data-valign="middle" sortable="true">Order Date</th>
         <th data-field="customer" data-align="left" data-valign="middle" sortable="true" data-formatter="customerNameFormatter">Customer</th>
         <th data-field="order_quantity" data-align="right" data-valign="middle" sortable="true">Items #</th>
         <th data-field="payment_due" data-align="right" data-valign="middle" sortable="true">Payment Due</th>
         <th data-field="customer" data-align="left" data-valign="middle" sortable="true" data-formatter="channelFormatter">Channel</th>
         <th data-field="label_state" data-align="center" data-valign="middle" sortable="true">Status</th>
         <th data-align="center" data-valign="middle" sortable="false" data-formatter="operateFormatter">Action</th>
      </thead>
>>>>>>> 35f51e18b78218e73b7b0166df26b2164bba40bb
      </table>
    </div>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->