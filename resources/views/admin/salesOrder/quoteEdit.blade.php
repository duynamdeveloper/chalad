@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box box-default">
      <div class="box-body">
        <div class="row ">
          <div class="col-md-12 ">
          
           @if($quote_cust_info[0]->status==0)
            <div class="top-bar-title btn-danger text-center padding-bottom">
           <strong>Status : {{ trans('message.extra_text.quote_pending') }}</strong>
           @elseif($quote_cust_info[0]->status==1)
            <div class="top-bar-title btn-success text-center padding-bottom">
           <strong>Status : {{trans('message.extra_text.quote_approve')}} -> Order #333</strong>
           @endif
           </div>
          </div> 
          <div class="col-md-2">
            
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-8">
        <div class="box box-default">
        <!-- /.box-header -->
        <div class="top-bar-title text-center padding-bottom">
           <h2><strong>Quote # {{$quote_cust_info[0]->id}}</strong></h2>
           
           </div>
        
        <div class="box-body">
        <form action="{{url('quote/update')}}" method="POST" id="salesForm">  
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <div class="row">
            
        <input type="hidden" value="{{$quote_cust_info[0]->id}}" name="quote_id" id="trn_quote_id">
                      
                      
                      <div class="box-body">
                      <div class="row">
                        <style type="text/css">
  select{
    cursor: pointer;
  }
</style>

<div class="col-md-12">

           
                          <div class="col-md-6">    
