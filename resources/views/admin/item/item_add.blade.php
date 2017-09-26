@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="box box-success">
                <div class="box-header text-left">
                    <h3 class="text-success">New Product</h3>
                </div>
               
            </div>
           <form id="addProductForm" class="form-horizontal" method="post" action="{{url('item/save')}}" enctype="multipart/form-data">
      
        <div class="row">
           {{ csrf_field() }}
            <!--Left Panel-->
            <div class="col-md-8">
                <div class="box box-success">
                    <div class="box-header text-left">
                        <h4 class="text-primary">Basic Information</h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                        <label class="text-left control-label col-sm-2 ">Name:</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="product_name" width="50%" placeholder="Product Name">    
                        </div>
                        </div>
                          <div class="form-group">
                        <label class="text-left control-label col-sm-2 ">SKU:</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="product_sku" width="50%" placeholder="SKU">    
                        </div>
                        </div>
                         <div class="form-group">
                      
                        <div class="col-sm-12">
                          <label class="control-label">Description:</label>
                            <textarea class="form-control" name="description"></textarea>    
                        </div>
                        </div>
                         <div class="form-group">
                      
<<<<<<< HEAD
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
=======
                        <div class="col-sm-12">
                          <label class="control-label">Short Description:</label>
                            <textarea class="form-control" name="short_description"></textarea>    
                        </div>
                        </div>
                         <div class="form-group">
                        <label class="text-left control-label col-sm-2 ">Category:</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" name="category_id" id="cat">
>>>>>>> e611f1bd972188b5834f68442a84193766c4d704
                       
                                @foreach ($categoryData as $data)
                                <option value="{{$data->category_id}}" data='{{$unit_name["$data->dflt_units"]}}' >{{$data->description}}</option>
                                @endforeach
                            </select>    
                        </div>
                        </div>
                        <div class="form-group">
                        <label class="text-left control-label col-sm-2 ">Regular Price:</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="regular_price" width="50%">    
                        </div>
                        </div>
                          <div class="form-group">
                        <label class="text-left control-label col-sm-2 ">Special Price:</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="special_price" width="50%">    
                        </div>
                        </div>
                         <div class="form-group">
                        <label class="col-sm-2 control-label">Status:</label>
                        <div class="col-sm-9">
                            <label class="radio-inline"><input type="radio" name="status" value="0">Active</label>
                                <label class="radio-inline"><input type="radio" name="status" value="1">Inactive</label>
                        </div>
                    </div>
                    </div>
                   
                </div>
       
            </div>
               <div class="col-md-4">
               
       
                <div class="box box-success">
                    <div class="box box-header">
                        <h4 class="text-primary text-left">Specifications</h4>
                    </div>
                    <div class="box box-body">
                        <div class="form-group">
                            <label class="control-label col-sm-3">Product Type</label>
                            <div class="col-sm-9">
                                <label class="radio-inline"><input type="radio" name="item_type" value="1">Simple Product</label>
                                <label class="radio-inline"><input type="radio" name="item_type" value="2">Grouped Product</label>
                            </div>
                        </div>
                            <div id="simple_product_group" hidden>
                                <div class="form-group">
                                    <label class="col-sm-3 control-lable">Weight: </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="weight" placeholder="weight">
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-3 control-lable">Pieces/Pack: </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="qty_per_pack" placeholder="Pieces/Pack">
                                    </div>
                                </div>
                            </div>
                            <div id="grouped_product_group" hidden>
                                <div class="form-group">
                                    <div class="col-sm-12">
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
                                        <div class="col-sm-12">
                                            <table class="table table-bordered" id="list-products">
                                        <thead>
                                        <th>STOCK ID</th>
                                        <th>IMAGE</th>
                                        <th>NAME</th>
                                        <th>QUANTITY</th>
                                        <th>ACTION</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        </table>
                                        </div>
                                    <input type="hidden" name="product_list" id="hiddenProductList">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                             <div class="box box-success">
                    <div class="box-header text-left">
                        <h4 class="text-primary">Image</h4>
                    </div>
                    <div class="box-body">
                    	<div class="form-group">
                     
                      <div class="col-sm-8 col-sm-offset-2 text-center">
                                       <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Choose a image</span>
                        <input type="file" class="form-control input-file-field" name="item_image" id="simpleProductForm_itemImage">
                          </span>
                          
                          <img width="100%" height="300px" id="simpleProductForm_imagePreview" src="{{asset('public/img/no-preview-available.png')}}" style="margin-top: 15px;"><br>
                          <p class="text-primary" id="simpleProductForm_imageName"></p>
                      </div>
 


                    </div>
                    </div>
                </div>
               
                </div>
            </div>
           
        </div>
         <div class="row">
                  <div class="box box-success">
                   
                    <div class="box-body text-center">
                        <button class="btn btn-success" type="submit">Save Product</button>
                    </div>
                </div>
            </div>
        </form>
            <!-- End Left Panel -->

            <!-- Right Panel -->
         
            <!-- End right Panel -->
        </div>
    </div>
@endsection
@section('js')
<script type="text/javascript">
     $(".select2").select2({
       width: '100%'
    });
</script>

<script type="text/javascript" src="{{asset('public/dist/js/pages/item/item-add.js')}}"></script>
@endsection