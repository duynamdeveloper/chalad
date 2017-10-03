<!--Select Product-->


<fieldset @if($order->order_status==1) style="display: none" @endif id="order_field">
    <div class="box box-default">
            <div class="box-header">
                <h3>Order Details <button class="btn btn-success pull-right next" type="button" id="btnSaveOrder">Save & Next</button></h3>



           </div>
            </div>
    <div id="order_detail_container">

        @include('admin.order.sub-partials.order_detail')
    </div>
    <div class="box box-default">
        <div class="box-body">

            <div class="form-group">
                              <button class="btn btn-success pull-right next" type="button" id="btnSaveOrder">Save & Next</button>
        </div>
    </div>

</fieldset>
<!--Select Product-->


<fieldset @if($order->order_status==1) style="display: none" @endif id="order_field">
    <div class="box box-default">
            <div class="box-header">
                <h3>Order Details <button class="btn btn-success pull-right next" type="button" id="btnSaveOrder">Save & Next</button></h3>



           </div>
            </div>
    <div id="order_detail_container">

        @include('admin.order.sub-partials.order_detail')
    </div>
    <div class="box box-default">
        <div class="box-body">

            <div class="form-group">
                              <button class="btn btn-success pull-right next" type="button" id="btnSaveOrder">Save & Next</button>
        </div>
    </div>

</fieldset>
