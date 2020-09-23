@include('layouts.frontend.header')
<!-- Banner/Slider -->
<div class="message-alert-top">
    @if(Session::has('success'))
    <div>
        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {{ session('success') }}</em></div>
    </div>
    @endif
    @if(Session::has('error'))
    <div>
        <div class="alert alert-danger"><em> {{session('error')}}</em></div>
    </div>
    @endif
</div>
<section class="banner">
    <div class="banner-content align-items-center customCarousel carousel slide" id="bannerCarousel"  data-ride="carousel">
        <div class="carousel-inner">
            <!-- Carousel Item -->
            <div class="carousel-item active ">
                @if(!empty($homes) > 0)
                <div class="bannerImg align-items-center" style="background-image: url({{$homes->first_img_url}}); background-size: cover;">
                    <div class="container text-left">
                        <h3>@if(!empty($homes->title)){{$homes->title}}@endif</h3>
                        <p class="mt-3"><?=htmlspecialchars_decode($homes->des_first)?></p>
                        @if(!Auth::user())
                        <a @if(Auth::user()) href="javascript:void(0);" @else href="javascript:void(0);" data-toggle="modal" data-target="#LoginModal" @endif class="btn btn-default btn-lg mt-4">SELL NOW</a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
            <!-- //Carousel Item -->
        </div>
    </div>
</section>

<!-- End Banner/Slider -->
<!-- Start Category Section -->
<section class="Categories">
    <div class="container">
        <div class="categoryList">
            <!-- Category Item -->
            @foreach($categories as $key => $category)
            <div class="categoryItem">
                <a href="{{url('artworks')}}/{{$category->id}}">
                    <div class="image"><img src="{{$category->media_url}}" alt=""></div>
                    <h3>{{$category->name}}</h3>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- End Category Section -->
<!-- Featured Artwork -->
@if(!empty($featuredArtworks))
<div class="container">
    <section class="featuredArt">
    <div class="featuredImage">
        <img src="{{$featuredArtworks->artwork_images[0]->media_url}}" alt="">
    </div>
    <div class="featuredDetail">
        <h4>Featured Art</h4>
        <h1>{{$featuredArtworks->title}}</h1>
        <p>{{$featuredArtworks->description}} </p>
        @if(count($featuredArtworks->variants) > 0)
        <div class="specifications">
            <span class="dimension">{{$featuredArtworks->variants[0]->height}} x {{$featuredArtworks->variants[0]->width}} cm</span> 
            <!-- <span class="weight">Weight : 10Kg</span> -->
        </div>
        <h2>Price: £{{$featuredArtworks->variants[0]->price}}</h2>
        <div class="col-lg-5 pl-0">
            <a href="{{url('artwork_details')}}/{{$featuredArtworks->id}}" class="btn btn-default btn-lg btn-block">BUY NOW</a>
        </div>
        @endif
    </div>
</section>
</div>

