/* Action on events */

$("#cbxBillingEqualShipping").change(function () {

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