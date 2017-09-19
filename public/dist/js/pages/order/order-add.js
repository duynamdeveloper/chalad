/* Bootbox Script */




/* Define Object */

var CUSTOMER = {};
var ITEM = {};
var ORDER = {};

ORDER = {
    API: {
        getShippingCost: SITE_URL + '/order/shipping-cost',
        save: SITE_URL + '/order/save',
        update: SITE_URL + '/order/update',
        update_status: SITE_URL + '/order/update-status',
        view: SITE_URL + '/order/view-order-details/',
        delete_payment: SITE_URL + '/order/deletepayment',
        delete_multi_payment: SITE_URL + '/order/deletemultipayment',
        update_status_multi_payment: SITE_URL + '/order/update-status-multi-payment',
        update_status_payment: SITE_URL + '/order/update-status-payment',
        edit: SITE_URL + '/order/edit/',
        check_payment_state: SITE_URL + '/order/check-payment-sate',
        get: SITE_URL + '/order/ajax-get'
    }
};

ORDER.updateStatistic = function() {

    var weight = ITEM.calculateTotalWeight();
    var shipping_method = $("#sel_shipping_method").val();

    $.ajax({
        url: ORDER.API.getShippingCost,
        type: 'get',
        data: {
            'weight': weight,
            'shipping_method': shipping_method
        },
        success: function(data) {

            $("#shipping_cost").val(data.cost);
            var amounts = $("input[name=amount]");
            var sub_total = 0;
            var total = 0;
            var grand_total = 0;
            $.each(amounts, function(i, amount) {
                sub_total += parseFloat($(amount).val());
            });
            $("#subTotal").html(parseInt(sub_total));
            var tax_rate = $("#sel_tax").val();
            if (parseFloat(tax_rate) < 0) {
                tax_rate = 0;
            }
            var shipping_cost = $("#shipping_cost").val();

            var discount_amount = $("#discount_amount").val();
            discount_amount = parseFloat(discount_amount);
            if (isNaN(discount_amount)) {
                discount_amount = 0;
            }
            total = parseFloat(sub_total) + parseFloat(shipping_cost) - parseFloat(discount_amount);
            var tax_amount = total * (parseFloat(tax_rate) / 100);
            $("#tax_amount").val(tax_amount);
            grand_total = total + tax_amount;
            $("#grand_total").val(grand_total);

        }

    });


};

ORDER.updateShippingCost = function() {
    var weight = ITEM.calculateTotalWeight();
    var shipping_method = $("#sel_shipping_method").val();

    ORDER.getShippingCost(shipping_method, weight);
};
ORDER.disabledEdit = function(state) {
    changeShippingInputState(state);
    changeBillingInputState(state);
    $("#btnSaveAddress").attr('disabled', state);
    $("#submitBtn").attr('disabled', state);
    $("#cbxBillingEqualShipping").attr('disabled', state);
    $("#orderTab").find("input").attr('disabled', state);
    $("#orderTab select").attr('disabled', state);
};
ORDER.updateAmount = function(item_id) {
    var row = $("#product_table > tbody").find('tr[item-id="' + item_id + '"]');
    var qty = row.find("input[name=quantity]").val();
    var price = row.find("input.inp_price").val();
    qty = parseInt(qty);
    price = parseFloat(price);
    var amount;
    if (isNaN(qty) || isNaN(price)) {
        amount = 0;
    } else {
        amount = parseInt(qty) * parseInt(price);
    }

    row.find("input[name=amount]").val(amount);
};

