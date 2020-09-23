@include('layouts.frontend.header')


<section class="checkout">
    <div class="basket container">
        <div class="message-alert-top">
            @if(Session::has('success_message'))
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-ok"></span>
                <em> {!! session('success_message') !!}</em>
            </div>
            @endif
            @if(Session::has('error_message'))
            <div class="alert alert-danger">
                <span class="glyphicon glyphicon-ok"></span>
                <em> {!! session('error_message') !!}</em>
            </div>
            @endif
        </div>
        <div class="basketHeader">
            <h1 class="text-huge">Orders ({{count($orders)}})</h1>
        </div>
        @if(count($orders) > 0)
            <div class="basketContent orderlist">
                <div class="basketContentSaleGroups">
                    @foreach($orders as $key => $artwork)
                    <?php
                    $json_info = json_decode($artwork->artwork_info);
                    ?>
                    <div class="basketSaleGroup">
                        <div class="basketSaleGroupHeader"><span class="text-left">Order from {{$json_info->artist->first_name}} {{$json_info->artist->last_name}}</span><span class="text-right text-thin">Price</span></div>
                        <div class="basketSaleGroupSale">
                            <div class="details">
                                <a href="{{url('artwork_details')}}/{{$artwork->artwork_id}}" class="">
                                <img alt="{{$json_info->title}}  | Artviayou.com" src="{{$json_info->artwork_images[0]->media_url}}?auto=compress&amp;fm=jpeg&amp;w=70&amp;fit=max" class=" loaded">
                                </a>
                                <div class="title">
                                    <div class="text-bold">{{$json_info->title}} </div>
                                    <p class="text-thin" style="margin-bottom: 0px;">
                                        <br><span class="">{{$json_info->variants[0]->width}}</span> x <span class="">{{$json_info->variants[0]->height}} cm</span>
                                        
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span style="cursor: help;">£{{$json_info->variants[0]->price}}</span>
                                @if($user_type == "artist")
                                    <button class="btn btn-default btn-md btn-sm d-block mt-2 shipping_status" data-order-id="{{$artwork->id}}" data-toggle="modal" data-target="#changeShippingStatus" >{{$artwork->shipping_status}}</button>
                                @else
                                    <button class="btn btn-default btn-md btn-sm d-block mt-2">{{$artwork->shipping_status}}</button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
        @else
        <div class="text-center"><h4>No Order Found</h4></div>
        @endif
    </div>
</section>

@include('layouts.frontend.comman_footer')