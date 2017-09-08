<div class="box box-success">
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <h5 class="text-info"><strong>Ship To</strong></h5>

                <div class="form-group">
                    <p class="col-sm-12 text-left" for="inputEmail3">Name: {{$order->shipping_name}}<br>
                        {{$order->shipping_street}}, {{$order->shipping_city}}<br>
                        State: {{$order->shipping_state}}<br>
                        ZIPCODE: {{$order->shipping_zip_code}}<br>
                        COUNTRY: {{$order->shipping_country_id}}<br><br>
                        Phone: {{$order->contact_phone}}
                    </p>

                </div>



            </div>
            <div class="col-md-4">

                <h5 class="text-info"><strong>Bill To</strong></h5>

                <div class="form-group">
                    <p class="col-sm-12 text-left" for="inputEmail3">Name: {{$order->billing_name}}<br>
                        {{$order->billing_street}}, {{$order->billing_city}}<br>
                        State: {{$order->billing_state}}<br>
                        ZIPCODE: {{$order->billing_zip_code}}<br>
                        COUNTRY: {{$order->billing_country_id}}<br><br>
                        Phone: {{$order->contact_phone}}
                    </p>

                </div>



            </div>

            <div class="col-md-4">

                <h4 class="text-info"><strong>Shipment Due:</strong></h4>
                <h3>{{$order->pending_quantity}} Items</h3>
                <button class="btn btn-success" id="addShipmentAutoBtn">Create/Update Shipment</button>
                <button class="btn btn-warning" id="addShipmentAutoBtn">View Payment History</button>



            </div>

            <!--End Shippind Address Form-->




        </div>

    </div>
</div>