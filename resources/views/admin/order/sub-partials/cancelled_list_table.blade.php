<div class="box box-success">
  <div class="box-body">
    <div class="table-responsive">
      <table id="orderList" class="table order-list-table" data-toolbar="#toolbar"
           data-search="true"
           data-show-refresh="true"
           data-show-toggle="true"
           data-show-columns="true"
           data-detail-view="true"
           data-detail-formatter="detailFormatter"
           data-show-pagination-switch="true"
         data-pagination="true"
        
          
           data-show-footer="false"
         
           data-url="{{url('order/ajax/cancelled-order-list')}}"
        >

      </table>
    </div>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->