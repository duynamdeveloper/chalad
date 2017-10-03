var PURCHASE = {};

var SUPPLIER = {};

PURCHASE.API = {
	'save' : SITE_URL + '/purchase/save',
};
SUPPLIER.API = {
    'get': SITE_URL + '/supplier/ajax/get',
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
PURCHASE.save = function(){
	items = PURCHASE.getFormData();
	supplier = SUPPLIER.getFormData();
	items = JSON.stringify(items);
	supplier = JSON.stringify(supplier);
	var shipping_cost = $("#shipping_cost").val();
	var grand_total = $("#grand_total").val();

	$.ajax({
		url: PURCHASE.API.save,
		type: 'post',
		data: {
			'items': items,
			'supplier': supplier,
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

SUPPLIER.getFormData = function() {
    var supplier = {
        id: $("#sel_supplier").val(),
        name: $("#inp_supplier_name").val(),
        phone: $("#inp_supplier_phone").val(),
        email: $("#inp_supplier_email").val(),
        address: $("#inp_supplier_address").val(),
        city: $("#inp_supplier_city").val(),
        state: $("#inp_supplier_state").val(),
        zip_code: $("#inp_supplier_state").val(),
        country: $("#sel_country").val()
    };
    return supplier;
};
SUPPLIER.get = function(supplier_id) {
    $.ajax({
        url: SUPPLIER.API.get,
        type: 'get',
        data: {
            'id': supplier_id
        },
        success: function(data) {
            if (data.state) {
                SUPPLIER.writeToForm(data.supplier);
            }
        }
    });
}
SUPPLIER.writeToForm = function(supplier) {
        $("#inp_supplier_name").val(supplier.name);
        $("#inp_supplier_phone").val(supplier.phone);
        $("#inp_supplier_email").val(supplier.email);
        $("#inp_supplier_address").val(supplier.address);
        $("#inp_supplier_city").val(supplier.city);
        $("#inp_supplier_state").val(supplier.state);
        $("#inp_supplier_zip_code").val(supplier.zip_code);
        $("#sel_country").val(supplier.country);
        $(".supplier-form").attr('disabled', true);
}
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
    $(document).on('keyup', '.inp_qty', function() {
        var item_id = $(this).closest('tr').attr('item-id');
        PURCHASE.updateAmount(item_id);
        PURCHASE.updateStatistic();
    });
    $(document).on('keyup', "#shipping_cost", function() {
        PURCHASE.updateStatistic();
    });
    $(document).on('click',"#btnSaveOrder", function(){
    	PURCHASE.save();
    });
    $(document).on('change', "#sel_supplier",function() {

    	if($(this).val() == -1 || $(this).val() == "null"){
    		$(".supplier-form").attr('disabled', false);
    		$("form")[0].reset();
    	}else if($(this).val() > 0){
    		SUPPLIER.get($(this).val());
    	}
    })
});