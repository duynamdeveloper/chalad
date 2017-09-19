$(document).ready(function() {
    $(".select2").select2();

    SHIPMENT.get(order_no);

});


$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

var SHIPMENT = {};

var shipmentTable = $("#shipmentTable");
var shipment_tbody = $("#shipmentTable tbody");
var MSG = {
    shipment_not_found: "NO SHIPMENT FOUND!",
}

SHIPMENT = {
    API: {
        get: SITE_URL + '/shipment/get-shipment-detail',
        automactic_allocate: SITE_URL + '/shipment/automatic-allocate',
        manual_allocate: SITE_URL + '/shipment/manual-allocate',
        validate_addtional_quantity: SITE_URL + '/shipment/validate-additional-quantity',
        add_tracking_number: SITE_URL + '/shipment/add-tracking',
        manual_get_exist_shipment: SITE_URL + '/shipment/manual-get-data',
        remove_shipment: SITE_URL + '/shipment/remove-shipment',
        edit_shipment: SITE_URL + '/shipment/edit-shipment'
    }
}

SHIPMENT.get = function(order_no) {
    $(".manually_allocate_td").hide();
    shipment_tbody.html('<tr><td colspan="8" class="text-center text-danger">Loading...</td></tr>')
    $.ajax({
        url: SHIPMENT.API.get,
        type: 'get',
        data: {
            'order_no': order_no,
        },
        success: function(data) {
            //console.log(order_no);
            if (data.shipments !== null) {
                SHIPMENT.writeToTable(data.shipments);
                ORDER.getStatus();
            } else {

                shipmentTable.children('tbody').html('<tr><td colspan="8" class="text-center"><h4 class="text-danger">' + MSG.shipment_not_found + '</h4></td></tr>');
            }
            return data.state;
            //console.log(data);
        }
    });
}
SHIPMENT.writeToTable = function(data) {
    shipment_tbody.html("");
    shipment_tbody.hide();
    var title_row = "<tr>" +
        "<td><strong>Stock ID</strong></td>" +
        "<td><strong>Description</strong></td>" +
        "<td><strong>Stock on hand</strong></td>" +
        "<td><strong>Order Quantity</strong></td>" +
        "<td><strong>Quantity</strong></td>" +
        "</tr>";
    //console.log(data.details);
    $.each(data.shipments, function(index, shipment) {
        var tr = $("<tr>");
        if (shipment.tracking_number == null) {
            shipment.tracking_number = "";
            var state_label = '<span class=\"label label-info\">Ready to ship</span>';
            shipment.shipping_method = -1;
        } else {
            var state_label = '<span class="label label-success">Shipped</span>';
        }
        var btn_group = $("<div>").addClass('btn-group');
        $('<td>').html("SHIPMENT NO:" + shipment.id).css('font-weight', 'bold').appendTo(tr);

        $('<td>').html('Tracking Number: ' + shipment.tracking_number).attr('colspan', 2).appendTo(tr);
        $('<td>').html('<strong>Status:</strong>' + state_label).appendTo(tr);
        var remove_btn = '<button class="btn btn-danger deleteShipment" shipment-id="' + shipment.id + '">Delete</button>';
        var edit_btn = '<button class="btn btn-info editShipment" shipment-id="' + shipment.id + '">Edit</button>';
        if (shipment.tracking_number == "") {
            btn_group.append('<button class="btn btn-success btnEditTracking" shipment-id="' + shipment.id + '">Tracking</button>' + remove_btn + edit_btn);
            $('<td>').append(btn_group).addClass("text-right").attr('colspan', 2).appendTo(tr);
        } else {
            btn_group.append('<button class="btn btn-primary btnEditTracking" shipment-id="' + shipment.id + '" data-tracking-number="' + shipment.tracking_number + '" shipping-method="' + shipment.shipping_method + '">Tracking</button>' + remove_btn);
            $('<td>').append(btn_group).addClass("text-right").attr('colspan', 2).appendTo(tr);
        }


        shipment_tbody.append(tr);
        shipment_tbody.append(title_row);
        $.each(shipment.details, function(index, detail) {

            var tr = $("<tr>").attr('shipment-detail-id', detail.id).attr('shipment-id', shipment.id);

            var span = "";

            $('<td>').html(detail.stock_id).appendTo(tr);
            $('<td>').html(detail.item.description).appendTo(tr);
            $('<td>').html(detail.item.stock_on_hand).appendTo(tr);
            $('<td>').html(detail.item.order_qty).appendTo(tr);
            $('<td>').html('<input type="number" name="packed_qty" value="' + detail.quantity + '" class="form-control" readonly>').appendTo(tr);




            shipment_tbody.append(tr);

        });
        shipment_tbody.append('<tr class="saveBtnRow" hidden shipment-id="' + shipment.id + '"><td colspan="8" class="text-right"><button class="btn btn-primary saveEditShipment" btn-shipment-id="' + shipment.id + '">Save</button></td></tr>');


        //$("#manualAllocateTable tbody").append(tr);
    });
    shipment_tbody.fadeIn('slow');
}

