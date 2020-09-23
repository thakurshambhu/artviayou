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
                                @foreach($categories as $category)
                                <li onclick="getSubCategory('{{$category->id}}')"><a href="javascript:;">{{$category->name}}</a></li>
                                @endforeach
                                <!-- <li class="active"><a href="javascript:;">Paintings</a> <span class="float-right">(4635)</span></li>
                                    <li><a href="javascript:;">Drawings</a> <span class="float-right">(1635)</span> </li>
                                    <li><a href="javascript:;">Digital art</a> <span class="float-right">(2635)</span></li>
                                    <li><a href="javascript:;">Photography</a> <span class="float-right">(4635)</span></li>
                                    <li><a href="javascript:;">Sculptures</a> <span class="float-right">(6645)</span></li> -->
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="filterBlock">
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
                                <!-- custom-control-input -->
                                <input type="checkbox" class="custom-control-input" name="variant_type" value="limited_edition" id="limitedPeriods">
                                <label class="custom-control-label variant_checkbox" for="limitedPeriods">Limited Periods</label>
                            </div>
                            <div class="custom-control custom-checkbox d-flex align-items-center">
                                <input type="checkbox" class="custom-control-input" name="variant_type" value="original" id="originals">
                                <label class="custom-control-label variant_checkbox" for="originals">Originals</label>
                            </div>
                            <div class="custom-control custom-checkbox d-flex align-items-center">
                                <input type="checkbox" class="custom-control-input" name="variant_type" value="art_paint" id="prints">
                                <label class="custom-control-label variant_checkbox" for="prints">Prints</label>
                            </div>
                        </div>
                    </div>
                    <div class="btn btn-default btn-block mt-3 reset_filter">reset filters</div>
                </div>
            </div>
            <div id="sub-category" class="col-12 col-md-8 col-lg-9">
            </div>
        </div>
    </div>
</section>
<!-- End Artworks Section -->
@include('layouts.frontend.comman_footer')
<script>
    $( window ).on( "load", function() {
      getSubCategory(1);
    });
</script>