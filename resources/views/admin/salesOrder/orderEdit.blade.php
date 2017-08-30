@extends('layouts.app')
@section('content')
<!-- Main content -->
<section class="content">
  <!-- Default box -->

  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="@if($saleData->order_status==2)btn-danger @elseif($saleData->order_status==1)btn-success @else btn-warning @endif text-center top-bar-title padding-bottom" style="margin-bottom: 15px;" id="orderStatusBar">Status: @if($saleData->order_status==2) Pending @elseif($saleData->order_status==1) Success @else Canceled @endif</div>

      </div>

      <br>
    </div>
    <div class="row">
      <div class="col-md-12" id="updateNotification" style="display: none;">
        <div class="alert alert-success alert-dismissable">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
         <strong>Success!</strong> Status has been updated successfully
       </div>
     </div>
   </div>

   <div class="row">
    <div class="col-md-8">
      <div class="box box-default">
       <div class="box-header">
        <h2 class="text-info text-center">{{ trans('message.table.order_no')}} # <a href="{{url('order/view-order-details/'.$saleData->order_no)}}">{{$saleData->reference}}</a></h2>
      </div>
      <!-- /.box-header -->
      <div class="box-body">

        <form action="{{url('order/update')}}" method="POST" id="salesForm" class="form-horizontal">  
          <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
          <input type="hidden" value="{{$saleData->order_no}}" name="order_no" id="order_no">
          <input type="hidden" value="{{$saleData->reference}}" name="reference" id="reference">
          <div class="row">


            <!--Customer Detail Form-->

            <div class="col-md-6" >
              <div class="form-title">
                <h4 class="text-info text-left" style="font-weight: bold;">Customer Information</h4>
              </div>
              <br>




              <input type="hidden" value="{{$saleData->debtor_no}}" name="debtor_no">









              <div class="form-group">
                <label class="control-label col-sm-3" for="email">Name:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="name" value="{{$saleData->name}}" name="name" placeholder="Enter Name" readonly="true">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="pwd">Phone:</label>
                <div class="col-sm-9"> 
                  <input type="text" class="form-control" id="phone" value="{{$saleData->phone}}" name="phone" placeholder="Enter Phone No." readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="email">Channel:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="channel" value="{{$saleData->channel_name}}"  name="channel" placeholder="Enter Channel" readonly>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="pwd">Channel ID:</label>
                <div class="col-sm-9"> 

                  <select class="form-control select2" name="channel_id" id="channel_id" disabled>
                    <option value="{{$saleData->channel_id}}" selected="selected">{{$saleData->channel_id}}</option>
                    <option value="">{{ trans('message.form.select_one') }}</option>
                    <option value="facebook">{{ trans('message.extra_text.facebook') }}</option>
                    <option value="twitter">{{ trans('message.extra_text.twitter') }}</option>
                    <option value="lazada">{{ trans('message.extra_text.lazada') }}</option>
                    <option value="line">{{ trans('message.extra_text.line') }}</option>

                  </select>
                  <input type="hidden" name="channel_id" value="{{ $saleData->channel_id }}">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="pwd">Email:</label>
                <div class="col-sm-9"> 
                  <input type="email" class="form-control" id="email" value="{{$saleData->email}}" name="email" placeholder="Enter Email" readonly>
                </div>
              </div>
            </div>

            <!--End Customer Detail Form-->
            <!-- Shipping Address -->
            <div class="col-md-6">
             <h4 class="text-info"><strong>{{ trans('message.invoice.shipping_address') }}</strong></h4>

             <br>
             <div class="form-group">
              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.form.name') }}</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" name="shipping_name" id="shipping_name" value="{{ $saleData->shipping_name }}" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="shipping_street" name="shipping_street" value="{{ $saleData->shipping_street }}" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="shipping_city" name="shipping_city" value="{{ $saleData->shipping_city }}" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="shipping_state" name="shipping_state" value="{{ $saleData->shipping_state }}" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

              <div class="col-sm-8">
                <input type="text" class="form-control" id="shipping_zip_code" name="shipping_zip_code" value="{{ $saleData->shipping_zip_code }}" required>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

              <div class="col-sm-8">
                <select class="form-control select2" name="shipping_country_id" id="shipping_country_id">
                  <option value="">{{ trans('message.form.select_one') }}</option>
                  @foreach ($countries as $data)

                  <option value="{{$data->code}}" @if($data->code == $saleData->shipping_country_id) selected="true" @endif>{{$data->country}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <!--End Shippind Address Form-->
          <!--Billing Address-->
          <div id="different_billing_address_div" class="col-md-6">    
           <div class="form-title">
            <h4 class="text-info text-left" style="font-weight: bold;">Billing Address</h4>
            <div class="form-group">
              <div class="col-sm-12">
               <h5 class="text-info" style="font-size: 18px;"><input type="checkbox" name="billing_address_the_same_as_shipping_address" id="cbxBillingEqualShipping"> Billing address the same as shipping address</h5>
             </div>

           </div>

         </div>
         <br>
         <div class="form-group">
          <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.name') }}</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" name="billing_name"  id="billing_name" required value="{{ $saleData->billing_name }}">
          </div>
        </div>
        <div class="form-group">
         <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.street') }}</label>

         <div class="col-sm-8">
          <input type="text" class="form-control" name="billing_street" id="billing_street" required value="{{ $saleData->billing_street }}">
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.city') }}</label>

        <div class="col-sm-8">
          <input type="text" class="form-control" name="billing_city"  id="billing_city" required value="{{ $saleData->billing_city }}">
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.state') }}</label>

        <div class="col-sm-8">
          <input type="text" class="form-control" name="billing_state"  id="billing_state" value="{{ $saleData->billing_state }}" required>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.zipcode') }}</label>

        <div class="col-sm-8">
          <input type="text" class="form-control" name="billing_zip_code" id="billing_zip_code" value="{{ $saleData->billing_zip_code }}" required>
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-4 control-label " for="inputEmail3">{{ trans('message.invoice.country') }}</label>

        <div class="col-sm-8">
          <select class="form-control select2" name="billing_country_id" id="billing_country_id">
            <option value="">{{ trans('message.form.select_one') }}</option>
            @foreach ($countries as $data)

            <option value="{{$data->code}}" @if($data->code=== $saleData->billing_country_id) selected="true" @endif>{{$data->country}}</option>
            @endforeach
          </select>
        </div>
        <input type="hidden" name="billing_country_id" id="hidden_billing_country_id" disabled>
      </div>
    </div>

    <!--End Billing Address -->


  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label for="exampleInputEmail1" class="col-sm-3 control-label">{{ trans('message.form.add_item') }}</label>
        <input class="form-control auto col-sm-9" placeholder="{{ trans('message.invoice.search_item') }}" id="search">

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
          <table class="table table-bordered" id="salesInvoice">
            <tbody>

              <tr class="tbl_header_color dynamicRows">
                <th width="30%" class="text-center">{{ trans('message.table.description') }}</th>
                <th width="10%" class="text-center">{{ trans('message.table.picture') }}</th>
                <th width="10%" class="text-center">{{ trans('message.table.quantity') }}</th>
                <th width="10%" class="text-center">{{ trans('message.table.price') }}({{Session::get('currency_symbol')}})</th>

                <th width="10%" class="text-center">{{ trans('message.table.amount') }}({{Session::get('currency_symbol')}})</th>
                <th width="5%"  class="text-center">{{ trans('message.table.action') }}</th>
              </tr>
              <?php
              $taxTotal = 0;
              ?>
              @if(count($invoiceData)>0)
              @foreach($invoiceData as $result)
              <?php
              if(in_array($result->stock_id, $invoicedItem)){
                $deleteBtn = 'deleteBtn';
              }else{
                $deleteBtn = '';
              }

              $priceAmount = ($result->quantity*$result->unit_price);
              $discount = ($priceAmount*$result->discount_percent)/100;
              $newPrice = ($priceAmount-$discount);
              $tax = ($newPrice*$result->tax_rate/100);

              $taxTotal += $tax;
              ?>
              <tr id="rowid{{$result->item_id}}">
                <td class="text-center">{{$result->description}}<input type="hidden" name="description[]" value="{{$result->description}}"><input type="hidden" name="stock_id[]" value="{{$result->stock_id}}"></td>
                 <td width="10%" class="text-center"><img src="{{url('public/uploads/itemPic/'.$result->item_image)}}" width="70px" height="70px"></td>
                <td><input class="form-control text-center no_units" min="0" data-id="{{$result->item_id}}" data-rate="{{$result->unit_price}}" id="qty_{{$result->item_id}}" name="item_quantity[]" value="{{$result->quantity}}" type="text"><input name="item_id[]" value="{{$result->item_id}}" type="hidden"></td>
                <td class="text-center"><input min="0" class="form-control text-center unitprice" name="unit_price[]" data-id="{{$result->item_id}}" id="rate_id_{{$result->item_id}}" value="{{$result->unit_price}}" type="text"></td>



                <input class="form-control text-center weight" type="hidden"  id="weight_{{$result->item_id}}" value="{{$result->item_weight}}" name="item_weight[]" >
                <input class="form-control text-center total_weight" type="hidden"  id="ttl_weight_{{$result->item_id}}" value="{{$result->quantity*$result->item_weight}}" name="" >



                <td><input amount-id="{{$result->item_id}}" class="form-control text-center amount" id="amount_{{$result->item_id}}" value="{{$newPrice}}" name="item_price[]" readonly type="text"></td>
                <td class="text-center"><button id="{{$result->item_id}}" class="btn btn-xs btn-danger delete_item {{$deleteBtn}}"><i class="glyphicon glyphicon-trash"></i></button></td>
              </tr>
              <?php
              $stack[] = $result->item_id;
              ?>
              @endforeach
              <tr class="tableInfos"><td colspan="4" align="right"><strong>{{ trans('message.table.sub_total') }}({{Session::get('currency_symbol')}})</strong></td><td align="center" colspan="3"><strong id="subTotal"></strong></td></tr>
              <tr class="tableInfos"><td colspan="4" align="right"><strong>{{ trans('message.invoice.is_tax') }}</strong></td><td align="center" colspan="3">
                <select  class="form-control" name="item_tax" id="item_tax" required="required">
                  <option value="">Select One</option>
                  @foreach($vat as $vat)
                  @if($saleData->item_tax == $vat->tax_rate)
                  <option value="{{$vat->tax_rate}}" selected="selected">{{$vat->name}}</option>
                  @else
                  <option value="{{$vat->tax_rate}}">{{$vat->name}}</option>
                  @endif
                  @endforeach
                </select>
              </td></tr>
              <tr class="tableInfos"><td colspan="4" align="right"><strong>{{ trans('message.invoice.tax_amount') }}</strong></td><td align="center" colspan="2">
               <input type="text" class="form-control" name="tax_amount" id="tax_amount" readonly>
             </td></tr>
             <input type="hidden" class="form-control" name="total_weight" id="total_weight" value="{{$saleData->total_weight}}" readonly> 



             <tr class="tableInfos"><td colspan="4" align="right"><strong>{{ trans('message.invoice.shipping_method') }}</strong></td><td align="center" colspan="3">
              <select  class="form-control" name="shipping_method" id="shipping_method" required="required">
                <option value="1">Select Method</option>

                <option value="EMS" @if($saleData->shipping_method=="EMS") selected @endif>EMS</option>
                <option value="Registered" @if($saleData->shipping_method=="Registered") selected @endif>Registered</option>
              </select>
            </td></tr>
            <tr class="tableInfos" id="shipping_cost_div"><td colspan="4" align="right"><strong>{{ trans('message.invoice.shipping_cost') }}</strong></td><td align="left" colspan="2">
              <input type="text" class="form-control" value="{{$saleData->shipping_cost}}" name="shipping_cost" id="shipping_cost" readonly>
            </td>
          </tr>
          <tr class="tableInfos"><td colspan="4" align="right"><strong>{{ trans('message.invoice.discount') }}</strong></td>
            <td align="center" colspan="2">

              <input type="number" min="0" class="form-control" value="{{$saleData->discount_amnount}}" name="discount_amnount" id="discount_amnount">
            </td></tr>
            <tr class="tableInfos"><td colspan="4" align="right"><strong>{{ trans('message.table.grand_total') }}({{Session::get('currency_symbol')}})</strong></td><td align="left" colspan="2"><input type='text' name="total"
             class="form-control" id = "grandTotal" value="{{$saleData->total}}" readonly></td></tr>
             @endif
           </tbody>
         </table>
       </div>
       <br><br>
     </div>
   </div>
   <!-- /.box-body -->
   <div class="col-md-12">
    <div class="form-group">
      <label for="exampleInputEmail1">{{ trans('message.table.note') }}</label>
      <textarea placeholder="{{ trans('message.table.description') }} ..." rows="3" class="form-control" name="comments"></textarea>
    </div>
    <a href="{{url('/order/list')}}" class="btn btn-info btn-flat">{{ trans('message.form.cancel') }}</a>
    <button id="btnSubmit" type="submit" class="btn btn-primary btn-flat pull-right">{{ trans('message.form.submit') }}</button> 
  </div>
</div>
</form>
</div>
</div>



</div>
<!-- Right Panel -->
<div class="row">
  <div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="text-info text-center">Action</h4>
      </div>
      <div class="panel-body">
        <div class="list-inline">
          <button class="btn btn-warning btnOrderStatus" data-id="{{ $saleData->order_no }}" value="0">Cancel</button>
          <button class="btn btn-danger btnOrderStatus" data-id="{{ $saleData->order_no }}" value="2">Pending</button>
          <button class="btn btn-success btnOrderStatus" data-id="{{ $saleData->order_no }}" value="1">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h4 class="text-info text-left">Summary</h4>
      </div>
      <div class="panel-body">
        <table class="table" style="font-weight: bold;">
          <tr>
            <td>Item Ordered</td>
            <td id="smTotalItem">-</td>
          </tr>
          <tr>
            <td>Total Amount</td>
            <td id="smTotalAmount">-</td>
          </tr>
          <tr>
            <td>Paid Amount</td>
            <td id="smPaidAmount">-</td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="panel panel-info">
      <div class="panel-heading text-right list-inline">
        <h4 class="text-info text-left">Payment Grid</h4>
        <button class="btn btn-success" id="addPaymentBtn">Add Payment</button>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Date</th>
              <th>Method</th>
              <th>Attached</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody>
           @if(!empty($payments))
           @foreach($payments as $payment)
           <tr>
            <td width="10%" class="text-center">{{$payment->id}}</td>
            <td width="15%" class="text-center">{{$payment->payment_date }}</td>
            <td width="10%" class="text-center">{{$payment->method }}</td>
            <td width="10%" class="text-center"><a href="{{url('public/uploads/paymentPic/'.$payment->file)}}">{!! substr($payment->file,1,4)!!}</a></td>
            <td width="10%" class="text-center">{{$payment->amount}}</td>
            <td width="10%"><button class="btn btn-xs btn-danger delete_payment"><i class="glyphicon glyphicon-trash"></i></button></td></td>
          </tr>
          @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>


<div class="row">
<div class="col-md-12">
@include('admin.shipment.includes.manageShipmentPanel')
</div>
</div>
</div>

<!-- End right panel -->
<!-- /.col -->

<!-- /.col -->

<!-- /.row -->
</div>
<!-- /.box-body -->
<!-- /.box -->

</section>
<!--Add Payment Modal-->

<div class="modal fade" id="addPaymentModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4  class="text-left text-info">Add Payment On: {{ trans('message.table.order_no')}} #{{$saleData->reference}}</h4>
      </div>
      <div class="modal-body">
        <form role="form" class="form-horizontal" method="post" action="{{ url('order/addpayment') }}" enctype="multipart/form-data">
          <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
          <input type="hidden" name="saleOrderNo" value="{{ $saleData->order_no }}" id="saleOrderNo">
          <input type="hidden" name="payment_debtorNo" value="{{ $saleData->debtor_no }}">
          <div class="form-group">
            <label class="control-label col-sm-3">Payment Type:</label>
            <div class="col-sm-8">
              <select class="form-control select-2" id="payment_type_id" name="payment_type">
                <option value="">Select Payment Type</option>
                <option value="cash">Cash</option>
                <option value="bank">Bank</option>
              </select>
            </div>

          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Amount:</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" name="payment_amount" placeholder="amount" id="payment_amount" required="">
            </div>

          </div>
          <div class="form-group">
            <label class="control-label col-sm-3">Paid On:</label>
            <div class="col-sm-8">
              <input name="payment_date" class="form-control" id="payment_date" placeholder="" type="text" required="">

            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label" for="inputEmail3">Picture</label>
            <div class="col-sm-8">
              <input class="form-control input-file-field" name="payment_image" type="file">
            </div>
          </div>


          
        </div>
        <div class="modal-footer">
         <button type="submit" class="btn btn-default btn-success pull-right" id="submitPayment">Pay Now</button>
       </form>
     </div>
   </div>
 </div>
</div>

<!-- End Add Payment -->




@endsection
@section('js')
<script type="text/javascript">
    //@param stack: list of products in order.
    //These variables are for the orderEdit.js below
    var DATE_FORMAT_TYPE = '{{Session::get('date_format_type')}}';
    var order_no = {{ $saleData->order_no }};
    
    var stack = [];
    var stack = <?php echo json_encode($stack); ?>;
    var order_status = {{ $saleData->order_status }};
  </script>
  <script type="text/javascript" src="{{ asset('public/dist/js/pages/orderEdit.js') }}"></script>
  <script type="text/javascript" src="{{ asset('public/dist/js/pages/shipment/manage-shipment.js') }}"></script>
  @endsection