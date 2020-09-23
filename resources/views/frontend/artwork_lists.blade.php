@include('layouts.frontend.header')
<!-- Artworks Section -->
<section class="artworksSection">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-lg-3">
                <div class="artworkfilters">
                    <div class="artworkSorting">
                        <h4>Filters</h4>
                        <div class="filterBlock">
                            <h5>Artworks <i class="fas fa-caret-right"></i></h5>
                            <ul>
                                @foreach($categories as $key=> $category)
                                @if(!empty($cat_id)) 
                                @if($category->id == $cat_id)
                                <li class="active category_li" onclick="getSubCategory('{{$category->id}}')"><a href="javascript:;">{{$category->name}}</a></li>
                                @else
                                <li class="category_li" onclick="getSubCategory('{{$category->id}}')"><a href="javascript:;">{{$category->name}}</a></li>
                                @endif
                                @else
                                <li @if($key ==0) class="active category_li" @else class="category_li" @endif onclick="getSubCategory('{{$category->id}}')"><a href="javascript:;">{{$category->name}}</a></li>
                                @endif 
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!--  <div class="filterBlock">
                        <h5 class="price_selected">Price (£1)</h5>
                        <div class="form-group">
                           <input type="range" class="custom-range price_range" id="price-filter" min="0" max="9999" value="0">
                           <div class="price-fields clearfix">
                              <input type="text" value="£1" class="float-left">  
                              <input type="text" value="£9999" class="float-right">
                           </div>
                        </div>
                        </div> -->
                    <div class="filterBlock">
                        <h5 class="price_selected">Price (£0-5000)</h5>
                        <div class="form-group">
                            <div class="slider-wrapper slider-danger slider-strips">
                                <input class="price-range" type="text" data-slider-step="1" data-slider-value="0, 5000" data-slider-min="0" data-slider-max="5000" data-slider-range="true" data-slider-tooltip_split="true"/>
                            </div>
                            <div class="price-fields clearfix">
                                <input type="text" value="0" id="price_start_range" name="price_start_range" class="float-left range_input_field">  
                                <input type="text" value="5000" id="price_end_range" name="price_end_range" class="float-right range_input_field">
                            </div>
                        </div>
                    </div>
                    <div class="filterBlock">
                        <h5>Size</h5>
                        <div class="form-group">
                            <div class="slider-wrapper slider-danger slider-strips unit_filter">
                                <div class="text-right">
                                    <span class="unit">Height</span>
                                    <span class="unit selected_unit"> (0-1000 cm)</span>
                                </div>
                                <div class="slider-wrapper slider-danger slider-strips">
                                    <input class="height-range" type="text" data-slider-step="1" data-slider-value="0, 1000" data-slider-min="0" data-slider-max="1000" data-slider-range="true" data-slider-tooltip_split="true"/>
                                </div>
                                <div class="price-fields clearfix">
                                    <input type="text" value="0" id="height_start_range" name="height_start_range" class="float-left range_input_field">  
                                    <input type="text" value="1000" id="height_end_range" name="height_end_range" class="float-right range_input_field">
                                </div>
                                <!-- <input class="input-range" type="text" data-slider-step="1" data-slider-value="14, 75" data-slider-min="0" data-slider-max="100" data-slider-range="true" data-slider-tooltip_split="true"/>
                                    <div class="price-fields d-flex justify-content-between">
                                      <input type="text" value="1 cm">  <input type="text" value="9999 cm">
                                    </div> -->
                            </div>
                            <div class="slider-wrapper slider-danger slider-strips unit_filter">
                                <div class="text-right">
                                    <span class="unit">Width</span>
                                    <span class="unit selected_unit"> (0-1000 cm)</span>
                                </div>
                                <div class="slider-wrapper slider-danger slider-strips">
                                    <input class="width-range" type="text" data-slider-step="1" data-slider-value="0, 1000" data-slider-min="0" data-slider-max="1000" data-slider-range="true" data-slider-tooltip_split="true"/>
                                </div>
                                <div class="price-fields clearfix">
                                    <input type="text" value="0" id="width_start_range" name="width_start_range" class="float-left range_input_field">  
                                    <input type="text" value="1000" id="width_end_range" name="width_end_range" class="float-right range_input_field">
                                </div>
                                <!-- <input class="input-range" type="text" data-slider-step="1" data-slider-value="14, 75" data-slider-min="0" data-slider-max="100" data-slider-range="true" data-slider-tooltip_split="true"/>
                                    <div class="price-fields d-flex justify-content-between">
                                      <input type="text" value="1 cm">  <input type="text" value="9999 cm">
                                    </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="filterBlock no-border">
                        <div class="form-group">
                            <select name="selected_style" id="style_id" class="form-control">
                                <option value="">Select Style</option>
                                @foreach($styles as $style)
                                <option value="{{$style->id}}">{{$style->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="filterBlock no-border">
                        <div class="form-group">
                            <select name="selected_subject" id="subject_id" class="form-control">
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="filterBlock no-border">
                        <div class="form-group">
                            <select name="filter_order" id="filter_order" class="form-control">
                                <option value="">Sort By</option>
                                <option value="low">Price Low To High</option>
                                <option value="high">Price High To Low</option>
                            </select>
                        </div>
                    </div>
                    <div class="filterBlock">
                        <h5>Type</h5>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox d-flex align-items-center">
                                <input type="checkbox" class="custom-control-input" id="limitedPeriods" name="variant_type" value="limited_edition">
                                <label class="custom-control-label variant_checkbox" for="limitedPeriods">Limited Periods</label>
                            </div>
                            <div class="custom-control custom-checkbox d-flex align-items-center">
                                <input type="checkbox" class="custom-control-input" id="originals" name="variant_type" value="original">
                                <label class="custom-control-label variant_checkbox" for="originals">Originals</label>
                            </div>
                            <div class="custom-control custom-checkbox d-flex align-items-center">
                                <input type="checkbox" class="custom-control-input" id="prints"  name="variant_type" value="art_paint">
                                <label class="custom-control-label variant_checkbox" for="prints">Prints</label>
                            </div>
                        </div>
                    </div>
                    <div class="btn btn-default btn-block mt-3 reset_filter">reset filters</div>
                </div>
            </div>
            <div id="sub-category" class="col-12 col-md-8 col-lg-9">
                <!-- Start Category Section -->
                <section class="Categories">
                    <div class="container">
                        <div class="categoryList">
                            <!-- Category Item -->
                            @if(count($categories)>0)
                            @if(!empty($cat_id))
                            @foreach($categories as $key => $cat)
                            @if($cat->id == $cat_id)
                            @foreach($categories[$key]->subcategories as $subcategory)
                            <div class="categoryItem">
                                <a href="javascript:void(0);" onclick="subCategoryInfo('{{$subcategory->id}}')">
                                    <div class="image"><img src="{{$subcategory->media_url}}" alt=""></div>
                                    <h3>{{$subcategory->name}}</h3>
                                </a>
                            </div>
                            @endforeach
                            @endif
                            @endforeach
                            @else
                            @foreach($categories[0]->subcategories as $subcategory)
                            <div class="categoryItem">
                                <a href="javascript:void(0);" onclick="subCategoryInfo('{{$subcategory->id}}')">
                                    <div class="image"><img src="{{$subcategory->media_url}}" alt=""></div>
                                    <h3>{{$subcategory->name}}</h3>
                                </a>
                            </div>
                            @endforeach
                            @endif
                            @endif
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
                            @foreach($all_artwork as $artworks)
                                @if(count($artworks->variants)>0)
                                <div class="col-lg-4 col-md-6">
                                    <div class="artPost">
                                        <div class="postHeader">
                                            <div class="username">
                                                <div class="image"><a href="{{url('profile_details')}}/{{$artworks->artist->id}}"><img src="{{ $artworks->artist->media_url ? $artworks->artist->media_url : url('/assets/images/default.png') }}" alt=""></a></div>
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
                        </div>
                    </div>
                </section>
                <!-- End Top Artworks Section -->
            </div>
        </div>
    </div>
</section>
<!-- End Artworks Section -->
@include('layouts.frontend.comman_footer')
<script></script>