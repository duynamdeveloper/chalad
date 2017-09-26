@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="box box-success">
                <div class="box-header text-left">
                    <h3 class="text-primary">Edit Product <span class="text-warning">{{$item->name}}</span></h3>
                </div>
               
            </div>
           <form id="addProductForm" class="form-horizontal" method="post" action="{{url('item/update')}}" enctype="multipart/form-data">
      <input type="hidden" name="id" value="{{$item->id}}">
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
                            <input class="form-control" name="product_name" width="50%" placeholder="Product Name" value="{{$item->name}}">    
                        </div>
                        </div>
                          <div class="form-group">
                        <label class="text-left control-label col-sm-2 ">SKU:</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="product_sku" width="50%" placeholder="SKU" value="{{$item->stock_id}}">    
                        </div>
                        </div>
                         <div class="form-group">
                      
                        <div class="col-sm-12">
                          <label class="control-label">Description:</label>
                            <textarea class="form-control" name="description">{{$item->description}}</textarea>    
                        </div>
                        </div>
                         <div class="form-group">
                      
                        <div class="col-sm-12">
                          <label class="control-label">Short Description:</label>
                            <textarea class="form-control" name="short_description">{{$item->short_description}}</textarea>    
                        </div>
                        </div>
                         <div class="form-group">
                        <label class="text-left control-label col-sm-2 ">Category:</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" name="category_id" id="cat">
                       
                                @foreach ($categoryData as $data)
                                <option value="{{$data->category_id}}" data='{{$unit_name["$data->dflt_units"]}}' @if($item->category_id == $data->category_id) selected="true" @endif>{{$data->description}}</option>
                                @endforeach
                            </select>    
                        </div>
                        </div>
                        <div class="form-group">
                        <label class="text-left control-label col-sm-2 ">Regular Price:</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="regular_price" width="50%" value="{{$item->price}}">    
                        </div>
                        </div>
                          <div class="form-group">
                        <label class="text-left control-label col-sm-2 ">Special Price:</label>
                        <div class="col-sm-6">
                            <input class="form-control" name="special_price" width="50%" value="{{$item->special_price}}">    
                        </div>
                        </div>
                         <div class="form-group">
                        <label class="col-sm-2 control-label">Status:</label>
                        <div class="col-sm-9">
                            <label class="radio-inline"><input type="radio" name="status" value="0" @if($item->inactive==0) checked @endif>Active</label>
                                <label class="radio-inline"><input type="radio" name="status" value="1" @if($item->inactive==1) checked @endif>Inactive</label>
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
                                <label class="radio-inline"><input type="radio" name="item_type" value="1" @if($item->item_type_id == 1) checked @else disabled="true" @endif>Simple Product</label>
                                <label class="radio-inline"><input type="radio" name="item_type" value="2" @if($item->item_type_id == 2) checked @else disabled="true" @endif>Grouped Product</label>
                            </div>
                        </div>
                            <div id="simple_product_group" @if($item->item_type_id !== 1) hidden @endif>
                                <div class="form-group">
                                    <label class="col-sm-3 control-lable">Weight: </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="weight" placeholder="weight" value="{{$item->weight}}">
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-3 control-lable">Pieces/Pack: </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="qty_per_pack" placeholder="Pieces/Pack" value="{{$item->qty_per_pack}}">
                                    </div>
                                </div>
                            </div>
                            <div id="grouped_product_group" @if($item->item_type_id !== 2) hidden @endif>
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
                                        @if(!empty($item->linked_products))
                                        @foreach($item->linked_products as $linked_product)
                                            
                                            <tr item-id="{{$linked_product['item']->stock_id}}">
                                                <td>{{$linked_product['item']->stock_id}}</td>
                                                <td><img src="{{asset('public/uploads/itemPic/'.$linked_product['item']->item_image)}}" width="80px" height="80px"></td>
                                                <td>{{$linked_product['item']->name}}</td>
                                                <td><input name="item_quantity" class="form-control inp_item_qty" value="{{$linked_product['quantity']}}"></td>
                                                <td><span class="glyphicon glyphicon-remove text-danger removeProduct"></span></td>

                                            </tr>
                                        @endforeach
                                        @endif
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
                          
                          <img width="100%" height="300px" id="simpleProductForm_imagePreview" src="{{asset('/public/uploads/itemPic/'.$item->item_image)}}" style="margin-top: 15px;"><br>
                          <p class="text-primary" id="simpleProductForm_imageName">Current Image</p>
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