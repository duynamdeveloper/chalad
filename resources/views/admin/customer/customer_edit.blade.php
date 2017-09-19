@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
        <div class="box">
           <div class="panel-body">
                <ul class="nav nav-tabs cus" role="tablist">
                    <li class="active">
                      <a href='{{url("customer/edit/$customerData->debtor_no")}}' >{{ trans('message.sidebar.profile') }}</a>
                    </li>
                    <li>
                      <a href="{{url("customer/order/$customerData->debtor_no")}}" >{{ trans('message.extra_text.sales_orders') }}</a>
                    </li>
                    <li>
                      <a href="{{url("customer/invoice/$customerData->debtor_no")}}" >{{ trans('message.extra_text.invoices') }}</a>
                    </li>
                    <li>
                      <a href="{{url("customer/payment/$customerData->debtor_no")}}" >{{ trans('message.extra_text.payments') }}</a>
                    </li>
                    <li>
                      <a href="{{url("customer/shipment/$customerData->debtor_no")}}" >{{ trans('message.extra_text.deliveries') }}</a>
                    </li>
               </ul>
              <div class="clearfix"></div>
           </div>
        </div>

        <h3>{{$customerData->name}}</h3>
        <div class="box">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="tabs" style="font-size:12px">
              <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false">{{ trans('message.table.general_settings') }}</a></li>
              <li><a href="#tab_2" data-toggle="tab" aria-expanded="false">Address</a></li>
              @if(!empty($customerData->password))
              <li><a href="#tab_3" data-toggle="tab" aria-expanded="false">{{ trans('message.form.update_password') }}</a></li>
              @else
              <li><a href="#tab_3" data-toggle="tab" aria-expanded="false">{{ trans('message.form.set_password') }}</a></li>
              @endif
            </ul>
            <div class="tab-content">
              <div class="tab-pane fade in active" id="tab_1">
                <div class="row">
                <div class="col-md-8">
                 
                <!-- form start -->
                <form action="{{ url("update-customer/$customerData->debtor_no") }}" method="post" id="myform1" class="form-horizontal">
                      
                  <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                        <div class="box-body">
                          
                          <div class="form-group">
                            <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.form.name') }}</label>

                            <div class="col-sm-7">
                              <input type="text" placeholder="{{ trans('message.form.full_name') }}" class="form-control valdation_check" id="fname" name="name" value="{{$customerData->name}}">
                              <span id="val_fname" style="color: red"></span>
                            </div>
                          </div>
                          
                          
                          <div class="form-group">
                            <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.table.phone') }}</label>

                            <div class="col-sm-7">
                              <input type="text" placeholder="{{ trans('message.table.phone') }}" class="form-control valdation_check" id="name" name="phone" value="{{$customerData->phone}}" readonly>
                              <span id="val_name" style="color: red"></span>
                            </div>
                          </div>
						  
						  						  <div class="form-group">
                            <label class="col-sm-4 control-label" for="inputEmail3">Channel ID</label>

                            <div class="col-sm-7">
                              <input type="text" placeholder="Channel ID" class="form-control valdation_check" id="name" name="channel_id" value="{{$customerData->channel_id}}">
                              <span id="val_name" style="color: red"></span>
                            </div>
                          </div>
						  
						  <div class="form-group">
                            <label class="col-sm-4 control-label" for="inputEmail3">Channel</label>

                            <div class="col-sm-7">
                              <input type="text" placeholder="Channel" class="form-control valdation_check" id="name" name="channel_name" value="{{$customerData->channel_name}}">
                              <span id="val_name" style="color: red"></span>
                            </div>
                          </div>
						  
						  <div class="form-group">
                            <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.form.email') }}</label>

                            <div class="col-sm-7">
                              <input type="text" placeholder="{{ trans('message.table.email') }}" class="form-control" id="email" name="email" value="{{$customerData->email}}">
                              <span id="val_email" style="color: red"></span>
                            </div>
                          </div>

						  


                          <div class="form-group">
                            <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.form.status') }}</label>

                            <div class="col-sm-7">
                              <select class="form-control valdation_select" name="inactive" >
                                
                                <option value="0" <?=isset($customerData->inactive) && $customerData->inactive ==  0? 'selected':""?> >Active</option>
                                <option value="1"  <?=isset($customerData->inactive) && $customerData->inactive == 1 ? 'selected':""?> >Inactive</option>
                              
                              </select>
                              @if(!empty(Session::get('customer_edit')))
                                <div style="margin-top:10px">
                                  <a href="{{ url('customer/list') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                                  <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                                </div>
                               @endif
                            </div>
                          </div>
                        </div>
                      </form>
              </div>
              </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">

      <div class="box box-success" id="orderForm">
    <div class="box-body">
        <div class="row">
            <form class="form-horizontal" id="shipping_billing_form" method="post" action="{{url('/customer/updateaddress')}}" >
                <input type="hidden" id="hiddenDebtor_no" name="debtor_no" value="{{$customerData->debtor_no}}">
                <div class="col-md-6">
                    <h4 class="text-info"><strong>{{ trans('message.invoice.shipping_address') }}</strong></h4>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.form.name') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="shipping_name" id="shipping_name" required value="{{$customerData->shipping_name}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_street" name="shipping_street" value="{{$customerData->shipping_street}}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_city" name="shipping_city" value="{{$customerData->shipping_city}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_state" name="shipping_state" value="{{$customerData->shipping_state}}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="shipping_zip_code" name="shipping_zip_code" value="{{$customerData->shipping_zip_code}}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                        <div class="col-sm-9">
                            <select class="form-control select2" name="shipping_country_id" id="shipping_country_id">
                                <option value="">{{ trans('message.form.select_one') }}</option>
                                @foreach ($countries as $data)
                                    
                                    <option value="{{$data->code}}" @if($data->code == $customerData->shipping_country_id) selected="true" @endif>{{$data->country}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label " for="inputEmail3">Phone:</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="contact_phone" name="contact_phone" value="{{$customerData->contact_phone}}" required>
                        </div>
                    </div>
                </div>

                <!--End Shippind Address Form-->
                <!--Billing Address-->
                <div id="different_billing_address_div" class="col-md-6">
                    <div class="form-title">
                        <h4 class="text-info text-left" style="font-weight: bold;">Billing Address</h4><span class="text-info" style="font-size: 18px;"><input type="checkbox" name="billing_address_the_same_as_shipping_address" id="cbxBillingEqualShipping" @if($customerData->different_billing_address == 1) checked @endif  > Different Billing Address?</span>


                    </div>
                    <div id="billing_form"  @if($customerData->different_billing_address == 0) hidden @endif>
                
                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.name') }}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_name"  id="billing_name" value="{{$customerData->billing_name}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_street" id="billing_street" value="{{$customerData->billing_street}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_city"  id="billing_city" value="{{$customerData->billing_city}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_state"  id="billing_state" value="{{$customerData->billing_state}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="billing_zip_code" id="billing_zip_code" value="{{$customerData->billing_zip_code}}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                            <div class="col-sm-8">
                                <select class="form-control select2" name="billing_country_id" id="billing_country_id">
                                    <option value="">{{ trans('message.form.select_one') }}</option>
                                    @foreach ($countries as $data)

                                        <option value="{{$data->code}}" @if($data->code == $customerData->billing_country_id) selected="true" @endif>{{$data->country}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <!--End Billing Address -->



          
        </div>
 <button class="btn btn-success pull-right" type="button" id="btnSaveUpdateAddress">Save</button>
    </div>
    
     </form>
</div>
              </div>
              <!-- /.tab-pane -->
              <!-- /.tab-pane -->
        
              <div class="tab-pane" id="tab_3">

                    <div class="row">
                      <div class="col-md-6">
                          <form action='{{url("customer/update-password")}}' class="form-horizontal" id="password-form" method="POST">
                            <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                            <input type="hidden" value="{{$customerData->debtor_no}}" name="customer_id">
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.password') }}</label>

                              <div class="col-sm-8">
                              <input type="password" class="form-control" name="password" id="password">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.confirm_password') }}</label>

                              <div class="col-sm-8">
                              <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                              <br>
                              @if(!empty(Session::get('customer_edit')))
                              <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                              @endif
                              </div>
                            </div>
                          </form>
                      </div>

              </div>

              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          
        </div>
        
        <!-- /.box-footer-->
      
      <!-- /edit branch .box -->
    <div id="edit-brunch" class="modal fade" role="dialog" style="display: none;">
        
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">{{ trans('message.table.branch_details') }}</h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" id="updateBranch">
                {!! csrf_field() !!}
                  
                  <div class="form-group">
                    <label for="quantity" class="col-sm-4 control-label require">{{ trans('message.table.branch_name') }}</label>
                    <div class="col-sm-6">
                      <input type="text" name="br_name" class="form-control" id="br_name" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="quantity" class="col-sm-4 control-label">{{ trans('message.table.contact') }}</label>
                    <div class="col-sm-6">
                      <input type="text" name="br_contact" class="form-control" id="br_contact" >
                    </div>
                  </div>
                  
                  
                  <h4 class="text-info text-center">{{ trans('message.invoice.billing_address') }}</h4>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                            <div class="col-sm-6">
                              <input name="bill_street" id="bill_street" type="text" class="form-control">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                            <div class="col-sm-6">
                              <input name="bill_city" id="bill_city" type="text" class="form-control">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                            <div class="col-sm-6">
                              <input name="bill_state" id="bill_state" type="text" class="form-control">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                            <div class="col-sm-6">
                              <input name="bill_zipCode" id="bill_zipCode" type="text" class="form-control" name="bill_zipCode">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.country') }}</label>
                            <div class="col-sm-6">
                              <select class="form-control" name="billing_country_id" id="billing_country_id">
                              <option value="">{{ trans('message.form.select_one') }}</option>
                              @foreach ($countries as $data)
                                <option value="{{$data->code}}" >{{$data->country}}</option>
                              @endforeach
                              </select>
                            </div>
                          </div>


                          <h4 class="text-info text-center">{{ trans('message.invoice.shipping_address') }}<button id="copy" class="btn btn-default btn-xs" type="button">{{ trans('message.table.copy_address') }}</button></h4>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                            <div class="col-sm-6">
                              <input name="ship_street" id="ship_street" type="text" class="form-control">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                            <div class="col-sm-6">
                              <input name="ship_city" id="ship_city" type="text" class="form-control">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                            <div class="col-sm-6">
                              <input name="ship_city" id="ship_state" type="text" class="form-control">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                            <div class="col-sm-6">
                              <input name="ship_zipCode" id="ship_zipCode" type="text" class="form-control">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.country') }}</label>
                            <div class="col-sm-6">
                              <select class="form-control" name="shipping_country_id" id="shipping_country_id">
                              <option value="">{{ trans('message.form.select_one') }}</option>
                              @foreach ($countries as $data)
                                <option value="{{$data->code}}" >{{$data->country}}</option>
                              @endforeach
                              </select>
                            </div>
                          </div>

                  <input type="hidden" name="br_id" id="br_id">
                  <div class="form-group">
                    <label for="btn_save" class="col-sm-4 control-label"></label>
                    <div class="col-sm-6">
                      <button type="button" class="btn btn-info btn-flat" data-dismiss="modal">{{ trans('message.form.close') }}</button>
                      <button type="submit" class="btn btn-primary btn-flat pull-right">{{ trans('message.form.update') }}</button>
                      
                    </div>
                  </div>
                </form>
              </div>
            </div>

          </div>
        </div>
  
  <!-- /.add New Branch box -->
        <div id="add-brunch" class="modal fade" role="dialog" style="display: none;">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">{{ trans('message.table.branch_details') }}</h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" id="addBranch">
                  
                  <div class="form-group">
                    <label for="quantity" class="col-sm-4 control-label require">{{ trans('message.table.branch_name') }}</label>
                    <div class="col-sm-6">
                      <input type="text" name="br_name" class="form-control" id="add_br_name" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="quantity" class="col-sm-4 control-label require">{{ trans('message.table.contact') }}</label>
                    <div class="col-sm-6">
                      <input type="text" name="br_contact" class="form-control" id="add_br_contact" >
                    </div>
                  </div>
                  
                  <h4 class="text-info text-center">{{ trans('message.invoice.billing_address') }}</h4>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                            <div class="col-sm-6">
                              <input name="bill_street" id="add_bill_street" type="text" class="form-control">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                            <div class="col-sm-6">
                              <input name="bill_city" id="add_bill_city" type="text" class="form-control">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                            <div class="col-sm-6">
                              <input name="bill_state" id="add_bill_state" type="text" class="form-control">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                            <div class="col-sm-6">
                              <input name="bill_zipCode" id="add_bill_zipCode" type="text" class="form-control" name="bill_zipCode">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.country') }}</label>
                            <div class="col-sm-6">
                              <select class="form-control select2" name="bill_country_id" id="bill_country_id">
                              <option value="">{{ trans('message.form.select_one') }}</option>
                              @foreach ($countries as $data)
                                <option value="{{$data->code}}" >{{$data->country}}</option>
                              @endforeach
                              </select>
                            </div>
                          </div>

                          <h4 class="text-info text-center">{{ trans('message.invoice.shipping_address') }} <button id="copyAddress" class="btn btn-default btn-xs" type="button">Copy Address</button></h4>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                            <div class="col-sm-6">
                              <input name="ship_street" id="add_ship_street" type="text" class="form-control">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                            <div class="col-sm-6">
                              <input name="ship_city" id="add_ship_city" type="text" class="form-control">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                            <div class="col-sm-6">
                              <input name="ship_city" id="add_ship_state" type="text" class="form-control">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                            <div class="col-sm-6">
                              <input name="ship_zipCode" id="add_ship_zipCode" type="text" class="form-control">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                            <div class="col-sm-6">
                              <select class="form-control select2" name="ship_country_id" id="ship_country_id">
                              <option value="">{{ trans('message.form.select_one') }}</option>
                              @foreach ($countries as $data)
                                <option value="{{$data->code}}" >{{$data->country}}</option>
                              @endforeach
                              </select>
                            </div>
                          </div>
                  <input type="hidden" name="cus_id" value="{{$customerData->debtor_no}}" id="cus_id">
                  <div class="form-group">
                    <label for="btn_save" class="col-sm-4 control-label"></label>
                    <div class="col-sm-6">
                      
                      <button type="button" class="btn btn-info btn-flat" data-dismiss="modal">{{ trans('message.form.close') }}</button>
                    <button type="submit" class="btn btn-primary btn-flat pull-right">{{ trans('message.form.submit') }}</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

          </div>
        </div>
    @include('layouts.includes.message_boxes')
    </section>
@endsection


@section('js')

    <script type="text/javascript">

jQuery(function($) {
    var index = 'qpsstats-active-tab';
    //  Define friendly data store name
    var dataStore = window.sessionStorage;
    var oldIndex = 0;
    //  Start magic!
    try {
        // getter: Fetch previous value
        oldIndex = dataStore.getItem(index);
    } catch(e) {}
 
    $( "#tabs" ).tabs({        active: oldIndex,
        activate: function(event, ui) {
            //  Get future value
            var newIndex = ui.newTab.parent().children().index(ui.newTab);
            //  Set future value
            try {
                dataStore.setItem( index, newIndex );
            } catch(e) {}
        }
    });
});


    </script>
     <script src="{{asset('/public/dist/js/pages/customer/customer.js')}}"></script>
    <script src="{{asset('/dist/js/pages/customer/customer.js')}}"></script>
@endsection