SHIPMENT.automatic_allocate = function(order_no) {
    $.ajax({
        url: SHIPMENT.API.automactic_allocate,
        type: 'get',
        data: {
            'order_no': order_no
        },
        success: function(data) {
            // console.log(data);
            SHIPMENT.get(order_no);
            SHIPMENT.notify("Automatic allocate success!");
            ORDER.getStatus();
        }
    });
}
SHIPMENT.edit_shipment = function(shipment_id) {
    var data = SHIPMENT.getEditShipmentDataFromTable(shipment_id);
    $.ajax({
        url: SHIPMENT.API.edit_shipment,
        type: 'get',
        dataType: 'json',
        data: {
            shipment_id: shipment_id,
            order_no: order_no,
            data: JSON.stringify(data)
        },
        success: function(data) {
            SHIPMENT.get(order_no);
            SHIPMENT.notify("Update success!");
            ORDER.getStatus();
        }
    });
}
SHIPMENT.manual_allocate = function(shipment_id, order_no) {
    //var order_no = $("#selOrder").val();
    //console.log(SHIPMENT.getManualAllocateDataFromTable(shipment_id));
    $.ajax({
        url: SHIPMENT.API.manual_allocate,
        type: 'get',
        data: {
            'shipment_id': shipment_id,
            'order_no': order_no,
            'data': SHIPMENT.getManualAllocateDataFromTable(shipment_id)
        },
        success: function(data) {
            //  console.log(data);
            SHIPMENT.get(order_no);
            SHIPMENT.notify("Manual Allocate Success");
        }
    });
}
SHIPMENT.getManualAllocateDataFromTable = function(shipmentId) {
    var rows = $('tr[shipment-id="' + shipmentId + '"]').not(':last');
    var data = [];
    $.each(rows, function(index, row) {
        var stock_id = $(this).find('td:first-child').html();
        var shipment_detail_id = $(this).attr('shipment-detail-id');
        var additional_packing = $(this).find('input.packed_qty').val();
        var item = [stock_id, additional_packing, shipment_detail_id];
        data.push(item);
    });

    return data;
}
SHIPMENT.getEditShipmentDataFromTable = function(shipment_id) {
    var rows = $('tr[shipment-id="' + shipment_id + '"]').not(':last');

    var data = [];
    $.each(rows, function(index, row) {
        var item = {
            stock_id: $(this).find('td:first-child').html(),
            shipment_detail_id: $(this).attr('shipment-detail-id'),
            packed_qty: $(this).find('input[name=packed_qty]').val(),
            //shipped_qty : $(this).find('input[name=shipped_qty]').val()
        }

        data.push(item);
    });

    return data;
}


SHIPMENT.notify = function(msg, type = 'success') {
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
}

SHIPMENT.validateAdditionalQuantity = function(order_no, stock_id) {
    $.ajax({
        url: SHIPMENT.API.validate_addtional_quantity,
        type: 'get',
        data: {
            'order_no': order_no,
            'stock_id': stock_id
        },
        error: function(xhr, status, error) {
            var err = JSON.parse(xhr.responseText);

        },
        success: function(data) {
            return data;
        }

    });
}
SHIPMENT.addTracking = function(shipment_id, tracking_number, shipping_method) {
    $.ajax({
        url: SHIPMENT.API.add_tracking_number,
        type: 'get',
        data: {
            'shipment_id': shipment_id,
            'tracking_number': tracking_number,
            'shipping_method': shipping_method
        },
        success: function(data) {
            SHIPMENT.notify('Tracking number updated!');
            SHIPMENT.get(order_no);
            ORDER.getStatus();
        }
    });
}
SHIPMENT.add_new_shipment_control = function(data) {
    var tr = $("<tr>").addClass('newShipmentRow');

    $('<td>').html("NEW SHIPMENT").attr('rowspan', data.length + 1).css('vertical-align', 'middle').css('font-weight', 'bold').css('background-color', 'rgba(22,22,22,0.5)').css('color', '#fff').appendTo(tr);

    shipment_tbody.append(tr);
    $.each(data, function(index, detail) {



        var tr = $("<tr>").attr('shipment-detail-id', -1).attr('shipment-id', -1).addClass('newShipmentRow');
        // $('<td>').html('').appendTo(tr);
        //console.log(detail);
        $('<td>').html(detail.stock_id).appendTo(tr);
        $('<td>').html(detail.description).appendTo(tr);
        $('<td>').html(detail.stock_qty).appendTo(tr);
        $('<td>').html(detail.quantity).appendTo(tr);
        $('<td>').html('<input type="number" name="packed_qty" value="0" class="form-control">').appendTo(tr);





        shipment_tbody.append(tr);

    });
    shipment_tbody.append('<tr class="saveBtnRow newShipmentRow" shipment-id="-1" hidden><td colspan="7" class="text-right"><button class="btn btn-primary saveManualAllocate" btn-shipment-id="-1">Save</button><button class="btn btn-danger btnHideNewShipmentControl">Cancel</button></td></tr>');
}
SHIPMENT.delete_shipment = function(shipment_id) {
    $.ajax({
        url: SHIPMENT.API.remove_shipment,
        type: 'get',
        data: {
            shipment_id: shipment_id
        },
        success: function(data) {
            if (data.state) {
                SHIPMENT.notify("Delete success");
                SHIPMENT.get(order_no);
                ORDER.getStatus();
                location.reload();
            } else {
                SHIPMENT.notify("Something went wrong, please contact administrator", "danger");
            }
        }
    });
}



