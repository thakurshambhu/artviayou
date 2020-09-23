@include('layouts.frontend.header')
<!-- Profile Cover -->
<!-- <div class="profileCover">
    <img src="{{asset('assets/images/cover.jpg')}}" alt="">
</div> --> 
<!-- End Profile Cover ---->
<section class="profilePage">
    <div class="userStats">
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
            <div class="d-flex align-items-center justify-content-center mainInfo">
                <div class="image">
                    <img src="{{ $profileDetails->media_url ? $profileDetails->media_url : url('/assets/images/default.png') }}" class="img-fluid" alt="">
                </div>
                <div class="userStatsinfo">
                    <span class="name">{{$profileDetails->first_name}} {{$profileDetails->last_name}}</span>
                    <div class="stats">
                        <a href="javascript:void()" @if(Auth::user() && Auth::user()->id == $profileDetails->id) data-btn-type="like" data-toggle="modal" data-target="#LikeModel"  data-dismiss="modal" aria-label="Close" @endif class="@if(Auth::user() && Auth::user()->id == $profileDetails->id)like_users @endif like_stats" data-user-id="{{$profileDetails->id}}">
                            <span>{{$all_likes}} Likes</span>
                        </a>
                        <a href="javascript:void()" data-btn-type="followers" data-toggle="modal" data-target="#FollowersModel"  data-dismiss="modal" aria-label="Close" class="like_users all_follower" data-user-id="{{$profileDetails->id}}"> 
                            <span>{{$all_follower_count}} Followers</span>
                        </a>
                        <a href="javascript:void()" data-btn-type="follow" data-toggle="modal" data-target="#FollowModel"  data-dismiss="modal" aria-label="Close" class="like_users" data-user-id="{{$profileDetails->id}}">
                            <span class="following">{{$all_following_count}} Following</span>
                        </a> 
                        @if(Auth::user())
                            @if(Auth::user() && in_array(Auth::user()->id, $profileDetails->like_count))
                            <a href="javascript:void(0);" class="btn btn-default btn-sm like_artist" data-artist-id="{{$profileDetails->id}}">Following</a>
                            @elseif(in_array(Session::get('random_id'), $profileDetails->like_count))
                            <a href="javascript:void(0);" class="btn btn-default btn-sm like_artist" data-artist-id="{{$profileDetails->id}}">Following</a>
                            @else

                                        <a href="javascript:void(0);" class="btn btn-default btn-sm like_artist" data-artist-id="{{$profileDetails->id}}">Follow</a>
                            @endif
                        @endif
  
                            @if($profileDetails->role == "artist")
                            @if(Auth::user())
                                @if(Auth::user()->role == "buyer" || Auth::user()->role == "gallery")
                                    @if(!empty($request_comm))
                                        <a href="javascript:void(0);" class="btn btn-grey ml-1">Commission Requested</a>
                                    @else
                                        <a href="{{url('req_comm')}}/{{Auth::user()->id}}/{{$profileDetails->id}}" class="btn btn-border btn-sm req_comm ml-1">Request Commission</a>
                                    @endif
                                @endif
                            @endif
                            @endif
                        
                    
                        
                        <!-- <a href="javascript:void(0);" class="btn btn-default btn-sm like_artist" data-artist-id="{{$profileDetails->id}}">Follow</a> -->

                    <!-- <a id="chat_with_user" href="javascript:void(0);" data-user-id="{{$profileDetails->id}}" class="btn btn-border btn-sm">Chat</a> -->
                    </div>
                    <p>{{$profileDetails->biography}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="artWorksAbout">
        <div class="container">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#artWorks" role="tab" aria-controls="artWorks" aria-selected="true"><img src="{{asset('assets/images/artwork-icon.svg')}}" alt=""> Artworks</a>
                    
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#about" role="tab" aria-controls="about" aria-selected="false"><img src="{{asset('assets/images/about-icon-light.svg')}}" alt=""> About</a>
                    
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="artWorks" role="tabpanel" aria-labelledby="nav-home-tab">
                    <!-- <div class="artwork-images" id="artwork-images">
                        @if(count($profileDetails->artworks) > 0)
                        @foreach($profileDetails->artworks as $key => $artwork)
                        <figure><img src="{{asset('assets/images/art1.jpg')}}"></figure>
                        @endforeach
                        @endif
                    </div> -->


                    <div class="row">
                    @if(count($profileDetails->artworks) > 0)
                        @foreach($profileDetails->artworks as $key => $artwork)
                    <div class="col-lg-4 col-md-6">
                        <div class="artPost">
                            <div class="postHeader">
                                <div class="username">
                                    <div class="image">
                                        <div class="profile_img">
                                            <a href="{{url('profile_details')}}/{{$profileDetails->id}}">
                                            <img src="{{ $profileDetails->media_url ? $profileDetails->media_url : url('/assets/images/default.png') }}" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <span class="name">{{$profileDetails->first_name}} {{$profileDetails->last_name}}</span>
                                </div>
                                <span class="Posted">{{date('d M Y', strtotime($artwork->created_at))}}</span>
                            </div>
                            <div class="postImage">
                                <a href="{{url('artwork_details')}}/{{$artwork->id}}"> <img src="{{$artwork->artwork_images[0]->media_url}}" alt=""></a>
                            </div>
                            <div class="postFooter">
                                <div class="leftBlock">
                                    <h5>{{$artwork->title}}</h5>
                                    <h6>@if(count($artwork->variants)>0)£{{$artwork->variants[0]->price}}@else Sold Out @endif</h6>
                                </div>
                                <div class="rightBlock">
                                    <span class="likes">{{count($artwork->artwork_like)}} Likes</span> 
                                    <div class="actionIcons">

                                        @if(Auth::user())
                                            @if(Auth::user() && in_array(Auth::user()->id, $artwork->like_count))
                                            <a class="like_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/red_heart.jpeg')}}" title="Like Artwork"></a>
                                            @elseif(in_array(Session::get('random_id'), $artwork->like_count))
                                            <a class="like_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/red_heart.jpeg')}}" title="Like Artwork"></a>
                                            @else
                                            <a class="like_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                            @endif
                                        @else
                                            <a class="" href="javascript:void(0);" data-toggle="modal" data-target="#LoginModal"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                        @endif


                                        @if(Auth::user() && in_array(Auth::user()->id, $artwork->save_count))
                                        <a class="save_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="save_image" src="{{asset('assets/images/save_filled.png')}}"  title="Save for later"></a>
                                        @elseif(in_array(Session::get('random_id'), $artwork->save_count))
                                        <a class="save_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="save_image" src="{{asset('assets/images/save_filled.png')}}"  title="Save for later"></a>
                                        @else
                                        <a class="save_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="save_image" src="{{asset('assets/images/saved.png')}}"  title="Save for later"></a>
                                        @endif
                                        <!-- <a  class="like_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                        <a class="save_artwork" data-artwork-id="{{$artwork->id}}" href="javascript:void(0);"><img style="width: 20px; height: 21px;" class="save_image" src="{{asset('assets/images/saved.png')}}"  title="Save for later"></a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                </div>
                <div class="tab-pane fade" id="about" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="profileAbout">
                        <div class="aboutHeader d-flex justify-content-between align-items-center">
                            <h4>about amenda</h4>
                            @if(Auth::user())
                            @if($profileDetails->id == Auth::user()->id)
                            <a href="/{{Auth::user()->role}}/profile/{{Auth::user()->id}}" class="btn btn-default">edit profile</a>
                            @endif
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h6>contact information</h6>
                                <div class="infoItem"><span class="title">Email:</span> <span class="data">{{$profileDetails->email}}</span></div>
                                <div class="infoItem"><span class="title">Address:</span> <span class="data">{{$profileDetails->city}}, {{$profileDetails->state}}, {{$profileDetails->country}}, {{$profileDetails->postal_code}}</span></div>
                                <div class="divider"></div>
                                <!-- <h6>basic information</h6> -->
                            </div>
                            <div class="col-md-8">
                                <div class="extraInfo">
                                    <h5>Professional in</h5>
                                    <ul class="skills">
                                        @if(count($professional) > 0)
                                        @foreach($professional as $key => $value)
                                        <li>{{$value}}</li>
                                        @endforeach
                                        @endif
                                    </ul>
                                    <p>{{$profileDetails->biography}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('layouts.frontend.comman_footer')
