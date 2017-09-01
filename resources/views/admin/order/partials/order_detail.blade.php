    <!--Select Product-->
                        
                        <div class="box box-success">
                            <div class="box-body">
                                             
                                <div class="form-group">
                                   
                                    <select class="select2 form-control" id="sel_product" style="float: none; width: 200px">
                                        <option value="-1">Select a product</option>
                                        @foreach($items as $item)
                                            <option value="{{$item->stock_id}}">{{$item->description}}</option>
                                        @endforeach
                                    </select>
                             
                            </div>
                     
                        <!-- End Select Product -->

                        <!-- Product Table -->

                      
                            <div class="col-md-12">
                                <table class="table table-reponsive info" id="product_table" >
                                    <thead>
                                        <th>Name</th>
                                        <th>Picture</th>
                                        <th>Stock On Hand</th>
                                        <th>Final Quantity</th>
                                        <th>Price (B)</th>
                                        <th>Amount (B)</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                        @foreach($order->details as $detail)
                                            <tr class="item-row" item-id="{{$detail->stock_id}}">
                                            <td>{{$detail->item->description}}</td>
<<<<<<< HEAD
                                            <td><img width="80px" height="80px" src="{{asset('/public/uploads/itemPic/'.$detail->item->item_image)}}"></td>
=======
                                            <td><img width="80px" height="80px" src="{{asset('/uploads/itemPic/'.$detail->item->item_image)}}"></td>
>>>>>>> f6bd814fff2647b73855968f1f617f7e218c4483
                                            <td>{{$detail->item->stock_on_hand}}</td>
                                            <td><input type="text" name="quantity" value="{{$detail->quantity}}" class="form-control text-center inp_qty"></td>
                                            <td><input type="text" name="price" value="{{$detail->unit_price}}" class="form-control text-center inp_price"></td>
                                            <td>
                                        <input type="text" name="amount" value="{!! ($detail->unit_price)*($detail->quantity) !!}" class="form-control text-center" readonly><input type="hidden" name="item_weight" value="{{ $detail->item->weight }}">
                                        </td>
                                        <td>
                                            <span class="glyphicon glyphicon-trash text-danger removebtn" item-id="{{$detail->stock_id}}" style="cursor:pointer; font-size:18px"></span>
                                        </td>
                                            </tr>
                                            
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="static_rows">
                                        <td colspan="5"><strong>Sub Total</strong></td>
                                        <td colspan="2" id="subTotal" style="font-weight:bold" class="text-left"></td>
                                    </tr>
                             
                                    <tr class="static_rows">
                                        <td colspan="5"><strong>Shipping Method</strong></td>
                                        <td>
                                            <select name="shipping_method" class="form-control" id="sel_shipping_method">
                                                <option>Select One</option>
                                                <option value="EMS" @if($order->shipping_method == "EMS") selected @endif>EMS</option>
                                                <option value="Registered"  @if($order->shipping_method == "Registered") selected @endif>Registered</option>
                                            </select>
                                        </td>
                                    </tr>
                                        <tr class="static_rows">
                                        <td colspan="5"><strong>Shipping Cost</strong></td>
                                        <td>
                                            <input class="form-control" id="shipping_cost" readonly value="{{$order->shipping_cost}}">
                                        </td>
                                    </tr>
                                        <tr class="static_rows">
                                        <td colspan="5"><strong>Discount Amount</strong></td>
                                        <td>
                                            <input class="form-control" id="discount_amount" type="number" name="discount_amount" value="{{$order->discount_amount}}">
                                        </td>
                                    </tr>
                                           <tr class="static_rows">
                                        <td colspan="5" ><strong>TAX</strong></td>
                                        <td>
                                            <select class="form-control" name="tax" id="sel_tax">
                                                <option value="-1">Select One</option>
                                                @foreach($tax_types as $tax_type)
                                                    <option value="{{$tax_type->tax_rate}}" @if($order->item_tax == $tax_type->tax_rate) selected @endif>{{$tax_type->name}}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                    </tr>
                                    <tr class="static_rows">
                                        <td colspan="5"><strong>Tax Amount</strong></td>
                                        <td>
                                            <input class="form-control" id="tax_amount" value="0" readonly >
                                        </td>
                                    </tr>
                                    <tr class="static_rows">
                                        <td colspan="5"><strong>Grand Total</strong></td>
                                        <td>
                                            <input class="form-control" id="grand_total" type="number" name="grand_total" value="0">
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
                        <label class="control-label">Note</label>
                        <textarea class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                             <button class="btn btn-primary pull-right" id="submitBtn">Submit</button>
                    </div>
           </div>
            </div>