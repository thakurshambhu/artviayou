@include('layouts.frontend.header')
<section class="productDetails">
    <div class="container">
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
        <div class="row">
            <div class="col-md-7">
                <div class="image">
                    <div class="owl-carousel productDetailCarousel">
                        @if(count($artwork_result['artwork_images']) > 0)
                        @foreach($artwork_result['artwork_images'] as $key => $image)
                        <div class="item">
                            <img src="{{$image->media_url}}" />
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="detail">
                    <div class="head justify-content-between">
                        <div class="title">
                            <h3>{{$artwork_result->title}}</h3>
                            <div class="breadcrumb">
                                Arist &gt; <a href="/profile_details/{{$artwork_result->artist->id}}"> {{$artwork_result->artist->first_name}} {{$artwork_result->artist->last_name}}</a>
                            </div>
                        </div>
                        <div class="price">
                            @if(count($artwork_result->variants) > 0)
                                £{{$artwork_result->variants[0]->price}}
                            @else
                                Sold Out
                            @endif
                            
                        </div>
                    </div>
                    <div class="text">
                        <p>{{$artwork_result->desacription}}</p>
                        <ul>
                            <li>Dimensions, @if(count($artwork_result->variants) > 0){{$artwork_result->variants[0]->height}} x {{$artwork_result->variants[0]->width}} @endif cm</li>
                            <li>{{$artwork_result->category_detail->name}}</li>
                            @if(!empty($artwork_result->sub_category_detail))<li>{{$artwork_result->sub_category_detail->name}}</li>@endif
                            <li>{{$artwork_result->style_detail->name}}</li>
                            <li>{{$artwork_result->subject_detail->name}}</li>
                        </ul>
                    </div>
                    <div class="button d-flex align-items-center">
                        @if(count($artwork_result->variants) > 0)
                            @if(in_array($artwork_result->id , $cart_artwork))
                            <a href="javascript:void(0)" data-artwork-id="{{$artwork_result->id}}" class="add_to_cart btn btn-default btn-block mr-2 mb-2">REMOVE FROM CART</a>
                            @else
                            <a href="javascript:void(0)" data-artwork-id="{{$artwork_result->id}}" class="add_to_cart btn btn-default btn-block mr-2 mb-2">ADD TO CART</a>
                            @endif
                            @if(Auth::user())
                                <a href="{{url('cart')}}" class="btn btn-border btn-block ml-2 mt-0 mb-2">CHECKOUT</a>
                            @else
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#LoginModal" class="btn btn-border btn-block ml-2 mt-0 mb-2">CHECKOUT</a>
                            @endif
                        @endif
                    </div>
                    <div class="actionBlock">
                        <span class="likes">{{count($artwork_result->artwork_like)}} Likes</span> 
                        <div class="actionIcons">
                            @if(Auth::user())
                                @if(Auth::user() && in_array(Auth::user()->id, $artwork_result->like_count))
                                <a class="like_artwork" data-artwork-id="{{$artwork_result->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/red_heart.jpeg')}}" title="Like Artwork"></a>
                                @elseif(in_array(Session::get('random_id'), $artwork_result->like_count))
                                <a class="like_artwork" data-artwork-id="{{$artwork_result->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/red_heart.jpeg')}}" title="Like Artwork"></a>
                                @else
                                <a class="like_artwork" data-artwork-id="{{$artwork_result->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                @endif
                            @else
                                <a class="" href="javascript:void(0);" data-toggle="modal" data-target="#LoginModal"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                            @endif

                            @if(Auth::user() && in_array(Auth::user()->id, $artwork_result->save_count))
                            <a class="save_artwork" data-artwork-id="{{$artwork_result->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="save_image" src="{{asset('assets/images/save_filled.png')}}"  title="Save for later"></a>
                            @elseif(in_array(Session::get('random_id'), $artwork_result->save_count))
                            <a class="save_artwork" data-artwork-id="{{$artwork_result->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="save_image" src="{{asset('assets/images/save_filled.png')}}"  title="Save for later"></a>
                            @else
                            <a class="save_artwork" data-artwork-id="{{$artwork_result->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="save_image" src="{{asset('assets/images/saved.png')}}"  title="Save for later"></a>
                            @endif
                            <!-- <a  class="like_artwork" data-artwork-id="{{$artwork_result->id}}" href="javascript:void(0);"><img class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                            <a class="save_artwork" data-artwork-id="{{$artwork_result->id}}" href="javascript:void(0);"><img class="save_image" src="{{asset('assets/images/saved.png')}}"  title="Save for later"></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- //Product Details -->
