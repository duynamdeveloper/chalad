var ITEM = {};

ITEM = {
    API: {
        get: SITE_URL + '/item/ajax/get-item',
        search: SITE_URL + '/order/ajax-item-search'
    }
};

ITEM.get = function(stock_id, callback = null) {

    $.ajax({
        url: ITEM.API.get,
        type: 'get',
        data: {
            'stock_id': stock_id
        },
        success: function(data) {
            if (data.state) {
            	if(callback !== null){
            		callback(data.item);
            	}
            }
            return false;
        },
        complete: function() {

        }
    });
};
ITEM.getInfo = function(stock_id) {

    $.ajax({
        url: ITEM.API.get,
        type: 'get',
        data: {
            'stock_id': stock_id
        },
        success: function(data) {
            if (data.state) {

                var img = '<img src="' + SITE_URL + '/public/uploads/itemPic/' + data.item.item_image + '" style="height: 70px !important;" class="img-circle" alt="Item Image">';
                $("#item-modal-image").html(img);
                $("#item-modal-name").html(data.item.description);
                $("#item-modal-category").html(data.item.category.description);
                $("#item-modal-stock-on-hand").html(data.item.stock_on_hand);
                $("#item-modal-quantity-pack").html(data.item.qty_per_pack);
                $("#item-modal-weight").html(data.item.weight);
                $("#itemInfoModal").modal('show');
            }
            return false;
        },
        complete: function() {

        }
    });
};
ITEM.search = function(string) {
    $.ajax({
        url: ITEM.API.search,
        type: 'get',
        data: {
            string: string
        },
        error: function() {
            $("#livesearch").html('<ul><li class="text-center">No item found!</li></ul>');
        },
        success: function(data) {
            if (!data.state) {
                $("#livesearch").html('<ul><li class="text-center">No item found!</li></ul>');
            } else {
                var ul = $("<ul>");
                $.each(data.items, function(i, item) {

                    $("<li>").attr('item-id', item.stock_id).addClass('search-result').html('<img src="' + SITE_URL + '/public/uploads/itemPic/' + item.item_image + '">' + '<span class="pull-right">' + item.name + '</span>').appendTo(ul);
                    //$("<li>").attr('item-id',item.stock_id).addClass('search-result').html('<img src="' + SITE_URL + '/uploads/itemPic/' + item.item_image + '">'+'<span class="pull-right">'+item.description+'</span>').appendTo(ul);
                });
                $("#livesearch").html(ul);

            }
        },
        timeout: 5000
    });
}
ITEM.writeToTable = function(item) {
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
    //ORDER.updateStatistic();
};

ITEM.calculateTotalWeight = function() {
    var rows = $("#product_table >tbody").find("tr.item-row");
    var total_weight = 0;
    $.each(rows, function(i, row) {
        var qty = $(row).find("input[name=quantity]").val();
        var weight = $(row).find("input[name=item_weight]").val();
        total_weight += parseInt(qty) * parseInt(weight);
    });
    return total_weight;
};

$(document).ready(function(){
    $(document).on('click', '.infobtn', function() {
        var stock_id = $(this).attr('item-id');
        ITEM.getInfo(stock_id);
    });
    $(document).on('keyup', '#inp_live_search', function() {

        $("#livesearch").show();
        ITEM.search($(this).val());
    });
})