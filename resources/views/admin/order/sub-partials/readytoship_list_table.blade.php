<div class="box box-success">
  <div class="box-body">
    <div class="table-responsive">
      <table id="orderList" class="table order-list-table" id="ready_to_ship_table" data-toolbar="#toolbar"
           data-search="true"
           data-show-refresh="true"
           data-show-toggle="true"
           data-show-columns="true"
           data-detail-view="true"
           data-detail-formatter="detailFormatter"
           data-show-pagination-switch="true"
         data-pagination="true"
        
          
           data-show-footer="false"
         
           data-url="{{url('order/ajax/ready-ship-order-list')}}"
        >

      </table>
    </div>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->