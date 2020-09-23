<div class="sorter">
    <div class="container d-flex align-items-center justify-content-between">
        <h3>{{$categories->name}} <span class="count">({{count($categories->artwork)}}) &nbsp;&nbsp;></span> <span
                class="property">Abstract</span></h3>
        <div class="form-group">
            <span class="input-icon"><img src="{{asset('assets/images/dropdown.svg')}}" alt=""></span>
            <select id="" class="form-control">
                <option value="">Sort by</option>
                <option value="">Trending</option>
                <option value="">Latest</option>
                <option value="">Popular</option>
            </select>
        </div>
    </div>
</div>

<!-- Start Category Section -->
<section class="Categories">
    <div class="container">
        <div class="categoryList">
            <!-- Category Item -->
            @foreach($categories->subcategories as $subcategory)
            <div class="categoryItem">
                <a href="javascript:void(0);" onclick="subCategoryInfo('{{$subcategory->id}}')">
                    <div class="image"><img src="{{$subcategory->media_url}}" alt=""></div>
                    <h3>{{$subcategory->name}}</h3>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- End Category Section -->

<!-- Top Artworks Section -->
<section class="topArtworks">
    <div class="container">
        <div class="sectionHeading">
            <h2>Top Artworks</h2>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @if(count($categories->artwork) > 0)
                @foreach($categories->artwork as $artworks)
                    @if(count($artworks->variants)>0)
                        <div class="col-lg-4 col-md-6">
                            <div class="artPost">
                                <div class="postHeader">
                                    <div class="username">
                                        <div class="image"><a href="{{url('profile_details')}}/{{$artworks->artist->id}}"><img src="{{$artworks->artist->media_url}}" alt=""></a></div>
                                        <span class="name">{{$artworks->artist->first_name}}</span>
                                    </div>
                                    <span class="Posted">{{date('d M Y', strtotime($artworks->created_at))}}</span>
                                </div>
                                <div class="postImage">
                                    <a href="{{url('artwork_details')}}/{{$artworks->id}}"><img src="{{$artworks->artwork_images[0]->media_url}}" alt=""></a>
                                </div>
                                <div class="postFooter">
                                    <div class="leftBlock">
                                        <h5>{{$artworks->title}}</h5>
                                        @if($artworks->variants)
                                        <h6>£{{$artworks->variants[0]->price}}</h6>
                                        @endif
                                    </div>
                                    <div class="rightBlock">
                                        <span class="likes">{{count($artworks->artwork_like)}} Likes</span> 
                                        <div class="actionIcons">
                                            @if(Auth::user())
                                                <a class="like_artwork" data-artwork-id="{{$artworks->id}}" href="javascript:void(0);"><img src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                            @else
                                                <a class="" href="javascript:void(0);" data-toggle="modal" data-target="#LoginModal"><img style="width: 20px; height: 21px;" class="like_image" src="{{asset('assets/images/like.png')}}" title="Like Artwork"></a>
                                            @endif
                                            <a class="save_artwork" data-artwork-id="{{$artworks->id}}" href="javascript:void(0);"><img src="{{asset('assets/images/saved.png')}}"  title="Save for later"></a>
                                        </div>
                                        <!-- <span class="likes">{{count($artworks->artwork_like)}} Likes</span>
                                        <div class="actionIcons">
                                            <a href="#"><img src="{{asset('assets/images/like.png')}}" alt=""></a>
                                            <a href="#"><img src="{{asset('assets/images/saved.png')}}" alt=""></a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
            <h5 style="text-align:center;">No Result Found</h5>
            @endif
        </div>
    </div>
</section>
<!-- End Top Artworks Section -->