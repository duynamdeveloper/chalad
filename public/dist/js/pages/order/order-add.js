/* Define Object */

var CUSTOMER = {};
var ITEM = {};
var ORDER = {};

ORDER.updateStatistic = function(){
    var amounts = $("input[name=amount]");
    var total = 0;
    $.each(amounts, function(i, amount){
      total += parseInt($(amount).val());
    });
    $("#subTotal").html(parseInt(total));
}


/* Define Customer Object */
CUSTOMER = {
    API:{
        get:SITE_URL+'/customer/ajax/get-customer',
    }
}

/* Define Item Object */

ITEM = {
    API: {
        get: SITE_URL+'/item/ajax/get-item',
    }
}

ITEM.get = function(stock_id){
    $.ajax({
        url: ITEM.API.get,
        type:'get',
        data:{
            'stock_id' : stock_id
        },
        success: function(data){
            if(data.state){
                ITEM.writeToTable(data.item);
            }
        }
    });
}
 
ITEM.writeToTable = function(item){
    var tbody = $("#product_table > tbody");
    var tr = $("<tr>").attr("item-id",item.stock_id);
    $("<td>").html(item.description).appendTo(tr);
    $("<td>").html('<img src="'+SITE_URL+'/public/uploads/itemPic/'+item.item_image+'" width="80px" height="80px">').appendTo(tr);
    $("<td>").html(item.stock_on_hand).appendTo(tr);
    $("<td>").html('<input type="text" name="quantity" value="1" class="form-control text-center">').appendTo(tr);
    $("<td>").html('<input type="text" name="price" value="'+item.special_price+'" class="form-control text-center">').appendTo(tr);
    $("<td>").html('<input type="text" name="amount" value="'+item.special_price+'" class="form-control text-center" readonly>').appendTo(tr);
    $("<td>").html('<span class="glyphicon glyphicon-trash text-danger removebtn" item-id="'+item.stock_id +'" style="cursor:pointer; font-size:18px"></span>').appendTo(tr);
    tbody.append(tr);
    $("#product_table > tfoot").show();
    ORDER.updateStatistic();
}

CUSTOMER.get = function(debtor_no){
    $.ajax({
        url: CUSTOMER.API.get,
        type:'get',
        data:{
            'debtor_no': debtor_no,
        },
        success: function(data){
            if(data.state){
                CUSTOMER.writeToForm(data.customer);
            }else{
                $(".customer-form").prop('disabled',false);
            }
            
        }
    });
}
CUSTOMER.writeToForm = function(customer){
    $("#inp_customer_name").val(customer.name);
    $("#inp_customer_phone").val(customer.phone);
    $("#inp_customer_email").val(customer.email);
    $("#inp_customer_channel").val(customer.channel_name);
    $("#sel_channel_id").val(customer.channel_id);
    $(".customer-form").prop('disabled',true);
}




/* Action on events */
$("#sel_customer").change(function(){
    var debtor_no = $(this).val();
    CUSTOMER.get(debtor_no);
});

$("#sel_product").change(function(){
    var stock_id = $(this).val();
    $('#sel_product option[value="'+stock_id+'"]').remove();
    ITEM.get(stock_id);
});
$(document).on('click','.removebtn', function(){
    var stock_id = $(this).attr('item-id');7
    var stock_name = $(this).closest('tr').find('td:first').html();
    $("#sel_product").append('<option value="'+stock_id+'">'+stock_name+'</option>')
    $(this).closest('tr').remove();$('#sel_product option[value="'+stock_id+'"]').show();
});


