@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

    <div class="box box-default">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
           <div class="top-bar-title padding-bottom">{{ trans('message.extra_text.add_quote_payment') }}</div>
          </div> 
        </div>
      </div>
    </div> 
        
        <div class="box">
                <!-- form start -->
                      <form action="{{ url('save-quote_payment') }}" method="post" enctype="multipart/form-data" id="customerAdd" class="form-horizontal">
                      
                      <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                      <div class="box-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="col-md-6">
                            
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.transaction_id') }}</label>

                              <div class="col-sm-8">
                                <input type="text" class="form-control" name="transaction_id" value="{{$transaction_id}}" id="" readonly>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.quote_id') }}</label>

                              <div class="col-sm-8">
                                <select class="form-control select2" name="quote_id" id="quote_id">
                                  <option value="">select Quote ID</option>
                                  @foreach($quote as $quote)
                                  <option value="{{$quote->id}}">Qut-{{$quote->id}}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            
                            <div class="form-group">
                              <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.table.customer_name') }}</label>

                              <div class="col-sm-8">
                                <input type="text" value="{{old('phone')}}" class="form-control" name="customer_name">
                              </div>
                            </div>

                                <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.payment_method') }}</label>

                              <div class="col-sm-8">
                                <select class="form-control select2" name="payment_method">
                                  <option value="-1">Select Payment Method</option>
                                  <option value="Cash">Cash</option>
                                  <option value="Bank_transfer">Bank Transfer</option>
                                  
                                </select>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.form.picture') }}</label>
                              <div class="col-sm-8">
                                <input type="text" class="form-control input-file-field" name="amount">
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-4 control-label" for="inputEmail3">{{ trans('message.form.picture') }}</label>
                              <div class="col-sm-8">
                                <input type="file" class="form-control input-file-field" name="payment_image">
                              </div>
                            </div>
                             <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.status') }}</label>

                              <div class="col-sm-8">
                                <select class="form-control select2" name="status">
                                  <option value="-1">Select Status</option>
                                  <option value="Active">Active</option>
                                  <option value="Cancel">Cancel</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          
                          <div class="col-md-6">
                             
                                <div id="quote_details"></div>

                               
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

        $(document).on('change', '#quote_id', function(ev){

      var method=$(this).val();
      if(method== null)
        method=0;
      
       
      $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});                    
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            
            $.ajax({
                url: 'quote_cust_info/'.concat(method),
                type: 'get',
                contentType: 'application/json',
                data: {_token: CSRF_TOKEN},
                //dataType: 'JSON',
                success: function (data) {
                      
                          
                          $("#quote_details").html(data);
                      
                }
            });
    });



    $(".select2").select2();
      // Item form validation
    $('#customerAdd').validate({
        rules: {
            transaction_id: {
                required: true
            },
            quote_id:{
                required: true
            },
            status:{
                required: true
            },
            payment_method:{
                required: true
            },
          customer_name:{
               required: true
            }

        }
    });

    </script>
@endsection