@endif
<!--End Featured Artwork -->
<!-- Top Artworks Section -->
<section class="topArtworks">
    <div class="container">
        <div class="sectionHeading">
            <h2 >Top Artworks</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="artistSLider owl-carousel artistCarousel">
                @if(count($topartworks) > 0)
                    @foreach($topartworks as $key => $artwork)
                        @if(count($artwork->variants)>0)
                        <div class="artPost">
                            <div class="postHeader">
                                <div class="username">
                                    <div class="image" style="width: 43px; height: 44px;"><a href="/profile_details/{{$artwork->artist->id}}"><img src="{{ $artwork->artist->media_url ? $artwork->artist->media_url : url('/assets/images/default.png') }}" alt=""></a></div>
                                    <span class="name">{{$artwork->artist->first_name}} {{$artwork->artist->last_name}}</span>
                                </div>
                                <span class="Posted">{{date('d M Y', strtotime($artwork->created_at))}}</span>
                            </div>
                            <div class="postImage">
                                <a href="{{url('artwork_details')}}/{{$artwork->id}}"><img src="{{$artwork->artwork_images[0]->media_url}}" alt=""></a> 
                            </div>
                            <div class="postFooter">
                                <div class="leftBlock">
                                    <h5>{{$artwork->title}}</h5>
                                    <h6>£{{$artwork->variants[0]->price}}</h6>
                                </div>
                                <div class="rightBlock">
                                    <span class="likes">{{count($artwork->like_count)}} Likes</span> 
                                    <div class="actionIcons">
                                        @if(Auth::user())
                                            @if(Auth::user() && in_array(Auth::user()->id, $artwork->like_count))
                                            <a class="like_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img class="like_image" src="{{asset('assets/images/red_heart.jpeg')}}" title="Like Artwork"></a>
                                            @elseif(in_array(Session::get('random_id'), $artwork->like_count))
                                            <a class="like_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img class="like_image" src="{{asset('assets/images/red_heart.jpeg')}}" title="Like Artwork"></a>
                                            @else
                                            <a class="like_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                            @endif
                                        @else
                                            <a class="" href="javascript:void(0);" data-toggle="modal" data-target="#LoginModal"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                        @endif

                                        @if(Auth::user() && in_array(Auth::user()->id, $artwork->save_count))
                                        <a class="save_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img class="save_image" src="{{asset('assets/images/save_filled.png')}}"  title="Save for later"></a>
                                        @elseif(in_array(Session::get('random_id'), $artwork->save_count))
                                        <a class="save_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img class="save_image" src="{{asset('assets/images/save_filled.png')}}"  title="Save for later"></a>
                                        @else
                                        <a class="save_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img class="save_image" src="{{asset('assets/images/saved.png')}}"  title="Save for later"></a>
                                        @endif
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
<!-- End Top Artworks Section -->
<!-- Top Artists Section -->
<section class="topArtworks topArtists">
    <div class="container">
        <div class="sectionHeading">
            <h2 >Top Artists</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="artistSLider owl-carousel artistCarousel">
                @if(count($topartists) > 0)
                @foreach($topartists as $key => $topartist)
                <div class="col-12 col-md-12">
                    <div class="artPost artPostNew">
                        <div class="artist-frame">
                            <div class="artist-detail">
                                <div class="profile_img">
                                    <a href="{{url('profile_details')}}/{{$topartist->id}}">
                                        <img src="{{ $topartist->media_url ? $topartist->media_url : url('/assets/images/default.png') }}" alt="">
                                    </a>
                                </div>
                                <div class="profile-summary">
                                    <!-- <div class="name">{{$topartist->first_name}} {{$topartist->last_name}}</div> -->
                                    <h6>{{$topartist->first_name}} {{$topartist->last_name}}</h6>
                                     <a href="{{url('profile')}}/{{$topartist->user_name}}"><p class="account">@ {{$topartist->user_name}}</p></a>
                                </div>
                            </div>
                            @if(Auth::user())
                                <div class="artist-follow">
                                    @if(Auth::user() && in_array(Auth::user()->id, $topartist->like_count))
                                    <a href="javascript:void(0);" class="btn btn-default btn-sm like_artist" data-artist-id="{{$topartist->id}}">Following</a>
                                    @elseif(in_array(Session::get('random_id'), $topartist->like_count))
                                    <a href="javascript:void(0);" class="btn btn-default btn-sm like_artist" data-artist-id="{{$topartist->id}}">Following</a>
                                    @else
                                    <a href="javascript:void(0);" class="btn btn-default btn-sm like_artist" data-artist-id="{{$topartist->id}}">Follow</a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="artistText">
                            <p>{{$topartist->biography}}<a href="javascript:void(0);">{{$topartist->user_name}}</a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
                
        </div>
    </div>
    <div class="container text-center mt-5">
        <a href="{{url('artist')}}" class="btn btn-default">VIEW ALL</a>
    </div>
</section>
<!-- End Top Artists Section -->
@include('layouts.frontend.comman_footer')

