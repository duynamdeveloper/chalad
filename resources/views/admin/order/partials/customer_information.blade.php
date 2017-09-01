            

            <div class="row">
            
            <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Name</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control customer-form" name="customer_name" id="inp_customer_name" placeholder="Enter Name" value="{{$order->customer->name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Phone</label>
                                        <div class="col-md-8">  
                                            <input type="text" class="form-control customer-form" name="customer_phone" id="inp_customer_phone" placeholder="Enter Phone Number" value="{{$order->customer->phone}}" readonly>
                                        </div>
                                    </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-4">Email</label>
                                        <div class="col-md-8">
                                            <input type="text"  class="form-control customer-form" name="customer_email" id="inp_customer_email" placeholder="Enter Email" value="{{$order->customer->email}}" readonly>
                                        </div>
                                    </div>
                                   
                            </div>
                            <div class="col-md-6">
                             <div class="form-group">
                                        <label class="control-label col-md-4">Channel</label>
                                        <div class="col-md-8">
                                           <input type="text" class="form-control customer-form" name="customer_channel" id="inp_customer_channel" placeholder="Enter Channel" value="{{$order->customer->channel_name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 ">Channel ID</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" value="{{$order->customer->channel_id}}" readonly>
                                        </div>
                                    </div>
                                  
                           
                                </div>
                                </div>
            <div class="row">
                <form class="form-horizontal" id="shipping_billing_form" method="get" action="{{url('/order/updateaddress')}}" >
                     <input type="hidden" name="order_no" value="{{$order->order_no}}">
                        <div class="col-md-6">
             <h4 class="text-info"><strong>{{ trans('message.invoice.shipping_address') }}</strong></h4>

             <br>
             <br>
             <div class="form-group">
              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.form.name') }}</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" name="shipping_name" id="shipping_name" value="{{ $order->shipping_name }}" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="shipping_street" name="shipping_street" value="{{ $order->shipping_street }}" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="shipping_city" name="shipping_city" value="{{ $order->shipping_city }}" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="shipping_state" name="shipping_state" value="{{ $order->shipping_state }}" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="shipping_zip_code" name="shipping_zip_code" value="{{ $order->shipping_zip_code }}" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

              <div class="col-sm-8">
                <select class="form-control select2" name="shipping_country_id" id="shipping_country_id">
                  <option value="">{{ trans('message.form.select_one') }}</option>
                  @foreach ($countries as $data)

                  <option value="{{$data->code}}" @if($data->code == $order->shipping_country_id) selected="true" @endif>{{$data->country}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <!--End Shippind Address Form-->
          <!--Billing Address-->
          <div id="different_billing_address_div" class="col-md-6">    
           <div class="form-title">
            <h4 class="text-info text-left" style="font-weight: bold;">Billing Address</h4><span class="text-info" style="font-size: 18px;"><input type="checkbox" name="billing_address_the_same_as_shipping_address" id="cbxBillingEqualShipping"> Billing address the same as shipping address</span>
          

         </div>
         <br>
         <div class="form-group">
          <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.name') }}</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="billing_name"  id="billing_name" required value="{{ $order->billing_name }}">
          </div>
        </div>
        <div class="form-group">
         <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

         <div class="col-sm-8">
          <input type="text" class="form-control" name="billing_street" id="billing_street" required value="{{ $order->billing_street }}">
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

        <div class="col-sm-8">
          <input type="text" class="form-control" name="billing_city"  id="billing_city" required value="{{ $order->billing_city }}">
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

        <div class="col-sm-8">
          <input type="text" class="form-control" name="billing_state"  id="billing_state" value="{{ $order->billing_state }}" required>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

        <div class="col-sm-8">
          <input type="text" class="form-control" name="billing_zip_code" id="billing_zip_code" value="{{ $order->billing_zip_code }}" required>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

        <div class="col-sm-8">
          <select class="form-control select2" name="billing_country_id" id="billing_country_id">
            <option value="">{{ trans('message.form.select_one') }}</option>
            @foreach ($countries as $data)

            <option value="{{$data->code}}" @if($data->code=== $order->billing_country_id) selected="true" @endif>{{$data->country}}</option>
            @endforeach
          </select>
        </div>
        <input type="hidden" name="billing_country_id" id="hidden_billing_country_id" disabled>
      </div>
    </div>

    <!--End Billing Address -->

               
                <button class="btn btn-success pull-right btnSave" type="submit" id="btnSaveAddress">Save</button>
                 </form>
            </div>