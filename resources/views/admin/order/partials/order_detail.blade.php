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
</div>
    <div id="itemInfoModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="box box-widget widget-user-2">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header bg-blue">
                        <div class="widget-user-image" id="item-modal-image">
                            <img class="img-circle" src="../dist/img/user7-128x128.jpg" alt="Item Avatar">
                        </div>
                        <!-- /.widget-user-image -->
                        <h3 class="widget-user-username" id="item-modal-name"></h3>
                        <h5 class="widget-user-desc" id="item-modal-category"></h5>
                    </div>
                    <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                            <li><a href="#">Stock On Hand <span class="pull-right" id="item-modal-stock-on-hand">31</span></a></li>
                            <li><a href="#">Weight <span class="pull-right" id="item-modal-weight">5</span></a></li>
                            <li><a href="#">Quantity/Pack <span class="pull-right" id="item-modal-quantity-pack">12</span></a></li>

                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
</fieldset>
