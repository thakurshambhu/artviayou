<div class="modal-dialog modal-lg" role="document">
    <!-- Summary Modal -->
    <div class="modal-content" id="summary_info">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Sumamry #{{str_pad($order_info->id, 5, '0', STR_PAD_LEFT)}}</h5>
            <button type="button" class="close_modal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
            $json_info = json_decode($order_info->artwork_info);
            ?>
        <div class="modal-body">
            <i class="fa fa-check-circle" aria-hidden="true"></i>
            Send Order Fulfilled Notification
            <div style="margin-top: 25px; font-size: 14px;">
                <p>Send an email notification to customer that the order has been fulfilled</p>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="slipUpper">
                            <h5>SHIPPED TO</h5>
                            <h6>{{$order_info->shipping_address->first_name}} {{$order_info->shipping_address->last_name}}</h6>
                            <p>{{$order_info->shipping_address->address}}</p>
                            <p>{{$order_info->shipping_address->state}}, {{$order_info->shipping_address->country}}, {{$order_info->shipping_address->postal_code}}</p>
                        </div>
                    </div>
                    <!-- <div class="col-md-4 col-sm-6">
                        <div class="slipUpper">
                            <h5>SHIPPED TO</h5>
                            <h6>Perry Kankam</h6>
                            <p>98746 Real Street, Lorem Ipsum</p>
                            <p>The Art Studio</p>
                            <p>New York, USA, 34567</p>
                        </div>
                    </div> -->
                </div>
                <hr>
                <h4>Order Summary</h4>
                <div class="slip-table-container">
                    <table class="table table-responsive-sm table-striped table-border">
                        <thead>
                            <tr>
                                <th>item</th>
                                <th>unit price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$json_info->title}}</td>
                                <td>£{{$json_info->variants[0]->price}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 offset-md-8">
                    <div class="table-subTotal">
                        <table class="table table-responsive-sm borderless">
                            <tbody>
                                <tr>
                                    <td>item subtotal</td>
                                    <td>£{{$json_info->variants[0]->price}}</td>
                                </tr>
                                <tr>
                                    <td>shipping</td>
                                    @if(!empty($json_info->variants[0]->worldwide_shipping_charge))
                                    <td>£{{$json_info->variants[0]->worldwide_shipping_charge}}</td>
                                    @else
                                    <td>Free Shipping</td>
                                    @endif
                                </tr>
                                <tr>
                                    <td>total</td>
                                    <td>£{{$json_info->variants[0]->price + $json_info->variants[0]->worldwide_shipping_charge}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <table class="table table-responsive-sm borderless table-bordered">
                        <tbody>
                            <tr class="align-items-center">
                                <td>CHARGE</td>
                                <td>{{$order_info->payment_id}}</td>
                                <!-- <td class="text-right"> <a href="#" class="btn btn-link">Payment</a> </td> -->
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if($order_info->artist_id == Auth::user()->id)
        <div class="modal-footer">
            <div class="col-md-12" >
                <button class="btn btn-default btn-md btn-sm d-block mt-2" id="change_shipping_status">Mark Fulfilled</button>
                
            </div>
        </div>
        @endif
    </div>
    <!-- Shipping Status -->
    <div class="modal-content" id="shipping_status" style="display:none">
        <form method="post" action="{{ url('/update_shipping_status') }}" autocomplete="off">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">MARK ORDER FULFILLED</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php
                $json_info = json_decode($order_info->artwork_info);
                ?>
            <input type="hidden" name="order_id" value="{{$order_info->id}}">
            <!-- <input type="hidden" name="shipping_status" value="Shipped"> -->
            <input type="hidden" name="previous_shipping_status" value="{{$order_info->shipping_status}}">
            <div class="modal-body">
                <i class="fa fa-check-circle" aria-hidden="true"></i>
                Send Order Fulfilled Notification
                <div style="margin-top: 25px; font-size: 14px; margin-left: 25px;">
                    <p>Send an email notification to customer that the order has been fulfilled</p>
                </div>
                <table class="table table-striped  table-responsive-md">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Recipient</th>
                            <th scope="col">Tracking Number</th>
                            <th scope="col">Carrier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#{{str_pad($order_info->id, 5, '0', STR_PAD_LEFT)}}</td>
                            <td>{{$user_name}}</td>
                            <td> <input type="text" name="tracking_number" class="form-control" value="{{$order_info->tracking_number}}" > </td>
                            <td> <input type="text" name="carrier" class="form-control" value="{{$order_info->carrier}}" > </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close_modal btn-md btn-sm d-block mt-2" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-default btn-md btn-sm d-block mt-2">Save changes</button>
            </div>
        </form>
    </div>
</div>