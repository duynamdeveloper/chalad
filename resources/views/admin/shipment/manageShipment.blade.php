@extends('layouts.app')
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<!--Left panel-->
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h4>Shipment</h4>
					</div>
					<div class="panel-body">
						<div class="container-fluid">
							<div class="row">
								<div class="control-panel col-md-3">
									<form class="form-inline">
										<div class="form-group">
											<label for="selOrder">Select a confirmed order:</label>
											<select class="select2 form-control " id="selOrder">
												<option value="-1">**Select a confirmed order**</option>
												@foreach($confirmedOrders as $order)
												<option value="{{ $order->order_no }}">{{ $order->reference }}</option>
												@endforeach
											</select>
										</div>
									</form>
								</div>
							</div>
						</div>

						<table class="table table-hover" id="shipmentTable">
							<thead>
								<th>{{ trans('message.table.item_id') }}</th>
								<th>{{ trans('message.table.description') }}</th>
								<th>{{ trans('message.table.curr_stock') }}</th>
								<th>{{ trans('message.table.quantity') }}</th>
								<th>{{ trans('message.table.packed') }}</th>
								<th>{{ trans('message.table.shipped') }}</th>
								<th>{{ trans('message.table.unpacked_qty') }}</th>
			<th class="manually_allocate_td" hidden> {{ trans('message.table.additional_packing_qty') }}</th>
							</thead>
							<tbody></tbody>
						</table>
					</div>
					<div class="panel-footer text-center">
						<button class="btn btn-primary" id="addPaymentManuallyBtn">{{ trans('message.shipment.create_shipment_manually') }}</button>
						<button class="btn btn-success" id="addPaymentAutoBtn">{{ trans('message.shipment.create_shipment_automaticly') }}</button>
					</div>
				</div>

			</div>
			<!--End left panel-->
			<!-- Right panel -->
			<div class="col-md-4">

			</div>
			<!-- End right panel -->
		</div>
	</div>
</section>
<div id="manualAllocateModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 80%">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Allocate Manually</h4>
      </div>
      <div class="modal-body">
       <table class="table" id="manualAllocateTable">
       	<thead>
       		<th>{{ trans('message.table.item_id') }}</th>
       		<th>{{ trans('message.table.description') }}</th>
       		<th>{{ trans('message.table.curr_stock') }}</th>
       		<th>{{ trans('message.table.quantity') }}</th>
       		<th>{{ trans('message.table.packed') }}</th>
			<th>{{ trans('message.table.unpacked_qty') }}</th>
			<th> {{ trans('message.table.additional_packing') }}</th>

       	</thead>
       </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('/public/dist/js/pages/shipment/manage-shipment.js') }}"></script>
@endsection