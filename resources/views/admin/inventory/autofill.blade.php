<style type="text/css">
  select{
    cursor: pointer;
  }
</style>
<div class="col-md-12">
<div class="top-bar-title btn-success text-center padding-bottom">
           <strong>Customer Detail's</strong>
           
           </div><br/>
                          <div class="col-md-6">
                            
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.name') }}</label>

                              <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name" value="{{$mobile[0]->name}}">
                              </div>
                            </div><br/><br/>
                          
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.table.phone') }}</label>

                              <div class="col-sm-8">
                                <input type="text" value="{{$mobile[0]->phone}}" class="form-control" name="phone">
                              </div>
                            </div><br/><br/>
                             <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.channel_id') }}</label>

                              <div class="col-sm-8">
                                <input type="text" value="{{$mobile[0]->channel_id}}" class="form-control" name="channel_id">
                              </div>
                            </div><br/><br/>
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.channel') }}</label>

                              <div class="col-sm-8">
                                <select class="form-control select2" name="channel" id="channel">
                                <option value="">{{ trans('message.form.select_one') }}</option>
                                @if(!empty($mobile[0]->channel))
                                <option value="{{$mobile[0]->channel}}" selected="true">{{ $mobile[0]->channel }}</option>
                                @endif
                                <option value="facebook">{{ trans('message.extra_text.facebook') }}</option>
                                <option value="twitter">{{ trans('message.extra_text.twitter') }}</option>
                                <option value="lazada">{{ trans('message.extra_text.lazada') }}</option>
                                <option value="line">{{ trans('message.extra_text.line') }}</option>

                                </select>
                              </div><br/><br/>
                              <div class="form-group">
                                  <div class="col-sm-3"></div>

                                  <div class="col-sm-9">
                                    <h4 class="text-info text-center"><input type="checkbox"  id="different_billing_address" >  {{ trans('message.invoice.different_billing_address') }} </h4>
                                  </div>
                                </div><br/><br/>

                          <div id="different_billing_address_div" style="display:none;">    
                              
                            <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_street" value="{{$mobile[0]->billing_street}}" id="bill_street">
                                  </div>
                                </div><br/><br/>
                                
                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_city" value="{{$mobile[0]->billing_city}}" id="bill_city">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_state" value="{{$mobile[0]->billing_state}}" id="bill_state">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_zipCode" value="{{$mobile[0]->billing_zip_code}}" id="bill_zipCode">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                                  <div class="col-sm-8">
                                    <select class="form-control select2" name="bill_country_id" id="bill_country_id">
                                    <option value="">{{ trans('message.form.select_one') }}</option>
                                    @foreach ($countries as $data)
                                      @if($mobile[0]->ship_country_id    = $data->code)
                                      <option value="{{$data->code}}" selected="true">{{$data->country}}</option>
                                      @endif
                                      <option value="{{$data->code}}">{{$data->country}}</option>
                                    @endforeach
                                    </select>
                                  </div>
                                </div>
                            </div>
                                </div>
                               
                            
                          </div>
                          
                          <div class="col-md-6">
                              <h4 class="text-info text-center">{{ trans('message.invoice.shipping_address') }} </h4>

                                <div class="form-group">
                              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.form.name') }}</label>

                              <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_name" id="shipping_name" value="{{$mobile[0]->shipping_name}}">
                              </div>
                            </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_street" name="ship_street" value="{{$mobile[0]->shipping_street}}">
                                  </div>
                                </div><br/><br/>
                                
                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_city" name="ship_city" value="{{$mobile[0]->shipping_city}}">
                                  </div>
                                </div><br/><br/>
                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_state" name="ship_state" value="{{$mobile[0]->shipping_state}}">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_zipCode" name="ship_zipCode" value="{{$mobile[0]->shipping_zip_code}}">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                                  <div class="col-sm-8">
                                    <select class="form-control select2" name="ship_country_id" id="ship_country_id">
                                    <option value="">{{ trans('message.form.select_one') }}</option>
                                    @foreach ($countries as $data)
                                     @if($mobile[0]->ship_country_id = $data->code)
                                      <option value="{{$data->code}}" selected="true">{{$data->country}}</option>
                                      @endif
                                      <option value="{{$data->code}}">{{$data->country}}</option>
                                    @endforeach
                                    </select>
                                  </div>
                                </div>
                          </div>
                          
                        </div>
