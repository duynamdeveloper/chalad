/* Define Object */

var CUSTOMER = {};
var ITEM = {};
var ORDER = {};

ORDER = {
    API:{
        getShippingCost:SITE_URL+'/order/shipping-cost',
    }
}

ORDER.updateStatistic = function(){
    ORDER.updateShippingCost();
    var amounts = $("input[name=amount]");
    var sub_total = 0;
    var total = 0;
    var grand_total = 0;
    $.each(amounts, function(i, amount){
      sub_total += parseFloat($(amount).val());
    });
    $("#subTotal").html(parseInt(sub_total));
    var tax_rate = $("#sel_tax").val();
    var shipping_cost = $("#shipping_cost").val();
    var discount_amount = $("#discount_amount").val();
    total = parseFloat(sub_total) + parseFloat(shipping_cost) - parseFloat(discount_amount);
    var tax_amount = total*(parseFloat(tax_rate)/100);
    $("#tax_amount").val(tax_amount);
    grand_total = total+tax_amount;
    $("#grand_total").val(grand_total);
    
}

ORDER.updateShippingCost = function(){
    var weight = ITEM.calculateTotalWeight();
    var shipping_method = $("#sel_shipping_method").val();
    ORDER.getShippingCost(shipping_method,weight);
}

ORDER.updateAmount = function(item_id){
    var row = $("#product_table > tbody").find('tr[item-id="'+item_id+'"]');
    var qty = row.find("input[name=quantity]").val();
    var price =row.find("input.inp_price").val();
    var amount = parseInt(qty)*parseInt(price);
    row.find("input[name=amount]").val(amount);
}

ORDER.getShippingCost = function(shipping_method, weight){
    $.ajax({
        url: ORDER.API.getShippingCost,
        type:'get',
        data:{
            'weight':weight,
            'shipping_method': shipping_method
        },
        success: function(data){
            $("#shipping_cost").val(data.cost);
        }

    });
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
            return false;
        },
        complete: function(){

        }
    });
}
 
ITEM.writeToTable = function(item){
    var tbody = $("#product_table > tbody");
    var tr = $("<tr>").addClass("item-row").attr("item-id",item.stock_id);
    $("<td>").html(item.description).appendTo(tr);
    $("<td>").html('<img src="'+SITE_URL+'/public/uploads/itemPic/'+item.item_image+'" width="80px" height="80px">').appendTo(tr);
    $("<td>").html(item.stock_on_hand).appendTo(tr);
    $("<td>").html('<input type="text" name="quantity" value="1" class="form-control text-center inp_qty">').appendTo(tr);
    $("<td>").html('<input type="text" name="price" value="'+item.special_price+'" class="form-control text-center inp_price">').appendTo(tr);
    $("<td>").html('<input type="text" name="amount" value="'+item.special_price+'" class="form-control text-center" readonly><input type="hidden" name="item_weight" value="'+item.weight+'">').appendTo(tr);
    $("<td>").html('<span class="glyphicon glyphicon-trash text-danger removebtn" item-id="'+item.stock_id +'" style="cursor:pointer; font-size:18px"></span>').appendTo(tr);
    tbody.append(tr);
    $("#product_table > tfoot").show();
    ORDER.updateStatistic();
}

ITEM.calculateTotalWeight = function(){
    var rows = $("#product_table >tbody").find("tr.item-row");
    var total_weight = 0;
    $.each(rows, function(i, row){   
        var qty = $(row).find("input[name=quantity]").val();
        var weight =$(row).find("input[name=item_weight]").val();
        total_weight += parseInt(qty)*parseInt(weight);
    });
    return total_weight;
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
    
    //ITEM.writeToTable(item);
});

$(".inp_qty").keyup(function(){
    alert($(this).val());
});

$(document).on('keyup','.inp_qty', function(){
    var item_id = $(this).closest('tr').attr('item-id');
    ORDER.updateAmount(item_id);
    ORDER.updateStatistic();
});

$(document).on('keyup','.inp_price',function(){
    var item_id = $(this).closest('tr').attr('item-id');
    ORDER.updateAmount(item_id);
    ORDER.updateStatistic();
});

$(document).on('change','#sel_shipping_method',function(){
   ORDER.updateStatistic();
});

$("#sel_tax").change(function(){
    ORDER.updateStatistic();
});

$(document).on('click','.removebtn', function(){
    var stock_id = $(this).attr('item-id');7
    var stock_name = $(this).closest('tr').find('td:first').html();
    $("#sel_product").append('<option value="'+stock_id+'">'+stock_name+'</option>')
    $(this).closest('tr').remove();$('#sel_product option[value="'+stock_id+'"]').show();
    ORDER.updateStatistic();
});


