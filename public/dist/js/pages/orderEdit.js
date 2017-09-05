      $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});


      $("#addPaymentBtn").click(function(event) {
       $("#addPaymentModal").modal('show');
       /* Act on the event */
     });
      $("#btnSaveOrder").click(function(){
        $("#salesForm").submit();
      });
      $(".btnOrderStatus").click(function(){
        var order_no = $(this).attr("data-id");
        var new_status = $(this).val();
        $.ajax({
          url: SITE_URL+"/order/update-status",
          type: "post",
          data:{
            'order_no': order_no,
            'new_status': new_status
          },
          success: function(data){
            if(data.state){
              if(new_status==0){
                $("#orderStatusBar").text("Status: Canceled");
                $("#orderStatusBar").removeClass();
                $("#orderStatusBar").addClass("text-center top-bar-title padding-bottom btn-warning");
                disableAllChange(true);
              }else if(new_status==1){
                $("#orderStatusBar").text("Status: Success");
                $("#orderStatusBar").removeClass();
                $("#orderStatusBar").addClass("text-center top-bar-title padding-bottom btn-success");
                disableAllChange(true);
              }else{
                $("#orderStatusBar").text("Status: Pending");
                $("#orderStatusBar").removeClass();
                $("#orderStatusBar").addClass("text-center top-bar-title padding-bottom btn-danger");
                disableAllChange(false);
              }
            }

          },
        });

      });
      $("#cbxBillingEqualShipping").change(function(){

        if(this.checked){
          $("#billing_country_id").val($("#shipping_country_id").val()).trigger('change');
          $("#billing_name").val($("#shipping_name").val());
          $("#billing_street").val($("#shipping_street").val());
          $("#billing_city").val($("#shipping_city").val());
          $("#billing_state").val($("#shipping_state").val());
          $("#billing_zip_code").val($("#shipping_zip_code").val());
          $("#hidden_billing_country_id").val($("#shipping_country_id").val());
          changeBillingInputState(true);

        }else{
          changeBillingInputState(false);
        }

      });


      $(function() {
        $(document).on('click', function(e) {
          if (e.target.id === 'no_div') {
            $('#no_div').hide();
          } else {
            $('#no_div').hide();
          }

        })
      });

      var taxOptionList = "{!! $tax_type_new !!}";
      $(document).ready(function(){
        if(order_status==0 || order_status==1){
          disableAllChange(true);
        }else{
          disableAllChange(false);
        }
        var refNo ='SO-'+$("#reference_no").val();
        $("#reference_no_write").val(refNo);
        $("#customer").on('change', function(){
          var debtor_no = $(this).val();
          $.ajax({
            method: "POST",
            url: SITE_URL+"/sales/get-branches",
            data: { "debtor_no": debtor_no,"_token":token }
          })
          .done(function( data ) {
            var data = jQuery.parseJSON(data);
            if(data.status_no == 1){
              $("#branch").html(data.branchs);
            }
          });
        });
      });

      $(document).on('keyup', '#reference_no', function () {
        var ref = 'SO-'+$(this).val();
        $("#reference_no_write").val(ref);
      // Check Reference no if available
      $.ajax({
        method: "POST",
        url: SITE_URL+"/sales/reference-validation",
        data: { "ref": ref,"_token":token }
      })
      .done(function( data ) {
        var data = jQuery.parseJSON(data);
        if(data.status_no == 1){
          $("#errMsg").html("{{ trans('message.invoice.exist') }}");
        }else if(data.status_no == 0){
          $("#errMsg").html("{{ trans('message.invoice.available') }}");
        }
      });
    });


      function in_array(search, array)
      {
        for (i = 0; i < array.length; i++)
        {
          if(array[i] ==search )
          {
            return true;
          }
        }
        return false;
      }

      $(function () {
        //Initialize Select2 Elements
        $(".select2").select2({

        });

        //Date picker
        $('#datepicker').datepicker({
          autoclose: true,
          todayHighlight: true,
          format: DATE_FORMAT_TYPE,
        });

        $('.ref').val(Math.floor((Math.random() * 100) + 1));

      });



      var token = $("#token").val();
      $( "#search" ).autocomplete({
        source: function(request, response) {
          $.ajax({
            url: SITE_URL+"/order/search",
            dataType: "json",
            type: "POST",
            data: {
              _token:token,
              search: request.term,
              salesTypeId:$("#sales_type_id").val()
            },
            success: function(data){
                  //Start
                  if(data.status_no == 1){
                    $("#val_item").html();
                    var data = data.items;
                    $('#no_div').css('display','none');
                    response( $.map( data, function( item ) {
                      return {
                        id: item.id,
                        stock_id: item.stock_id,
                        value: item.description,
                        units: item.units,
                        price: item.price,
                        tax_rate: item.tax_rate,
                        tax_id: item.tax_id,
                        weight:item.weight,
                        image: item.item_image
                      }
                    }));
                  }else{
                    $('.ui-menu-item').remove();
                    $("#no_div").css('display','block');
                  }
                  //end

                }
              })
        },
        /* @param stack: list of products in order */
        select: function(event, ui) {
          var e = ui.item;
          if(e.id) {
            if(!in_array(e.id, stack))
            {
              stack.push(e.id);
              var taxAmount = (e.price*e.tax_rate)/100;
              var new_row = '<tr id="rowid'+e.id+'">'+
              '<td class="text-center">'+ e.value +'<input type="hidden" name="description_new[]" value="'+e.value+'"><input type="hidden" name="stock_id_new[]" value="'+e.stock_id+'"></td>'+
              '<td width="10%" class="text-center"><img src="'+SITE_URL+'/public/uploads/itemPic/'+e.image+'" width="70px" height="70px"></td>'+
              '<td> <input class="form-control text-center no_units" min="0" data-id="'+e.id+'" data-rate="'+ e.price +'" type="text" id="qty_'+e.id+'" name="item_quantity_new[]" value="1"><input type="hidden" name="item_id_new[]" value="'+e.id+'"></td>'+
              '<td class="text-center"><input min="0"  type="text" class="form-control text-center unitprice" name="unit_price_new[]" data-id = "'+e.id+'" id="rate_id_'+e.id+'" value="'+ e.price +'"></td>'+
              '<input class="form-control text-center weight" type="hidden"  id="weight_'+e.id+'" value="'+e.weight +'" name="item_weight[]" >'+

              '<input class="form-control text-center total_weight" type="hidden"  id="ttl_weight_'+e.id+'" value="'+e.ttlweight+'" name="" >'+
              '<td><input class="form-control text-center amount" type="text" amount-id = "'+e.id+'" id="amount_'+e.id+'" value="'+e.price+'" name="item_price_new[]" readonly></td>'+
              '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>'+
              '</tr>';

              $(new_row).insertAfter($('table tr.dynamicRows:last'));

              $(function() {
                $("#rowid"+e.id+' .taxList').val(e.tax_id);
              });
              $(function() {
                $("#ttl_weight_"+e.id).val(e.weight);
              });
              var taxRateValue = parseFloat( $("#rowid"+e.id+' .taxList').find(':selected').attr('taxrate'));


              var weight_total=calculateweight();
            //alert(weight_total);
            $("#total_weight").val(weight_total);

                // Calculate subtotal
                updateValueAfterChange();

              } else {

                $('#qty_'+e.id).val( function(i, oldval) {
                  return ++oldval;
                });

                var q = $('#qty_'+e.id).val();
                var r = $("#rate_id_"+e.id).val();

                var total_weight = parseFloat(q)*parseFloat($('#weight_'+e.id).val());
                $("#ttl_weight_"+e.id).val(total_weight);

                $('#amount_'+e.id).val( function(i, amount) {
                  var result = q*r; 
                  var amountId = $(this).attr("amount-id");
                  var qty = parseInt($("#qty_"+amountId).val());
                  var unitPrice = parseFloat($("#rate_id_"+amountId).val());
                  var discountPercent = parseFloat($("#discount_id_"+amountId).val())/100;
                  if(isNaN(discountPercent)){
                    discountPercent = 0;
                  }
                  var discountAmount = qty*unitPrice*discountPercent;
                  var newPrice = parseFloat([(qty*unitPrice)-discountAmount]);
                  return newPrice;
                });

                var taxRateValue = parseFloat( $("#rowid"+e.id+' .taxList').find(':selected').attr('taxrate'));
                var amountByRow = $('#amount_'+e.id).val(); 
                var taxByRow = amountByRow*taxRateValue/100;

                $("#rowid"+e.id+" .taxAmount").text(taxByRow);
                var weight_total=calculateweight();

                $("#total_weight").val(weight_total);
                updateValueAfterChange();

              }
              
              $(this).val('');
              $('#val_item').html('');
              return false;
            }
          },
          minLength: 1,
          autoFocus: true
        });


      $(document).on('change keyup blur','.check',function() {
        var row_id = $(this).attr("id").substr(2);
        var disc = $(this).val();
        var amd = $('#a_'+row_id).val();

        if (disc != '' && amd != '') {
          $('#a_'+row_id).val((parseInt(amd)) - (parseInt(disc)));
        } else {
          $('#a_'+row_id).val(parseInt(amd));
        }

      });

      $(document).ready(function() {
        $(window).keydown(function(event){
          if(event.keyCode == 13) {
            event.preventDefault();
            return false;
          }
        });
      });

    // price calcualtion with quantity
    $(document).ready(function(){
     $('.tableInfo').hide();
   });
    $("#item_tax").change(function(){
      updateValueAfterChange();
    });
    $(document).on('keyup', '#discount_amnount', function(ev){
      var discount = parseFloat($(this).val());
          //alert(discount);
          if(isNaN(discount))
          {
            discount = 0;
          }


          updateValueAfterChange();
          //alert(item_tax);
          // subTotal = subTotal+(parseFloat((subTotal*item_tax)/100));
          // //alert(subtotal);
          // var grandTotal = parseFloat(subTotal+shipping_cost);
          // after_discount = grandTotal-discount;
          // $("#grandTotal").val(after_discount);

        });

     // calculate amount with item quantity
     $(document).on('keyup', '.no_units', function(ev){
      var id = $(this).attr("data-id");
      var qty = parseInt($(this).val());
      var order_no = $("#order_no").val();
      var reference = $("#reference").val();
      var token = $("#token").val();
      var from_stk_loc = $("#loc").val();
      // check item quantity in store location after sale
      $.ajax({
        method: "POST",
        url: SITE_URL+"/order/check-quantity-after-invoice",
        data: { "id": id,'order_no':order_no,'reference':reference ,"location_id": from_stk_loc,'qty':qty,"_token":token }
      })
      .done(function( data ) {
        var data = jQuery.parseJSON(data);

        if(data.status_no == 0){
          $("#quantityMessage").html('You can not decrease the item quantity.');
          $("#rowid"+id).addClass("insufficient");
          $('#btnSubmit').attr('disabled', 'disabled');
        }else if(data.status_no == 1){
         $("#quantityMessage").html("");
         $("#rowid"+id).removeClass("insufficient");
         $("#quantityMessage").hide();
         $('#btnSubmit').removeAttr('disabled');
       }
     });


      if(isNaN(qty)){
        qty = 0;
      }

      var rate = $("#rate_id_"+id).val();
      var subweight_ = $("#weight_"+id).val();
      var sub_weight = parseFloat(calculatsubeweight(qty,subweight_));
     //alert(sub_weight);
     $("#ttl_weight_"+id).val(sub_weight);

     var sub_weight = calculateweight();
     $("#total_weight").val(sub_weight);

     var price = calculatePrice(qty,rate);  

     var discountRate = parseFloat($("#discount_id_"+id).val());     
     if(isNaN(discountRate)){
      discountRate = 0;
    }
    var discountPrice = calculateDiscountPrice(price,discountRate); 
    $("#amount_"+id).val(discountPrice);


    var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));
    var amountByRow = $('#amount_'+id).val(); 
    var taxByRow = amountByRow*taxRateValue/100;
    $("#rowid"+id+" .taxAmount").text(taxByRow);
    updateValueAfterChange();
      // var taxTotal = calculateTaxTotal();
      // $("#taxTotal").text(taxTotal);

      // // Calculate subTotal
      // var subTotal = calculateSubTotal();
      // $("#subTotal").html(subTotal);


      // // Calculate GrandTotal
      // var grandTotal = (subTotal + taxTotal);
      // $("#grandTotal").val(grandTotal);

    });
     $(document).on('change', '#shipping_method', function(ev){

      var method=$(this).val();
      if(method== 1)
        method=0;
      var subTotal = calculateSubTotal();
      var sub_weight = calculateweight();
     //alert(sub_weight);


     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
     $('#category_product_code').empty();
     $caterory_in = 0;
     $.ajax({
      url: 'shipping_cost_price/'.concat(sub_weight).concat('/').concat(method),
      type: 'get',
      contentType: 'application/json',
      data: {_token: CSRF_TOKEN},
                //dataType: 'JSON',
                success: function (data) {
                  var item_tax = parseFloat($('#item_tax').val());
                  var discount_amnount = parseFloat($('#discount_amnount').val());
                        //alert(item_tax);
                        if(isNaN(item_tax))
                        {
                          item_tax=0;
                        }
                        if(isNaN(discount_amnount))
                        {
                          discount_amnount=0;
                        }
                        var grandTotal = (subTotal+((subTotal*item_tax)/100)+parseFloat(data));
                        $("#grandTotal").val(grandTotal-discount_amnount);  
                        $("#shipping_cost").val(data);
                        $("#shipping_cost_div").show("fast");
                        updateValueAfterChange();
                      }
                    });





   });
     // calculate amount with discount
     $(document).on('keyup', '.discount', function(ev){

      var discount = parseFloat($(this).val());

      if(isNaN(discount)){
        discount = 0;
      }

      var id = $(this).attr("data-input-id");
      var qty = $("#qty_"+id).val();
      var rate = $("#rate_id_"+id).val();
      var discountRate = $("#discount_id_"+id).val();

      var price = calculatePrice(qty,rate); 
      var discountPrice = calculateDiscountPrice(price,discountRate);       
      $("#amount_"+id).val(discountPrice);

      var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));
      var amountByRow = $('#amount_'+id).val(); 
      var taxByRow = amountByRow*taxRateValue/100;
      $("#rowid"+id+" .taxAmount").text(taxByRow);
      updateValueAfterChange();


    });


     // calculate amount with unit price
     $(document).on('keyup', '.unitprice', function(ev){

      var unitprice = parseFloat($(this).val());

      if(isNaN(unitprice)){
        unitprice = 0;
      }

      var id = $(this).attr("data-id");
      var qty = $("#qty_"+id).val();
      var rate = $("#rate_id_"+id).val();
      var discountRate = $("#discount_id_"+id).val();

      var price = calculatePrice(qty,rate);  
      var discountPrice = calculateDiscountPrice(price,discountRate);     
      $("#amount_"+id).val(discountPrice);

      var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));
      var amountByRow = $('#amount_'+id).val(); 
      var taxByRow = amountByRow*taxRateValue/100;
      $("#rowid"+id+" .taxAmount").text(taxByRow);
      updateValueAfterChange();

    });

     $(document).on('change', '.taxList', function(ev){
      var taxRateValue = $(this).find(':selected').attr('taxrate');
      var rowId = $(this).closest('tr').prop('id');
      var amountByRow = $("#"+rowId+" .amount").val(); 
      
      var taxByRow = amountByRow*taxRateValue/100;

      $("#"+rowId+" .taxAmount").text(taxByRow);
      updateValueAfterChange();

    });

    // Delete item row
    $(document).ready(function(e){
      $('#salesInvoice').on('click', '.delete_item', function() {
        var v = $(this).attr("id");
        stack = jQuery.grep(stack, function(value) {
          return value != v;
        });

        $(this).closest("tr").remove();

        var taxRateValue = parseFloat( $("#rowid"+v+' .taxList').find(':selected').attr('taxrate'));
        var amountByRow = $('#amount_'+v).val(); 
        var taxByRow = amountByRow*taxRateValue/100;
        $("#rowid"+v+" .taxAmount").text(taxByRow);
        updateValueAfterChange();


      });

    });
      function disableAllChange(state){
            changeBillingInputState(state);
                changeShippingInputState(state);
                $("#addPaymentBtn").attr('disabled',state);
                $("#search").prop('readonly', state);
                $(".unitprice").prop('readonly',state);
                $(".no_units").prop('readonly',state);
                $("#btnSubmit").attr('disabled',state);
                $("#item_tax").attr('disabled', state);
                $("#shipping_method").attr('disabled',state);
                $("#discount_amnount").prop('readonly',state);
      }


      function changeShippingInputState(state){
        $("#shipping_name").prop('readonly',state);
        $("#shipping_street").prop('readonly',state);
        $("#shipping_city").prop('readonly',state);
        $("#shipping_state").prop('readonly',state);
        $("#shipping_zip_code").prop('readonly',state);      
        $("#shipping_country_id").attr('disabled',state);
      }
      /**
      * Change billing input state
      **/

      function changeBillingInputState(state){
        $("#billing_name").prop('readonly',state);
        $("#billing_street").prop('readonly',state);
        $("#billing_city").prop('readonly',state);
        $("#billing_state").prop('readonly',state);
        $("#billing_zip_code").prop('readonly',state);
        
        $("#billing_country_id").attr('disabled',state);
        $("#hidden_billing_country_id").attr('disabled',!state);
        
        
      }
      /**
      

      * Calcualte Total tax
      *@return totalTax for row wise
      */
      function calculateTaxTotal (){
        var totalTax = 0;
        $('.taxAmount').each(function() {
          totalTax += parseFloat($(this).text());
        });
        return totalTax;
      }
      function calculateTotalItemsQuantity(){
        var qty = 0;
        $('.no_units').each(function(index, el) {
          qty += parseFloat($(this).val());
        });
        return qty;
      }
      
      /**
      * Calcualte Sub Total 
      *@return subTotal
      */

      function calculateweight (){
        var sub_weight = 0;
        $('.total_weight').each(function() {
          sub_weight += parseFloat($(this).val());
        });
        return sub_weight;
      }
      function calculatsubeweight(qty,subweight_){
       var subweight_ = (qty*subweight_);
       return subweight_;
     } 
     function calculateSubTotal (){
      var subTotal = 0;
      $('.amount').each(function() {
        subTotal += parseFloat($(this).val());
      });
      return subTotal;
    }
      /**
      * Calcualte price
      *@return price
      */
      function calculatePrice (qty,rate){
       var price = (qty*rate);
       return price;
     }   
      // calculate tax 
      function caculateTax(p,t){
       var tax = (p*t)/100;
       return tax;
     }   


      // calculate discont amount
      function calculateDiscountPrice(p,d){
        var discount = [(d*p)/100];
        var result = (p-discount); 
        return result;
      }

