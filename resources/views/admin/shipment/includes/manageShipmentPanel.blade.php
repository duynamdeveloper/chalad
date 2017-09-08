<h3>Shipment Details</h3>
<div class="box box-success">
    <div class="box-body">
          <div class="row">
                        <div class="col-md-4">
             <h5 class="text-info"><strong>Ship To</strong></h5>

             <div class="form-group">
              <p class="col-sm-12 text-left" for="inputEmail3">Name<br>
			  Street Address, City<br>State ZIPCODE<br>COUNTRY<br><br>Phone: 0988251927
			  </p>

              </div>



              </div>
		  <div class="col-md-4">

		  <h5 class="text-info"><strong>Bill To</strong></h5>

             <div class="form-group">
              <p class="col-sm-12 text-left" for="inputEmail3">Name<br>
			  Street Address, City<br>State ZIPCODE<br>COUNTRY<br><br>Phone: 0988251927
			  </p>

              </div>



              </div>

		   <div class="col-md-4">

		  <h4 class="text-info"><strong>Shipment Due:</strong></h4>
		  <h3>10 Items</h3>
		   <button class="btn btn-success" id="addShipmentAutoBtn">Create/Update Shipment</button>
 <button class="btn btn-warning" id="addShipmentAutoBtn">View Payment History</button>



          </div>

          <!--End Shippind Address Form-->




      </div>

    </div>
</div>



<!--End Payment Summary -->

<div class="box box-success">
                            <div class="box-body">
<div class="row">
                        <div class="col-md-12">
             <h5 class="text-info"><strong>Order Summary</strong></h5>
                                <table class="table table-reponsive info" id="product_table" >
                                    <thead>
										<th></th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Price (B)</th>
                                        <th>Amount (B)</th>
										<th>Shipped</th>
                                    </thead>
                                    <tbody>
                                        @foreach($order->details as $detail)
                                            <tr class="item-row" item-id="{{$detail->stock_id}}">
											<td><img width="50px" height="50px" src="{{asset('/public/uploads/itemPic/'.$detail->item->item_image)}}"></td>
                                            <td>{{$detail->item->description}}</td>
                                            <td>{{$detail->quantity}}</td>
                                            <td>{{$detail->unit_price}}</td>
                                            <td>{!! ($detail->unit_price)*($detail->quantity) !!} </td>
											<td><span class="label label-success">{{$detail->quantity}}</span></td>
                                            </tr>

                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr class="static_rows">
                                        <td colspan="4"><strong>Sub Total</strong></td>
                                        <td colspan="2" id="subTotal"  class="text-left">1000</td>
                                    </tr>

                                        <tr class="static_rows">
                                        <td colspan="4"><strong>Shipping Cost</strong></td>
                                        <td class="text-left">
                                           {{$order->shipping_cost}}
                                        </td>
                                    </tr>
                                        <tr class="static_rows">
                                        <td colspan="4"><strong>Discount Amount</strong></td>
                                        <td  class="text-left">
                                            {{$order->discount_amount}}
                                        </td>
                                    </tr>

                                    <tr class="static_rows">
                                        <td colspan="4"><strong>Tax Amount</strong></td>
                                        <td class="text-left">
                                            0
                                        </td>
                                    </tr>
                                    <tr class="static_rows">
                                        <td colspan="4"><strong>Grand Total</strong></td>
                                        <td class="text-left">
                                            1000
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>



          </div>


          <!--End Shippind Address Form-->




            </div>

</div>
</div>


		<div class="box box-success">
			<div class="col-md-12">
				<h5 class="text-info"><strong>Shipment Summary</strong></h5>
			</div>
			<div class="box-body">
				<div class="container-fluid">
					<div class="row">
						<div class="control-panel col-md-3">
				{{-- 					<form class="form-inline">
										<div class="form-group">
											<label for="selOrder">Select a confirmed order:</label>
											<select class="select2 form-control " id="selOrder">
												<option value="-1">**Select a confirmed order**</option>
												@foreach($confirmedOrders as $order)
												<option value="{{ $order->order_no }}">{{ $order->reference }}</option>
												@endforeach
											</select>
										</div>
									</form> --}}
								</div>
							</div>
						</div>

						<table class="table table-stripped" id="shipmentTable">

							<tbody></tbody>
						</table>
					</div>
				</div>
				<div id="addTrackingModal" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Add Tracking Number</h4>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" id="addTrackingForm">
									<div class="form-group">
										<label class="control-label col-sm-4">Shipment ID:</label>
										<div class="col-sm-8">
											<input type="text" name="shipment_id" class="form-control" id="inputShipmentId" readonly="">


										</div>
									</div>
									<div class="tracking-container">
									<h4>Tracking </h4>
									<div class="form-group">
										<label class="control-label col-sm-4">Tracking Number 1:</label>
										<div class="col-sm-8">

											<input type="text" name="tracking_number" class="form-control" id="inputTrackingNumber">
											<span class="text-warning" id="trackingHelpblock">Leave blank if you want to delete this tracking number</span>
										</div>
									</div>
										<div class="form-group">
										<label class="control-label col-sm-4">Shipment method 1:</label>
										<div class="col-sm-8">

											<select class="form-control" id="selShippingMethod" name="shipping_method">
												<option value="-1">Select a method</option>
												<option value="EMS">EMS</option>
												<option value="Registered">Registered</option>
											</select>
										
										</div>
									</div>

									</div>
								</div>
								<div class="modal-footer">
									<button class="btn btn-success" id="saveAddTrackingBtn" type="submit">Save</button>
								</form>
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>

					</div>
				</div>

				<div id="confirmDelete" class="modal fade" role="dialog">
					<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Delete Shipment</h4>
							</div>
							<div class="modal-body">
								Are you sure to delete this shipment?
								</div>
								<div class="modal-footer">
									<button class="btn btn-danger" id="confirmDeleteBtn" type="submit">Delete</button>
						
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>

					</div>
				</div>
