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
                    $("<td>").html(item.name).appendTo(tr);
                    $("<td>").html('<input type="text" class="form-control inp_item_qty text-center" name="item_quantity" value="1">').appendTo(tr);
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

                    $("<li>").attr('item-id', item.stock_id).addClass('search-result').html('<img src="' + SITE_URL + '/public/uploads/itemPic/' + item.item_image + '">' + '<span class="pull-right">' + item.name + '</span>').appendTo(ul);
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
        list = list+$(row).attr('item-id')+'&'+$(row).find('input[name="item_quantity"]').val()+'|';
    });
    console.log(list);
    return list;
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#simpleProductForm_imagePreview').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
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
                                console.log(getAllProductList());
                            }
                            
                        }
                    });
    $(document).on('click','.removeProduct', function(){
        $(this).closest('tr').remove();
    });
    $("#addProductForm").submit(function(e){
    
        $("#hiddenProductList").val(getAllProductList());
        $("form#addProductForm").submit();
        return true;
    });
    $("#simpleProductForm_itemImage").change(function(){
        readURL(this);
        $('#simpleProductForm_imageName').html(this.files && this.files.length ? this.files[0].name : '');
    });
    $('#addProductForm input[name=item_type]').on('change', function() {
       var item_type = $('input[name=item_type]:checked', '#addProductForm').val();
       if(item_type==1){
           $("#simple_product_group").show();
           $("#grouped_product_group").hide();
       }else if(item_type==2){
        $("#simple_product_group").hide();
        $("#grouped_product_group").show();
       }
 
     });
});




