@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <!---Top Section Start-->
      
      <!---Top Section End-->
    <div class="row">
        <div class="col-md-8 right-padding-col8">
		<div class="box box-default">
      <div class="box-header text-center">
        <h5 class="text-left text-info"><b>{{ trans('message.table.order_no') }} # <a href="{{URL::to('/')}}/order/view-order-details/{{$orderInfo->order_no}}">{{$orderInfo->reference}}</a></b></h5>
      </div>
    </div>
            <div class="box box-default">
              <div class="box-body">
                
                  <div class="row">
                    <div class="col-md-4">
                      <strong>{{ trans('message.invoice.order_date')}} : {{ formatDate($saleData->ord_date)}}</strong>
                      <br>
                      <strong>{{ trans('message.extra_text.location')}} : {{ $saleData->location_name}}</strong>
                    </div>
                    <div class="col-md-8">
                      <div class="btn-group pull-right">
                        <button title="Email" type="button" class="btn btn-default btn-flat" data-toggle="modal" data-target="#emailOrder">{{ trans('message.extra_text.email') }}</button>
                        <a target="_blank" href="{{URL::to('/')}}/order/print/{{$saleData->order_no}}" title="Print" class="btn btn-default btn-flat">{{ trans('message.extra_text.print') }}</a>
                        <a target="_blank" href="{{URL::to('/')}}/order/pdf/{{$saleData->order_no}}" title="PDF" class="btn btn-default btn-flat">{{ trans('message.extra_text.pdf') }}</a>
                        @if(!empty(Session::get('order_edit')))
                          <a href="{{URL::to('/')}}/order/edit/{{$saleData->order_no}}" title="Edit" class="btn btn-default btn-flat">{{ trans('message.extra_text.edit') }}</a>
                        @endif

                        @if(!empty(Session::get('order_delete')))
                         <form method="POST" action="{{ url("order/delete/$saleData->order_no") }}" accept-charset="UTF-8" style="display:inline">
                            {!! csrf_field() !!}
                            <button class="btn btn-default btn-flat delete-btn" type="button" data-toggle="modal" data-target="#confirmDelete" data-title="{{ trans('message.invoice.delete_order') }}" data-message="{{ trans('message.invoice.delete_order_confirm') }}">
                               {{ trans('message.extra_text.delete') }}
                            </button>
                        </form>
                        @endif
                      </div>
                    </div>
                  </div>
              </div>

              <div class="box-body">
                <div class="row">
                  @if(($orderQty+$invoiceQty) > 0  )
        @if(!empty(Session::get('sales_add')))
			<div class="col-md-4">
                    <strong>{{ Session::get('company_name') }}</strong>
                    <h5 class="">{{ Session::get('company_street') }}</h5>
                    <h5 class="">{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</h5>
                    <h5 class="">{{ Session::get('company_country_id') }}, {{ Session::get('company_zipCode') }}</h5>
                  </div>
				  
				   <div class="col-md-4">
                  <strong>{{ trans('message.extra_text.bill_to') }}</strong><br>
				  Name: {{ !empty($customerInfo->name) ? $customerInfo->name : ''}}<br>
                    Street: {{ !empty($customerInfo->billing_street) ? $customerInfo->billing_street : ''}}<br>
                    State: {{ !empty($customerInfo->billing_state) ? $customerInfo->billing_state : ''}}<br>
                  City: {{ !empty($customerInfo->billing_city) ? $customerInfo->billing_city : ''}}<br>
				 Country: {{ !empty($customerInfo->billing_country_id) ? $customerInfo->billing_country_id : ''}}<br>
				  Zipcode: {{ !empty($customerInfo->billing_zip_code) ? $customerInfo->billing_zip_code : ''}}
                  </div>
		@endif
		@else
		<div class="col-md-4">
                    <strong>{{ Session::get('company_name') }}</strong>
                    <h5 class="">{{ Session::get('company_street') }}</h5>
                    <h5 class="">{{ Session::get('company_city') }}, {{ Session::get('company_state') }}</h5>
                    <h5 class="">{{ Session::get('company_country_id') }}, {{ Session::get('company_zipCode') }}</h5>
                  </div>
				  
				   <div class="col-md-4">
                  <strong>{{ trans('message.extra_text.bill_to') }}</strong>
                  <h5>{{ !empty($customerInfo->name) ? $customerInfo->name : ''}}</h5>
                  <h5>{{ !empty($customerInfo->billing_street) ? $customerInfo->billing_street : ''}} </h5>
                  <h5>{{ !empty($customerInfo->billing_state) ? $customerInfo->billing_state : ''}}{{ !empty($customerInfo->billing_city) ? ', '.$customerInfo->billing_city : ''}}</h5>
                  <h5>{{ !empty($customerInfo->billing_country_id) ? $customerInfo->billing_country_id : ''}} {{ !empty($customerInfo->billing_zip_code) ? ', '.$customerInfo->billing_zip_code : ''}}</h5>
                  </div>
                  
		@endif
 
                  
                  <div class="col-md-4">
                  <strong>{{ trans('message.extra_text.shiptment_to') }}</strong>
                  <h5>{{ !empty($customerInfo->br_name) ? $customerInfo->br_name : ''}}</h5>
                  <h5>{{ !empty($customerInfo->shipping_street) ? $customerInfo->shipping_street :'' }}</h5>
                  <h5>{{ !empty($customerInfo->shipping_city) ? $customerInfo->shipping_city : ''}} {{ !empty($customerInfo->shipping_state) ? ', '.$customerInfo->shipping_state : ''}}</h5>
                  <h5>{{ !empty($customerInfo->shipping_country_id) ? $customerInfo->shipping_country_id :''}} {{ !empty($customerInfo->shipping_zip_code) ? ', '.$customerInfo->shipping_zip_code : ''}}</h5>
                  </div>

                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="box-body no-padding">
                      <div class="table-responsive">
                      <table class="table table-bordered" id="salesInvoice">
                        <tbody>
                        <tr class="tbl_header_color dynamicRows">
                          <th width="30%" class="text-center">{{ trans('message.table.description') }}</th>
                          <th width="20%" class="text-center">{{ trans('message.table.quantity') }}</th>
                          <th width="30%" class="text-center">{{ trans('message.table.rate') }}({{Session::get('currency_symbol')}})</th>
                          
                          <th width="30%" class="text-center">{{ trans('message.table.amount')}}({{Session::get('currency_symbol')}})</th>
                        </tr>
                        @if(count($invoiceData)>0)
                         <?php $subTotal = 0;$units = 0;$itemsInformation = '';?>
                          @foreach($invoiceData as $result)
                              <tr>
                                <td class="text-center">{{$result['description']}}</td>
                                <td class="text-center">{{$result['quantity']}}</td>
                                <td class="text-center">{{ number_format($result['unit_price'],2,'.',',') }}</td>
                               
                                <?php
                                  $priceAmount = ($result['quantity']*$result['unit_price']);
                                  $discount = ($priceAmount*$result['discount_percent'])/100;
                                  $newPrice = ($priceAmount-$discount);
                                  $subTotal += $newPrice;
                                  $units += $result['quantity'];
                                  $itemsInformation .= '<div>'.$result['quantity'].'x'.' '.$result['description'].'</div>';
                                ?>
                                <td align="right">{{ number_format($newPrice,2,'.',',') }}</td>
                              </tr>
                          @endforeach
                          <tr class="tableInfos"><td colspan="3" align="right">{{ trans('message.table.total_qty') }}</td><td align="right" colspan="1">{{$units}}</td></tr>

                          <tr class="tableInfos"><td colspan="3" align="right">TAX Rate(%)</td><td align="right" colspan="1">{{$saleData->item_tax}}</td></tr>

                          <tr class="tableInfos"><td colspan="3" align="right">Shipping Method</td><td align="right" colspan="1">{{$saleData->shipping_method}}</td></tr>

                          <tr class="tableInfos"><td colspan="3" align="right">Shipping Cost</td><td align="right" colspan="1">{{$saleData->shipping_cost}}</td></tr>
                          <tr class="tableInfos"><td colspan="3" align="right">Discount Amnount</td><td align="right" colspan="1">{{$saleData->discount_amnount}}</td></tr>
                          


                        <tr class="tableInfos"><td colspan="3" align="right">{{ trans('message.table.sub_total') }}</td><td align="right" colspan="1">{{ Session::get('currency_symbol').number_format($subTotal,2,'.',',') }}</td></tr>
                        @foreach($taxType as $rate=>$tax_amount)
                        @if($rate != 0)
                        <tr><td colspan="3" align="right">VAT({{$rate}}%)</td><td colspan="2" class="text-right">{{ Session::get('currency_symbol').number_format($tax_amount,2,'.',',') }}</td></tr>
                        @endif
                        @endforeach
                          <tr class="tableInfos"><td colspan="3" align="right"><strong>{{ trans('message.table.grand_total') }}</strong></td><td colspan="1" class="text-right"><strong>{{Session::get('currency_symbol').number_format($saleData->total,2,'.',',')}}</strong></td></tr>
<!--                         
						 <?php
                           $invoiceAmount = 0;
                            if(!empty($paymentsList)){
                             
                              foreach ($paymentsList as $key => $paymentAmount) {
                               $invoiceAmount += $paymentAmount->amount;
                              }
                            }
                          ?>
                          <tr><td colspan="5" align="right">{{ trans('message.invoice.paid') }}</td><td colspan="2" class="text-right">{{Session::get('currency_symbol').number_format($invoiceAmount,2,'.',',')}}</td></tr>
                          <tr class="tableInfos"><td colspan="5" align="right"><strong>{{ trans('message.invoice.due') }}</strong></td><td colspan="2" class="text-right"><strong>{{Session::get('currency_symbol').number_format(($saleData->total-$invoiceAmount),2,'.',',')}}</strong></td></tr>
                        -->
						@endif
                        </tbody>
                      </table>
                      </div>
                      <br><br>
                    </div>
                  </div>
                </div>
              </div>
            </div>
			<!-- starts invoices -->
			
			<div class="box box-default">
      <div class="box-header text-center">
        <strong>{{ trans('message.invoice.shipment_list') }}</strong>
      </div>
      <div class="box-body">
        @if(!empty($shipmentList))
        <table class="table table-bordered">
          <thead>
            <tr>
              <th class="text-center">{{ trans('message.invoice.shift_no') }}</th>
              <th class="text-center">{{ trans('message.extra_text.shift_status') }}</th>
			  <th class="text-center">Tracking no.</th>
              <th class="text-center">{{ trans('message.invoice.shipment_qty') }}</th>
			  
            </tr>
          </thead>
          <tbody>
            <?php
            $sumShipment = 0;
            ?>
            @foreach($shipmentList as $key=>$shipment)
            <tr>
              <td align="center"><a href="{{ url('shipment/view-details/'.$orderInfo->order_no.'/'.$shipment->shipment_id) }}"><i class="fa fa-chevron-right" aria-hidden="true"></i>&nbsp;{{sprintf("%04d", $shipment->shipment_id)}}</a></td>
              <td align="center">{{getShipmentStatus($shipment->shipment_id)}}</td>
			  <td class="text-center">Tracking no.</td>
              <td align="center">{{$shipment->total}}</td>
            </tr>
            <?php
            $sumShipment += $shipment->total;
            ?>
            @endforeach
			<td></td>
              <td colspan="2" align="right"><strong>{{ trans('message.invoice.total') }}</stron></td><td align="center"><strong>{{$sumShipment}}</strong></td>
          </tbody>
        </table>
        @else
        <h5 class="text-center">{{ trans('message.invoice.no_shipment') }}</h5>
        @endif
      </div>
        @if($shipmentStatus=='available')

         @if(!empty(Session::get('shipment_add')))
        <div class="box-body">
          <div class="row">
            <div class="col-md-6 btn-block-left-padding">
              <a href="{{URL::to('/')}}/shipment/add/{{$orderInfo->order_no}}" title="{{ trans('message.extra_text.manual_packing') }}" class="btn btn-success btn-flat btn-block">{{ trans('message.table.manual_invoice_title') }}</a>
            </div>
            <div class="col-md-6 btn-block-right-padding">
              <a href="{{URL::to('/')}}/shipment/create-auto-shipment/{{$orderInfo->order_no}}" title="{{ trans('message.extra_text.auto_packing') }}" class="btn bg-orange btn-flat btn-block">{{ trans('message.table.automatic_invoice_title') }}</a>
            </div>
          </div>
        </div>
        @endif
        @endif
    </div>   
			
			<!-- end invoices -->
			
        </div>
      <!--Modal start-->
        <div id="emailOrder" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <form id="sendOrderInfo" method="POST" action="{{url('order/email-order-info')}}">
            <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            <input type="hidden" value="{{$orderInfo->order_no}}" name="order_id" id="order_id">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('message.email.email_order_info')}}</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="email">{{ trans('message.email.send_to')}}:</label>
                  <input type="email" value="{{$customerInfo->email}}" class="form-control" name="email" id="email">
                </div>
                <?php
                $subjectInfo = str_replace('{order_reference_no}', $orderInfo->reference, $emailInfo->subject);
                $subjectInfo = str_replace('{company_name}', Session::get('company_name'), $subjectInfo);
                ?>
                <div class="form-group">
                  <label for="subject">{{ trans('message.email.subject')}}:</label>
                  <input type="text" class="form-control" name="subject" id="subject" value="{{$subjectInfo}}">
                </div>
                  <div class="form-groupa">
                      <?php
                      $bodyInfo = str_replace('{customer_name}', $customerInfo->name, $emailInfo->body);
                      $bodyInfo = str_replace('{order_reference_no}', $orderInfo->reference, $bodyInfo);
                      $bodyInfo = str_replace('{billing_street}', $customerInfo->billing_street, $bodyInfo);
                      $bodyInfo = str_replace('{billing_city}', $customerInfo->billing_city, $bodyInfo);
                      $bodyInfo = str_replace('{billing_state}', $customerInfo->billing_state, $bodyInfo);
                      $bodyInfo = str_replace('{billing_zip_code}', $customerInfo->billing_zip_code, $bodyInfo);
                      $bodyInfo = str_replace('{billing_country}', $customerInfo->billing_country_id, $bodyInfo);                      
                      $bodyInfo = str_replace('{company_name}', Session::get('company_name'), $bodyInfo);
                      $bodyInfo = str_replace('{order_summery}', $itemsInformation, $bodyInfo);                     
                      $bodyInfo = str_replace('{currency}', Session::get('currency_symbol'), $bodyInfo);
                      $bodyInfo = str_replace('{total_amount}', $saleData->total, $bodyInfo); 
                      $bodyInfo = str_replace('{order_date}', formatDate($saleData->ord_date), $bodyInfo); 
                      ?>
                      <textarea id="compose-textarea" name="message" id='message' class="form-control editor" style="height: 200px">{{$bodyInfo}}</textarea>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{{ trans('message.email.close')}}</button><button type="submit" class="btn btn-primary btn-sm">{{ trans('message.email.send')}}</button>
              </div>
            </div>
            </form>
          </div>
        </div>
        <!--Modal end -->
		
		<div class="col-md-4 left-padding-col4">
		<div class="box box-default">
        
        <div class="box-body">

          <div class="row">
          
            <div class="col-md-12 ">
             <div class="top-bar-title"><h3 class="text-center">{{ trans('message.invoice.summary') }}</h3></div>
            </div><br/><br/>

            <table class="table table-bordered" >
                      <tbody>

