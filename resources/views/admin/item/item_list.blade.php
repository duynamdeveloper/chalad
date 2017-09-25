@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

      <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-8">
             <div class="top-bar-title padding-bottom">{{ trans('message.table.item') }}</div>
            </div> 
             @if (!empty(Session::get('item_add')))
            <div class="col-md-2 top-left-btn">
                <a href="{{ URL::to('itemimport') }}" class="btn btn-block btn-default btn-flat btn-border-purple"><span class="fa fa-upload"> &nbsp;</span>{{ trans('message.extra_text.import_new_item') }}</a>
            </div>

            <div class="col-md-2 top-right-btn">
                <a href="{{ url('create-item/item') }}" class="btn btn-block btn-default btn-flat btn-border-orange"><span class="fa fa-plus"> &nbsp;</span>{{ trans('message.extra_text.add_new_item') }}</a>
            </div>
            @endif
          </div>
        </div>
      </div>

      <!-- Top Box-->
      <div class="box">
        <div class="box-body">
          <div class="col-md-2 col-xs-6 border-right text-center">
              <h3 class="bold">{{count($itemData)}}</h3>
              <span class="text-info bold">{{ trans('message.table.item') }}</span>
          </div>
          <div class="col-md-2 col-xs-6 border-right text-center">
              <h3 class="bold">{{!empty($itemQuantity->total_item) ? $itemQuantity->total_item : 0 }}</h3>
              <span class="text-info bold">{{ trans('message.extra_text.quantity') }}</span>
          </div>


          <div class="col-md-3 col-xs-6 border-right text-center">
              <h3 class="bold">{{ Session::get('currency_symbol').number_format($costValueQtyOnHand,2,'.',',')}}</h3>
              <span class="text-info">{{ trans('message.report.on_hand_cost_value') }}</span>
          </div>
          <div class="col-md-3 col-xs-6 border-right text-center">
              <h3 class="bold">{{ Session::get('currency_symbol').number_format($retailValueOnHand ,2,'.',',')}}</h3>
              <span class="text-info">{{ trans('message.report.on_hand_retail_value') }} </span>
          </div>
          <div class="col-md-2 col-xs-6 text-center">
              <h3 class="bold">
                @if($profitValueOnHand<0)
                -{{Session::get('currency_symbol').number_format(abs($profitValueOnHand),2,'.',',')}}
                @else
                 {{Session::get('currency_symbol').number_format(abs($profitValueOnHand),2,'.',',')}}
                @endif
              </h3>
              <span class="text-info">{{ trans('message.report.on_hand_profit_value') }}</span>
          </div>


        </div>
        <br>
      </div><!--Top Box End-->

      <!-- Default box -->
      <div class="box">
      
            <div class="box-header">
              <a href="{{ URL::to('itemdownloadcsv/csv') }}"><button class="btn btn-default btn-flat btn-border-info"><span class="fa fa-download"> &nbsp;</span>{{ trans('message.table.download_csv') }}</button></a>
            </div>
  
            <!-- /.box-header -->
            <div class="box-body">
              <table id="itemList" class="table table-bordered table-striped" data-toolbar="#toolbar"
           data-search="true"
           data-show-refresh="true"
           data-show-toggle="true"
           data-show-columns="true"
         
          
         data-pagination="true"
        
          
           data-show-footer="false"
         
           data-url="{{url('item/ajax/list')}}">
                <thead>
                <th data-field="state" data-checkbox="true" align="center" valign="middle"></th>
         <th data-field="id" data-align="center" data-valign="middle" sortable="true">ID</th>
         <th data-field="item_type" data-align="center" data-valign="middle" sortable="true">Type</th>
         <th data-field="name" data-align="left" data-valign="middle" sortable="true">Name</th>
         <th data-field="item_image" data-align="left" data-valign="middle" sortable="true" data-formatter="itemImageFormatter">Image</th>
         <th data-field="category" data-align="left" data-valign="middle" sortable="true" data-formatter="categoryFormatter">Category </th>
         
         <th data-field="stock_on_hand" data-align="right" data-valign="middle" sortable="true">On Hand</th>
         <th data-field="price" data-align="right" data-valign="middle" sortable="true">Price</th>
         <th data-field="linked_products" data-align="left" data-valign="middle" sortable="false" data-formatter="linkedProductFormatter">Linked Products</th>
         <th data-field="state_label" data-align="center" data-valign="middle" sortable="true">Status</th>
         <th data-align="center" data-valign="middle" sortable="false" data-formatter="operateFormatter">Action</th>
                </thead>
       
              </table>
            </div>
            <!-- /.box-body -->
          </div>
      <!-- /.box -->

    </section>

@include('layouts.includes.message_boxes')

@endsection

@section('js')
<script src="{{asset('public/plugins/bootstrap-table/bootstrap-table.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('public/plugins/bootstrap-table/bootstrap-table.css')}}">
    <script type="text/javascript">

 
    
$(document).ready(function(){
  $("#itemList").bootstrapTable();
});
function itemImageFormatter(value, index, row){
      return ['<img src="' + SITE_URL + '/public/uploads/itemPic/' + value + '" width="80px" height="80px">'];
    }
function categoryFormatter(value, index, row){
  return value.description;
}
function operateFormatter(value, row, index) {
    return ['<a href="' + SITE_URL + '/item/edit/' + row.order_no + '"><i class="glyphicon glyphicon-edit"></i></a>'];
}
function linkedProductFormatter(value, row, index){
    var product_list = "";
    
    $.each(value, function(i,product){
      if(value !== null && value.length > 0){
       
      
        product_list += '<span class="text-primary"><strong>'+product.item.name+'</strong></span>' +' : '+'<small class="label bg-green">'+product.quantity+'</small>'   + '<br>';
      }
      
    })
    console.log(product_list);
    if(product_list.length == 0){
      return " - ";
    }
    return product_list;
}
    </script>
@endsection