var ITEM = {};
ITEM = {
    API:{
        get: SITE_URL + '/item/ajax/get-item',
        search: SITE_URL + '/order/ajax-item-search'
    }
}
ITEM.get = function(stock_id) {
    
        $.ajax({
            url: ITEM.API.get,
            type: 'get',
            data: {
                'stock_id': stock_id
            },
            success: function(data) {
                if (data.state) {
                    var item = data.item;
                    var table_body = $("#list-products > tbody");
                    var tr = $("<tr>").attr("item-id",item.stock_id);
                    $("<td>").html(item.stock_id).appendTo(tr);
                    $("<td>").html('<img src="' + SITE_URL + '/public/uploads/itemPic/' + item.item_image + '" width="80px" height="80px">').appendTo(tr);
                    $("<td>").html(item.description).appendTo(tr);
                    $("<td>").html('<span class="glyphicon glyphicon-remove text-danger removeProduct"></span>').appendTo(tr);
                    table_body.append(tr);
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

                    $("<li>").attr('item-id', item.stock_id).addClass('search-result').html('<img src="' + SITE_URL + '/public/uploads/itemPic/' + item.item_image + '">' + '<span class="pull-right">' + item.description + '</span>').appendTo(ul);
                    //$("<li>").attr('item-id',item.stock_id).addClass('search-result').html('<img src="' + SITE_URL + '/uploads/itemPic/' + item.item_image + '">'+'<span class="pull-right">'+item.description+'</span>').appendTo(ul);
                });
                $("#livesearch").html(ul);

            }
        },
        timeout: 5000
    });
}
function getAllProductList(){
    var rows = $("#list-products tbody").find('tr');
    var list = "";
    $.each(rows, function(i, row){
        list = list+','+$(row).attr('item-id');
    });
    return list;
}
$(document).ready(function(){
    $(document).on('keyup', '#inp_live_search', function() {
        
                $("#livesearch").show();
                ITEM.search($(this).val());
            });
    $(document).on('click', '.search-result', function() {
                
                        var stock_id = $(this).attr('item-id');
                        $("#livesearch").hide();
                
                        var tr = $("#list-products").find("> tbody").find('tr[item-id="' + stock_id + '"]');
                        if (tr.length > 0) {
                            return 0;
                        } else {
                            ITEM.get(stock_id);
                
                        }
                
                    });
     $(document).on('focusout', '#inp_live_search', function() {
                        //     $("#livesearch").hide();
                    });
    $(document).on('click', function(event) {
                        if (!$(event.target).closest('#livesearch').length) {
                            if ($('#livesearch').is(":visible")) {
                                $('#livesearch').hide();
                            }
                        }
                    });
    $(document).on('click','.removeProduct', function(){
        $(this).closest('tr').remove();
    });
    $("#addGroupedProduct").submit(function(e){
    
        $("#hiddenProductList").val(getAllProductList());
        $("form#addGroupedProduct").submit();
        return true;
    })
});