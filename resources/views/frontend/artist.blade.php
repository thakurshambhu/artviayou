@include('layouts.frontend.header')
<!-- Page Header Title -->
<div class="page-title">
<div class="page-title-inner">
   <span class="pagetitleText">artists</span> 
   <img src="{{asset('assets/images/artists-graphic.svg')}}" class="title-img" alt="">
</div>
</div>
<!--End Page Header Title -->
<div class="sorter">
<div class="container d-flex align-items-center justify-content-between">
   <h3>Artists</h3>
   <!-- <div class="form-group">
      <span class="input-icon"><img src="{{asset('assets/images/dropdown.svg')}}" alt=""></span>
      <select  id="" class="form-control">
         <option value="">Trending</option>
         <option value="">Latest</option>
         <option value="">Popular</option>
      </select>
   </div> -->
</div>
</div>
<!-- Trending Artists Page  ----->
<section class="TrendingArtists">
<div class="container">
   @if(!empty($artists) > 0)
   @foreach($artists as $key => $artist)
   <div class="artistContainer">
      <div class="artistHeader d-flex justify-content-between">
         <div class="artistHeaderLeft d-flex justify-content-between align-items-center">
            <div class="image"><a href="{{url('profile_details')}}/{{$artist->id}}"><img src="{{ $artist->media_url ? $artist->media_url : url('/assets/images/default.png') }}"  alt=""></a></div>
            <div class="nameFollowers">
               <span class="name">{{$artist->first_name}} {{$artist->last_name}}</span>
               <span class="followersNum">({{count($artist->like_count)}} Followers)</span>
            </div>

                @if(Auth::user() && in_array(Auth::user()->id, $artist->like_count))
                <a href="javascript:void(0);" class="btn btn-border btn-sm like_artist" data-artist-id="{{$artist->id}}">Following</a>
                @elseif(in_array(Session::get('random_id'), $artist->like_count))
                <a href="javascript:void(0);" class="btn btn-border btn-sm like_artist" data-artist-id="{{$artist->id}}">Following</a>
                @else
                <a href="javascript:void(0);" class="btn btn-border btn-sm like_artist" data-artist-id="{{$artist->id}}">Follow</a>
                @endif
            
            <!-- <a href="#" class="btn btn-border btn-sm">Follow</a> -->
         </div>
         <div class="artistHeaderRight d-flex justify-content-between align-items-center">
            <span class="artworkNumber"><img src="{{asset('assets/images/artworkIcon.svg')}}" alt=""> {{count($artist->artworks)}} artworks</span>
         </div>
      </div>
      <div class="artistSLider">
         <div class="owl-carousel artistCarousel">
            @foreach($artist->artworks as $artwork)
            <div class="artPost">
               <div class="postImage">

                  <a href="{{url('artwork_details')}}/{{$artwork->id}}"> <img src="{{$artwork->artwork_images[0]->media_url}}" alt=""></a>
               </div>
               <div class="postFooter">
                  <div class="leftBlock">
                     <h5>{{$artwork->title}}</h5>
                     <h6>@if(count($artwork->variants)>0)£{{$artwork->variants[0]->price}} @else Sold Out @endif</h6>
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
            @endforeach
            
         </div>
      </div>
   </div>
   @endforeach
   @endif

</div>
<div class="container">
  
   <div class="col-lg-12  py-4 border d-flex paginationContainer">
       <ul class="pagination mx-auto">
        <?php //dd($artists);?>
        <!-- {{ $artists->onEachSide(1)->links() }} -->
        {{ $artists->links() }}
         
       </ul>
   </div>
    
 </div>


</section>
<!--End Trending Artists Page  -->
@include('layouts.frontend.comman_footer')