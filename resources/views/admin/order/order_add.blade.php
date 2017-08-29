@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="text-info">Create New Order</h3>
                </div>
                <div class="box-body">
                    <div class="container-fluid">
                     <form class="form-horizontal">
                        <div class="row">
                            <div class="col-md-6">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Select Customer</label>
                                        <div class="col-md-8">
                                            <select class="select2 form-control" name="customer_id" id="sel_customer">
                                                <option value="null">Choose an option</option>
                                                <option value="-1">CREATE NEW CUSTOMER</option>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->debtor_no }}">{{ $customer->name }} (Phone: {{$customer->phone}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Name</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control customer-form" name="customer_name" id="inp_customer_name" placeholder="Enter Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Phone</label>
                                        <div class="col-md-8">  
                                            <input type="text" class="form-control customer-form" name="customer_phone" id="inp_customer_phone" placeholder="Enter Phone Number" >
                                        </div>
                                    </div>
                                      <div class="form-group">
                                        <label class="control-label col-md-4">Email</label>
                                        <div class="col-md-8">
                                            <input type="text"  class="form-control customer-form" name="customer_email" id="inp_customer_email" placeholder="Enter Email">
                                        </div>
                                    </div>
                                   
                            </div>
                            <div class="col-md-6">
                             <div class="form-group">
                                        <label class="control-label col-md-4">Channel</label>
                                        <div class="col-md-8">
                                           <input type="text" class="form-control customer-form" name="customer_channel" id="inp_customer_channel" placeholder="Enter Channel" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4 ">Channel ID</label>
                                        <div class="col-md-8">
                                            <select class="select2 form-control customer-form" name="channel_id" id="sel_channel_id">
                                                <option value="">{{ trans('message.form.select_one') }}</option>
                                                <option value="facebook">{{ trans('message.extra_text.facebook') }}</option>
                                                <option value="twitter">{{ trans('message.extra_text.twitter') }}</option>
                                                <option value="lazada">{{ trans('message.extra_text.lazada') }}</option>
                                                <option value="line">{{ trans('message.extra_text.line') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                  
                                </form>
                                </div>
                            </div>
                        </div>
<hr>
                        <!--Select Product-->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Add a product</label>
                                    <select class="select2 form-control" id="sel_product">
                                        <option value="-1">Select a product</option>
                                        @foreach($items as $item)
                                            <option value="{{$item->stock_id}}">{{$item->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- End Select Product -->

                        <!-- Product Table -->

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-reponsive info" id="product_table" >
                                    <thead>
                                        <th>Name</th>
                                        <th>Picture</th>
                                        <th>Stock On Hand</th>
                                        <th>Final Quantity</th>
                                        <th>Price (B)</th>
                                        <th>Amount (B)</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot hidden>
                                    <tr class="static_rows">
                                        <td colspan="5"><strong>Sub Total</strong></td>
                                        <td colspan="2" id="subTotal" style="font-weight:bold" class="text-left"></td>
                                    </tr>
                                    <tr class="static_rows">
                                        <td colspan="5" ><strong>TAX</strong></td>
                                        <td>
                                            <select class="form-control" name="tax" id="sel_tax">
                                                <option value="-1">Select One</option>
                                            </select>
                                        </td>

                                    </tr>
                                    <tr class="static_rows">
                                        <td colspan="5"><strong>Tax Amount</strong></td>
                                        <td>
                                            <input class="form-control" id="tax_amount" readonly>
                                        </td>
                                    </tr>
                                    <tr class="static_rows">
                                        <td colspan="5"><strong>Shipping Method</strong></td>
                                        <td>
                                            <select name="shipping_method" class="form-control">
                                                <option>Select One</option>
                                                <option value="EMS">EMS</option>
                                                <option value="Registered">Registered</option>
                                            </select>
                                        </td>
                                    </tr>
                                        <tr class="static_rows">
                                        <td colspan="5"><strong>Shipping Cost</strong></td>
                                        <td>
                                            <input class="form-control" id="shipping_cost" readonly>
                                        </td>
                                    </tr>
                                        <tr class="static_rows">
                                        <td colspan="5"><strong>Discount Amount</strong></td>
                                        <td>
                                            <input class="form-control" id="discount_amount" type="number" name="discount_amount">
                                        </td>
                                    </tr>
                                    <tr class="static_rows">
                                        <td colspan="5"><strong>Grand Total</strong></td>
                                        <td>
                                            <input class="form-control" id="grand_total" type="number" name="grand_total">
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $(".select2").select2();
        });
    </script>
    <script type="text/javascript" src="{{asset('public/dist/js/pages/order/order-add.js')}}"></script>
@endsection