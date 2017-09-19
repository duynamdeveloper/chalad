var CUSTOMER = {};
$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
CUSTOMER = {
    API:{
        updateAddress: SITE_URL+'/customer/updateaddress',
    }
};
CUSTOMER.saveAddress = function() {
    
        var address = CUSTOMER.getAddress();
        address = JSON.stringify(address);
        var debtor_no = $("#hiddenDebtor_no").val();
        $.ajax({
            url: CUSTOMER.API.updateAddress,
            type: 'post',
            data: {
                'address': address,
                'debtor_no':debtor_no
            },
            success: function(data) {
               location.reload();
            }
        });
    };
CUSTOMER.getAddress = function() {
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

$(document).on('click','#btnSaveUpdateAddress', function(e){
    e.preventDefault();
    CUSTOMER.saveAddress();
});
$(document).on('click', '#cbxBillingEqualShipping', function() {
    if ($(this).is(':checked')) {
        $("#billing_form").show();
    } else {
        $("#billing_form").hide();
    }
});
