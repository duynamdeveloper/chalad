<div class="box box-success">
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <h5 class="text-info"><strong>Order Summary</strong></h5>
                <table class="table table-reponsive info">
                    <thead>
                    <th></th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price (B)</th>
                    <th>Amount (B)</th>
                    </thead>
                    <tbody>
                    @php $subtotal = 0; @endphp
                    @foreach($order->details as $detail)
                        <tr class="item-row" item-id="{{$detail->stock_id}}">
                            <td><img width="50px" height="50px" src="{{asset('/public/uploads/itemPic/'.$detail->item->item_image)}}"></td>
                            <td>{{$detail->item->description}}</td>
                            <td>{{$detail->quantity}}</td>
                            <td>{{$detail->unit_price}}</td>
                            <td>{!! ($detail->unit_price)*($detail->quantity) !!} </td>
                            @php $subtotal += ($detail->unit_price)*($detail->quantity) @endphp
                        </tr>

                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr class="static_rows">
                        <td colspan="4"><strong>Sub Total</strong></td>
                        <td colspan="2" id="subTotal"  class="text-left">{{ $subtotal }}</td>
                    </tr>

                    <tr class="static_rows">
                        <td colspan="4"><strong>Shipping Cost</strong></td>
                        <td class="text-left">
                            {{$order->shipping_cost}}
                        </td>
                    </tr>
                    <tr class="static_rows">
                        <td colspan="4"><strong>Discount Amount</strong></td>
                        <td  class="text-left">
                            {{$order->discount_amount}}
                        </td>
                    </tr>

                    <tr class="static_rows">
                        <td colspan="4"><strong>Tax Amount</strong></td>
                        <td class="text-left">
                            {!! ($subtotal)*($order->item_tax)/100 !!}
                        </td>
                    </tr>
                    <tr class="static_rows">
                        <td colspan="4"><strong>Grand Total</strong></td>
                        <td class="text-left">
                           {{ $order->total  }}
                        </td>
                    </tr>
                    </tfoot>
                </table>



            </div>


            <!--End Shippind Address Form-->




        </div>

    </div>
</div>