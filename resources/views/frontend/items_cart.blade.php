@include('layouts.frontend.header')
<div class="page-title">
    <div class="page-title-inner">
        <span class="pagetitleText">Cart</span> 
        <img src="assets/images/saved-graphic.svg" class="title-img" alt="">
    </div>
</div>
<!--End Page Header Title -->
<!-- Top Artworks Section -->
<section class="savedArtworks">
    <div class="container">
        <div class="sectionHeading">
            <h2 >Your Cart</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @if(count($items_cart) > 0)
            @foreach($items_cart as $key => $artwork)
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
                            <h6>£{{$artwork->saved_artwork->variants[0]->price}}</h6>
                        </div>
                        <div class="rightBlock">
                            <span class="likes">{{count($artwork->saved_artwork->artwork_like)}} Likes</span> 
                            <div class="actionIcons">
                                <a  class="like_artwork" data-artwork-id="{{$artwork->saved_artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                <a class="save_artwork" data-artwork-id="{{$artwork->saved_artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="save_image" src="{{asset('assets/images/saved.png')}}"  title="Save for later"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @else
                <div style="text-align:center" class="container">
                    <div class="sectionHeading">
                        <h2 >No Artwork in Your Cart</h2>
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