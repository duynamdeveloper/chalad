var PURCHASE = {};

var SUPPLIER = {};

var SHIPMENT = {};

PURCHASE.API = {
	'save' : SITE_URL + '/purchase/save',
	'update' : SITE_URL +'/purchase/update'
};
SUPPLIER.API = {
    'get': SITE_URL + '/supplier/ajax/get',
}
SHIPMENT.API = {
	'save': SITE_URL + '/purchase/saveshipment',
	'mark_shipped': SITE_URL + '/purchase/markshipped'
}

PURCHASE.updateStatistic = function() {
    var amounts = $("input[name=amount]");
    var subtotal = 0;
    $.each(amounts, function(i, amount) {
        subtotal += parseFloat($(amount).val());
    });
    subtotal = parseFloat(subtotal);
    if (isNaN(subtotal)) {
        subtotal = 0;
    }
    $("#subTotal").html(subtotal);
    var shipping_cost = parseFloat($("#shipping_cost").val());
    if (isNaN(shipping_cost)) {
        shipping_cost = 0;
    }
    var grand_total = shipping_cost + subtotal;
    $("#grand_total").val(grand_total);
}
PURCHASE.update = function(){
	items = PURCHASE.getFormData();
	items = JSON.stringify(items);
	var shipping_cost = $("#shipping_cost").val();
	var grand_total = $("#grand_total").val();

	$.ajax({
		url: PURCHASE.API.update,
		type: 'post',
		data: {
			'items': items,
			'purchase_id':purchase_id,
			'shipping_cost': shipping_cost,
			'grand_total': grand_total
		},
		success: function(data){
			console.log('success');
		}
	});
}
PURCHASE.writeToTable = function(item) {
    var tbody = $("#product_table > tbody");
    var tr = $("<tr>").addClass("item-row").attr("item-id", item.stock_id);

    $("<td>").html('<img src="' + SITE_URL + '/public/uploads/itemPic/' + item.item_image + '" width="80px" height="80px">').appendTo(tr);
    $("<td>").html(item.name).appendTo(tr);
    $("<td>").html('<input type="text" name="quantity" value="1" class="form-control text-center inp_qty">').appendTo(tr);
    $("<td>").html('<input type="text" name="price" value="' + item.special_price + '" class="form-control text-center inp_price">').appendTo(tr);
    $("<td>").html('<input type="text" name="amount" value="' + item.special_price + '" class="form-control text-center" readonly><input type="hidden" name="item_weight" value="' + item.weight + '">').appendTo(tr);
    $("<td>").html('<span class="glyphicon glyphicon-trash text-danger removebtn" item-id="' + item.stock_id + '" style="cursor:pointer; font-size:18px"></span>' + '<span class="glyphicon glyphicon-info-sign text-info infobtn" item-id="' + item.stock_id + '" style="cursor:pointer; font-size:18px"></span>').appendTo(tr);
    tbody.append(tr);
    $("#product_table > tfoot").show();
    PURCHASE.updateStatistic();
}
PURCHASE.updateAmount = function(item_id) {
    var row = $("#product_table > tbody").find('tr[item-id="' + item_id + '"]');
    var qty = row.find("input[name=quantity]").val();
    var price = row.find("input.inp_price").val();
    qty = parseInt(qty);
    price = parseFloat(price);
    var amount;
    if (isNaN(qty) || isNaN(price)) {
        amount = 0;
    } else {
        amount = parseInt(qty) * parseFloat(price);
    }

    row.find("input[name=amount]").val(amount);
};

PURCHASE.getFormData = function() {
    // var formData = $("form").serializeArray();
    var itemArray = [];
    var rows = $("#product_table > tbody").find("tr.item-row");
    $.each(rows, function(i, row) {
        var item = {};
        item = {
            item_id: $(row).attr('item-id'),
            price: $(row).find('input[name=price]').val(),
            qty: $(row).find('input[name=quantity]').val(),
            name: $(row).find('td:nth-child(2)').html()
        };
        itemArray.push(item);

    });
    return itemArray;

};
SHIPMENT.writeToTable = function(item){
	var table_body = $("#shipmentTable > tbody");
	
	var tr = $("<tr>").attr('shipment-id', '-1');
	$("<td>").html('<img width="100px" height="100px" src="'+SITE_URL+'/uploads/itemPic/'+item.item_image+'">').appendTo(tr);
	$("<td>").html(item.stock_id).appendTo(tr);
	$("<td>").html(item.name).appendTo(tr);
	$("<td>").html('<input name="item_qty" class="inp_qty form-control text-center" value="1">').appendTo(tr);
	$("<td>").html('<input name="tracking" class="inp_tracking form-control text-center">').appendTo(tr);
	$("<td>").html('<input name="date_arrival" class="datetime date_arrival form-control text-center">').appendTo(tr);
	$("<td>").html('<label class="label label-default">Pending</label>').appendTo(tr);
	$("<td>").html('<span class="glyphicon glyphicon-floppy-disk icon-control save-shipment text-primary"></span><span class="glyphicon glyphicon-check mark-shipped icon-control text-success"></span><span class="glyphicon glyphicon-remove icon-control remove-shipment text-danger"></span>').appendTo(tr);
	table_body.append(tr);
}
SHIPMENT.save = function(data){
	data = JSON.stringify(data);
	$.ajax({
		url: SHIPMENT.API.save,
		type: 'post',
		data: {
			'data': data,
			'purchase_id':purchase_id
		},
		success: function(received){
			notify('Update shipment success!');
		}
	});
}
SHIPMENT.markShipped = function(shipment_id){
	$.ajax({
		url: SHIPMENT.API.mark_shipped,
		type: 'post',
		data: {
			'shipment_id':shipment_id
		},
		success: function(received){
			notify('Update shipment success!');

		}
	});
}
function notify(msg, type = 'success') {
    $.notify({
        message: msg,

    }, {
        type: type,
        animate: {
            enter: "animated fadeInUp",
            exit: "animated fadeOutDown"
        },
        allow_dismiss: true,
    });
};
/*Action on events*/