<!-- Similar Artworks Section -->
<section class="topArtworks">
    <div class="container">
        <div class="sectionHeading">
            <h2 >Similar Artworks</h2>
        </div>
    </div>
    <div class="container">
        <div class="artistSLider">
            <div class="owl-carousel artistCarousel">
                @foreach($similar_artwork as $artworks)
                    @if($artwork_result->id != $artworks->id)
                        @if(count($artworks->variants)>0)
                        <div class="artPost">
                            <div class="postHeader">
                                <div class="username">
                                    <div class="image"><a href="{{url('profile_details')}}/{{$artwork_result->artist->id}}"><img src="{{ $artworks->artist->media_url ? $artworks->artist->media_url : url('/assets/images/default.png') }}" alt=""></a></div>
                                    <span class="name">{{$artworks->artist->first_name}}</span>
                                </div>
                                <span class="Posted">{{date('d M Y', strtotime($artworks->created_at))}}</span>
                            </div>
                            <div class="postImage">
                                <a href="{{url('artwork_details')}}/{{$artworks->id}}"> <img src="{{$artworks->artwork_images[0]->media_url}}" alt=""></a>
                            </div>
                            <div class="postFooter">
                                <div class="leftBlock">
                                    <h5>{{$artworks->title}}</h5>
                                    @if(count($artworks->variants) > 0)
                                    <h6>£ {{$artworks->variants[0]->price}}</h6>
                                    @endif
                                </div>
                                <div class="rightBlock">
                                    <span class="likes">{{count($artworks->artwork_like)}} Likes</span> 
                                    <div class="actionIcons">
                                        @if(Auth::user())
                                            @if(Auth::user() && in_array(Auth::user()->id, $artworks->like_count))
                                            <a class="like_artwork" data-artwork-id="{{$artworks->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/red_heart.jpeg')}}" title="Like Artwork"></a>
                                            @elseif(in_array(Session::get('random_id'), $artworks->like_count))
                                            <a class="like_artwork" data-artwork-id="{{$artworks->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/red_heart.jpeg')}}" title="Like Artwork"></a>
                                            @else
                                            <a class="like_artwork" data-artwork-id="{{$artworks->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                            @endif
                                        @else
                                            <a class="" href="javascript:void(0);" data-toggle="modal" data-target="#LoginModal"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                        @endif

                                        @if(Auth::user() && in_array(Auth::user()->id, $artworks->save_count))
                                        <a class="save_artwork" data-artwork-id="{{$artworks->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="save_image" src="{{asset('assets/images/save_filled.png')}}"  title="Save for later"></a>
                                        @elseif(in_array(Session::get('random_id'), $artworks->save_count))
                                        <a class="save_artwork" data-artwork-id="{{$artworks->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="save_image" src="{{asset('assets/images/save_filled.png')}}"  title="Save for later"></a>
                                        @else
                                        <a class="save_artwork" data-artwork-id="{{$artworks->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="save_image" src="{{asset('assets/images/saved.png')}}"  title="Save for later"></a>
                                        @endif
                                        <!-- <a  class="like_artwork" data-artwork-id="{{$artworks->id}}" href="javascript:void(0);"><img class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                        <a class="save_artwork" data-artwork-id="{{$artworks->id}}" href="javascript:void(0);"><img class="save_image" src="{{asset('assets/images/saved.png')}}"  title="Save for later"></a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- End Similar Artworks Section -->
<!-- Footer Section -->
@include('layouts.frontend.comman_footer')