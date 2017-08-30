

$(document).ready(function(){
	$("#selReason").change(function(event) {
		if($(this).val()=="create_new"){
			$("#createNewReasonGroup").show();
		}else{
			$("#createNewReasonGroup").hide();
		}
	});
	$(".btnEdit").click(function(){
		var id = $(this).attr('data-stock-movement-id');
		$.ajax({
			url: SITE_URL+'/stock/movement/get-by-id',
			type:'get',
			data:{
				'id': id,
			},
			success: function(data){
				console.log(data);
				$("#hiddenInpStockMoveId").val(data.id);
				$("#selStockId").val(data.stock_id);
				$("#inpQty").val(data.quantity);
				$("#selReason").val(data.reason_id);
				$("#stockMovementForm").attr('action',SITE_URL+'/stock/movement/edit');
				$("#stockMovementModal").modal('show');
			}
		});
	});
	$(".btnRemove").click(function(){
		var id = $(this).attr('data-stock-movement-id');
		var check = confirm("Are you sure");
		if(check){
		$.ajax({
			url: SITE_URL+'/stock/movement/delete',
			type:'post',
			data:{
				'id':id
			},
			success: function(data){
				if(data.state){
					location.reload();
				}
			}
		});
		}

	});
});