ORDER.getShippingCost = function(shipping_method, weight) {
    $.ajax({
        url: ORDER.API.getShippingCost,
        type: 'get',
        data: {
            'weight': weight,
            'shipping_method': shipping_method
        },
        success: function(data) {

            $("#shipping_cost").val(data.cost);
            ORDER.updateStatistic();

        }

    });
};
ORDER.getFormData = function() {
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

ORDER.save = function() {
    var dialog = bootbox.dialog({
        title: 'Sending data',
        message: '<img src="' + SITE_URL + '/public/img/loader.gif" class="text-center">'
    });
    var customer = CUSTOMER.getFormData();
    var items = ORDER.getFormData();
    var address = ORDER.getAddress();
    address = JSON.stringify(address);
    items = JSON.stringify(items);
    customer = JSON.stringify(customer);
    var shipping_cost = $("#shipping_cost").val();
    var shipping_method = $("#sel_shipping_method").val();
    var discount_amount = $("#discount_amount").val();
    var item_tax = $("#sel_tax").val();
    var total_fee = $("#grand_total").val();
    $.ajax({
        url: ORDER.API.save,
        type: 'post',
        data: {
            'address': address,
            'customer': customer,
            'items': items,
            'shipping_cost': shipping_cost,
            'discount_amount': discount_amount,
            'item_tax': item_tax,
            'total_fee': total_fee,
            'shipping_method':shipping_method
        },
        success: function(data) {
        //   console.log(data);
            dialog.init(function() {
                dialog.find('.modal-title').html('<h4 class="text-success">Success!</h4>');
                dialog.find('.bootbox-body').html('<span class="text-center text-success" style="font-size:18px">Create Order Successfully</span><br><span style="font-size:16px">Redirecting...</span>');
                window.setTimeout(function() {
                    window.location.href = ORDER.API.edit + data.order_no;
                }, 1500);
            });
        }
    });
};
ORDER.getAddress = function() {
        var address = {};
        var different_billing = true;
        if ($("#cbxBillingEqualShipping").is(':checked')) {
            different_billing = true;
        } else {
            different_billing = false;
        }
        address = {
            shipping_name: $("#shipping_name").val(),
            shipping_street: $("#shipping_street").val(),
            shipping_city: $("#shipping_city").val(),
            shipping_state: $("#shipping_state").val(),
            shipping_zip_code: $("#shipping_zip_code").val(),
            shipping_country_id: $("#shipping_country_id").val(),
            contact_phone: $("#contact_phone").val(),
            billing_name: $("#billing_name").val(),
            billing_street: $("#billing_street").val(),
            billing_city: $("#billing_city").val(),
            billing_state: $("#billing_state").val(),
            billing_zip_code: $("#billing_zip_code").val(),
            billing_country_id: $("#billing_country_id").val(),
            different_billing_address: different_billing
        };

        return address;
    }
/* Define Customer Object */
CUSTOMER = {
    API: {
        get: SITE_URL + '/customer/ajax/get-customer',
    }
};

/* Define Item Object */

ITEM = {
    API: {
        get: SITE_URL + '/item/ajax/get-item',
        search: SITE_URL + '/order/ajax-item-search'
    }
};

ITEM.get = function(stock_id) {

    $.ajax({
        url: ITEM.API.get,
        type: 'get',
        data: {
            'stock_id': stock_id
        },
        success: function(data) {
            if (data.state) {
                ITEM.writeToTable(data.item);
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

                    $("<li>").attr('item-id', item.stock_id).addClass('search-result').html('<img src="' + SITE_URL + '/public/uploads/itemPic/' + item.item_image + '">' + '<span class="pull-right">' + item.description + '</span>').appendTo(ul);
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
    $("<td>").html(item.description).appendTo(tr);
    $("<td>").html('<input type="text" name="quantity" value="1" class="form-control text-center inp_qty">').appendTo(tr);
    $("<td>").html('<input type="text" name="price" value="' + item.special_price + '" class="form-control text-center inp_price">').appendTo(tr);
    $("<td>").html('<input type="text" name="amount" value="' + item.special_price + '" class="form-control text-center" readonly><input type="hidden" name="item_weight" value="' + item.weight + '">').appendTo(tr);
    $("<td>").html('<span class="glyphicon glyphicon-trash text-danger removebtn" item-id="' + item.stock_id + '" style="cursor:pointer; font-size:18px"></span>' + '<span class="glyphicon glyphicon-info-sign text-info infobtn" item-id="' + item.stock_id + '" style="cursor:pointer; font-size:18px"></span>').appendTo(tr);
    tbody.append(tr);
    $("#product_table > tfoot").show();
    ORDER.updateStatistic();
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


CUSTOMER.get = function(debtor_no) {
    $.ajax({
        url: CUSTOMER.API.get,
        type: 'get',
        data: {
            'debtor_no': debtor_no,
        },
        success: function(data) {
            if (data.state) {
                CUSTOMER.writeToForm(data.customer);
            } else {
                $(".customer-form").prop('disabled', false);
            }

        }
    });
};
CUSTOMER.writeToForm = function(customer) {
    console.log(customer);
    $("#inp_customer_name").val(customer.name);
    $("#inp_customer_phone").val(customer.phone);
    $("#inp_customer_email").val(customer.email);
    $("#inp_customer_channel").val(customer.channel_name);
    $("#sel_channel_id").val(customer.channel_id);
    $(".customer-form").prop('disabled', true);
    $("#shipping_name").val(customer.shipping_name);
    $("#shipping_street").val(customer.shipping_street);
    $("#shipping_city").val(customer.shipping_city);
    $("#shipping_state").val(customer.shipping_state);
    $("#shipping_zip_code").val(customer.shipping_zip_code);
    $("#shipping_country_id").val(customer.shipping_country_id);
    $("#contact_phone").val(customer.contact_phone);
    $("#billing_name").val(customer.billing_name);
    $("#billing_street").val(customer.billing_street);
    $("#billing_city").val(customer.billing_city);
    $("#billing_state").val(customer.billing_state);
    $("#billing_zip_code").val(customer.billing_zip_code);
    $("#billing_country_id").val(customer.billing_country_id);
    if(customer.different_billing_address==1){
        $("#cbxBillingEqualShipping").prop('checked',true);
        $("#billing_form").show();
    }else{
        $("#cbxBillingEqualShipping").prop('checked',false);
        $("#billing_form").hide();
    }
};
CUSTOMER.getFormData = function() {
    var customer = {
        id: $("#sel_customer").val(),
        name: $("#inp_customer_name").val(),
        phone: $("#inp_customer_phone").val(),
        email: $("#inp_customer_email").val(),
        channel_name: $("#inp_customer_channel").val(),
        channel_id: $("#sel_channel_id").val(),
    };
    return customer;
};



function changeShippingInputState(state) {
    $("#shipping_name").prop('readonly', state);
    $("#shipping_street").prop('readonly', state);
    $("#shipping_city").prop('readonly', state);
    $("#shipping_state").prop('readonly', state);
    $("#shipping_zip_code").prop('readonly', state);
    $("#shipping_country_id").attr('disabled', state);
    $("#contact_phone").attr('disabled', state);
    $(".next").attr('disabled', state);
}
/**
 * Change billing input state
 **/

function changeBillingInputState(state) {
    $("#billing_name").prop('readonly', state);
    $("#billing_street").prop('readonly', state);
    $("#billing_city").prop('readonly', state);
    $("#billing_state").prop('readonly', state);
    $("#billing_zip_code").prop('readonly', state);

    $("#billing_country_id").attr('disabled', state);
    $("#hidden_billing_country_id").attr('disabled', !state);

}

function checkAddressForm() {
    var state = false;
    var someEmpty = $('#orderForm input').filter(function() {
        return ($.trim(this.value).length === 0 && $(this).parent().parent().parent().is(':visible'));
    }).length > 0;
    return someEmpty;


}
/* Action on events */
$(document).ready(function() {

    $("form")[0].reset();
    $(document).on('click', '.search-result', function() {

        var stock_id = $(this).attr('item-id');
        $("#livesearch").hide();

        var tr = $("#product_table").find("> tbody").find('tr[item-id="' + stock_id + '"]');
        if (tr.length > 0) {
            var qty = tr.find('input[name=quantity]').val();
            tr.find('input[name=quantity]').val(++qty);
        } else {
            ITEM.get(stock_id);

        }

    });
    $(document).on('click', '#cbxBillingEqualShipping', function() {
        if ($(this).is(':checked')) {
            $("#billing_form").show();
        } else {
            $("#billing_form").hide();
        }
    });
    $(document).on('click', '.infobtn', function() {
        var stock_id = $(this).attr('item-id');
        ITEM.getInfo(stock_id);
    });
    $(document).on('keyup', '#inp_live_search', function() {

        $("#livesearch").show();
        ITEM.search($(this).val());
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
    $("#sel_customer").change(function() {
        var debtor_no = $(this).val();
        CUSTOMER.get(debtor_no);
    });

    $("#sel_product").change(function() {
        var stock_id = $(this).val();
        $('#sel_product option[value="' + stock_id + '"]').remove();
        ITEM.get(stock_id);

        //ITEM.writeToTable(item);
    });


    $(document).on('keyup', '.inp_qty', function() {
        var item_id = $(this).closest('tr').attr('item-id');
        ORDER.updateAmount(item_id);
        ORDER.updateStatistic();
    });

    $(document).on('keyup', '.inp_price', function() {
        var item_id = $(this).closest('tr').attr('item-id');
        ORDER.updateAmount(item_id);
        ORDER.updateStatistic();
    });

    $(document).on('keyup', '#discount_amount', function() {
        ORDER.updateStatistic();
    });

    $(document).on('change', '#sel_shipping_method', function() {
        ORDER.updateStatistic();
    });

    $("#sel_tax").change(function() {
        ORDER.updateStatistic();
    });

    $(document).on('click', '.removebtn', function() {
        var stock_id = $(this).attr('item-id');

        var stock_name = $(this).closest('tr').find('td:first').html();
        $("#sel_product").append('<option value="' + stock_id + '">' + stock_name + '</option>');
        $(this).closest('tr').remove();
        $('#sel_product option[value="' + stock_id + '"]').show();
        ORDER.updateStatistic();
    });

    $(document).on('click', '#btnSaveOrder', function() {
        ORDER.save();
    });
});