<div class=""><h4 style="margin-top: -6px;"  class="text-info"><strong>Customer Detail</strong></h4></div>						  
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.name') }}</label>

                              <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name" value="{{$quote_cust_info[0]->name}}">
                              </div>
                            </div><br/><br/>
                          
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.table.phone') }}</label>

                              <div class="col-sm-8">
                                <input type="text" value="{{$quote_cust_info[0]->phone}}" class="form-control" name="phone">
                              </div>
                            </div><br/><br/>
                             <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.channel_id') }}</label>

                              <div class="col-sm-8">
                                <input type="text" value="{{$quote_cust_info[0]->channel_id}}" class="form-control" name="channel_id">
                              </div>
                            </div><br/><br/>
                            <div class="form-group">
                              <label class="col-sm-4 control-label require" for="inputEmail3">{{ trans('message.form.channel') }}</label>

                              <div class="col-sm-8">
                                <select class="form-control select2" name="channel" id="channel">
                                <option value="">{{ trans('message.form.select_one') }}</option>
                                @if(!empty($quote_cust_info[0]->channel))
                                <option value="{{$quote_cust_info[0]->channel}}" selected="true">{{ $quote_cust_info[0]->channel }}</option>
                                @endif
                                <option value="facebook">{{ trans('message.extra_text.facebook') }}</option>
                                <option value="twitter">{{ trans('message.extra_text.twitter') }}</option>
                                <option value="lazada">{{ trans('message.extra_text.lazada') }}</option>
                                <option value="line">{{ trans('message.extra_text.line') }}</option>

                                </select>
                              </div><br/><br/>
                              <div class="form-group">
                                 

                                  <div class="col-sm-12">
                                    <p class="text-info"><input type="checkbox"  id="different_billing_address">  {{ trans('message.invoice.different_billing_address') }} </p>
                                  </div>
                                </div><br/><br/>

                          <div id="different_billing_address_div" style="display:none;">    
                              
                            <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_street" value="{{$quote_cust_info[0]->bill_street}}" id="bill_street">
                                  </div>
                                </div><br/><br/>
                                
                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_city" value="{{$quote_cust_info[0]->bill_city}}" id="bill_city">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_state" value="{{$quote_cust_info[0]->bill_state}}" id="bill_state">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" name="bill_zipCode" value="{{$quote_cust_info[0]->bill_zipCode}}" id="bill_zipCode">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                                  <div class="col-sm-8">
                                    <select class="form-control select2" name="bill_country_id" id="bill_country_id">
                                    <option value="">{{ trans('message.form.select_one') }}</option>
                                    @foreach ($countries as $data)
                                      @if($quote_cust_info[0]->bill_country_id = $data->code)
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
                                 <h4 style="margin-top: -6px;"  class="text-info"><strong>{{ trans('message.invoice.shipping_address') }}</strong></h4>
                                 
                                 
                                <div class="form-group">
                              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.form.name') }}</label>

                              <div class="col-sm-8">
                                <input type="text" class="form-control" name="shipping_name" id="shipping_name" value="{{$quote_cust_info[0]->shipping_name}}">
                              </div>
                            </div><br/><br />

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_street" name="ship_street" value="{{$quote_cust_info[0]->ship_street}}">
                                  </div>
                                </div><br/><br/>
                                
                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_city" name="ship_city" value="{{$quote_cust_info[0]->ship_city}}">
                                  </div>
                                </div><br/><br/>
                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_state" name="ship_state" value="{{$quote_cust_info[0]->ship_state}}">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

                                  <div class="col-sm-8">
                                    <input type="text" class="form-control" id="ship_zipCode" name="ship_zipCode" value="{{$quote_cust_info[0]->ship_zipCode}}">
                                  </div>
                                </div><br/><br/>

                                <div class="form-group">
                                  <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

                                  <div class="col-sm-8">
                                    <select class="form-control select2" name="ship_country_id" id="ship_country_id">
                                    <option value="">{{ trans('message.form.select_one') }}</option>
                                    @foreach ($countries as $data)
                                     @if($quote_cust_info[0]->ship_country_id = $data->code)
                                      <option value="{{$data->code}}" selected="true">{{$data->country}}</option>
                                      @endif
                                      <option value="{{$data->code}}">{{$data->country}}</option>
                                    @endforeach
                                    </select>
                                  </div>
                                </div>
                          </div>
                          
                        </div>

                      </div><br>
                      </div>
                        <!-- /.box-body
                        
                        <div class="box-footer">
                          <a href="{{ url('customer/list') }}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                          <button class="btn btn-primary pull-right btn-flat" type="submit">{{ trans('message.form.submit') }}</button>
                        </div>
                         /.box-footer -->
                      <!--</form>-->
          
        
                       

           

            
        </div>

        

        <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                  <label for="exampleInputEmail1">{{ trans('message.form.add_item') }}</label>
                  <input class="form-control auto" placeholder="{{ trans('message.invoice.search_item') }}" id="search">

                <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="no_div" tabindex="0" style="display: none; top: 60px; left: 15px; width: 520px;">
                <li>No record found!</li>
                </ul>


              </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="text-center" id="quantityMessage" style="color:red; font-weight:bold">
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <!-- /.box-header -->
              <div class="box-body no-padding">
                <div class="table-responsive">
                <table class="table table-bordered" id="purchaseInvoice">
                  <tbody>

                  <tr class="tbl_header_color dynamicRows">
                    <th width="30%" class="text-center">{{ trans('message.table.description') }}</th>
                    <th width="30%" class="text-center">{{ trans('message.table.current_stock') }}</th>
                    <th width="10%" class="text-center">{{ trans('message.table.quantity') }}</th>
                   <!-- <th width="10%" class="text-center">{{ trans('message.table.unit_weight') }}</th>
                    <th width="10%" class="text-center">{{ trans('message.table.total_weight') }}</th>-->
                    <th width="10%" class="text-center">{{ trans('message.table.rate') }}({{Session::get('currency_symbol')}})</th>
                    <th width="10%" class="text-center">{{ trans('message.table.discount') }}</th>
                    <th width="10%" class="text-center">{{ trans('message.table.amount') }}({{Session::get('currency_symbol')}})</th>
                    <th width="5%"  class="text-center">{{ trans('message.table.action') }}</th>
                  </tr><?php $sumsubtotal=0;$subtotal=0;?>
                  @foreach($quote_details as $quote_details)
                  <?php $subtotal= $quote_details->item_quantity*$quote_details->unit_price;
                    $sumsubtotal=$subtotal+$sumsubtotal;
                        
                  ?>
                 <tr id="rowid_{{$quote_details->item_id}}">
                          <td class="text-center">{{$quote_details->product_name}}<input type="hidden" name="stock_id[]" value="{{$quote_details->  stock_id}}">
                          <input type="hidden" name="description[]" value="{{$quote_details->product_name}}"></td>
                          <td class="text-center"><input class="form-control text-center" name="stock[]" value="{{$quote_details->stock}}" readonly/></td>
                          <td><input class="form-control text-center no_units" min="0" data-id="{{$quote_details->item_id}}" 
                          data-rate="{{$quote_details->unit_price}}" type="text" id="qty_{{$quote_details->item_id}}" name="item_quantity[]" value="{{$quote_details->item_quantity}}">
                          <input type="hidden" name="item_id[]" value="{{$quote_details->item_id}}"></td>
                          
                          <input class="form-control text-center weight" type="hidden"  id="weight_{{$quote_details->item_id}}" value="{{$quote_details->item_weight}}" name="item_weight[]" readonly>

                          <input class="form-control text-center total_weight" type="hidden"  id="ttl_weight_{{$quote_details->item_id}}" value="{{$quote_details->item_weight *$quote_details->item_quantity }}" name="" readonly>

                          <td class="text-center"><input min="0"  type="text" class="form-control text-center unitprice" name="unit_price[]" data-id = "{{$quote_details->item_id}}" id="rate_id_{{$quote_details->item_id}}" value="{{$quote_details->unit_price}}"></td>

                          <td class="text-center"><input type="text" class="form-control text-center discount" name="discount[]" data-input-id="{{$quote_details->item_id}}" id="discount_id_{{$quote_details->item_id}}" max="100" min="0"></td>
                          <td><input class="form-control text-center amount" type="text" amount-id = "{{$quote_details->item_id}}" id="amount_{{$quote_details->item_id}}" value="{{$quote_details->unit_price*$quote_details->item_quantity}}" name="item_price[]" readonly></td>
                          <td class="text-center"><button id="{{$quote_details->item_id}}" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>
                          </tr>
                  @endforeach
                  <tr class="tableInfo"><td colspan="4" align="right"><strong>{{ trans('message.table.sub_total') }}({{Session::get('currency_symbol')}})
                  </strong></td><td align="left" colspan="2"><input type="text" class="form-control" id="subTotal" name="subtotal" value="<?php echo $sumsubtotal ?>" readonly></td></tr>
                  
                  <tr class="tableInfo"><td colspan="4" align="right"><strong>{{ trans('message.invoice.is_vat') }}</strong></td><td align="left" colspan="2">

                  @if($quote_cust_info[0]->is_vat==1)
                    <input type="checkbox" name="is_vat"  id="is_vat" checked="checked">
                  
                  @else
                  <input type="checkbox" name="is_vat"  id="is_vat">
                  @endif 
                  </td></tr>

                  <input type="hidden" class="form-control" name="total_weight" value="{{$quote_cust_info[0]->total_weight}}" id="total_weight" readonly>

                    <tr class="tableInfo"><td colspan="4" align="right"><strong>{{ trans('message.invoice.shipping_method') }}</strong></td><td align="left" colspan="2">
                    <select  class="form-control select2" name="shipping_method" id="shipping_method" required="required" >
                    <option value="1">Select Method</option>
                      @if($quote_cust_info[0]->shipping_method=='EMS'){
                      <option value="EMS" selected="selected">EMS</option>
                      <option value="Registered">Registered</option>}
                      @elseif($quote_cust_info[0]->shipping_method=='Registered')
                      {
                      <option value="EMS" >EMS</option>
                      <option value="Registered" selected="selected">Registered</option>}
                      @endif
                    </select>
                    </td>
                    
                    </tr>
                    <tr class="tableInfo" id="shipping_cost_div"><td colspan="4" align="right"><strong>{{ trans('message.invoice.shipping_cost') }}</strong></td><td align="left" colspan="2">
                        <input type="text" class="form-control" name="shipping_cost" id="shipping_cost" readonly>
                    </td>
                    </tr>

                  <tr class="tableInfo"><td colspan="4" align="right">
                      <strong>{{ trans('message.table.grand_total') }}({{Session::get('currency_symbol')}})</strong></td><td align="left" colspan="2">
                          <input type='text' name="total" class="form-control" id = "grandTotal" value="{{$quote_cust_info[0]->total}}"  readonly></td></tr>
                  </tbody>
                </table>
                </div>
                 <div class="col-md-12 pull-left">
              <div class="form-group">
                    <label for="exampleInputEmail1">{{ trans('message.table.note') }}</label>
                    <textarea placeholder="{{ trans('message.table.description') }} ..." rows="3" class="form-control" name="comments"></textarea>
                </div>
               
              </div>
              </div>
            </div>
              <!-- /.box-body -->
             
              
        </div>
        
      </div>
          <!-- /.row --> 
    </div>
    </div>
     <div class="col-md-4">
        <div class="box box-default">
        
        <div class="box-body">

          <div class="row">
          <div class="col-md-12">
            <div class="text-center" >
			<h4 class="text-center text-info" style="padding:10px; background-color:#f2f2f3;">Actions</h4>
                 <a href="{{url('/order/list')}}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
                 @if($quote_cust_info[0]->status==0)
                  <button type="submit" name="approve" class="btn btn-success btn-flat" id="btnSubmit">{{ trans('message.form.approve') }}</button>

                <button type="submit" name="save" class="btn btn-primary btn-flat " id="btnSubmit">{{ trans('message.form.save_quote') }}</button>
                
                @endif

              </div>
          </div>
            
          </div>
        </div>
      </div>
      </form>  
    </div> 
         <div class="col-md-4">
        <div class="box box-default">
        
        <div class="box-body">

          <div class="row">
          
            <div class="col-md-12 ">
             <div class="top-bar-title">{{ trans('message.invoice.summary') }}</div>
            </div><br/><br/>

            <table class="table table-bordered" >
                      <tbody>
                      <tr class=" dynamicRows">
                        <th width="40%" class="text-center">{{ trans('message.table.item_ordered') }}</th> 
                        <th  width="40%" class="text-center">{{number_format($item_quantity)}}</th>                      
                      </tr>
                      <tr class=" dynamicRows">
                        <th width="40%" class="text-center">{{ trans('message.table.order_amount') }}</th>     
                        <th width="40%" class="text-center">{{number_format($quote_cust_info[0]->total,2)}}</th>                   
                      </tr>
                      <tr class=" dynamicRows">
                        <th width="40%" class="text-center">{{ trans('message.table.paid_amount') }}</th>     
                        <th width="40%" class="text-center">{{number_format($paid_amount,2)}}</th>                   
                      </tr>
                      
                    
                      </tbody>
                    </table>
          </div>
        </div>
      </div>
        
    </div> 
 
     <div class="col-md-4">
        <div class="box box-default">
        <div class="box-body">
          <div class="row">
            <div class="col-md-7">
             <div class="top-bar-title">{{ trans('message.invoice.payment_grid') }}</div>
            </div>
			<div class="col-md-5">
              <button title="{{ trans('message.invoice.pay_now')}}" type="button" class="btn btn-default btn-flat success-btn quote_payment" id="paynow"
                data-toggle="modal" data-quote_id="{{$quote_cust_info[0]->id}}" data-customer="{{$quote_cust_info[0]->name}}" 
                data-target="#payModal">{{ trans('message.invoice.add_payment')}}</button>
            </div>
			<br/><br/>
            <table class="table table-bordered" >
                      <tbody>
                      <tr class=" dynamicRows">
                        <th width="10%" class="text-center">{{ trans('message.table.id') }}</th>
                        <th width="15%" class="text-center">{{ trans('message.table.date') }}</th>
                        <th width="10%" class="text-center">{{ trans('message.table.method') }}</th>
                        <th width="10%" class="text-center">{{ trans('message.table.attached') }}</th>
                        <th width="10%" class="text-center">{{ trans('message.table.amount') }}</th>
                      </tr>
                      @if(!empty($quote_payment))
                      @foreach($quote_payment as $quote_payment)
                        <tr>
                            <td width="10%" class="text-center">{{$quote_payment->id}}</td>
                            <td width="15%" class="text-center">{{$quote_payment->create_time }}</td>
                            <td width="10%" class="text-center">{{$quote_payment->payment_method }}</td>
                            <td width="10%" class="text-center"><a href="{{url('public/uploads/Quote_recipt_Pic/'.$quote_payment->payment_image)}}">{{$quote_payment->payment_image}}</a></td>
                            <td width="10%" class="text-center">{{$quote_payment->amount}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan="5" class="text-center">NO Payment Made.</td></tr>
                      @endif
                      </tbody>
                    </table>
          </div>
        </div>
      </div>
        
    </div>  
    </div>
    
    
  <!--Pay Modal End-->
    
    </section>
    <div class="modal fade" id="payModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('message.table.new_payment') }}</h4>
          <p></p>
        </div>
        <div class="modal-body">

       <form action="{{ url('save-quote_payment') }}" method="post" enctype="multipart/form-data" id="customerAdd" class="form-horizontal">
                      
          <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
          
          <div class="form-group">
            <label for="payment_type_id" class="col-sm-3 control-label">{{ trans('message.form.payment_type') }} : </label>
            <div class="col-sm-6">

              <select style="width:100%" class="form-control select2" name="payment_type_id" id="payment_type_id">
               <option value="">Select Payment Type</option>
               <option value="cash">Cash</option>
               <option value="transfer">Bank Transfer</option>
              </select>

            </div>
          </div>
          
          
          <div class="form-group">
            <label for="amount" class="col-sm-3 control-label">{{ trans('message.invoice.quote') }} : </label>
            <div class="col-sm-6">
              <input type="number" name="quote_id" value="" class="form-control" id="quote_id" placeholder="Quote ID" readonly>
            </div>
          </div>
          
          <div class="form-group">
            <label for="amount" class="col-sm-3 control-label">{{ trans('message.invoice.amount') }} : </label>
            <div class="col-sm-6">
              <input type="number" name="amount" value="" class="form-control" id="amount" placeholder="Amount">
            </div>
          </div>
          <div class="form-group">
            <label for="payment_date" class="col-sm-3 control-label">{{ trans('message.invoice.paid_no') }} : </label>
            <div class="col-sm-6">
              <input type="text" name="payment_date" class="form-control" id="payment_date" placeholder="">
            </div>
          </div>
            <div class="form-group">
                              <label class="col-sm-3 control-label" for="inputEmail3">{{ trans('message.form.picture') }}</label>
                              <div class="col-sm-6">
                                <input type="file" class="form-control input-file-field" name="payment_image">
                              </div>
                            </div>
          

          <div class="form-group">
            <div class="col-sm-offset-3 col-sm-6">
              <button type="submit" class="btn btn-primary btn-flat">{{ trans('message.invoice.pay_now') }}</button>
              <button type="button" class=" btn btn-danger btn-flat" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
    <script type="text/javascript">
    
$(document).on("click", ".quote_payment", function () {
     var myBookId = $('#trn_quote_id').val();
     var amount = $('#grandTotal').val();
     console.log(myBookId);
     //alert(myBookId);
     $("#payModal #quote_id").val( myBookId );
     //$("#payModal #amount").val( amount );
     
});
$(document).ready(function() {
      $("#payment_type_id").select2();
      $('#payment_date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: '{{Session::get('date_format_type')}}'
    });  
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

    
    $(document).ready(function(){
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
        var val = $(this).val();

        if(val == null || val == ''){
         $("#errMsg").html("{{ trans('message.invoice.exist') }}");
          $('#btnSubmit').attr('disabled', 'disabled');
          return;
         }else{
          $('#btnSubmit').removeAttr('disabled');
         }

        var ref = 'SO-'+$(this).val();
        $("#reference_no_write").val(ref);
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
        $(".select2").select2({});

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: '{{Session::get('date_format_type')}}'
        });

        $('.ref').val(Math.floor((Math.random() * 100) + 1));
       
         $('#datepicker').datepicker('update', new Date());
    });

    var stack = [];
    var token = $("#token").val();

    $( "#search" ).autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "{{URL::to('quote/search')}}",
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
                            stock:item.stock,
                            weight:item.weight
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

        select: function(event, ui) {
          var e = ui.item;
          if(e.id) {
              if(!in_array(e.id, stack))
              {
                stack.push(e.id);
                var taxAmount = e.tax_rate;
                var new_row = '<tr id="rowid'+e.id+'">'+
                          '<td class="text-center">'+ e.value +'<input type="hidden" name="stock_id[]" value="'+e.stock_id+'"><input type="hidden" name="description[]" value="'+e.value+'"></td>'+
                          '<td class="text-center">'+ e.stock +'</td>'+
                          '<td><input class="form-control text-center no_units" min="0" data-id="'+e.id+'" data-rate="'+ e.price +'" type="text" id="qty_'+e.id+'" name="item_quantity[]" value="1"><input type="hidden" name="item_id[]" value="'+e.id+'"></td>'+
                          
                          '<td><input class="form-control text-center weight" type="text"  id="weight_'+e.id+'" value="'+e.weight +' gm'+'" name="item_weight[]" readonly></td>'+

                            '<td><input class="form-control text-center total_weight" type="text"  id="ttl_weight_'+e.id+'" value="'+e.ttlweight +' gm'+'" name="" readonly></td>'+

                          '<td class="text-center"><input min="0"  type="text" class="form-control text-center unitprice" name="unit_price[]" data-id = "'+e.id+'" id="rate_id_'+e.id+'" value="'+ e.price +'"></td>'+

                          '<td class="text-center"><input type="text" class="form-control text-center discount" name="discount[]" data-input-id="'+e.id+'" id="discount_id_'+e.id+'" max="100" min="0"></td>'+
                          '<td><input class="form-control text-center amount" type="text" amount-id = "'+e.id+'" id="amount_'+e.id+'" value="'+e.price+'" name="item_price[]" readonly></td>'+
                          '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>'+
                          '</tr>';
                
                $(new_row).insertAfter($('table tr.dynamicRows:last'));
                // Calculate total tax
                $(function() {
                    $("#rowid"+e.id+'.total_weight').val(e.tax_id);
                });
                $(function() {
                    $("#ttl_weight_"+e.id).val(e.weight);
                });
                
                var taxRateValue = parseFloat( $("#rowid"+e.id+' .taxList').find(':selected').attr('taxrate'));

                // Calculate subtotal
                var subTotal = calculateSubTotal();
                $("#subTotal").val(subTotal);

                //var taxTotal = calculateTaxTotal();
                //$("#taxTotal").text(taxTotal);
                var grandTotal = (subTotal);
                $("#grandTotal").val(grandTotal);

                $("#total_weight").val(e.weight);
                
               var sub_weight = calculateweight();
                  $("#total_weight").val(sub_weight);
                 

                $('.tableInfo').show();

              } else {
                  $('#qty_'+e.id).val( function(i, oldval) {
                      return ++oldval;
                  });
                  
                  //console.log(oldval);
                  var q = $('#qty_'+e.id).val();
                  
                  //cal total weight = qty*weight
                  
                  //alert(plant);
                  var total_weight = parseFloat(q)*parseFloat($('#weight_'+e.id).val());
                  $("#ttl_weight_"+e.id).val(total_weight);

                  var sub_weight = calculateweight();
                  $("#total_weight").val(sub_weight);
                   /*$('#total_weight').val( function(i, aoldval) {
                      return ++aoldval;
                  });*/
                  $("#rate_id_"+e.id).val();
                  r = parseFloat($("#rate_id_"+e.id).val());
                
                  

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

                // Calculate subTotal
                var subTotal = calculateSubTotal();
                $("#subTotal").val(subTotal);

                // Calculate taxTotal
                var taxTotal = calculateTaxTotal();
                $("#taxTotal").text(taxTotal);

                // Calculate GrandTotal
                var grandTotal = (subTotal );
                $("#grandTotal").val(grandTotal);

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
     

     // calculate amount with item quantity
    $(document).on('keyup', '.no_units', function(ev){
      var id = $(this).attr("data-id");
      var qty = parseInt($(this).val());
      var token = $("#token").val();
      var from_stk_loc = $("#loc").val();
      // check item quantity in store location
      $.ajax({
        method: "POST",
        url: SITE_URL+"/sales/quantity-validation",
        data: { "id": id, "location_id": from_stk_loc,'qty':qty,"_token":token }
      })
        .done(function( data ) {
          var data = jQuery.parseJSON(data);
          if(data.status_no == 0){
            $("#quantityMessage").html(data.message);
            $("#rowid"+id).addClass("insufficient");
          }else{
            $("#rowid"+id).removeClass("insufficient");
            $("#quantityMessage").hide();
          }
        });


      if(isNaN(qty)){
          qty = 0;
       }
       var weight=$("#weight_"+id).val();
      console.log(id);
      $("#ttl_weight_"+id).val(parseFloat(weight)*qty);


      $("#is_vat").attr('checked', false).change();
      $("#shipping_method option[value='1']").attr('selected', 'selected').change();

      var rate = $("#rate_id_"+id).val();
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

      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").val(subTotal);
      // Calculate taxTotal
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
      var grandTotal = (subTotal);
      $("#grandTotal").val(grandTotal);

      var sub_weight = calculateweight();
      $("#total_weight").val(sub_weight);

    });

     // calculate weight with quantity
    $(document).on('keyup', '.no_units', function(ev){
     
      var qty = parseFloat($(this).val());

      if(isNaN(weight)){
          discount = 0;
       }
     
      
      
      var id = $(this).attr("data-input-id");
      var qty = $("#qty_"+id).val();
      var weight=$("#weight_"+id).val();
      console.log(id);
      $("#ttl_weight_"+id).val(parseFloat(weight)*qty);

      var rate = $("#rate_id_"+id).val();
      var discountRate = $("#discount_id_"+id).val();
      var price = calculatePrice(qty,rate); 
      var discountPrice = calculateDiscountPrice(price,discountRate);       
      $("#amount_"+id).val(discountPrice);
      
       $("#is_vat").attr('checked', false).change();

      $("#shipping_method option[value='1']").attr('selected', 'selected').change();

     var taxRateValue = parseFloat( $("#rowid"+id+' .taxList').find(':selected').attr('taxrate'));
     var amountByRow = $('#amount_'+id).val(); 
     var taxByRow = amountByRow*taxRateValue/100;
     $("#rowid"+id+" .taxAmount").text(taxByRow);

      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").val(subTotal);
      // Calculate taxTotal
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
      var grandTotal = (subTotal);
      $("#grandTotal").val(grandTotal);


      var sub_weight = calculateweight();
      $("#total_weight").val(sub_weight);
    });

     // calculate amount with discount
    $(document).on('keyup', '.discount', function(ev){
     
      var discount = parseFloat($(this).val());

      if(isNaN(discount)){
          discount = 0;
       }
     
       $("#is_vat").attr('checked', false).change();
      $("#shipping_method option[value='1']").attr('selected', 'selected').change();
      
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

      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").val(subTotal);
      // Calculate taxTotal
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
      var grandTotal = (subTotal);
      $("#grandTotal").val(grandTotal);

    });


     // calculate amount with unit price
    $(document).on('keyup', '.unitprice', function(ev){
     
      var unitprice = parseFloat($(this).val());

      if(isNaN(unitprice)){
          unitprice = 0;
       }
      $("#is_vat").attr('checked', false).change();

      $("#shipping_method option[value='1']").attr('selected', 'selected').change();
      
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

      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").val(subTotal);
      // Calculate taxTotal
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
      var grandTotal = (subTotal );
      $("#grandTotal").val(grandTotal);

    });

    $(document).on('change', '.taxList', function(ev){
      var taxRateValue = $(this).find(':selected').attr('taxrate');
      var rowId = $(this).closest('tr').prop('id');
      var amountByRow = $("#"+rowId+" .amount").val(); 
      
      var taxByRow = amountByRow*taxRateValue/100;

      $("#"+rowId+" .taxAmount").text(taxByRow);

      // Calculate subTotal
      var subTotal = calculateSubTotal();
      $("#subTotal").val(subTotal);
      // Calculate taxTotal
      var taxTotal = calculateTaxTotal();
      $("#taxTotal").text(taxTotal);
      // Calculate GrandTotal
      var grandTotal = (subTotal );
      $("#grandTotal").val(grandTotal);

    });

    $(document).on('change', '#shipping_method', function(ev){

      var method=$(this).val();
      if(method== 1)
        method=0;
      //alert(method);
      var subTotal = calculateSubTotal();
      var sub_weight = calculateweight();
     //alert(sub_weight);
       
      $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});                    
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
                      if($("#is_vat").is(':checked')){
                        var grandTotal = (subTotal+(subTotal*.07)+parseFloat(data));
                        $("#grandTotal").val(grandTotal); 
                        //alert(data);
                        $("#shipping_cost").val(data);
                        $("#shipping_cost_div").show("fast");
                      }
                      else
                      {
                        alert(data);
                          var grandTotal = (subTotal);
                          $("#shipping_cost").val(data);
                         $("#grandTotal").val(grandTotal+parseFloat(data));
                         $("#shipping_cost_div").show("fast");
                      }
                }
            });


      
      

    });
    
    $(document).ready(function() {
        $("#is_vat").click(function() {
            var shipping_method=$("#shipping_method").val();
            var subTotal = calculateSubTotal();
            //alert(subTotal) ;
            //$("#shipping_method").val("").attr("selected", true);;
            var checked = $(this).is(':checked');
            if (checked) {
              var grand_total = calculateSubTotal();
              var grand_final = parseFloat(grand_total)+parseFloat(grand_total*.07);
              //alert(grand_final);
                $("#grandTotal").val(grand_final);
            } else {
                var subTotal = calculateSubTotal();
              var grand_final = parseFloat(subTotal);
              
                $("#grandTotal").val(grand_final);
            }
         //$('#shipping_method').val("").attr("selected", "selected");
         $("#shipping_method option[value='1']").attr('selected', 'selected').change();
        });
    });

    $(document).ready(function() {
        $("#different_billing_address").click(function() {
            //var shipping_method=$("#shipping_method").val();
            //var subTotal = calculateSubTotal();
            //alert(subTotal) ;
            //$("#shipping_method").val("").attr("selected", true);;
            var checked = $(this).is(':checked');
            //alert(checked);
            if (checked) 
              
                //$('#different_billing_address_div').show("fast");
              $('#different_billing_address_div').show("fast");
             else 
               $("#different_billing_address_div").hide("fast");
            
         
        });
    });

    


    // Delete item row
    $(document).ready(function(e){
      $('#purchaseInvoice').on('click', '.delete_item', function() {
            var v = $(this).attr("id");
            stack = jQuery.grep(stack, function(value) {
              return value != v;
            });
            
            $(this).closest("tr").remove();
            $("#is_vat").attr('checked', false).change();
            $("#shipping_method option[value='1']").attr('selected', 'selected').change();
           var taxRateValue = parseFloat( $("#rowid"+v+' .taxList').find(':selected').attr('taxrate'));
           var amountByRow = $('#amount_'+v).val(); 
           var taxByRow = amountByRow*taxRateValue/100;
           $("#rowid"+v+" .taxAmount").text(taxByRow);

            var subTotal = calculateSubTotal();
            $("#subTotal").val(subTotal);
           

           var weight_total=calculateweight();
           // alert(weight_total);
            $("#total_weight").val(weight_total);

            var taxTotal = calculateTaxTotal();
            $("#taxTotal").text(taxTotal);
            // Calculate GrandTotal
            var grandTotal = (subTotal );
            $("#grandTotal").val(grandTotal);           

        });
    });
      
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
      
      /**
      * Calcualte Sub Total 
      *@return subTotal
      */
      function calculateSubTotal (){
        var subTotal = 0;
        $('.amount').each(function() {
            subTotal += parseFloat($(this).val());
        });
        return subTotal;
      }
      
      
      function calculateweight (){
        var sub_weight = 0;
        $('.total_weight').each(function() {
            sub_weight += parseFloat($(this).val());
        });
        return sub_weight;
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
    $('#customerAdd').validate({
        rules: {
            payment_method: {
                required: true

            },
            payment_date: {
                required: true
            },           
            amount:{
              required:true
            }                    
        }
    });
     $( "#search_mobile" ).on('keyup', function() {
        $mobile_no = $('#search_mobile').val();

             $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});                    
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $('#category_product_code').empty();
            $caterory_in = 0;
            $.ajax({
                url: 'customer_details/'.concat($mobile_no),
                type: 'get',
                contentType: 'application/json',
                data: {_token: CSRF_TOKEN},
                //dataType: 'JSON',
                success: function (data) {
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                    $("#search_mobile").css("background","#FFF");

                    //$('#search_mobile').append("<option value="+data+">"+data+"</option>");
                    //$('#details').html(data);

                }
            });

    });
     function selectCountry(val) {
$("#search_mobile").val(val);
$("#suggesstion-box").hide();
 $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});                    
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
                url: 'fill_data/'.concat(val),
                type: 'get',
                contentType: 'application/json',
                data: {_token: CSRF_TOKEN},
                //dataType: 'JSON',
                success: function (data) {                   
                    
                     $("#cutomer_info").html(data);
                    

                }
            });

}
 $( "#add_new_customer" ).on('click', function() {
  val='add_new_customer';
  //alert(val);
         $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});                    
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $.ajax({
                url: 'fill_data/'.concat(val),
                type: 'get',
                contentType: 'application/json',
                data: {_token: CSRF_TOKEN},
                //dataType: 'JSON',
                success: function (data) {                   
                    
                     $("#cutomer_info").html(data);
                    

                }
            });
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