$("#selOrder").change(function(event) {


    SHIPMENT.get($(this).val());
    $(".manually_allocate_td").hide();
});
$(".btnAddTracking").click(function() {
    $shipment_id = $(this).attr('shipment-id');
    //console.log(shipment_id);

    $("#addTrackingModal modal-title").html('Add Tracking Number for Shipment No #' + shipment_id);
    $("#addTrackingModal").modal('show');

});
$("#addShipmentManuallyBtn").click(function(event) {
    $(".newShipmentRow").hide();
    $(".saveBtnRow").hide();
    $("input[name=packed_qty]").attr('readonly', true);
    /* Act on the event */
    $.ajax({
        url: SHIPMENT.API.manual_get_exist_shipment,
        type: 'get',
        data: {
            'order_no': order_no,
        },
        success: function(data) {


            SHIPMENT.add_new_shipment_control(data.data);
            $(".manually_allocate_td").show();
            $(".saveBtnRow").show();

        }
    });

    //$(".additional_packing").show();
});
$(document).on('click', '.saveEditShipment', function() {
    var shipment_id = $(this).attr('btn-shipment-id');
    SHIPMENT.edit_shipment(shipment_id);
});
$(document).on('click', '.btnHideNewShipmentControl', function() {
    $(".newShipmentRow").remove();
});
$(document).on('click', '.editShipment', function() {
    var shipment_id = $(this).attr('shipment-id');
    $(".saveBtnRow").hide();
    $(".newShipmentRow").hide();
    $('tr[shipment-id="' + shipment_id + '"].saveBtnRow').show();
    $('tr[shipment-id="' + shipment_id + '"] td input[name=packed_qty]').attr('readonly', false);
});
$(document).on('click', '.btnAddTracking', function() {
    shipment_id = $(this).attr('shipment-id');
    $("#inputShipmentId").val(shipment_id);
    $("#addTrackingModal .modal-title").html('Add Tracking Number for Shipment No #' + shipment_id);
    $("#addTrackingModal").modal('show');
});
$(document).on('click', '.btnEditTracking', function() {
    var shipment_id = $(this).attr('shipment-id');
    var tracking_number = $(this).attr('data-tracking-number');
    //(shipment_id);
    $("#inputShipmentId").val(shipment_id);
    $("#inputTrackingNumber").val(tracking_number);
    $("#selShippingMethod").val($(this).attr('shipping-method'));
    $("#addTrackingModal .modal-title").html('Add Tracking Number for Shipment No #' + shipment_id);
    $("#addTrackingModal").modal('show');
});
$(document).on('click', '.saveManualAllocate', function() {
    var shipment_id = $(this).attr('btn-shipment-id');

    SHIPMENT.manual_allocate(shipment_id, order_no);
});
$(document).on('submit', '#addTrackingForm', function(event) {
    event.preventDefault();
    var shipment_id = $("#inputShipmentId").val();
    var tracking_number = $("#inputTrackingNumber").val();
    var shipping_method = $("#selShippingMethod").val();

    $("#addTrackingModal").modal('hide');
    SHIPMENT.addTracking(shipment_id, tracking_number, shipping_method);

});
$(document).on('click', '.deleteShipment', function(e) {
    var checkstr = confirm("Are you sure?");
    var shipment_id = $(this).attr('shipment-id');
    if (checkstr) {
        SHIPMENT.delete_shipment(shipment_id);
    }

});

$("#addShipmentAutoBtn").click(function() {
    SHIPMENT.automatic_allocate(order_no);
});


$('#btnAddTab').click(function(e) {
    var nextTab = $('#tabs li').size() + 1;

    // create the tab
    $('<li><a href="#tab' + nextTab + '" data-toggle="tab">Tab ' + nextTab + '</a></li>').appendTo('#tabs');

    // create the tab content
    $('<div class="tab-pane" id="tab' + nextTab + '">tab' + nextTab + ' content</div>').appendTo('.tab-content');

    // make the new tab active
    $('#tabs a:last').tab('show');
});