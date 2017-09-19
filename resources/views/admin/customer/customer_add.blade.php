@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
           <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.customer') }}</div>
          </div> 
        </div>
      </div>
    </div> 
        
        <div class="box">
                <!-- form start --> 
                      <form action="{{ url('save-customer') }}" method="post" id="customerAdd" class="form-horizontal">
                      
                      <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                      <div class="box-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="col-md-8">
                            <h4 class="text-info text-center">{{ trans('message.invoice.customer_info') }}</h4>
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.name') }}</label>

                              <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" value="{{old('name')}}" id="name">
                              </div>
                            </div>
							
                            
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.table.phone') }}</label>

                              <div class="col-sm-8">
                                <input type="text" value="{{old('phone')}}" class="form-control" name="phone">
                              </div>
                            </div>

                            
                                <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.channel_id') }}</label>

                              <div class="col-sm-8">
                                <input type="text" value="{{old('channel_id')}}" class="form-control" name="channel_id">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.channel') }}</label>

                              <div class="col-sm-8">
                                <select class="form-control select2" name="channel_name" id="channel">
                                <option value="">{{ trans('message.form.select_one') }}</option>
                                <option value="facebook">{{ trans('message.extra_text.facebook') }}</option>
                                <option value="twitter">{{ trans('message.extra_text.twitter') }}</option>
                                <option value="lazada">{{ trans('message.extra_text.lazada') }}</option>
                                <option value="line">{{ trans('message.extra_text.line') }}</option>

                                </select>
                              </div>
                            </div>
                          </div>
                          
                        
                        </div>
                      </div><br>
                      </div>
                        <!-- /.box-body -->
                        
                        <div class="box-footer">
                          <a href="{{ url('customer/list') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                          <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                        </div>
                        <!-- /.box-footer -->
                      </form>
          
        </div>
        
        <!-- /.box-footer-->
      
      <!-- /.box -->

    </section>
@endsection

@section('js')
    <script type="text/javascript">

    $(".select2").select2();
      // Item form validation
    $('#customerAdd').validate({
        rules: {
            name: {
                required: true
            },
            email:{
                required: true
            },

            bill_street: {
                required: true
            },
            bill_city:{
                required: true
            },
            bill_state:{
               required: true
            },
            bill_country_id:{
               required: true
            },
           
            bill_zipCode:{
               required: true
            },

            ship_street: {
                required: true
            },
            ship_city:{
                required: true
            },
            ship_state:{
               required: true
            },
            ship_country_id:{
               required: true
            },
          ship_zipCode:{
               required: true
            }

        }
    });

    $('#copy').on('click', function() {


        $('#shipping_name').val($('#name').val());
        $('#ship_street').val($('#bill_street').val());
        $('#ship_city').val($('#bill_city').val());
        $('#ship_state').val($('#bill_state').val());
        $('#ship_zipCode').val($('#bill_zipCode').val());

       var bill_country = $('#bill_country_id').val();

 $("#ship_country_id").val(bill_country).change();
    });
    </script>
@endsection