@extends('layouts.frontend.artist.app', [
    'class' => '',
    'elementActive' => 'artworks',
])
@section('content')
<section class="form-box" >
   <div class="container">
      <div class="row noRowMargin">
         <div class="col-md-12 form-wizard">
            <!-- Form Wizard -->
            <form role="form" enctype="multipart/form-data" action="{{url('artist/upload_artwork')}}" autocomplete="off" method="post" id="edit-artwork">
                @csrf
                <?php //dd($artwork);?>
                <input type="hidden" name="role" value="artist">
               
                <input type="hidden" name="id" value="{{$artwork->id}}">
            
               <h2>Artwork details</h2>
               <fieldset>
                  <div class="row noRowMargin">
                     
                     <div class="col-md-8 categorySection">
                        <div class="form-group">
                           <label>Title: <span>*</span></label>
                           <input id="mkl" type="text" name="title" placeholder="Title" maxlength="100" class="form-control required" value="{{$artwork->title}}">
                           <span class="characterLeft">Characters left: 100</span>
                        </div>
                        <div class="form-group">
                           <label>Description: <span></span></label>
                           <textarea class="form-control textarea" maxlength="1000" name="description" onkeyup="countChar(this)" rows="9" cols="50">{{$artwork->description}}</textarea>
                           <span class="descCharacterLeft">Characters left: 1000</span>
                        </div>
                        <div class="form-group">
                           <label>Additional Images: </label>
                           
                           <div class="imagesRow" id="imagesRow">
                              @if(count($artwork->artwork_images) > 0)
                              @foreach($artwork->artwork_images as $images)
                              <div class="addedImage" style="margin-left: 15px;">
                                 <div class="imageBox">
                                    <img src="{{$images->media_url}}" alt="">
                                 <!--    <button><i class="fa fa-trash remove_artwork_image" aria-hidden="true" data-artwork-image-id="{{$images->id}}"></i></button> -->
                                  <button type="button" class="remove_image" data-img-id="{{$images->id}}" data-artwork-id="{{$artwork->id}}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                 </div>
                              </div>
                              @endforeach
                              @endif

                              <div class="addedImage" style="display: none;">
                                 <div class="imageBox">
                                    <img src="{{asset('assets/images/image_placeholder.jpg')}}" alt="">
                                    <button><i class="fa fa-trash" aria-hidden="true"></i></button>
                                 </div>
                              </div>
                           <button class="addImage">+<input type="file" multiple id="gallery-photo-add" name="upload_files[]"></button>
                           </div>
                           <input type="hidden" name="hidden_image[]" >
                        </div>
                     </div>
                     <div class="col-md-4">
                           <div class="form-group">
                              <label>Category: <span>*</span></label>
                              <select class="form-control" name="category" id="category_id">
   
                              <option value="">Select Category</option>
                                
                              @foreach ($categories as $key => $category)
                                <option value="{{ $category->id }}" @if($category->id == $artwork->category_detail->id) selected @endif>{{ $category->name }}</option>
                              @endforeach    
                            </select>
                           </div>
                    
                           <div class="form-group">
                              <label>Type of painting: <span>*</span></label>
                              <select class="form-control" name="sub_category" id="sub_category">
                                 <option value="">Select Type</option>
                                  @foreach ($subcategories as $key => $subcategory)
                                   <option value="{{$subcategory->id}}" @if(!empty($artwork->sub_category_detail)) @if($subcategory->id == $artwork->sub_category_detail->id) selected @endif @endif>{{$subcategory->name }}</option>
                                 @endforeach 
                              </select>
                           </div>
                            <div class="form-group">
                           <label>Style: <span>*</span></label>
                           <select class="form-control" name="style" id="style_id">
                              <option value="">Select Style</option>
                              @foreach ($styles as $key => $style)
                                <option value="{{$style->id}}"  @if($style->id == $artwork->style_detail->id) selected @endif>{{$style->name }}</option>
                              @endforeach  
                           </select>
                        </div>
                        <div>
                           <label>Subject: <span>*</span></label>
                            <select class="form-control" name="subject" id="subject_id">
                              <option value="">Select Subject</option>
                              @foreach ($subjects as $key => $subject)
                                <option value="{{$subject->id}}"@if($subject->id == $artwork->subject_detail->id) selected @endif>{{ $subject->name }}</option>
                              @endforeach  
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="">
                     <div class="col-md-12 text-center">
                        <h2>Inventory and pricing</h2>
                     </div>
                     <div class="col-md-8 offset-md-2 inventoryPricing">
                        <div class="checkboxes d-flex justify-content-center ">
                           <div class="form-group">
                              <div ><label for="subject_animals"><input type="checkbox" id="originalCheck" name="variant_type" value="original" @if(count($variant_types) > 0 && in_array('original', $variant_types)) checked @endif >Orignal</label>
                              </div>
                           </div>
                           <div class="form-group">
                              <div ><label for="subject_animals"><input type="checkbox" id="limitedCheck" name="variant_type" value="limited_edition" @if(count($variant_types) > 0 && in_array('limited_edition', $variant_types)) checked @endif>Limited Edition</label>
                              </div>
                           </div>
                           <div class="form-group">
                              <div ><label for="subject_animals"><input type="checkbox" name="variant_type" id="printsCheck" value="art_paint" @if(count($variant_types) > 0 && in_array('art_paint', $variant_types)) checked @endif>Art Prints</label>
                              </div>
                           </div>
                           <input type="hidden" name="checked_variant_type" value="" id="checked_variant_type">
                        </div>
                     </div>
                  </div>
                  @if(count($variant_types) > 0)
                  @foreach($artwork->variants as $key => $value)
                     @if($value->variant_type == "original")
                     <div class="sizeRow original another_original" id="original">
                        <div class="col-md-12 d-flex justify-content-between">
                           <h3>Original</h3>
                        </div>
                        <div id = "AddInventory" class="col-md-12 ">
                           <div class="inputsRow d-flex justify-content-between flex-wrap">
                              <input type="hidden" name="original_id" value="{{$value->id}}">
                              <div class="col-md-6 form-group">
                                 <label for="">Width <span>*</span></label>
                                 <input class="form-control" type="text" value="{{$value->width}}" name="original_width">
                                 <select name="width_unit" class="form-control" id="">
                                    <option value="">cm</option>
                                 </select>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label for="">Height <span>*</span></label>
                                 <input class="form-control" type="text" value="{{$value->height}}" name="original_height">
                                 <select name="" class="form-control" id="">
                                    <option value="">cm</option>
                                 </select>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label for="">Price <span>*</span></label>
                                 <input class="form-control" type="text" value="{{$value->price}}" name="original_price">
                                 <select name="price" class="form-control" id="">
                                    <option value="">GBP</option>
                                 </select>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label for="">Shipping </label>
                                 <input class="form-control" type="text" value="{{$value->worldwide_shipping_charge}}" name="original_shipping_charge">
                                 <!-- <a href="javascript:void(0);" class="form-control addShippingLink" data-toggle="modal" data-target="#addShipping" >Add Shipping Price  <span>+</span></a> -->
                              </div>
                              <div class="deleteOriginal deleteType">
                                 <a href="javascript:void(0);">    <i class="fa fa-trash" aria-hidden="true"></i></a>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endif
                     @if($value->variant_type == "limited_edition")
                     <div class="sizeRow limitedEdition another_limited_edition" >
                        <div class="col-md-12 d-flex justify-content-between">
                           <h3>Limited Edition</h3>
                           <a href="javascript:void(0);" rel="another_limited_edition" class="addAnother" id="addlimtedEadi">add another size</a>
                        </div>
                        <div id = "AddInventory" class="col-md-12 ">
                           <div class="inputsRow d-flex justify-content-between flex-wrap">
                              <input type="hidden" name="limited_edition_id[]" class="hidden_limited_id" value="{{$value->id}}">
                              <div class="col-md-6 form-group">
                                 <label for="">Width <span>*</span></label>
                                 <input class="form-control" type="text" value="{{$value->width}}" name="limited_width[]">
                                 <select name="width" class="form-control" id="">
                                    <option value="">cm</option>
                                 </select>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label for="">Height <span>*</span></label>
                                 <input class="form-control" type="text" value="{{$value->height}}" name="limited_height[]">
                                 <select name="" class="form-control" id="">
                                    <option value="">cm</option>
                                 </select>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label for="">Price <span>*</span></label>
                                 <input class="form-control" type="text" value="{{$value->price}}" name="limited_price[]">
                                 <select name="price" class="form-control" id="">
                                    <option value="">GBP</option>
                                 </select>
                              </div>
                             
                              <div class="col-md-6 form-group">
                                 <label for="">Editions <span>*</span></label>
                                 <input class="form-control" type="text" value="{{$value->editions_count}}" name="limited_edition_count[]">
                                 <select name="editions_count" class="form-control" id="">
                                    <option value="">Ed.</option>
                                 </select>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label for="">Shipping </label>
                                 <input class="form-control" type="text" value="{{$value->worldwide_shipping_charge}}" name="limited_edition_shipping_charge[]">
                                 <!-- <a href="javascript:void(0);" class="form-control addShippingLink" data-toggle="modal" data-target="#addShipping" >Add Shipping Price  <span>+</span></a> -->
                              </div>
                              <div class="deleteLimtedEdition deleteType">
                                 <a href="javascript:void(0);">    <i class="fa fa-trash" aria-hidden="true"></i></a>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endif
                     @if($value->variant_type == "art_paint")
                     <div class="sizeRow artPrint another_art_print">
                        <div class="col-md-12 d-flex justify-content-between">
                           <h3>Art print</h3>
                           <a href="javascript:void(0);" rel="another_art_print" class="addAnother" id="addArtprint">add another size</a>
                        </div>
                        <div id = "AddInventory" class="col-md-12 ">
                           <div class="inputsRow d-flex justify-content-between flex-wrap">
                              <input type="hidden" name="art_print_id[]" class="hidden_art_id" value="{{$value->id}}">
                              <div class="col-md-6 form-group">
                                 <label for="">Width <span>*</span></label>
                                 <input class="form-control" type="text" value="{{$value->width}}" name="art_width[]">
                                 <select name="width" class="form-control" id="">
                                    <option value="">cm</option>
                                 </select>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label for="">Height <span>*</span></label>
                                 <input class="form-control" type="text" value="{{$value->height}}" name="art_height[]">
                                 <select name="" class="form-control" id="">
                                    <option value="">cm</option>
                                 </select>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label for="">Price <span>*</span></label>
                                 <input class="form-control" type="text" value="{{$value->price}}" name="art_price[]">
                                 <select name="price" class="form-control" id="">
                                    <option value="">GBP</option>
                                 </select>
                              </div>
                              <div class="col-md-6 form-group">
                                 <label for="">Shipping </label>
                                 <input class="form-control" type="text" value="{{$value->worldwide_shipping_charge}}" name="art_shipping_charge[]">
                                 <!-- <a href="javascript:void(0);" class="form-control addShippingLink" data-toggle="modal" data-target="#addShipping" >Add Shipping Price  <span>+</span></a> -->
                              </div>
                              <div class="deleteArtprint deleteType">
                                 <a href="javascript:void(0);">    <i class="fa fa-trash" aria-hidden="true"></i></a>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endif
                  @endforeach
                  @else
                  <!-- <div class="sizeRow original another_original" id="original" style="display:none;">
                     <div class="col-md-12 d-flex justify-content-between">
                        <h3>Original</h3>
                     </div>
                     <div id = "AddInventory" class="col-md-12 ">
                        <div class="inputsRow d-flex justify-content-between flex-wrap">
                           <div class="col-md-6 form-group">
                              <label for="">Width <span>*</span></label>
                              <input class="form-control" type="text" value="" name="original_width">
                              <select name="width_unit" class="form-control" id="">
                                 <option value="">cm</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Height <span>*</span></label>
                              <input class="form-control" type="text" value="" name="original_height">
                              <select name="" class="form-control" id="">
                                 <option value="">cm</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Price <span>*</span></label>
                              <input class="form-control" type="text" value="" name="original_price">
                              <select name="price" class="form-control" id="">
                                 <option value="">GBP</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Shipping </label>
                              <input class="form-control" type="text" value="" name="original_shipping_charge">
                           </div>
                           <div class="deleteOriginal deleteType">
                              <a href="javascript:void(0);">    <i class="fa fa-trash" aria-hidden="true"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="sizeRow limitedEdition another_limited_edition" style="display:none;">
                     <div class="col-md-12 d-flex justify-content-between">
                        <h3>Limited Edition</h3>
                        <a href="javascript:void(0);" rel="another_limited_edition" class="addAnother" id="addlimtedEadi">add another size</a>
                     </div>
                     <div id = "AddInventory" class="col-md-12 ">
                        <div class="inputsRow d-flex justify-content-between flex-wrap">
                           <div class="col-md-6 form-group">
                              <label for="">Width <span>*</span></label>
                              <input class="form-control" type="text" value="" name="limited_width[]">
                              <select name="width" class="form-control" id="">
                                 <option value="">cm</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Height <span>*</span></label>
                              <input class="form-control" type="text" value="" name="limited_height[]">
                              <select name="" class="form-control" id="">
                                 <option value="">cm</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Price <span>*</span></label>
                              <input class="form-control" type="text" value="" name="limited_price[]">
                              <select name="price" class="form-control" id="">
                                 <option value="">GBP</option>
                              </select>
                           </div>
                          
                           <div class="col-md-6 form-group">
                              <label for="">Editions <span>*</span></label>
                              <input class="form-control" type="text" value="" name="limited_edition_count[]">
                              <select name="editions_count" class="form-control" id="">
                                 <option value="">Ed.</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Shipping </label>
                              <input class="form-control" type="text" value="" name="limited_edition_shipping_charge[]">
                           </div>
                           <div class="deleteLimtedEdition deleteType">
                              <a href="javascript:void(0);">    <i class="fa fa-trash" aria-hidden="true"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="sizeRow artPrint another_art_print" style="display:none;">
                     <div class="col-md-12 d-flex justify-content-between">
                        <h3>Art print</h3>
                        <a href="javascript:void(0);" rel="another_art_print" class="addAnother" id="addArtprint">add another size</a>
                     </div>
                     <div id = "AddInventory" class="col-md-12 ">
                        <div class="inputsRow d-flex justify-content-between flex-wrap">
                           <div class="col-md-6 form-group">
                              <label for="">Width <span>*</span></label>
                              <input class="form-control" type="text" value="" name="art_width[]">
                              <select name="width" class="form-control" id="">
                                 <option value="">cm</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Height <span>*</span></label>
                              <input class="form-control" type="text" value="" name="art_height[]">
                              <select name="" class="form-control" id="">
                                 <option value="">cm</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Price <span>*</span></label>
                              <input class="form-control" type="text" value="" name="art_price[]">
                              <select name="price" class="form-control" id="">
                                 <option value="">GBP</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Shipping </label>
                              <input class="form-control" type="text" value="" name="art_shipping_charge[]">
                           </div>
                           <div class="deleteArtprint deleteType">
                              <a href="javascript:void(0);">    <i class="fa fa-trash" aria-hidden="true"></i></a>
                           </div>
                        </div>
                     </div>
                  </div> -->
                  @endif
                  @if(!in_array('original', $variant_types)) 
                  <div class="sizeRow original another_original" id="original" style="display:none;">
                     <div class="col-md-12 d-flex justify-content-between">
                        <h3>Original</h3>
                     </div>
                     <div id = "AddInventory" class="col-md-12 ">
                        <div class="inputsRow d-flex justify-content-between flex-wrap">
                           <div class="col-md-6 form-group">
                              <label for="">Width <span>*</span></label>
                              <input class="form-control" type="text" value="" name="original_width">
                              <select name="width_unit" class="form-control" id="">
                                 <option value="">cm</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Height <span>*</span></label>
                              <input class="form-control" type="text" value="" name="original_height">
                              <select name="" class="form-control" id="">
                                 <option value="">cm</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Price <span>*</span></label>
                              <input class="form-control" type="text" value="" name="original_price">
                              <select name="price" class="form-control" id="">
                                 <option value="">GBP</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Shipping </label>
                              <input class="form-control" type="text" value="" name="original_shipping_charge">
                              <!-- <a href="javascript:void(0);" class="form-control addShippingLink" data-toggle="modal" data-target="#addShipping" >Add Shipping Price  <span>+</span></a> -->
                           </div>
                           <div class="deleteOriginal deleteType">
                              <a href="javascript:void(0);">    <i class="fa fa-trash" aria-hidden="true"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endif
                  @if(!in_array('limited_edition', $variant_types)) 
                  <div class="sizeRow limitedEdition another_limited_edition" style="display:none;" >
                     <div class="col-md-12 d-flex justify-content-between">
                        <h3>Limited Edition</h3>
                        <a href="javascript:void(0);" rel="another_limited_edition" class="addAnother" id="addlimtedEadi">add another size</a>
                     </div>
                     <div id = "AddInventory" class="col-md-12 ">
                        <div class="inputsRow d-flex justify-content-between flex-wrap">
                           <div class="col-md-6 form-group">
                              <label for="">Width <span>*</span></label>
                              <input class="form-control" type="text" value="" name="limited_width[]">
                              <select name="width" class="form-control" id="">
                                 <option value="">cm</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Height <span>*</span></label>
                              <input class="form-control" type="text" value="" name="limited_height[]">
                              <select name="" class="form-control" id="">
                                 <option value="">cm</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Price <span>*</span></label>
                              <input class="form-control" type="text" value="" name="limited_price[]">
                              <select name="price" class="form-control" id="">
                                 <option value="">GBP</option>
                              </select>
                           </div>
                          
                           <div class="col-md-6 form-group">
                              <label for="">Editions <span>*</span></label>
                              <input class="form-control" type="text" value="" name="limited_edition_count[]">
                              <select name="editions_count" class="form-control" id="">
                                 <option value="">Ed.</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Shipping </label>
                              <input class="form-control" type="text" value="" name="limited_edition_shipping_charge[]">
                              <!-- <a href="javascript:void(0);" class="form-control addShippingLink" data-toggle="modal" data-target="#addShipping" >Add Shipping Price  <span>+</span></a> -->
                           </div>
                           <div class="deleteLimtedEdition deleteType">
                              <a href="javascript:void(0);">    <i class="fa fa-trash" aria-hidden="true"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endif
                  @if(!in_array('art_paint', $variant_types)) 
                  <div class="sizeRow artPrint another_art_print" style="display:none;">
                     <div class="col-md-12 d-flex justify-content-between">
                        <h3>Art print</h3>
                        <a href="javascript:void(0);" rel="another_art_print" class="addAnother" id="addArtprint">add another size</a>
                     </div>
                     <div id = "AddInventory" class="col-md-12 ">
                        <div class="inputsRow d-flex justify-content-between flex-wrap">
                           <div class="col-md-6 form-group">
                              <label for="">Width <span>*</span></label>
                              <input class="form-control" type="text" value="" name="art_width[]">
                              <select name="width" class="form-control" id="">
                                 <option value="">cm</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Height <span>*</span></label>
                              <input class="form-control" type="text" value="" name="art_height[]">
                              <select name="" class="form-control" id="">
                                 <option value="">cm</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Price <span>*</span></label>
                              <input class="form-control" type="text" value="" name="art_price[]">
                              <select name="price" class="form-control" id="">
                                 <option value="">GBP</option>
                              </select>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="">Shipping </label>
                              <input class="form-control" type="text" value="" name="art_shipping_charge[]">
                              <!-- <a href="javascript:void(0);" class="form-control addShippingLink" data-toggle="modal" data-target="#addShipping" >Add Shipping Price  <span>+</span></a> -->
                           </div>
                           <div class="deleteArtprint deleteType">
                              <a href="javascript:void(0);">    <i class="fa fa-trash" aria-hidden="true"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endif
                  <div class="form-wizard-buttons">
                     <button type="submit" class="btn btn-submit formSubmit">Submit</button>
                  </div>
               </fieldset>
              
            </form>
            <!-- Form Wizard -->
         </div>
      </div>
   </div>
</section>
@endsection