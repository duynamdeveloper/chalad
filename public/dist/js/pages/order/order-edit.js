/* Define Object */
"use strict";

/* Bootbox Script */




/* Define Object */

var CUSTOMER = {};
var ITEM = {};
var ORDER = {};
var PAYMENT = {};
var PAGE = {};
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
        check_payment_state: SITE_URL + '/order/check-payment-sate',
    }
};

ORDER.updateStatistic = function() {
    ORDER.updateShippingCost();
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

};
ORDER.updateStatus = function(status) {
    $.ajax({
        url: ORDER.API.update_status,
        type: 'post',
        data: {
            order_no: order_no,
            status: status
        },
        success: function(data) {
            if (data.state) {
                PAGE.notify("Update status successfully!");
                location.reload();
            }
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
ORDER.checkPaymentState = function() {

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
            name: $(row).find('td:first').html()
        };
        itemArray.push(item);

    });
    return itemArray;

};

ORDER.save = function() {

    var dialog = bootbox.dialog({
        title: 'Sending data',
        message: '<img src="' + SITE_URL + '/img/loader.gif" class="text-center">'
    });
    var items = ORDER.getFormData();
    items = JSON.stringify(items);

    var shipping_cost = $("#shipping_cost").val();
    var discount_amount = $("#discount_amount").val();
    var item_tax = $("#sel_tax").val();
    var total_fee = $("#grand_total").val();
    console.log(item_tax);
    $.ajax({
        url: ORDER.API.update,
        type: 'post',
        data: {
            'items': items,
            'shipping_cost': shipping_cost,
            'discount_amount': discount_amount,
            'item_tax': item_tax,
            'total_fee': total_fee,
            'order_no': order_no,
        },
        success: function(data) {
            dialog.init(function() {
                dialog.find('.modal-title').html('<h4 class="text-success">Success!</h4>');
                dialog.find('.bootbox-body').html('<span class="text-center text-success" style="font-size:18px">Create Order Successfully</span><br><span style="font-size:16px">Redirecting...</span>');
                window.setTimeout(function() {
                    window.location.href = ORDER.API.view + data.order_no;
                }, 3000);
            });
        }
    });
};

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

ITEM.writeToTable = function(item) {
    var tbody = $("#product_table > tbody");
    var tr = $("<tr>").addClass("item-row").attr("item-id", item.stock_id);
    $("<td>").html(item.description).appendTo(tr);
    $("<td>").html('<img src="' + SITE_URL + '/uploads/itemPic/' + item.item_image + '" width="80px" height="80px">').appendTo(tr);
    $("<td>").html(item.stock_on_hand).appendTo(tr);
    $("<td>").html('<input type="text" name="quantity" value="1" class="form-control text-center inp_qty">').appendTo(tr);
    $("<td>").html('<input type="text" name="price" value="' + item.special_price + '" class="form-control text-center inp_price">').appendTo(tr);
    $("<td>").html('<input type="text" name="amount" value="' + item.special_price + '" class="form-control text-center" readonly><input type="hidden" name="item_weight" value="' + item.weight + '">').appendTo(tr);
    $("<td>").html('<span class="glyphicon glyphicon-trash text-danger removebtn" item-id="' + item.stock_id + '" style="cursor:pointer; font-size:18px"></span>').appendTo(tr);
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
    $("#inp_customer_name").val(customer.name);
    $("#inp_customer_phone").val(customer.phone);
    $("#inp_customer_email").val(customer.email);
    $("#inp_customer_channel").val(customer.channel_name);
    $("#sel_channel_id").val(customer.channel_id);
    $(".customer-form").prop('disabled', true);
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
PAYMENT.delete = function(payment_id) {
    $.ajax({
        url: ORDER.API.delete_payment,
        type: 'post',
        data: {
            'payment_id': payment_id
        },
        success: function(data) {
            $("#paymentTable").find('tr[payment-id="' + payment_id + '"]').fadeOut(1000, function () {
                $(this).remove();
            });
            PAGE.notify('Delete payment successfully');
        }
    });
};
PAYMENT.multiDelete = function(list) {
    var list = PAYMENT.getCheckedList();
    if (list.length > 0) {
        $.ajax({
            url: ORDER.API.delete_multi_payment,
            type: 'post',
            data: {
                'list': list
            },
            success: function(data) {
                if (data.state) {
                    PAGE.notify('Delete ' + data.number + ' payment(s) successfully!');
                }
                $.each(list, function(i, payment_id) {
                    $("#paymentTable").find('tr[payment-id="' + payment_id + '"]').fadeOut(1000, function() { $(this).remove(); });
                });
            }
        });
    } else {
        PAGE.notify("Please at least one payment", 'warning');
    }

};
PAYMENT.updateMultiStatus = function(status) {
    var list = PAYMENT.getCheckedList();
    if (list.length > 0) {
        $.ajax({
            url: ORDER.API.update_status_multi_payment,
            type: 'post',
            data: {
                'list': list,
                'state': status
            },
            success: function(data) {
                if (data.state) {
                    PAGE.notify('Update ' + data.number + ' payment(s) status successfully!');
                    location.reload();
                } else {
                    PAGE.notify('Something went wrong! Cannot update the payments', 'danger');
                }

            }
        });
    } else {
        PAGE.notify("Please at least one payment", 'warning');
    }
};
PAYMENT.updateStatus = function(payment_id, status) {


    $.ajax({
        url: ORDER.API.update_status_payment,
        type: 'post',
        data: {
            'payment_id': payment_id,
            'state': status
        },
        success: function(data) {
            if (data.state) {
                PAGE.notify('Update payment status successfully!');
                location.reload();
            } else {
                PAGE.notify('Something went wrong! Cannot update the payment', 'danger');
            }

        }
    });

};
PAYMENT.getCheckedList = function() {
    var checkboxes = $("#paymentTable > tbody").find(':checkbox');
    var data = [];
    $.each(checkboxes, function(i, checkbox) {
        if ($(checkbox).is(':checked')) {
            data.push($(checkbox).val());
        }
    });
    return data;
};
PAGE.notify = function(msg, type = 'success') {
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

/* Action on events */
$(document).ready(function() {
    if (exist_shipments > 0 || order_status === 1) {
        ORDER.disabledEdit(true);
    }
    ORDER.updateStatistic();
    $("#sel_product").change(function() {
        var stock_id = $(this).val();
        var tr = $("#product_table").find("> tbody").find('tr[item-id="' + stock_id + '"]');
        if (tr.length > 0) {
            var qty = tr.find('input[name=quantity]').val();
            tr.find('input[name=quantity]').val(++qty);
        } else {
            ITEM.get(stock_id);

        }
        $('#sel_product option[value="' + stock_id + '"]').remove();



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
        $('#sel_product').find('option[value="' + stock_id + '"]').show();
        ORDER.updateStatistic();
    });

    $(document).on('click', '#submitBtn', function() {
        ORDER.save();
    });
    $(document).on('click', '.delete_payment', function() {
        if (confirm("Are you sure to delete this payment?")) {
            PAYMENT.delete($(this).attr('payment-id'));
        }

    });
    $('#payment_date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: DATE_FORMAT_TYPE
    });
    $(document).on('click', '#cb-check-all', function() {
        var checkboxes = $("#paymentTable > tbody").find(':checkbox');
        if ($(this).is(':checked')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });
    $(document).on('click', '#deleteMultiPayment', function() {
        PAYMENT.multiDelete();
    });
    $(document).on('click', '#pendingMultiPayment', function() {
        if (confirm("Are you sure?")) {
            PAYMENT.updateMultiStatus(0);
        }

    });
    $(document).on('click', '#confirmMultiPayment', function() {
        if (confirm("Are you sure?")) {
            PAYMENT.updateMultiStatus(1);
        }
    });
    $(document).on('click', '.pending_payment', function() {
        var payment_id = $(this).attr('payment-id');
        var status = 0;
        PAYMENT.updateStatus(payment_id, status);
    });
    $(document).on('click', '.confirm_payment', function() {
        var payment_id = $(this).attr('payment-id');
        var status = 1;
        PAYMENT.updateStatus(payment_id, status);
    });
    $(document).on('click', '.edit_payment', function() {
        var payment_id = $(this).attr('payment-id');
        var payment_type = $(this).closest('tr').find('td:nth-child(4)').html();
        var date = $(this).closest('tr').find('td:nth-child(3)').html();
        var amount = $(this).closest('tr').find('td:nth-child(6)').html();
        $("#inp_payment_id").val(payment_id);
        $("#payment_type_id").val(payment_type);
        $("#payment_amount").val(amount);
        $("#payment_date").val(date);
        $("#editPaymentModal").modal('show');
    });
    $(document).on('click', '#pending_status_btn', function(e) {
        e.preventDefault();
        ORDER.updateStatus(2);
    });
    $(document).on('click', '#cancel_status_btn', function(e) {
        e.preventDefault();
        ORDER.updateStatus(0);
    });
    $(document).on('click', '#confirm_status_btn', function(e) {
        e.preventDefault();
        if (exist_payments > 0) {
            if (confirm(" Are you sure you want to confirm order? There is still payment due")) {
                ORDER.updateStatus(1);
            }
        }else{
            ORDER.updateStatus(1);
        }
    });
    $(document).on('click', '#confirm_create_shipment', function() {
        if (exist_payments > 0) {
            if (confirm(" Are you sure you want to confirm order? There is still payment due")) {
                ORDER.updateStatus(1);
                SHIPMENT.automatic_allocate(order_no);
                $('.tab-content div.active').removeClass('active');

                $("#navTab li.active").removeClass('active');
                $('a[href="#shipmentTab"]').closest('li').addClass('active');
                $("#shipmentTab").addClass('active in').show();
            }
        } else {
            ORDER.updateStatus(1);
            SHIPMENT.automatic_allocate(order_no);
            $('.tab-content div.active').removeClass('active');

            $("#navTab li.active").removeClass('active');
            $('a[href="#shipmentTab"]').closest('li').addClass('active');
            $("#shipmentTab").addClass('active in').show();
        }
    });
});




/* Action on events */

$("#cbxBillingEqualShipping").change(function() {

    if (this.checked) {
        $("#billing_country_id").val($("#shipping_country_id").val()).trigger('change');
        $("#billing_name").val($("#shipping_name").val());
        $("#billing_street").val($("#shipping_street").val());
        $("#billing_city").val($("#shipping_city").val());
        $("#billing_state").val($("#shipping_state").val());
        $("#billing_zip_code").val($("#shipping_zip_code").val());
        $("#hidden_billing_country_id").val($("#shipping_country_id").val());
        changeBillingInputState(true);

    } else {
        changeBillingInputState(false);
    }

});



function changeShippingInputState(state) {
    $("#shipping_name").prop('readonly', state);
    $("#shipping_street").prop('readonly', state);
    $("#shipping_city").prop('readonly', state);
    $("#shipping_state").prop('readonly', state);
    $("#shipping_zip_code").prop('readonly', state);
    $("#shipping_country_id").attr('disabled', state);
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