$(document).ready(function() {
    $(document).on('click', '.search-result', function() {

        var item_id = $(this).attr('item-id');
        $("#livesearch").hide();

        var tr = $("#product_table").find("> tbody").find('tr[item-id="' + item_id + '"]');
        if (tr.length > 0) {
            var qty = tr.find('input[name=quantity]').val();
            tr.find('input[name=quantity]').val(++qty);
            PURCHASE.updateAmount(item_id);
        } else {
            ITEM.get(item_id, function(item) {
                PURCHASE.writeToTable(item);
            });

        }


    });
    $(document).on('click','.mark-shipped', function(){
    	var shipment_id = $(this).closest('tr').attr('shipment-id');
    	if(shipment_id == -1){
    		notify('Save shipment first!','warning');
    	}else{
    		SHIPMENT.markShipped(shipment_id);
    		$(this).closest('tr').find('td:nth-child(7)').html('<labe class="label label-success">Shipped</label>');
    	}
    });
     $(document).on('click','.save-shipment', function(){
        var shipment_id = $(this).closest('tr').attr('shipment-id');
        var row = $(this).closest('tr');
        var data = {
        	shipment_id: shipment_id,
        	stock_id : row.find('td:nth-child(2)').html(),
        	quantity: row.find('.inp_qty').val(),
        	tracking: row.find('.inp_tracking').val(),
        	date_arrival: row.find('.date_arrival').val()
        };
        SHIPMENT.save(data);
    });
    $(document).on('click','.ready_to_ship_btn', function(){
    	nextToShipment();
    });
    $(document).on('change','#sel_shipment_product', function(){
    	if($(this).val() !== -1){
    		ITEM.get($(this).val(), function(item){
    		SHIPMENT.writeToTable(item);
    	});
    	}
    	
    })
    $(document).on('keyup', '.inp_qty', function() {
        var item_id = $(this).closest('tr').attr('item-id');
        PURCHASE.updateAmount(item_id);
        PURCHASE.updateStatistic();
    });
    $(document).on('keyup','.inp_price', function(){
    	PURCHASE.updateStatistic();
    });
    $(document).on('keyup', "#shipping_cost", function() {
        PURCHASE.updateStatistic();
    });
    $(document).on('click',"#btnSaveOrder", function(){
    	nextToPayment();
    	PURCHASE.update();
    });
    $(document).on('click', '.edit_payment', function() {
        var payment_id = $(this).attr('payment-id');
        var payment_type = $(this).closest('tr').find('td:nth-child(3)').html();
        var date = $(this).closest('tr').find('td:nth-child(2)').html();
        var amount = $(this).closest('tr').find('td:nth-child(5)').html();
        $("#inp_payment_id").val(payment_id);
        $("#payment_type_id").val(payment_type);
        $("#payment_amount").val(amount);
        $("#payment_date").val(date);
        $("#editPaymentModal").modal('show');
    });
});

function nextToShipment() {
    animating = false;
    if (animating) return false;

    animating = true;

    current_fs = $("#payment_field");

    next_fs = current_fs.next();

    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate({ opacity: 0 }, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale current_fs down to 80%
            scale = 1 - (1 - now) * 0.2;
            //2. bring next_fs from the right(50%)
            left = (now * 50) + "%";
            //3. increase opacity of next_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({
                'transform': 'scale(' + scale + ')',

            });
            next_fs.css({ 'left': left, 'opacity': opacity });
        },
        duration: 800,
        complete: function() {
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });

}

function nextToPayment() {
    animating = false;
    if (animating) return false;
    animating = true;

    current_fs = $("#order_field");

    next_fs = current_fs.next();
    if (next_fs[0].id !== "shipment_field") {
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50) + "%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    'transform': 'scale(' + scale + ')',

                });
                next_fs.css({ 'left': left, 'opacity': opacity });
            },
            duration: 800,
            complete: function() {
                current_fs.hide();
                animating = false;
            },
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    }
    //activate next step on progressbar using the index of next_fs

}
$(".previous").click(function() {
    if (animating) return false;
    animating = true;

    current_fs = $(this).parent().parent().parent().parent();
    previous_fs = current_fs.prev();

    //de-activate current step on progressbar
    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

    //show the previous fieldset
    previous_fs.show();
    //hide the current fieldset with style
    current_fs.animate({ opacity: 0 }, {
        step: function(now, mx) {
            //as the opacity of current_fs reduces to 0 - stored in "now"
            //1. scale previous_fs from 80% to 100%
            scale = 0.8 + (1 - now) * 0.2;
            //2. take current_fs to the right(50%) - from 0%
            left = ((1 - now) * 50) + "%";
            //3. increase opacity of previous_fs to 1 as it moves in
            opacity = 1 - now;
            current_fs.css({ 'left': left });
            previous_fs.css({ 'transform': 'scale(' + scale + ')', 'opacity': opacity });
        },
        duration: 800,
        complete: function() {
            current_fs.hide();
            animating = false;
        },
        //this comes from the custom easing plugin
        easing: 'easeInOutBack'
    });
});