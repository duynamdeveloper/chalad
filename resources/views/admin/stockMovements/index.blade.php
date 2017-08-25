@extends('layouts.app')
@section('content')
<style type="text/css">
	.action-control{
		font-size: 20px;
		cursor: pointer;
		transition: all 0.5s ease;
		box-sizing: border-box;
	}
	.action-control:hover{
		transform:scale(1.2,1.2);	
	}
</style>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h4>Stock Movements</h4>
					</div>
					<div class="panel panel-body">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<button class="btn btn-success" data-toggle="modal" data-target="#stockMovementModal">Add</button>
								</div>
							</div>
						</div>
						<table class="table">
							<thead>
								<th>ID</th>

								<th>Product Code</th>
								<th>Product Name</th>
								<th>Quantity</th>
								<th>Reason</th>
								
								<th>Created At</th>
							</thead>
							<tbody>
								@if($stock_movements==null)
								<tr><td colspan="9" class="text-center text-danger"><h4>No stock movements found!</h4><td></td>
									@else
									@foreach($stock_movements as $stock)
									<tr>
										<td>{{ $stock->id }}</td>

										<td>{{ $stock->stock_id }}</td>
										<td>{{ $stock->item_name }}</td>
										<td>{{ $stock->quantity }}</td>
										<td>{{ $stock->reason }}</td>
										<td>{{ Carbon\Carbon::createFromTimeStamp(strtotime($stock->created_at))->diffForHumans() }}</td>
										<td><span class="glyphicon glyphicon-edit text-info action-control btnEdit" data-stock-movement-id="{{ $stock->id }}"></span>
										
										<span class="glyphicon glyphicon-trash text-danger action-control  btnRemove" data-stock-movement-id="{{ $stock->id }}"></span></td>
									</tr>
									@endforeach
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div id="stockMovementModal" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Insert new stock movements</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" id="stockMovementForm" method="post" action="{{ url('/stock/movement/create') }}">
						{{ csrf_field() }}
						<input type="hidden" name="stock_movement_id" id="hiddenInpStockMoveId">
						<div class="form-group">
							<label class="control-label col-sm-4">Product:</label>
							<div class="col-sm-8">

								<select class="form-control select2" name="stock_id" id="selStockId">
									<option value="-1">Choose an item</option>
									@foreach($items as $item)
									<option value="{{ $item->stock_id }}">{{ $item->description }}</option>
									@endforeach
								</select>

							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">Quantity</label>
							<div class="col-sm-8">

								<input type="number" name="quantity" class="form-control" id="inpQty">

							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4">Reason:</label>
							<div class="col-sm-8">

								<select class="form-control select2" name="reason" id="selReason">
									<option value="-1">Choose a reason</option>
									<option value="create_new">Create new reason</option>
									@foreach($reasons as $reason)
									<option value="{{ $reason->id }}">{{ $reason->name }}</option>
									@endforeach
								</select>

							</div>
						</div>
						<div class="form-group" id="createNewReasonGroup" hidden>
							<label class="control-label col-sm-4">New Reason:</label>
							<div class="col-sm-8">

								<input type="text" name="new_reason" class="form-control" placeholder="New reason">

							</div>
						</div>


					</div>
					<div class="modal-footer">
						<button class="btn btn-success" id="saveStockMoveBtn" type="submit">Save</button>
					</form>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>

		</div>
	</div>



	@endsection
	@section('js')
	<script type="text/javascript" src="{{ asset('public/dist/js/pages/stock-movements/stock-movements.js') }}"></script>
	@endsection