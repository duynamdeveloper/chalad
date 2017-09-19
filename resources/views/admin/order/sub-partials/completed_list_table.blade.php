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
        
          
           data-show-footer="false"
         
           data-url="{{url('order/ajax/pending-order-list')}}"
        >
      <thead>
        <th data-field="state" data-checkbox="true" align="center" valign="middle"></th>
         <th data-field="order_no" data-align="center" data-valign="middle" sortable="true" data-formatter="orderIdFormatter">Order No #</th>
         <th data-field="ord_date" data-align="right" data-valign="middle" sortable="true">Order Date</th>
         <th data-field="customer" data-align="left" data-valign="middle" sortable="true" data-formatter="customerNameFormatter">Customer</th>
         <th data-field="order_quantity" data-align="right" data-valign="middle" sortable="true">Items #</th>
         
         <th data-field="customer" data-align="left" data-valign="middle" sortable="true" data-formatter="channelFormatter">Channel</th>
         <th data-field="label_state" data-align="center" data-valign="middle" sortable="true">Status</th>
         <th data-align="center" data-valign="middle" sortable="false" data-formatter="operateFormatter">Action</th>
      </thead>
      </table>
    </div>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->