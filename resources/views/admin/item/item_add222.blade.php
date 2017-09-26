@extends('layouts.app')
@section('styles')
<link rel="stylesheet" href="{{asset('plugins/jquery-file-upload/css/style.css')}}">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="{{asset('plugins/jquery-file-upload/css/jquery.fileupload.css')}}">
@endsection
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
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">Simple Product</a></li>
              <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Grouped Product</a></li>
              <li class="disabled disabledTab"><a href="#tab_3" data-toggle="tab" aria-expanded="true">Transactions</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
			  <div class="box-header">
			  <h4 class="text-info text-left">{{ trans('message.table.item_info') }}</h4>
			  </div>
			   <div class="box box-default">
                <div class="row">
				<form action="{{ url('save-simple-product') }}" method="post" id="createSimpleProductForm" class="form-horizontal" enctype="multipart/form-data">
				
				
                <div class="col-md-4">
                  
                  <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
				  <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Type</label>

                      <div class="col-sm-9">
                        <p style="margin-bottom:0px;">Simple Product</p>
                      </div>
                    </div>
                   <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.item_name') }}</label>

                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.item_name') }}" class="form-control valdation_check" name="description" value="{{old('description')}}" required>
                      </div>
                    </div>
             
                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Product Code</label>
                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.item_id') }}" class="form-control" name="stock_id" value="{{old('stock_id')}}" required>
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

            
                    

                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Regular Price</label>
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
					
		<div class="box-header">
			  <h4 class="text-info text-left">Specifications</h4>
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
					
             </div>
			<div class="col-md-3">
				<div class="form-group">
                      <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.picture') }}</label>
                      <div class="col-sm-9">
                                       <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Choose a image</span>
                        <input type="file" class="form-control input-file-field" name="item_image" id="simpleProductForm_itemImage">
                          </span>
                          
                          <img width="120px" height="120px" id="simpleProductForm_imagePreview" src="{{asset('/img/no-preview-available.png')}}" style="margin-top: 15px;"><br>
                          <p class="text-primary" id="simpleProductForm_imageName"></p>
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
				<button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
				</div>
                  <!-- /.box-body -->
				  </div>
                  <!-- /.box-footer -->
                </form>
              
              </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">

                     <div class="row">
                <div class="col-md-6">
                  <h4 class="text-info text-center">{{ trans('message.table.item_info') }}</h4>
                <form action="{{ url('item/save-grouped-product') }}" method="post" id="addGroupedProduct" class="form-horizontal" enctype="multipart/form-data">
                  <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                  <div class="box-body">
             
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

            
                    

                    <div class="form-group">
                      <label class="col-sm-3 control-label require" for="inputEmail3">Price</label>
                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.weight') }}" class="form-control" name="price" value="{{old('price')}}" required>
                      </div>
                    </div>
                    
                    <div class="form-group" hidden>
                      <label class="col-sm-3 control-label require" for="inputEmail3">{{ trans('message.form.special_price') }}</label>
                      <div class="col-sm-9">
                        <input type="text" placeholder="{{ trans('message.form.special_price') }}" class="form-control" name="special_price" value="{{old('special_price')}}" required>
                      </div>
                    </div>
                           <div class="form-group">

            <label class="col-md-3 control-label">Search :</label>
            <div class="col-md-4">

                <input class="form-control" id="inp_live_search">

                <div id="livesearch" hidden>

                    <ul>
                        <li><img src="{{asset('public/img/loading-icon.gif')}}" width="50px" height="50px"> Loading...</li>

                    </ul>
                </div>
            </div>

        </div>
        <div class="form-group">
        <div class="col-sm-9 col-sm-offset-3">
            <table class="table table-bordered" id="list-products">
        <thead>
          <th>STOCK ID</th>
          <th>IMAGE</th>
          <th>DESCRIPTION</th>
          <th>ACTION</th>
        </thead>
        <tbody>
        </tbody>
        </table>
        </div>
      <input type="hidden" name="product_list" id="hiddenProductList">
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
                    <button class="btn btn-primary pull-right btn-flat" type="submit" id="saveGroupedProduct">{{ trans('message.form.submit') }}</button>
                  </div>
                  <!-- /.box-footer -->
                </form>
              </div>
              </div>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
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
<script src="{{asset('/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js')}}"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>

<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="{{asset('plugins/jquery-file-upload/js/jquery.iframe-transport.js')}}"></script>
<!-- The basic File Upload plugin -->
<script src="{{asset('plugins/jquery-file-upload/js/jquery.fileupload.js')}}"></script>
<!-- The File Upload processing plugin -->
<script src="{{asset('plugins/jquery-file-upload/js/jquery.fileupload-process.js')}}"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="{{asset('plugins/jquery-file-upload/js/jquery.fileupload-image.js')}}"></script>
<!-- The File Upload audio preview plugin -->

<script src="{{asset('plugins/jquery-file-upload/js/jquery.iframe-transport.js')}}"></script>

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
    <!--<script src="{{asset('public/dist/js/pages/item/item-add.js')}}"></script>-->
    <script src="{{asset('/dist/js/pages/item/item-add.js')}}"></script>
@endsection