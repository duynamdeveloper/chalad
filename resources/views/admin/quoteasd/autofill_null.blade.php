<style type="text/css">
  select{
    cursor: pointer;
  }
</style>
<div class="col-md-12">
                          <div class="col-md-6">
                            
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.name') }}</label>

                              <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" value="" id="name">
                              </div>
                            </div><br/><br/>
                          
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.table.phone') }}</label>

                              <div class="col-sm-8">
                                <input type="text" value="" class="form-control" name="phone">
                              </div>
                            </div><br/><br/>
                             <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.channel_id') }}</label>

                              <div class="col-sm-8">
                                <input type="text" value="" class="form-control" name="channel_id">
                              </div>
                            </div><br/><br/>
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.channel') }}</label>

                              <div class="col-sm-8">
                                <select class="form-control select2" name="channel" id="channel">
                                <option value="">{{ trans('message.form.select_one') }}</option>
                               
                                <option value="facebook">{{ trans('message.extra_text.facebook') }}</option>
                                <option value="twitter">{{ trans('message.extra_text.twitter') }}</option>
                                <option value="lazada">{{ trans('message.extra_text.lazada') }}</option>
                                <option value="line">{{ trans('message.extra_text.line') }}</option>

                                </select>
                              </div><br/><br/>
                              <h4 class="text-info text-center">{{ trans('message.invoice.billing_address') }} </h4>
                            <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_street" value="" id="bill_street">
                                  </div>
                                </div><br/><br/>
                                
                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_city" value="" id="bill_city">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_state" value="" id="bill_state">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_zipCode" value="" id="bill_zipCode">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                                  <div class="col-sm-8">
                                    <select class="form-control select2" name="bill_country_id" id="bill_country_id">
                                    <option value="">{{ trans('message.form.select_one') }}</option>
                                    @foreach ($countries as $data)
                                      
                                      <option value="{{$data->code}}">{{$data->country}}</option>
                                    @endforeach
                                    </select>
                                  </div>
                                </div>
                                </div>
                               
                            
                          </div>
                          
                          <div class="col-md-6">
                              <h4 class="text-info text-center">{{ trans('message.invoice.shipping_address') }}</h4>

                                <div class="form-group">
                              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.form.name') }}</label>

                              <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_name" value="" id="shipping_name">
                              </div>
                            </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_street" name="ship_street" value="">
                                  </div>
                                </div><br/><br/>
                                
                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_city" name="ship_city" value="">
                                  </div>
                                </div><br/><br/>
                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_state" name="ship_state" value="">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_zipCode" name="ship_zipCode" value="">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                                  <div class="col-sm-8">
                                    <select class="form-control select2" name="ship_country_id" id="ship_country_id">
                                    <option value="">{{ trans('message.form.select_one') }}</option>
                                    @foreach ($countries as $data)
                                     
                                      <option value="{{$data->code}}">{{$data->country}}</option>
                                    @endforeach
                                    </select>
                                  </div>
                                </div>
                          </div>
                          
                        </div>