// Item form validation
$('#salesForm').validate({
  rules: {
    debtor_no: {
      required: true
    },

    reference:{
      required:true
    }

  }
});
function calculateGrandTotal(){
  var tax_rate = parseFloat($("#item_tax").val());
          //alert(tax_rate);
          if(isNaN(tax_rate))
          {
            tax_rate = 0;
          }
          var subTotal = calculateSubTotal();
          var shipping_cost = parseFloat($('#shipping_cost').val());
          if(isNaN(shipping_cost))
          {
            shipping_cost = 0;
          }
          var discount_amnount = parseFloat($('#discount_amnount').val());
          if(isNaN(discount_amnount))
          {
            discount_amnount = 0;
          }
          
          //alert(shipping_cost);
          var grandTotal = parseFloat(subTotal+shipping_cost);
          after_discount = grandTotal-discount_amnount;
          tax_cal = after_discount+(after_discount*tax_rate)/100;
          var tax_amount = (after_discount*tax_rate)/100;
          $("#subTotal").text(subTotal);
          $("#tax_amount").val(tax_amount);
          $("#grandTotal").val(tax_cal);
        }
        function updateValueAfterChange(){
          calculateGrandTotal();

          $("#smTotalItem").text(calculateTotalItemsQuantity());
          $("#smTotalAmount").text($("#grandTotal").val());
        }
        $(document).ready(function(){
          var subTotal = calculateSubTotal();
          $("#subTotal").text(subTotal);
          updateValueAfterChange();
          $(document).ready(function() {
            $("#payment_type_id").select2();
            $('#payment_date').datepicker({
              autoclose: true,
              todayHighlight: true,
              format: DATE_FORMAT_TYPE
            });  
          });

        });
