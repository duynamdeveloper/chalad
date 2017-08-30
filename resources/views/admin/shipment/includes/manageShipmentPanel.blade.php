		<div class="panel panel-primary">
			<div class="panel-heading">
				<h4>Shipment</h4>
			</div>
			<div class="panel-body">
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

						<table class="table table-hover" id="shipmentTable">
							<thead>
								<th></th>
								<th>{{ trans('message.table.item_id') }}</th>
								<th>{{ trans('message.table.description') }}</th>
								<th>{{ trans('message.table.curr_stock') }}</th>
								<th>{{ trans('message.table.quantity') }}</th>
								<th>{{ trans('message.shipment.ready_to_ship') }}</th>
								<th>{{ trans('message.table.shipped') }}</th>
								
								<th class="manually_allocate_td" hidden> {{ trans('message.table.additional_packing_qty') }}</th>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					<div class="panel-footer text-center">
						<button class="btn btn-primary" id="addShipmentManuallyBtn">{{ trans('message.shipment.create_shipment_manually') }}</button>
						<button class="btn btn-success" id="addShipmentAutoBtn">{{ trans('message.shipment.allocate_item_automaticly') }}</button>
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
