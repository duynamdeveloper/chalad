$(document).ready(function() {
    $(".order-list-table").bootstrapTable();
    $(document).on('click', '.toggleOrderSummary', function() {

        var btn = $(this);
        var tr = $(this).closest('tr').next('tr');
        if (tr.hasClass('out')) {
            tr.addClass('in');
            tr.slideDown();
            tr.removeClass('out');
            btn.removeClass('fa-plus');
            btn.addClass('fa-minus')
        } else {
            tr.addClass('out');
            tr.slideUp();
            tr.removeClass('in');
            btn.removeClass('fa-minus');
            btn.addClass('fa-plus')
        }
    });
    $('.order-list-table').on('check.bs.table uncheck.bs.table ' +
        'check-all.bs.table uncheck-all.bs.table',
        function() {


            // save your data, here just save the current page
            selections = getIdSelections();
            console.log(selections);
            // push or splice the selections if you want to save all data selections
        });
    $('.order-list-table').on('expand-row.bs.table', function(e, index, row, $detail) {

        $detail.html('Loading from ajax request...');
        $.ajax({
            url: SITE_URL + '/order/ajax/get-order-summary',
            type: 'get',
            data: {
                'order_no': row.order_no,
            },
            success: function(data) {
                if (data.state) {
                    $detail.html(data.view);
                } else {
                    $detail.html("Something went wrong, please check your Internet Connection or contact Administrator");
                }
            }
        });

    });


});



function detailFormatter(index, row) {
    var html = [];
    $.each(row, function(key, value) {
        html.push('<p><b>' + key + ':</b> ' + value + '</p>');
    });
    return html.join('');
}

function orderIdFormatter(value, row, index) {
    return ['<a href="' + SITE_URL + '/order/view-order-details/' + value + '">#' + value + '</a>'];
}

function customerNameFormatter(value, row, index) {
    return ['<a href="' + SITE_URL + '/customer/edit/"' + value.debtor_no + '>' + value.name + '</a>']
}

function channelFormatter(value, row, index) {
    return value.channel_name;
}

function operateFormatter(value, row, index) {
    return ['<a href="' + SITE_URL + '/order/edit/' + row.order_no + '"><i class="glyphicon glyphicon-edit"></i></a>'];
}

function getIdSelections() {
    return $.map($('.order-list-table').bootstrapTable('getSelections'), function(row) {
        return row.order_no;
    });
}