@include('layouts.frontend.header')
<div class="page-title">
    <div class="page-title-inner">
        <span class="pagetitleText">saved</span> 
        <img src="assets/images/saved-graphic.svg" class="title-img" alt="">
    </div>
</div>
<!--End Page Header Title -->
<!-- Top Artworks Section -->
<section class="savedArtworks">
    <div class="container">
        <div class="sectionHeading">
            <h2 >Saved Art</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @if(count($saved_artwork) > 0)
            @foreach($saved_artwork as $key => $artwork)
            <div class="col-lg-4 col-md-6">
                <div class="artPost">
                    <div class="postHeader">
                        <div class="username">
                            <div class="image" style="width: 43px; height: 44px;"><a href="/profile_details/{{$artwork->saved_artwork->artist->id}}"><img src="{{ $artwork->saved_artwork->artist->media_url ? $artwork->saved_artwork->artist->media_url : url('/assets/images/default.png') }}" alt=""></a></div>
                            <span class="name">{{$artwork->saved_artwork->artist->first_name}} {{$artwork->saved_artwork->artist->last_name}}</span>
                        </div>
                        <span class="Posted">{{date('d M Y', strtotime($artwork->created_at))}}</span>
                    </div>
                    <div class="postImage">
                        <a href="{{url('artwork_details')}}/{{$artwork->saved_artwork->id}}"><img src="{{$artwork->saved_artwork->artwork_images[0]->media_url}}" alt=""></a> 
                    </div>
                    <div class="postFooter">
                        <div class="leftBlock">
                            <h5>{{$artwork->saved_artwork->title}}</h5>
                            <h6>@if(count($artwork->saved_artwork->variants)>0)£{{$artwork->saved_artwork->variants[0]->price}}@else Sold Out @endif</h6>
                        </div>
                        <div class="rightBlock">
                            <span class="likes">{{count($artwork->saved_artwork->artwork_like)}} Likes</span> 
                            <div class="actionIcons">
                                @if(Auth::user())
                                    @if(in_array($artwork->saved_artwork->id, $artwork->like_count))
                                    <a class="like_artwork" data-artwork-id="{{$artwork->saved_artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/red_heart.jpeg')}}" title="Like Artwork"></a>
                                    @elseif(in_array(Session::get('random_id'), $artwork->like_count))
                                    <a class="like_artwork" data-artwork-id="{{$artwork->saved_artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/red_heart.jpeg')}}" title="Like Artwork"></a>
                                    @else
                                    <a class="like_artwork" data-artwork-id="{{$artwork->saved_artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                    @endif
                                @else
                                    <a class="" href="javascript:void(0);" data-toggle="modal" data-target="#LoginModal"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                @endif
                                <a class="save_artwork" data-artwork-id="{{$artwork->saved_artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="save_image" src="{{asset('assets/images/save_filled.png')}}"  title="Save for later"></a>
                                
                                <!-- <a  class="like_artwork" data-artwork-id="{{$artwork->saved_artwork->id}}" href="javascript:void(0);"><img class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                <a class="save_artwork" data-artwork-id="{{$artwork->saved_artwork->id}}" href="javascript:void(0);"><img class="save_image" src="{{asset('assets/images/saved.png')}}"  title="Save for later"></a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
                <div style="text-align:center" class="container">
                    <div class="sectionHeading">
                        <h2 >No Artwork Saved</h2>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- End Top Artworks Section -->
<!-- End Top Artists Section -->
<!-- Footer Section -->
@include('layouts.frontend.comman_footer')