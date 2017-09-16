$(document).ready(function() {
    initTable();
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
   
    function initTable(){
        $(".order-list-table").bootstrapTable({
            columns: [
                {
                    field: 'state',
                    checkbox: true,
                    align: 'center',
                    valign: 'middle'

                },{
                    field: 'order_no',
                    title: 'Order #',
                    align:'center',
                    valign: 'middle',
                    sortable: 'true',
                    formatter: orderIdFormatter
                },{
                    field:'ord_date',
                    title:'Order Date',
                    align: 'right',
                    valign:'middle',
                    sortable:'true'
                },{
                    field:'customer',
                    title:'Customer Name',
                    align:'left',
                    valign:'middle',
                    sortable:true,
                    formatter: customerNameFormatter
                },{
                    field:'order_quantity',
                    title:'Items #',
                    align:'right',
                    valign:'middle',
                    sortable: true
                },{
                    field:'total',
                    title:'Total',
                    align:'right',
                    valign:'middle',
                    sortable:true
                },{
                    field:'ready_to_ship_quantity',
                    title:'Ship Ready #',
                    align:'right',
                    valign:'middle',
                    sortable:true
                },{
                    field:'pending_quantity',
                    title:'Ship Pending #',
                    align:'right',
                    valign:'middle',
                    sortable:true
                },{
                    field:'customer',
                    title:'Channel',
                    align:'left',
                    valign:'middle',
                    sortable:true,
                    formatter: channelFormatter
                },{
                    field:'label_state',
                    title:'Status',
                    align:'center',
                    valign:'middle',
                    sortable:true
                },{
                    field:'action',
                    title:'Action',
                    align:'center',
                    valign:'middle',
                    sortable:false,
                    formatter: operateFormatter
                }


            ],
        });
    }
   
    $('.order-list-table').on('expand-row.bs.table', function (e, index, row, $detail) {
      
            $detail.html('Loading from ajax request...');
            $.ajax({
                url: SITE_URL+'/order/ajax/get-order-summary',
                type:'get',
                data:{
                    'order_no':row.order_no,
                },
                success: function(data){
                    if(data.state){
                        $detail.html(data.view);
                    }else{
                        $detail.html("Something went wrong, please check your Internet Connection or contact Administrator");
                    }
                }
            });
     
    });
    $('.order-list-table').on('check.bs.table uncheck.bs.table ' +
    'check-all.bs.table uncheck-all.bs.table', function () {
  

// save your data, here just save the current page
    selections = getIdSelections();
    console.log(selections);
// push or splice the selections if you want to save all data selections
});
    function detailFormatter(index, row) {
        var html = [];
        $.each(row, function (key, value) {
            html.push('<p><b>' + key + ':</b> ' + value + '</p>');
        });
        return html.join('');
    }
    function orderIdFormatter(value, row, index){
        return ['<a href="'+SITE_URL+'/order/view-order-details/'+value+'">#'+value+'</a>'];
    }
    function customerNameFormatter(value, row, index){
        return ['<a href="'+SITE_URL+'/customer/edit/"'+value.debtor_no+'>'+value.name+'</a>']
    }
    function channelFormatter(value, row, index){
        return value.channel_name;
    }
    function operateFormatter(value, row, index){
        return ['<a href="'+SITE_URL+'/order/edit/'+row.order_no+'"><i class="glyphicon glyphicon-edit"></i></a>'];
    }
    function getIdSelections() {
        return $.map($('.order-list-table').bootstrapTable('getSelections'), function (row) {
            return row.order_no;
        });
    }

});