<tr class=" dynamicRows">
                        <th width="40%" class="text-center"><h4>Payment Due:</h4></th> 
                        <th  width="40%" class="text-center"><h4>{{Session::get('currency_symbol').number_format(($saleData->total-$invoiceAmount),2,'.',',')}}</h4></th>                      
                      </tr>
                      <tr class=" dynamicRows">
                        <th width="40%" class="text-center">Total Order: </th>     
                        <th width="40%" class="text-center">{{Session::get('currency_symbol').number_format($saleData->total,2,'.',',')}}</th>                   
                      </tr>
                      <tr class=" dynamicRows">
                        <th width="40%" class="text-center">Paid</th>     
                        <th width="40%" class="text-center">{{Session::get('currency_symbol').number_format($invoiceAmount,2,'.',',')}}</th>                   
                      </tr>   

<tr class=" dynamicRows">
 
                        <th width="40%" class="text-center"><h4>Pending Shipments:</h4></th> 
                        <th  width="40%" class="text-center"><h4></h4></th>                      
                      </tr>
                      <tr class=" dynamicRows">
                        <th width="40%" class="text-center">Total Items:</th>     
                        <th width="40%" class="text-center">{{$units}}</th>                   
                      </tr>
                      <tr class=" dynamicRows">
                        <th width="40%" class="text-center">Shipped Items:</th>     
                        <th width="40%" class="text-center"></th>                   
                      </tr>					  
                    
                      </tbody>
                    </table>
          </div>
        </div>
      </div>
		</div>
         @include('layouts.includes.content_right_option')
      </div>
    </section>
	
	
@include('layouts.includes.message_boxes')    
@endsection
@section('js')
<script type="text/javascript">

      $(function () {
        $(".editor").wysihtml5();
      });

    $('#sendOrderInfo').validate({
        rules: {
            email: {
                required: true
            },
            subject:{
               required: true,
            },
            message:{
               required: true,
            }                   
        }
    }); 

</script>
@endsection