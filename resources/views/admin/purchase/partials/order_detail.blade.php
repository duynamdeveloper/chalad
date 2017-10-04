<!--Select Product-->


<fieldset @if($purchase->status==1) style="display: none" @endif id="order_field">
	<div class="box box-default">
            <div class="box-header">
                <h3>Order Details <button class="btn btn-success pull-right next" type="button" id="btnSaveOrder">Save & Next</button></h3>



           </div>
            </div>
    <div id="order_detail_container">

        <div class="box box-success">
    <div class="box-body">

        <h4 class="text-info"><strong>Order Details</strong></h4>
        <div class="form-group livesearch_container">

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
                    @if(count($purchase->details)>0)
                    @foreach($purchase->details as $detail)
                        <tr class="item-row" item-id="{{$detail->stock_id}}">
                        <td><img width="50px" height="50px" src="{{asset('/public/uploads/itemPic/'.$detail->item->item_image)}}"></td>
                        <td>{{$detail->item->name}}</td>
                       
                        <td><input type="text" name="quantity" value="{{$detail->quantity}}" class="form-control text-center inp_qty"></td>
                        <td><input type="text" name="price" value="{{$detail->unit_price}}" class="form-control text-center inp_price"></td>
                        <td>
                            <input type="text" name="amount" value="{!! ($detail->unit_price)*($detail->quantity) !!}" class="form-control text-center" readonly><input type="hidden" name="item_weight" value="{{ $detail->item->weight }}">
                        </td>
                        <td>
                            <span class="glyphicon glyphicon-trash text-danger removebtn" item-id="{{$detail->stock_id}}" style="cursor:pointer; font-size:18px"></span>
                            <span class="glyphicon glyphicon-info-sign text-info infobtn" item-id="{{$detail->stock_id}}" style="cursor:pointer; font-size:18px"></span>

                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
                <tfoot  @if(count($purchase->details) == 0) hidden @endif>
                    <tr class="static_rows">
                        <td colspan="5"><strong>Sub Total</strong></td>
                        <td colspan="2" id="subTotal" style="font-weight:bold" class="text-left"></td>
                    </tr>

                    <tr class="static_rows">
                        <td colspan="5"><strong>Shipping Cost</strong></td>
                        <td>
                            <input class="form-control" id="shipping_cost" value="{{ $purchase->shipping_cost }}">
                        </td>
                    </tr>
                    <tr class="static_rows">
                        <td colspan="5"><strong>Grand Total</strong></td>
                        <td>
                            <input class="form-control" id="grand_total" type="number" name="grand_total" value="{{ $purchase->total }}">
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>


</div>
    </div>
    <div class="box box-default">
        <div class="box-body">

            <div class="form-group">
							  <button class="btn btn-success pull-right next" type="button" id="btnSaveOrder">Save & Next</button>
        </div>
    </div>

</fieldset>
