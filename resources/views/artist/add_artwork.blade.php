@extends('layouts.frontend.artist.app', [
    'class' => '',
    'elementActive' => 'new_artwork',
])
@section('content')
<section class="form-box" >
   <div class="container">
      <div class="row mainRow">
         <div class="col-md-12 form-wizard">
            <!-- Form Wizard -->
            <form role="form" id="upload_form" enctype="multipart/form-data" action="{{url('artist/upload_artwork')}}" autocomplete="off" method="post">
                @csrf
               <p>Fill all form field to go next step</p>
               <!-- Form progress -->
               <div class="form-wizard-steps form-wizard-tolal-steps-4">
                  <div class="form-wizard-progress">
                     <div class="form-wizard-progress-line" data-now-value="12.25" data-number-of-steps="4" style="width: 12.25%;"></div>
                  </div>
                  <!-- Step 1 -->
                  <div class="form-wizard-step active">
                     <div class="form-wizard-step-icon"><i class="fa fa-picture-o" aria-hidden="true"></i></div>
                     <p>Images</p>
                  </div>
                  <!-- Step 1 -->
                  <!-- Step 2 -->
                  <div class="form-wizard-step">
                     <div class="form-wizard-step-icon"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                     <p>Title and description</p>
                  </div>
                  <!-- Step 2 -->
                  <!-- Step 3 -->
                  <div class="form-wizard-step">
                     <div class="form-wizard-step-icon"><i class="fa fa-list-alt" aria-hidden="true"></i></div>
                     <p>Categorization</p>
                  </div>
                  <!-- Step 3 -->
                  <!-- Step 4 -->
                  <div class="form-wizard-step">
                     <div class="form-wizard-step-icon"><i class="fa fa-list-ol" aria-hidden="true"></i></div>
                     <p>Inventory and pricing</p>
                  </div>
                  <!-- Step 4 -->
               </div>
               <!-- Form progress -->
               <!-- Form Step 1 -->
               <fieldset>
                  <h4>Add a primary image of your artwork. To create the best listing, please crop the image to only show the artwork itself: <span class="steps_number">Step 1 - 4</span></h4>
                  <div class="container">
                     <div id="carbon-block" style="margin:50px auto"></div>
                     <div class="imageSelector">
                        <label for="cropzee-input" class="image-previewer" data-cropzee="cropzee-input"></label>
                        <i class="fa fa-picture-o" aria-hidden="true"></i>
                        <label for="cropzee-input" class="imageInput" >
                        <input id="cropzee-input" class="image-label" name="main_image" type="file" accept="image/*"> 
                        Select Artwork
                        </label>
                     </div>
                     <input type="hidden" name="main_image_base64" id="main_image" value="">
                     <div class="form-wizard-buttons">
                        <button type="button" class="btn btn-next first_step">Next</button>
                     </div>
                  </div>
               </fieldset>
               <fieldset>
                  <h4>Please choose the category of the original, even if you’re not selling it on Artviayou: <span class="steps_number">Step 2 - 4</span></h4>
                  <div class="row noRowMargin">
                     <div class="col-md-6">
                        <img class="img_preview" style="width:100%" src="{{asset('assets/images/image_placeholder.jpg')}}" alt="...">
                     </div>
                     <div class="col-md-6" >
                        <div class="form-group">
                           <label>Title: <span>*</span></label>
                           <input id="mkl" type="text" name="title" placeholder="Title" maxlength="100" class="form-control required" value="">
                           <span class="characterLeft">Characters left: 100</span>
                        </div>
                        <div class="form-group">
                           <label>Description: <span>*</span></label>
                           <textarea class="form-control textarea" maxlength="1000" name="description" onkeyup="countChar(this)" rows="9" cols="50"></textarea>
                           <span class="descCharacterLeft">Characters left: 1000</span>
                        </div>
                        <div class="form-group">
                           <label>Additional Images: </label>
                           <div class="imagesRow">
                              <div class="addedImage" style="display: none;">
                                 <div class="imageBox">
                                    <img src="{{asset('assets/images/image_placeholder.jpg')}}" alt="">
                                    <button><i class="fa fa-trash" aria-hidden="true"></i></button>
                                 </div>
                              </div>
                              <!-- <button class="addImage" data-toggle="modal" data-target="#addArtworkModal" >+</button> -->
                           <button class="addImage">+<input type="file" multiple id="gallery-photo-add" name="upload_files[]"></button>
                           </div>
                        </div>
                        <div class="form-wizard-buttons">
                           <button type="button" class="btn btn-previous">Previous</button>
                           <button type="button" class="btn btn-next second_step">Next</button>
                        </div>
                     </div>
                  </div>
                  <div class="modal fade getStartedModals LoginModal" id="addArtworkModal">
                     <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                           <div class="modal-body">
                              <div class="loginForm text-center">
                                 <div class="col-md-8 offset-md-2">
                                    <i class="fa fa-picture-o fa-5x" aria-hidden="true"></i>
                                    <div class="form-group mt-5">
                                       <label for="selectImage" > Select Image
                                       <input id="cropzee-input-multiple" class="image-label" name="media_url" type="file" accept="image/*"> 
                                       </label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </fieldset>
               <!-- Form Step 2 -->
               <!-- Form Step 3 -->
               <fieldset>
                  <h4>The better you describe your artwork using keywords, the higher you will get ranked by search engines: <span class="steps_number">Step 3 - 4</span></h4>
                  <div class="row noRowMargin">
                     <div class="col-md-6">
                        <img class="img_preview" src="{{asset('assets/images/image_placeholder.jpg')}}" alt="...">
                     </div>
                     <div class="col-md-6 categorySection">
                        <div class="d-flex justify-content-between cat-sub">
                           <div class="form-group">
                              <label>Category: <span>*</span></label>
                              <select class="form-control" name="category" id="category_id">
                                 <option value="">Select Category</option>
                                 @foreach ($categories as $key => $category)
                                    <option value="{{ $category->id }}"> 
                                        {{ $category->name }} 
                                    </option>
                                  @endforeach    
                            </select>
                           </div>
                           <div class="form-group">
                              <label>Sub-category: <span>*</span></label>
                              <select class="form-control" name="sub_category" id="sub_category">
                                
                              </select>
                           </div>
                        </div>
                        <div class="form-group">
                           <label>Style: <span>*</span></label>
                           <select class="form-control" name="style" id="style_id">
                              <option value="">Select Style</option>
                              @foreach ($styles as $key => $style)
                                <option value="{{$style->id}}">{{ $style->name }}</option>
                              @endforeach  
                           </select>
                        </div>
                        <div>
                           <label>Subject: <span>*</span></label>
                           <select class="form-control" name="subject" id="subject_id">
                              <option value="">Select Subject</option>
                              @foreach ($subjects as $key => $subject)
                                <option value="{{$subject->id}}">{{ $subject->name }}</option>
                              @endforeach  
                           </select>
                           <!-- <div class="d-flex justify-content-between cat-sub">
                            @foreach ($subjects as $key => $subject)
                              <div class="form-group">
                                 <div><input type="checkbox" class="subject_animals" name="subject"><label for="subject_animals">{{$subject->name}}</label></div>
                              </div>
                            @endforeach
                           </div> -->
                        </div>
                     </div>
                  </div>
                  <br/>
                  <div class="form-wizard-buttons">
                     <button type="button" class="btn btn-previous">Previous</button>
                     <button type="button" class="btn btn-next third_step">Next</button>
                  </div>
               </fieldset>
               <!-- Form Step 3 -->
               <!-- Form Step 4 -->
               <fieldset class="inventoryPricing">
                  <h4>Are you selling an original piece, limited editions or art prints? You can add as many variants as you want now, and always add more later on: <span class="steps_number">Step 4 - 4</span></h4>
                  <div class="">
                     <div class="col-md-12 text-center">
                        <h2>Inventory and pricing</h2>
                     </div>
                     <div class="col-md-8 offset-md-2">
                        <div class="checkboxes d-flex justify-content-center ">
                           <div class="form-group">
                              <div ><label for="subject_animals"><input type="checkbox" id="originalCheck" name="variant_type" value="original">Orignal</label>
                              </div>
                           </div>
                           <div class="form-group">
                              <div ><label for="subject_animals"><input type="checkbox" id="limitedCheck" name="variant_type" value="limited_edition">Limited Edition</label>
                              </div>
                           </div>
                           <div class="form-group">
                              <div ><label for="subject_animals"><input type="checkbox" name="variant_type" id="printsCheck" value="art_paint">Art Prints</label>
                              </div>
                           </div>
                           <input type="hidden" name="checked_variant_type" value="" id="checked_variant_type">
                        </div>
                     </div>
                  </div>
                  <div class="sizeRow original another_original" id="original">
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
                              <label for="">Shipping</label>
                              <input class="form-control" type="text" value="" name="original_shipping_charge">
                              <!-- <a href="javascript:void(0);" class="form-control addShippingLink" data-toggle="modal" data-target="#addShipping" >Add Shipping Price  <span>+</span></a> -->
                           </div>
                           <div class="deleteOriginal deleteType">
                              <a href="javascript:void(0);">    <i class="fa fa-trash" aria-hidden="true"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="sizeRow limitedEdition another_limited_edition">
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
                              <label for="">Shipping</label>
                              <input class="form-control" type="text" value="" name="limited_edition_shipping_charge[]">
                              <!-- <a href="javascript:void(0);" class="form-control addShippingLink" data-toggle="modal" data-target="#addShipping" >Add Shipping Price  <span>+</span></a> -->
                           </div>
                           <div class="deleteLimtedEdition deleteType">
                              <a href="javascript:void(0);">    <i class="fa fa-trash" aria-hidden="true"></i></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- </div> -->
                  <div class="sizeRow artPrint another_art_print">
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
                              <label for="">Shipping</label>
                              <input class="form-control" type="text" value="" name="art_shipping_charge[]">
                              <!-- <a href="javascript:void(0);" class="form-control addShippingLink" data-toggle="modal" data-target="#addShipping" >Add Shipping Price  <span>+</span></a> -->
                           </div>
                           <div class="deleteArtprint deleteType">
                              <a href="javascript:void(0);">    <i class="fa fa-trash" aria-hidden="true"></i></a>
                           </div>
                        </div>
                     </div>
                    
                  </div>

                   <div class="form-wizard-buttons">
                        <button type="button" class="btn btn-previous">Previous</button>
                        <button type="submit" class="btn btn-submit submit_artwork">Submit</button>
                     </div>
                  <div class="modal fade getStartedModals LoginModal" id="addShipping">
                     <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                           <div class="modal-body">
                              <div class="loginForm text-center">
                                 <div class="col-md-12">
                                    <div class="heading">
                                       <h2>Shipping</h2>
                                       <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam nemo quam blanditiis optio ea, expedita voluptas?</p>
                                    </div>
                                    <div class="divider"></div>
                                    <div>
                                       
                                    </div class=" ">
                                  <table class="table table-responsive-sm  table-hover table-bordered tableShipping">
                                       <thead class="thead-light">
                                          <tr>
                                             <th></th>
                                             <th>Name</th>
                                             <th>Origins</th>
                                             <th>Destinations</th>
                                             <th></th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td>
                                                <div class=""><input type="radio" name="" id=""></div>
                                             </td>
                                             <td>Default</td>
                                             <td></td>
                                             <td>Worldwide</td>
                                             <td>Free</td>
                                          </tr>
                                       </tbody>
                                    </table>
    
                                 </div>
                              
                                    <div class="d-flex justify-content-between align-item-center shippingButtons">
                                       <a href="" class="btn btn-border" data-toggle="modal" data-target="#ShippingModal">+ Add New Shipping</a>
                                       <a href="" class="btn btn-submit">Submit</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal fade getStartedModals LoginModal" id="ShippingModal">
                     <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                           <div class="modal-body">
                              <div class="loginForm text-center">
                                 <div class="col-md-12">
                                    <div class="heading">
                                       <h2>Shipping</h2>
                                       <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam nemo quam blanditiis optio ea, expedita voluptas?</p>
                                    </div>
                                    <div class="divider"></div>

                                       <div class="col-md-12">
                                       <div class="d-flex justify-content-between shippingDetails">
                                          <div class="shippingText">
                                             <h6>Shipping origin</h6>
                                             <p>Lorem ipsum dolor sit amet consectetur.</p>
                                          </div>
                                          <div class="shippingCurrency d-flex justify-content-between">
                                             <div class="form-group shippingCountry">
                                                <select class="form-control">
                                                    <option>USA</option>
                                                    <option>INDIA</option>
                                                </select>
                                               
                                             </div>

                                               <div class="form-group shippingCurrency">
                                                <select class="form-control">
                                                    <option>USA</option>
                                                  
                                                </select>
                                               
                                             </div>
                             
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-12">
                                       <div class="d-flex justify-content-between shippingDetails">
                                          <div class="shippingText">
                                             <h6>Worldwide</h6>
                                            
                                          </div>
                                          <div class="shippingCurrency d-flex justify-content-between">
                                             <div class="form-group shippingCountry">
                                                <input type="text" class required="form-control" value="0">
                                                <span class="valueType">INR</span>
                                             </div>
                                             
                                          </div>
                                       </div>
                                    </div>

                                      <div class="col-md-12">
                                       <div class="d-flex justify-content-between shippingDetails">
                                          <div class="shippingText">
                                            <h6>Worldwide</h6>
                                          </div>
                                          <div class="shippingCurrency d-flex justify-content-between">
                                             <div class="form-group shippingCountry">
                                                <input type="text" class required="form-control" value="0">
                                                <span class="valueType">INR</span>
                                             </div>
                                             <button class="delCurrency">
                                             <i class="fa fa-trash" aria-hidden="true"></i>
                                             </button>
                                          </div>
                                       </div>
                                    </div>

                                    <div class="col-md-12">
                                        <a href="javascript:void(0);" class="btn btn-secondary btn-block my-2">Add another location</a>

                                    </div>


                                    <div class="divider"></div>

                                    <div class="col-md-12">
                                        <h6>
                                            Shipping specification name
                   
                                        </h6>
                                        <p>Name your setting so you can use it in the future</p>
                    
                                    </div>
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="" class="form-control" placeholder="From 5 GBP international" name="">
                                        </div>

                                     </div>




                                    <div class="d-flex justify-content-between align-item-center shippingButtons">
                                       <a href="" class="btn btn-border">Cancel</a>
                                       <a href="" class="btn btn-submit">Save</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                <!--   <div class="form-wizard-buttons">
                     <button type="button" class="btn btn-previous">Previous</button>
                     <button type="submit" class="btn btn-submit submit_artwork">Submit</button>
                  </div> -->
               </fieldset>
               <!-- Form Step 4 -->
            </form>
            <!-- Form Wizard -->
         </div>
      </div>
   </div>
</section>

@endsection
<script type="text/javascript">
$(".sizeRow").hide();
</script>