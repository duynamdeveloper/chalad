@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Top Box-->
      <div class="box">
        <div class="box-body">
          <strong>
           {{ trans('message.table.item_info') }}
          </strong>
        </div>
      </div><!--Top Box End-->
      <!-- Default box -->
            <div class="box">
            
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom" id="tabs">
            <ul class="nav nav-tabs">
              <li class="<?= ($tab=='details') ? 'active' :'disabled disabledTab' ?>"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Details</a></li>
              <li class="<?= ($tab=='specification') ? 'active' :'disabled disabledTab' ?>"><a href="#tab_2" data-toggle="tab" aria-expanded="false">Specifications</a></li>
              <li class="<?= ($tab=='transaction') ? 'active' :'disabled disabledTab' ?>"><a href="#tab_3" data-toggle="tab" aria-expanded="true">Transactions</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane <?= ($tab=='details') ? 'active' :'' ?>" id="tab_1">
                <div class="row">
                <div class="col-md-6">
                  <h4 class="text-info text-center">{{ trans('message.table.item_info') }}</h4>
                <form action="{{ url('save-item') }}" method="post" id="itemAddForm" class="form-horizontal" enctype="multipart/form-data">
                  <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                  <div class="box-body">
                  <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Type</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="item_type">
                        @foreach($item_types as $item_type)
                          <option value="{{$item_type->id}}">{{$item_type->type_name}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Product Code</label>
                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.item_id') }}" class="form-control" name="stock_id" value="{{old('stock_id')}}" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.item_name') }}</label>

                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.item_name') }}" class="form-control valdation_check" name="description" value="{{old('description')}}" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.category') }}</label>
                      <div class="col-sm-9">
                        <select class="form-control select2" name="category_id" id="cat">
                       
                        @foreach ($categoryData as $data)
                          <option value="{{$data->category_id}}" data='{{$unit_name["$data->dflt_units"]}}' >{{$data->description}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>

            

                   <!-- <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.item_des') }}</label>
                      <div class="col-sm-9">
                        <textarea placeholder="{{ trans('message.form.item_des') }} ..." rows="3" class="form-control" name="long_description">{{old('long_description')}}</textarea>
                      </div>
                    </div>-->
                    

                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Price</label>
                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.weight') }}" class="form-control" name="price" value="{{old('price')}}" required>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.special_price') }}</label>
                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.special_price') }}" class="form-control" name="special_price" value="{{old('special_price')}}" required>
                      </div>
                    </div>
             
                         
                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Weight</label>

                      <div class="col-sm-9">
                        <input type="text" placeholder="weight" class="form-control" name="weight" value="{{old('weight')}}">
                      
                      </div>
                    </div>

                      <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Pieces/Pack</label>

                      <div class="col-sm-9">
                        <input type="text" placeholder="Pieces/Pack" class="form-control" name="qty_per_pack" value="{{old('qty_per_pack')}}">
                      
                      </div>
                    </div>
                      <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Cost Price</label>

                      <div class="col-sm-9">
                        <input type="text" placeholder="Cost Price" class="form-control" name="cost_price" value="{{old('cost_price')}}">
                        <span id="price" style="color: red"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.picture') }}</label>
                      <div class="col-sm-9">
                        <input type="file" class="form-control input-file-field" name="item_image">
                      </div>
                    </div>
                     <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">Status</label>
                      <div class="col-sm-9">
                        <select class="form-control" name="status">
                          <option value="0">Active</option>
                           <option value="1">Inactive</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <a href="{{ url('item') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                    <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                  </div>
                  <!-- /.box-footer -->
                </form>
              </div>
              </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane <?= ($tab=='specification') ? 'active' :'' ?>" id="tab_2">

                <div class="row">
                <div class="col-md-6">
                  <h4 class="text-info text-center">Specifications</h4>
                <form action="{{ url('save-sale-price') }}" method="post" id="salesInfoForm" class="form-horizontal">
                  <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                  <input type="hidden" value="<?= isset($stock_id) ? $stock_id : ''?>" name="stock_id" id="stock_id">
                  <input type="hidden" value="USD" name="curr_abrev" id="curr_abrev">
                  <div class="box-body">
                
                   
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Weight</label>

                      <div class="col-sm-9">
                        <input type="text" placeholder="weight" class="form-control" name="weight" value="{{old('weight')}}">
                      
                      </div>
                    </div>

                      <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Pieces/Pack</label>

                      <div class="col-sm-9">
                        <input type="text" placeholder="Pieces/Pack" class="form-control" name="qty_per_pack" value="{{old('qty_per_pack')}}">
                      
                      </div>
                    </div>
                      <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Cost Price</label>

                      <div class="col-sm-9">
                        <input type="text" placeholder="Cost Price" class="form-control" name="cost_price" value="{{old('cost_price')}}">
                        <span id="price" style="color: red"></span>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <a href="{{ url('item') }}" class="btn btn-primary custom-btn">{{ trans('message.form.cancel') }}</a>
                    <button class="btn btn-info pull-right custom-btn" type="next">{{ trans('message.form.submit') }}</button>
                  </div>
                  <!-- /.box-footer -->
                </form>
              </div>
              </div>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane <?= ($tab=='purchase') ? 'active' :'' ?>" id="tab_3">
                <div class="row">
                <div class="col-md-6">
                  <h4 class="text-info text-center">Purchase Price Information</h4>
                <form action="{{ url('save-specification') }}" method="post" id="purchaseInfoForm" class="form-horizontal">
                  <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                  <input type="hidden" value="<?= isset($stock_id) ? $stock_id : ''?>" name="stock_id" id="stock_id">
                  
                  <div class="box-body">
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.supplier') }}<span class="text-danger"> *</span></label>

                      <div class="col-sm-9">
                        <select class="form-control select2" name="supplier_id">
                        <option value="">{{ trans('message.form.select_one') }}</option>
                        @foreach ($suppliers as $supplier)
                          <option value="{{$supplier->supplier_id}}" >{{$supplier->supp_name}}</option>
                        @endforeach
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.price') }} <span class="text-danger"> *</label>
                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.price') }}" class="form-control" name="price" value="{{old('price')}}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.supplier_unit_of_messure') }} <span class="text-danger"> *</label>
                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.supplier_unit_of_messure') }}" class="form-control" name="suppliers_uom" value="{{old('suppliers_uom')}}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.conversion_factor') }}</label>
                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.conversion_factor') }}" class="form-control" name="conversion_factor" value="{{old('conversion_factor')}}">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.supplier_description') }}</label>
                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.supplier_description') }}" class="form-control" name="supplier_description" value="{{old('supplier_description')}}">
                      </div>
                    </div>
                                                            

                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <a href="{{ url('item') }}" class="btn btn-primary custom-btn">{{ trans('message.form.cancel') }}</a>
                    <button class="btn btn-info pull-right custom-btn" type="submit">{{ trans('message.form.submit') }}</button>
                  </div>
                  <!-- /.box-footer -->
                </form>
              </div>
              </div>

              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        
          </div>
        <div class="clearfix"></div>
        <!-- /.box-footer-->
      
      <!-- /.box -->

    </section>
@endsection
@section('js')
    <script type="text/javascript">
$(document).ready(function () {

    $(".select2").select2({
       width: '100%'
    });

    $(document).on('change','#cat', function() {
      var option = $('option:selected', this).attr('data');
      $("#unit").val(option);
    });

// Item form validation
    $('#itemAddForm').validate({
        rules: {
            stock_id: {
                required: true
            },
            description: {
                required: true
            },
            category_id:{
               required: true
            },
            tax_type_id:{
               required: true
            }, 
            units:{
               required: true
            }                        
        }
    });
    // Sales form validation
    $('#salesInfoForm').validate({
        rules: {
            sales_type_id: {
                required: true
            },
            price: {
                required: true
            }                        
        }
    });

    // Purchse form validation
    $('#purchaseInfoForm').validate({
        rules: {
            supplier_id: {
                required: true
            },
            price: {
                required: true
            },
            suppliers_uom: {
                required: true
            }                                     
        }
    });

});

    </script>
@endsection