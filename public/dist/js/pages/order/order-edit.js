"use strict";

/* Bootbox Script */

var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating;


/* Define Object */


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
                ORDER.getStatus();
            }
        }
    });
};
ORDER.getStatus = function() {
    $.ajax({
        url: ORDER.API.get,
        type: 'get',
        data: {
            'order_no': order_no
        },
        success: function(received) {
            console.log(received);
            if (received.state) {

                $("#ship_bill_payment").html(received.ship_bill_payment);
                $("#ship_bill_shipment").html(received.ship_bill_shipment);
                $("#order_state_label").html(received.order.label_state);
                $("#order_qty_span").html(received.order.order_quantity);
                $("#ready_ship_span").html(received.order.ready_to_ship_quantity);
                $("#shipped_span").html(received.order.shipped_quantity);
                $("#pending_span").html(received.order.pending_quantity);
                if (received.order.order_status == 0) {
                    $("#cancelBtnContainer").html('<button type="button" class="btn btn-block btn-danger" id="btnRemoveCancel">Remove Cancel</button>');
                    ORDER.disabledEdit(true);
                } else if (received.order.order_status == 1) {
                    $("#cancelBtnContainer").html('<button type="button" class="btn btn-block btn-danger btnCancel" disabled data-toggle="tooltip" title="The shipment already created! Cannot cancel order">Cancel Order</button>');
                    ORDER.disabledEdit(false);
                } else {
                    $("#cancelBtnContainer").html('<button type="button" class="btn btn-block btn-danger" id="btnCancel" >Cancel Order</button>');
                    ORDER.disabledEdit(false);
                }
            }
        }
    });
}
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


    var items = ORDER.getFormData();
    var address = ORDER.getAddress();
    address = JSON.stringify(address);
    items = JSON.stringify(items);
    var shipping_method = $("#sel_shipping_method").val();
    var shipping_cost = $("#shipping_cost").val();
    var discount_amount = $("#discount_amount").val();
    var item_tax = $("#sel_tax").val();
    var total_fee = $("#grand_total").val();
    $.ajax({
        url: ORDER.API.update,
        type: 'post',
        data: {
            'address': address,
            'items': items,
            'shipping_cost': shipping_cost,
            'shipping_method':shipping_method,
            'discount_amount': discount_amount,
            'item_tax': item_tax,
            'total_fee': total_fee,
            'order_no': order_no,
        },
        success: function(data) {
            $("#order_detail_container").html(data.order_detail);
            $(".order_summary_container").html(data.order_summary);
            $("#ship_bill_payment").html(data.ship_bill_payment);
            $("#ship_bill_shipment").html(data.ship_bill_shipment);
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


PAYMENT.delete = function(payment_id) {
    $.ajax({
        url: ORDER.API.delete_payment,
        type: 'post',
        data: {
            'payment_id': payment_id
        },
        success: function(data) {
            $("#paymentTable").find('tr[payment-id="' + payment_id + '"]').fadeOut(1000, function() {
                $(this).remove();
            });
            PAGE.notify('Delete payment successfully');
        }
    });
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
                $("#paymentTable").find('tr[payment-id="' + payment_id + '"]').find('button.stateBtn').removeClass().addClass('btn stateBtn btn-' + data.payment.state_bootstrap_class).html(data.payment.state_name);
                $("#paymentTable").find('tr[payment-id="' + payment_id + '"]').find('button.dropDownBtn').removeClass().addClass('btn dropDownBtn dropdown-toggle btn-' + data.payment.state_bootstrap_class);
                ORDER.getStatus();



            } else {
                PAGE.notify('Something went wrong! Cannot update the payment', 'danger');
            }

        }
    });
    return false;

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

    if (order_status === 1 || order_status === 0) {
        ORDER.disabledEdit(true);
    }


    ORDER.updateStatistic();


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
        ORDER.updateShippingCost();
        ORDER.updateStatistic();
    });

    $("#sel_tax").change(function() {
        ORDER.updateStatistic();
    });

    $(document).on('click', '.removebtn', function() {
        var stock_id = $(this).attr('item-id');
        var stock_name = $(this).closest('tr').find('td:first').html();

        $(this).closest('tr').remove();

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
    $(document).on('click', '#cbxBillingEqualShipping', function() {
        if ($(this).is(':checked')) {
            $("#billing_form").show();
        } else {
            $("#billing_form").hide();
        }
    });
    $(document).on('click', '.pending_payment', function() {
        var payment_id = $(this).attr('payment-id');
        var status = 0;
        bootbox.confirm({
            title: "Change payment status?",
            message: "Do you want to change this payment's status?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirm'
                }
            },
            callback: function(result) {
                if (result) {
                    PAYMENT.updateStatus(payment_id, status);
                }
            }
        });

    });
    $(document).on('click', '.confirm_payment', function() {
        var payment_id = $(this).attr('payment-id');
        var status = 1;
        bootbox.confirm({
            title: "Change payment status?",
            message: "Do you want to change this payment's status?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirm'
                }
            },
            callback: function(result) {
                if (result) {
                    PAYMENT.updateStatus(payment_id, status);
                }
            }
        });

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
    $(document).on('click', '#pending_status_btn', function(e) {
        e.preventDefault();
        ORDER.updateStatus(2);
    });
    $(document).on('click', '#cancel_status_btn', function(e) {
        e.preventDefault();
        ORDER.updateStatus(0);
    });

    $(document).on('click', '.ready_to_ship_btn', function() {
        $.ajax({
            url: ORDER.API.get,
            type: 'get',
            data: {
                'order_no': order_no,
            },
            success: function(data) {
                var exist_payments = data.order.payment_due;
                if (exist_payments > 0) {
                    bootbox.dialog({
                        title: 'Alert',
                        message: 'Please finalize payment before proceeding to ready to ship'
                    });

                } else {
                    bootbox.confirm({
                        title: "Ready to ship?",
                        message: "Confirm you are ready to ship?",
                        buttons: {
                            cancel: {
                                label: '<i class="fa fa-times"></i> Cancel'
                            },
                            confirm: {
                                label: '<i class="fa fa-check"></i> Confirm'
                            }
                        },
                        callback: function(result) {
                            if (result) {
                                ORDER.updateStatus(1);
                                SHIPMENT.automatic_allocate(order_no);
                                nextToShipment();
                            }
                        }
                    });

                }
            }
        });

    });


    $(document).on('click', '.infobtn', function() {
        var stock_id = $(this).attr('item-id');
        ITEM.getInfo(stock_id);
    });
    $(document).on('click', '#btnSaveOrder', function() {
        if (!checkAddressForm()) {
            nextToPayment();
            ORDER.save();
        } else {
            PAGE.notify("Please fill out all inputs", 'warning');
        }

    });
    $(document).on('click', '#btnCancel', function() {
        bootbox.confirm({
            title: "Cancel order?",
            message: "Do you want cancel this order?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirm'
                }
            },
            callback: function(result) {
                if (result) {
                    ORDER.updateStatus(0);
                }
            }
        });
    });
    $(document).on('click', '#btnRemoveCancel', function() {
        bootbox.confirm({
            title: "Remove Cancel?",
            message: "Do you want to remove cancel this order?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Cancel'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Confirm'
                }
            },
            callback: function(result) {
                if (result) {
                    ORDER.updateStatus(2);
                }
            }
        });
    });
});




/* Action on events */

// $("#cbxBillingEqualShipping").change(function() {
//
//     if (this.checked) {
//         $("#billing_country_id").val($("#shipping_country_id").val()).trigger('change');
//         $("#billing_name").val($("#shipping_name").val());
//         $("#billing_street").val($("#shipping_street").val());
//         $("#billing_city").val($("#shipping_city").val());
//         $("#billing_state").val($("#shipping_state").val());
//         $("#billing_zip_code").val($("#shipping_zip_code").val());
//         $("#hidden_billing_country_id").val($("#shipping_country_id").val());
//         changeBillingInputState(true);
//
//     } else {
//         changeBillingInputState(false);
//     }
//
// });



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

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
/* STEP FORM */


//jQuery time
//flag to prevent quick multi-click glitches
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

$(".submit").click(function() {
    return false;
})