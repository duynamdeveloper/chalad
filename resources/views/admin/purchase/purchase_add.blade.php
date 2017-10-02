@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="text-info">Create New Purchase Order</h3>
        </div>
        <div class="box-body">

         <form class="form-horizontal">
           <div class="row">
            <div class="col-md-6">
                <form class="form-horizontal supplier_form" autocomplete="offs" id="supplier_form">
                    <div class="form-group">
                        <label class="control-label col-md-4">Select Supplier</label>
                        <div class="col-md-8">
                            <select class="select2 form-control" name="supplier_id" id="sel_supplier">
                                <option value="null">Choose an option</option>
                                <option value="-1">CREATE NEW SUPPLIER</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Name</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control supplier-form" name="supplier_name" id="inp_supplier_name" placeholder="Enter Name">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Phone</label>
                    <div class="col-md-8">  
                        <input type="text" class="form-control supplier-form" name="supplier_phone" id="inp_supplier_phone" placeholder="Enter Phone Number" >
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-4">Email</label>
                    <div class="col-md-8">
                        <input type="text"  class="form-control supplier-form" name="supplier_email" id="inp_supplier_email" placeholder="Enter Email">
                    </div>
                </div>

            </div>
            <div class="col-md-6">
             <div class="form-group">
                <label class="control-label col-md-4">Address</label>
                <div class="col-md-8">
                   <input type="text" class="form-control supplier-form" name="supplier_address" id="inp_supplier_address" placeholder="Enter Address" >
               </div>
           </div>
           <div class="form-group">
                <label class="control-label col-md-4">City</label>
                <div class="col-md-8">
                   <input type="text" class="form-control supplier-form" name="supplier_city" id="inp_supplier_city" placeholder="Enter City" >
               </div>
           </div>
           <div class="form-group">
                <label class="control-label col-md-4">State</label>
                <div class="col-md-8">
                   <input type="text" class="form-control supplier-form" name="supplier_state" id="inp_supplier_state" placeholder="Enter Address" >
               </div>
           </div>
           <div class="form-group">
                <label class="control-label col-md-4">Zip Code</label>
                <div class="col-md-8">
                   <input type="text" class="form-control supplier-form" name="supplier_zip_code" id="inp_supplier_zip_code" placeholder="Enter Zip Code" >
               </div>
           </div>
           <div class="form-group">
                <label class="control-label col-md-4">Country</label>
                <div class="col-md-8">
                   <select class="form-control select2 supplier-form" name="supplier_country" id="sel_country" >
                       @foreach($countries as $country)
                            <option value="{{ $country->code }}">{{$country->country }}</option>
                       @endforeach
                   </select>
               </div>
           </div>
       </div>

   </form>
</div>
</div>

</div>


<div class="box box-success">
    <div class="box-body">

        <h4 class="text-info"><strong>Order Details</strong></h4>
        <div class="form-group">

            <div class="col-md-3">Search :</div>
            <div class="col-md-4">

                <input class="form-control" id="inp_live_search">

                <div id="livesearch" hidden>

                    <ul>
                        <li><img src="{{asset('public/img/loading-icon.gif')}}" width="50px" height="50px"> Loading...</li>

                    </ul>
                </div>
            </div>

        </div>

        <!-- End Select Product -->

        <!-- Product Table -->


        <div class="col-md-12">
            <table class="table table-reponsive info" id="product_table" >
                <thead>
                    <th></th>
                    <th>Name</th>

                    <th>Quantity</th>
                    <th>Price (B)</th>
                    <th>Amount (B)</th>
                    <th>Action</th>
                </thead>
                <tbody>

                </tbody>
                <tfoot hidden>
                    <tr class="static_rows">
                        <td colspan="5"><strong>Sub Total</strong></td>
                        <td colspan="2" id="subTotal" style="font-weight:bold" class="text-left"></td>
                    </tr>

                    <tr class="static_rows">
                        <td colspan="5"><strong>Shipping Cost</strong></td>
                        <td>
                            <input class="form-control" id="shipping_cost" value="0">
                        </td>
                    </tr>
                    <tr class="static_rows">
                        <td colspan="5"><strong>Grand Total</strong></td>
                        <td>
                            <input class="form-control" id="grand_total" type="number" name="grand_total">
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>


</div>
<div class="box box-default">
    <div class="box-body">

        <div class="form-group">
         <button class="btn btn-success pull-right next" type="button" id="btnSaveOrder">Save</button>
     </div>
 </div>
</div>

<div id="itemInfoModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="box box-widget widget-user-2">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-blue">
                    <div class="widget-user-image" id="item-modal-image">
                        <img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="Item Avatar">
                    </div>
                    <!-- /.widget-user-image -->
                    <h3 class="widget-user-username" id="item-modal-name"></h3>
                    <h5 class="widget-user-desc" id="item-modal-category"></h5>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li><a href="#">Stock On Hand <span class="pull-right" id="item-modal-stock-on-hand">31</span></a></li>
                        <li><a href="#">Weight <span class="pull-right" id="item-modal-weight">5</span></a></li>
                        <li><a href="#">Quantity/Pack <span class="pull-right" id="item-modal-quantity-pack">12</span></a></li>

                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $(".select2").select2();
    });
</script>
<script type="text/javascript" src="{{asset('public/dist/js/item-tool.js')}}"></script>
<script type="text/javascript" src="{{asset('public/dist/js/pages/purchase/purchase.js')}}"></script>`
@endsection