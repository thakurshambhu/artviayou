<!-- Footer Section -->
<footer class="siteFooter">
  <div class="container footerLink">
    <div class="row">
      <div class="col-md-4 d-flex justify-content-between flex-wrap">
        <div class="Links">
          <h3>About</h3>
          <ul class="navLink">
            <li><a href="{{url('about_us')}}">About Us</a></li>
           <!--  <li><a href="#">Careers</a></li>  -->
          </ul>
        </div>
        <div class="Links">
          <h3>Support</h3>
          <ul class="navLink">
            <!-- <li><a href="#">Shipping & Returns</a></li> -->
            <li><a href="{{url('faq')}}">Help/FAQ</a></li>
            <li><a href="{{url('terms_conditions')}}">Terms of use</a></li>
            <!-- <li><a href="javascript:void(0);">Project Management</a></li> -->
            <!-- <li><a href="javascript:void(0);">Mounting Instructions</a></li> -->
            <li><a href="{{url('privacy_policy')}}">Privacy Policy</a></li>
            <li><a href="{{url('contact_us')}}">Contact Us</a></li>
          </ul>
        </div>
        <!-- <div class="Links">
          <h3>Important Links</h3>
          <ul class="navLink">
            <li><a href="#">Sell your Art</a></li>
            <li><a href="#">Buy Art</a></li>
            <li><a href="#">Gallery</a></li>
            <li><a href="#">Sitemap</a></li>
          </ul>
        </div>
        <div class="Links">
          <h3>Other Links</h3>
          <ul class="navLink">
            <li><a href="#">Sell your Art</a></li>
            <li><a href="#">Buy Art</a></li>
            <li><a href="#">Gallery</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Sitemap</a></li>
          </ul>
        </div> -->
      </div>
      <div class="col-md-8 text-right">
        <div class="social-links">
          <a href="javascript:void(0)" target="_blank"><img src="{{asset('assets/images/fb.png')}}" alt=""></a>
          <a href="https://www.instagram.com/artviayou" target="_blank"><img src="{{asset('assets/images/insta.png')}}" alt="" ></a>
          <a href="https://www.youtube.com/channel/UC7OUAZlM0uNwXte0RAvr8GA" target="_blank"><img src="{{asset('assets/images/youtube.png')}}" alt=""></a>
        </div>
        <div class="footerLower">
          <div class="lowerLinks">
            @if(Auth::user() && Auth::user()->role == 'artist')
            <a href="{{url('/artist/add_artwork')}}">Sell on Artviayou</a>
            @endif

            @if (!Auth::user())
            <a href="javascript:void(0);" data-toggle="modal" data-target="#LoginModal">Sell on Artviayou</a>  
            @endif

         
            <a href="{{url('/faq')}}">Help</a>
            <a href="{{url('/cart')}}">Cart</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Copyright -->
  <div class="copyright">
    <div class="container">
      <p class="copyTxt">© All Right Reserved Artviayou {{date('Y')}}.</p>
    </div>
  </div>
  <!-- //Copyright -->
</footer>
<!-- Like  Model -->

<div class="modal fade user_list" tabindex="-1" role="dialog"  id="LikeModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Likes User List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="users_like_list">
       <!--  <p>Modal body text goes here.</p> -->
      </div>
      
    </div>
  </div>
</div>

<!-- Followers  Model -->

<div class="modal fade followers_users" tabindex="-1" role="dialog"  id="FollowersModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Followers User List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="FollowersModelBody">
      <!--   <p>Modal body text goes here.</p> -->
      </div>
      
    </div>
  </div>
</div>

<!-- Follow  Model -->

<div class="modal fade following_users" tabindex="-1" role="dialog"  id="FollowModel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Following User List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="FollowModelBody">
       <!--  <p>Modal body text goes here.</p> -->
      </div>
      
    </div>
  </div>
</div>

<!-- Chat Model -->
<div class="chatModal" id="chatModal">
    
</div>
<!-- End Chat Model -->
<!-- Change Order Status Model -->
<div class="modal fade" id="">
    
</div>

<div class="modal fade" id="changeShippingStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  
</div>
<!-- End Change Order Status Model -->
<!-- //Footer Section -->
<form class="form" method="POST" action="{{url('/submit_login')}}" id="login_form">
  @csrf
  <div class="modal fade getStartedModals LoginModal" id="LoginModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
         <a href="#" class="goBack"  data-dismiss="modal" aria-label="Close"><img src="{{asset('assets/images/left-arrow.svg')}}" alt=""> Go back</a>
        <div class="loginForm text-center">
            <h3>Sign In to your account</h3>
            <div class="col-md-8 offset-md-2">
              <div class="form-group">
              <span class="loginerror formerror" style="color:red"></span>
                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}"  autofocus id="email">
              
                
                @if ($errors->has('email'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
                
              </div>

              <div class="form-group">
                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" id="password">
                
                @if ($errors->has('password'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
              </div>
              <button type="submit" class="btn btn-default btn-block" id="submit-form">{{ __('Sign in') }}</button>
              <a href="#" class="btn btn-link btn-sm my-3" data-toggle="modal" data-target="#forgetModel" data-dismiss="modal" aria-label="Close">Forgot Password?</a>
              <a href="#" class="btn btn-border btn-block" data-toggle="modal" data-target="#SignUpModal" data-dismiss="modal" aria-label="Close">create account</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<div class="modal fade getStartedModals SignUpModal2" id="forgetModel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <a href="#" class="goBack" data-toggle="modal" data-target="#SignUpModal"  data-dismiss="modal" aria-label="Close"><img src="{{asset('assets/images/left-arrow.svg')}}" alt=""> Go back</a>
        <div class="loginForm text-center">
          <h3>Enter your details to sign up</h3>
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <form method="POST"  action="{{ route('password.email') }}" id="forgot-password">
            @csrf
            <div class="col-md-8 offset-md-2">
              <div class="form-group">
              <span class="resetpasswordlink formerror" style="color:red;"></span>
              <span class="resetpasswordsuccess  signupFormerror" style="color:green !important;"></span>
                <input id="forgot-email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <button type="submit" class="btn btn-default btn-block" id="submit-password">{{ __('Send Verification Link') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade getStartedModals SignUpModal" id="SignUpModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <a href="#" class="goBack"  data-dismiss="modal" aria-label="Close"><img src="{{asset('assets/images/left-arrow.svg')}}" alt=""> Go back</a>
        <div class="loginForm text-center">
          <h3>Sign Up with artviayou</h3>
          <div class="col-md-8 offset-md-2">
            <a href="#" class="btn btn-default btn-block" data-toggle="modal" data-target="#SignUpModal2" data-dismiss="modal" aria-label="Close">sign up with email</a>
            <span class="or-divider">Or</span>
            <!-- <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-default btn-block btn-facebook">sign up with facebook</a> -->

            <a href="#" class="btn btn-default btn-block" data-toggle="modal" data-target="#SignUpModal4" data-dismiss="modal" aria-label="Close">sign up with facebook</a>

          </div>
          <span class="mt-4"> <a href="#" class="btn btn-link btn-sm" data-toggle="modal" data-target="#LoginModal" data-dismiss="modal" aria-label="Close">Already a member of ArtviaYou Login</a></span>
        </div>
      </div>
    </div>
  </div>
</div>
<form class="form" method="POST" id="registerForm" action="{{ route('register') }}">
  @csrf
  <div class="modal fade getStartedModals SignUpModal2" id="SignUpModal2">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <a href="#" class="goBack" data-toggle="modal" data-target="#SignUpModal"  data-dismiss="modal" aria-label="Close"><img src="{{asset('assets/images/left-arrow.svg')}}" alt=""> Go back</a>
          <div class="loginForm text-center">
            <h3>Enter your details to sign up</h3>
            <div class="col-md-8 offset-md-2">
              <div class="form-group">
              <span class="signuperror formerror" style="color:red"></span>
                <input name="first_name" type="text" class="form-control" placeholder="First Name" value="{{ old('first_name') }}" required autofocus id="first_name">
                @if ($errors->has('first_name'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('first_name') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group">
                <input name="last_name" type="text" class="form-control" placeholder="Last Name" value="{{ old('last_name') }}" required id="last_name">
                @if ($errors->has('last_name'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('last_name') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group">
                <input name="email" type="email" class="form-control" placeholder="Email" required value="{{ old('email') }}" id="email-address">
                @if ($errors->has('email'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Password" required id="register-password">
                @if ($errors->has('password'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
              </div>
              <div class="form-group">
                <input name="user_name" type="user_name" class="form-control" placeholder="User Name" required id="user_name">
                @if ($errors->has('user_name'))
                <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('user_name') }}</strong>
                </span>
                @endif
              </div>
              <input type="hidden" id="user_role" name="role" required>
              <a href="#" class="btn btn-default btn-block" id="registration-form" data-toggle="modal" aria-label="Close">Next Step</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade getStartedModals SignUpModal3" id="SignUpModal3">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <a href="#" class="goBack" data-toggle="modal" data-target="#SignUpModal2" data-dismiss="modal" aria-label="Close"><img src="{{asset('assets/images/left-arrow.svg')}}" alt=""> Go back</a>
          <div class="loginForm text-center">
            <h3>Account type</h3>
            <div class="col-md-8 offset-md-2">
              <div class="userTypes d-flex justify-content-between mb-3">
              <span class="registerFormerror formerror" style="color:red;"></span>
              <span class="signupForm signupFormerror" style="color:green;"></span>
                <button type="button" data-btn-val="buyer" class="btn btn-border btn-lg role_btn setUserRole" >Buyer</button>
                <button type="button" data-btn-val="artist" class="btn btn-border btn-lg role_btn setUserRole" >Artist</button>
                <button type="button" data-btn-val="gallery" class="btn btn-border btn-lg role_btn setUserRole" >Gallery</button>
              </div>
              <div class="custom-control custom-checkbox d-flex align-items-center mb-4">
                <input type="checkbox" class="custom-control-input clickcheckbox" name="agree_terms_and_conditions" value="1" id="customCheck1" required>
                <label class="custom-control-label" for="customCheck1">By signing up you agree to our <a target="_blank" href="{{url('terms_conditions')}}">Terms & Conditions</a>.</label>
              </div>
              <button type="submit" class="btn btn-default btn-block showSignup" style="display: none;">{{ __('Sign Up') }}</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
</form>
  <div class="modal fade getStartedModals SignUpModal3" id="SignUpModal4">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <a href="#" class="goBack" data-toggle="modal" data-target="#SignUpModal" data-dismiss="modal" aria-label="Close"><img src="{{asset('assets/images/left-arrow.svg')}}" alt=""> Go back</a>
          <div class="loginForm text-center">
            <h3>Account type</h3>
            <div class="col-md-8 offset-md-2">
              <div class="userTypes d-flex justify-content-between mb-3">
              <span class="registerFormerror formerror" style="color:red;"></span>
              <span class="signupForm signupFormerror" style="color:green;"></span>
                <button type="button" data-btn-val="buyer" class="btn btn-border btn-lg role_btn setUserRole" >Buyer</button>
                <button type="button" data-btn-val="artist" class="btn btn-border btn-lg role_btn setUserRole" >Artist</button>
                <button type="button" data-btn-val="gallery" class="btn btn-border btn-lg role_btn setUserRole" >Gallery</button>
              </div>
              <div class="custom-control custom-checkbox d-flex align-items-center mb-4">
                <input type="checkbox" class="custom-control-input clickcheckbox" name="agree_terms_and_conditions" value="1" id="customCheck2" required>
                <label class="custom-control-label" for="customCheck2">By signing up you agree to our <a target="_blank" href="{{url('terms_conditions')}}">Terms & Conditions</a>.</label>
              </div>
              <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-default btn-block showSignup" style="display: none;">{{ __('Sign Up') }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- //Wrapper -->
<!-- jQuery CDN Link -->
<script src="{{asset('assets/js/jquery-3.3.1.slim.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-slider.min.js')}}"></script>
<script src="{{asset('assets/js/wow.min.js')}}"></script>
<script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/js/toastr.js')}}"></script>
<script src="{{asset('assets/js/bootstrap3-typeahead.js')}}"></script>
<script src="{{url('ckeditor/ckeditor.js')}}"></script>

<script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
<script type="text/javascript" language="javascript" src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>

<script>
  $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 500,
      values: [ 75, 300 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
      " - $" + $( "#slider-range" ).slider( "values", 1 ) );
  } );
  </script>
<script>

  $('document').ready(function() {
   if ($(".message-alert-top").children().length == 0 ) {
       $(".message-alert-top").css('display','none');
       $(".message-alert-top").removeClass('active_alert');
   }
   else{
       $(".message-alert-top").css('display','block');
       $(".message-alert-top").addClass('active_alert');
    }
  }); 

  setTimeout(function() {
    $('.message-alert-top').fadeOut('fast');
  }, 3500); 
   var category_id = '';
   var sub_category_id = '';
   function subCategoryInfo(id) {
      sub_category_id = id;
      var favorite = [];
        $.each($("input[name='variant_type']:checked"), function(){
          favorite.push($(this).val());
        });
      data = {'id':category_id,'sub_category_id':sub_category_id,'price_start_range': $('#price_start_range').val(), 'price_end_range': $('#price_end_range').val(),'height_start_range': $('#height_start_range').val(), 'height_end_range': $('#height_end_range').val(),'width_start_range': $('#width_start_range').val(), 'width_end_range': $('#width_end_range').val(),'subject_id':$('#subject_id').val(),'filter_order':$('#filter_order').val(),'style_id':$('#style_id').val(),'variant_type':favorite.join(",")}
      applyFilter(data);
   }

   function getSubCategory(id) {
      category_id = id;
      sub_category_id = "";
      var favorite = [];
        $.each($("input[name='variant_type']:checked"), function(){
          favorite.push($(this).val());
        });
      data = {'id':category_id,'sub_category_id':sub_category_id,'price_start_range': $('#price_start_range').val(), 'price_end_range': $('#price_end_range').val(),'height_start_range': $('#height_start_range').val(), 'height_end_range': $('#height_end_range').val(),'width_start_range': $('#width_start_range').val(), 'width_end_range': $('#width_end_range').val(),'subject_id':$('#subject_id').val(),'filter_order':$('#filter_order').val(),'style_id':$('#style_id').val(),'variant_type':favorite.join(",")}
      applyFilter(data);
   }
   
   function applyFilter(data){
    // console.log(data);
      $.ajax({
            url: '{{url('buyer/sub-categories')}}',
            type: 'POST',
            data: data,
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

            success: function (res) {
               if (res.status == "200") {
                  $("#sub-category").html(res.html);
               } else {

                  return false;
               }
            },
            error: function (errormessage) {

               return false;
            }
      });
   }
</script>

<script>
  $(document).on('click', '.categoryItem', function () { 
    var favorite = [];
    $.each($("input[name='variant_type']:checked"), function(){
      favorite.push($(this).val());
    });
     // alert("My favourite sports are: " + favorite.join(", "));
     data = {'id':category_id,'sub_category_id':sub_category_id,'price_start_range': $('#price_start_range').val(), 'price_end_range': $('#price_end_range').val(),'height_start_range': $('#height_start_range').val(), 'height_end_range': $('#height_end_range').val(),'width_start_range': $('#width_start_range').val(), 'width_end_range': $('#width_end_range').val(),'subject_id':$('#subject_id').val(),'filter_order':$('#filter_order').val(),'style_id':$('#style_id').val(),'variant_type':favorite.join(",")}
      applyFilter(data);
  });
</script>   
<script>
  // $(document).on('click', '.variant_checkbox', function () { 
  $(document).on('click', 'input[name="variant_type"]', function () { 
    var favorite = [];
    $.each($("input[name='variant_type']"), function(){
      if($(this).prop("checked") == true){
        favorite.push($(this).val());
      }
    });
    // console.log(favorite);
     // alert("My favourite sports are: " + favorite.join(", "));
     data = {'id':category_id,'sub_category_id':sub_category_id,'price_start_range': $('#price_start_range').val(), 'price_end_range': $('#price_end_range').val(),'height_start_range': $('#height_start_range').val(), 'height_end_range': $('#height_end_range').val(),'width_start_range': $('#width_start_range').val(), 'width_end_range': $('#width_end_range').val(),'subject_id':$('#subject_id').val(),'filter_order':$('#filter_order').val(),'style_id':$('#style_id').val(),'variant_type':favorite.join(",")}
      applyFilter(data);
  });
</script>   
<script>
   //   $(".price-range").on('change keyup paste', function () {
   //      var favorite = [];
   //      $.each($("input[name='variant_type']:checked"), function(){
   //        favorite.push($(this).val());
   //      });
   //      console.log($('#price_end_range').val());
   //      data = {'id':category_id,'sub_category_id':sub_category_id,'price_start_range': $('#price_start_range').val(), 'price_end_range': $('#price_end_range').val(),'height_start_range': $('#height_start_range').val(), 'height_end_range': $('#height_end_range').val(),'width_start_range': $('#width_start_range').val(), 'width_end_range': $('#width_end_range').val(),'subject_id':$('#subject_id').val(),'filter_order':$('#filter_order').val(),'style_id':$('#style_id').val(),'variant_type':favorite.join(",")}
   //    applyFilter(data);
   // });
</script>

<script>
   //   $("#height-filter").on('change keyup paste', function () {
   //      var favorite = [];
   //    $.each($("input[name='variant_type']:checked"), function(){
   //      favorite.push($(this).val());
   //    });
   //    data = {'id':category_id,'sub_category_id':sub_category_id,'price_start_range': $('#price_start_range').val(), 'price_end_range': $('#price_end_range').val(),'height_start_range': $('#height_start_range').val(), 'height_end_range': $('#height_end_range').val(),'width_start_range': $('#width_start_range').val(), 'width_end_range': $('#width_end_range').val(),'subject_id':$('#subject_id').val(),'filter_order':$('#filter_order').val(),'style_id':$('#style_id').val(),'variant_type':favorite.join(",")}
   //    applyFilter(data);
   // });
</script>

<script>
   //   $("#width-filter").on('change keyup paste', function () {
   //      var favorite = [];
   //    $.each($("input[name='variant_type']:checked"), function(){
   //      favorite.push($(this).val());
   //    });
   //    data = {'id':category_id,'sub_category_id':sub_category_id,'price_start_range': $('#price_start_range').val(), 'price_end_range': $('#price_end_range').val(),'height_start_range': $('#height_start_range').val(), 'height_end_range': $('#height_end_range').val(),'width_start_range': $('#width_start_range').val(), 'width_end_range': $('#width_end_range').val(),'subject_id':$('#subject_id').val(),'filter_order':$('#filter_order').val(),'style_id':$('#style_id').val(),'variant_type':favorite.join(",")}
   //    applyFilter(data);
   // });
</script>

<script>
      $(document).on('change', 'select', function(){
        var favorite = [];
      $.each($("input[name='variant_type']:checked"), function(){
        favorite.push($(this).val());
      });
      data = {'id':category_id,'sub_category_id':sub_category_id,'price_start_range': $('#price_start_range').val(), 'price_end_range': $('#price_end_range').val(),'height_start_range': $('#height_start_range').val(), 'height_end_range': $('#height_end_range').val(),'width_start_range': $('#width_start_range').val(), 'width_end_range': $('#width_end_range').val(),'subject_id':$('#subject_id').val(),'filter_order':$('#filter_order').val(),'style_id':$('#style_id').val(),'variant_type':favorite.join(",")}
      applyFilter(data);
   });
</script>

<script>
      $(document).on('keyup', '.range_input_field', function(){
        var favorite = [];
      $.each($("input[name='variant_type']:checked"), function(){
        favorite.push($(this).val());
      });
      data = {'id':category_id,'sub_category_id':sub_category_id,'price_start_range': $('#price_start_range').val(), 'price_end_range': $('#price_end_range').val(),'height_start_range': $('#height_start_range').val(), 'height_end_range': $('#height_end_range').val(),'width_start_range': $('#width_start_range').val(), 'width_end_range': $('#width_end_range').val(),'subject_id':$('#subject_id').val(),'filter_order':$('#filter_order').val(),'style_id':$('#style_id').val(),'variant_type':favorite.join(",")}
      applyFilter(data);
   });
</script>

<script type="text/javascript">
$(document).on('click', '.role_btn', function(){
  $('.role_btn').css("background-color", "");  
  $(this).css("background-color", "#0e0f11");  
})

$(document).on('change mousemove', '.width-range', function(){
  $(this).parents('.unit_filter').find('.selected_unit').html(' ('+$(this).val()+' cm)')
  var width_range = $(this).val();
  var width_range_val = width_range.split(',');
  // console.log('split val 0 '+width_range_val[0]);
  // console.log('split val 1 '+width_range_val[1]);
  $('#width_start_range').val(width_range_val[0]);
  $('#width_end_range').val(width_range_val[1]);

  var favorite = [];
    $.each($("input[name='variant_type']:checked"), function(){
      favorite.push($(this).val());
    });
    console.log($('#price_end_range').val());
    data = {'id':category_id,'sub_category_id':sub_category_id,'price_start_range': $('#price_start_range').val(), 'price_end_range': $('#price_end_range').val(),'height_start_range': $('#height_start_range').val(), 'height_end_range': $('#height_end_range').val(),'width_start_range': $('#width_start_range').val(), 'width_end_range': $('#width_end_range').val(),'subject_id':$('#subject_id').val(),'filter_order':$('#filter_order').val(),'style_id':$('#style_id').val(),'variant_type':favorite.join(",")}
  applyFilter(data);

})
$(document).on('change mousemove', '.height-range', function(){
  $(this).parents('.unit_filter').find('.selected_unit').html(' ('+$(this).val()+' cm)')
  var height_range = $(this).val();
  var height_range_val = height_range.split(',');
  // console.log('split val 0 '+height_range_val[0]);
  // console.log('split val 1 '+height_range_val[1]);
  $('#height_start_range').val(height_range_val[0]);
  $('#height_end_range').val(height_range_val[1]);

  var favorite = [];
    $.each($("input[name='variant_type']:checked"), function(){
      favorite.push($(this).val());
    });
    console.log($('#price_end_range').val());
    data = {'id':category_id,'sub_category_id':sub_category_id,'price_start_range': $('#price_start_range').val(), 'price_end_range': $('#price_end_range').val(),'height_start_range': $('#height_start_range').val(), 'height_end_range': $('#height_end_range').val(),'width_start_range': $('#width_start_range').val(), 'width_end_range': $('#width_end_range').val(),'subject_id':$('#subject_id').val(),'filter_order':$('#filter_order').val(),'style_id':$('#style_id').val(),'variant_type':favorite.join(",")}
  applyFilter(data);

})
$(document).on('change mousemove', '.price-range', function(){
  $(this).parents('.filterBlock').find('.price_selected').html('Price (£'+$(this).val()+')')
  var price_range = $(this).val();
  var price_range_val = price_range.split(',');
  $('#price_start_range').val(price_range_val[0]);
  $('#price_end_range').val(price_range_val[1]);


  var favorite = [];
    $.each($("input[name='variant_type']:checked"), function(){
      favorite.push($(this).val());
    });
    console.log($('#price_end_range').val());
    data = {'id':category_id,'sub_category_id':sub_category_id,'price_start_range': $('#price_start_range').val(), 'price_end_range': $('#price_end_range').val(),'height_start_range': $('#height_start_range').val(), 'height_end_range': $('#height_end_range').val(),'width_start_range': $('#width_start_range').val(), 'width_end_range': $('#width_end_range').val(),'subject_id':$('#subject_id').val(),'filter_order':$('#filter_order').val(),'style_id':$('#style_id').val(),'variant_type':favorite.join(",")}
  applyFilter(data);
})

$("#site_filter, .filter_result").focus(function() {
  $(document).on('keyup', '#site_filter', function(){
    var this_filter = $(this);
    var site_filter = $('#site_filter').val();
    var data_from = "ajax";
    if(site_filter == ""){
      $(this_filter).parents('.searchbar').find('.filter_result').html('');
    }else{
      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{url('filter_search')}}?data_from="+data_from+'&filter_key='+site_filter,
        type: 'get',
        success: function(res){
            if(res.status=="200"){
                $(this_filter).parents('.searchbar').find('.filter_result').html(res.result);
            }else{
                
            }
        },
        error: function (errormessage) {
            console.log(errormessage);
        }
      });
    }

  })
}).blur(function() {
  setTimeout(clear_filter, 200);
});

function clear_filter(){
  $('#site_filter').val('');
  $(document).find('.filter_result').html('');;
}
$(document).ready(function(){
  $('#site_filter').typeahead({
    ajax: {
        url: '/cities/list',
        method: 'post',
        triggerLength: 1
    },
    onSelect: displayResult
  });  
  $('#site_filter').typeahead({
    ajax:'AJAX URL'
  // source: [
  //   { id: 1, name:'Value 1' },
  //   { id: 2, name:'Value 2' },
  //   { id: 3, name:'Value 3' },
  // ]
});

function displayResult(item) {
  $('.alert').show().html('You selected <strong>' + item.value + '</strong>: <strong>' + item.text + '</strong>');
}

})
$(document).ready(function() {
$('#registerForm').submit(function(e) {
e.preventDefault();
var user_role = $('#user_role').val();
if($.trim(user_role) == ''){
// toastr.options.timeOut = 2000; // 2s
// toastr.error('Please Select Account Type!');
$('.registerFormerror').text('Please Select Account Type!')
return false;
}else{
// toastr.options.timeOut = 1000; // 42s
// toastr.success(' Verification Mail has been sent to your Email Id ');
$('.signupForm').text('Registration was successful!')
document.getElementById("registerForm").submit();
}
});
});
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#user_name').val('');
    $('#registration-form').click(function(e) {
      e.preventDefault();
      var first_name = $('#first_name').val();
      var last_name = $('#last_name').val();
      var email = $('#email-address').val();
      var password = $('#register-password').val();
      var username=$('#user_name').val();
      var email_filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      if($.trim(first_name) == ''){
        // toastr.options.timeOut = 1500; // 2s
        // toastr.error('Please Enter First Name');
        $('.signuperror').text("Please Enter First Name");
        return false;
      }else if($.trim(last_name)==''){
              // toastr.options.timeOut = 1500; // 2s
              // toastr.error('Please Enter Last Name');
              $('.signuperror').text("Please Enter Last Name");
              return false;
      }else if ($.trim(email)==''){
              // toastr.options.timeOut = 1500; // 2s
              // toastr.error('Please Enter Email');
              $('.signuperror').text("Please Enter Email");
              return false;
      }else if(!email_filter.test(email)){
              // toastr.options.timeOut = 1500; // 1.5s
              // toastr.error('Please Enter Valid Email.');
              $('.signuperror').text("Please Enter Valid Email.");
              return false;
      }else if($.trim(password)==''){
              // toastr.options.timeOut = 1500; // 2s
              // toastr.error('Please Enter Password');
              $('.signuperror').text("Please Enter Password");
              return false;
      }else if($.trim(password).length<8){
              // toastr.options.timeOut = 1500; // 1.5s
              // toastr.error('Please enter Password more than 6 characters.');
               $('.signuperror').text("Please enter Password more than 8 characters.");
              return false;
      }else if($.trim(username)==''){
              // toastr.options.timeOut = 1500; // 2s
              // toastr.error('Please Enter UserName');
                $('.signuperror').text("Please Enter UserName");
              return false;
      }else if($.trim(email)){
        $.ajax({
        url: "{{url('check_email')}}",
        type: 'POST',
        data:{'email':email},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        
        success: function(res){
          if(res.status=="200"){
            console.log('test');
            toastr.options.timeOut = 1500; // 2s
            toastr.error(res.message);
            e.preventDefault();
            return false;
          }
          else{
            console.log('ajax else email');
            if($.trim(username)){
              $.ajax({
              url: "{{url('check_username')}}",
              type: 'POST',
              data:{'user_name':username},
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              
              success: function(res){
                if(res.status=="200"){
                  // toastr.options.timeOut = 1500; // 2s
                  // toastr.error(res.message);
                  $('.signuperror').text(res.message);
                  e.preventDefault();
                  return false;
                }
                else{
                  console.log('ajax else username');
                  //$("#SignUpModal3").show();
                  $('#SignUpModal2').modal('hide');
                  $('#SignUpModal3').modal('show');
                }
              },
              error: function (errormessage) {
                // toastr.options.timeOut = 1500; // 1.5s
                // toastr.error('You are Not Authorised Person.');
                 $('.signuperror').text('Incorrect email/password.');
                return false;
              }
              });
            }
            
          }
        },
        error: function (errormessage) {
          // toastr.options.timeOut = 1500; // 1.5s
          // toastr.error('You are Not Authorised Person.');
          $('.signuperror').text('Incorrect email/password.');
          return false;
        }
        });
      }else{
              console.log('else----condition');
              //$("#SignUpModal3").show();
              $('#SignUpModal2').modal('hide');
              $('#SignUpModal3').modal('show');
      }
    });
  });
</script>
<script type="text/javascript">
  $(document).ready(function() {
  $('#submit-form').click(function(e) {
  $('.errormessage').css("display:none");
  e.preventDefault();
  var email = $('#email').val();
  var password = $('#password').val();
  var email_filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if($.trim(email) == '')
    {
      // toastr.options.timeOut = 1500; 
      // toastr.error('Please Enter Email');
      $('.loginerror').text("Please Enter Email");
      
      return false;
    }
    else if(!email_filter.test(email))
    {
      // toastr.options.timeOut = 1500; // 1.5s
      // toastr.error('Please Enter Valid Email.');
      $('.loginerror').text("Please Enter Valid Email.");
      return false;
    }
      else if($.trim(password)==''){
      // toastr.options.timeOut = 1500; // 1.5s
      // toastr.error('Please Enter Password.');
      $('.loginerror').text("Please Enter Password.");
      return false;
    }
      else if($.trim(password).length<6){
      // toastr.options.timeOut = 1500; // 1.5s
      // toastr.error('Please enter Password more than 8 characters.');
       $('.loginerror').text("Please enter Password more than 6 characters.");
      return false;
    }else{
      makeUserLogin();
      // document.getElementById("login_form").submit();
  }
});
});

function makeUserLogin(){
    var url = "{{url('submit_login')}}";
    var loginDetails = $('#login_form').serialize();
    console.log(loginDetails);
    $.ajax({
        url: url,
        type: 'POST',
        data:loginDetails,
        
  success: function(res){
    if(res.status=="200"){
      window.location.href = res.redirect_url;
    }else{
      $('.loginerror').text(res.message);
      // toastr.options.timeOut = 1500; // 1.5s
      // toastr.error(res.message);
      return false;
    }
  },
  error: function (errormessage) {
    // toastr.options.timeOut = 1500; // 1.5s
    // toastr.error('You are Not Authorised Person.');
     $('.loginerror').text('Incorrect email/password.');
    return false;
  }
});
}  
</script>

<script type="text/javascript">
  $(document).ready(function() {
  $('#submit-password').click(function(e) {
  e.preventDefault();
  var email = $('#forgot-email').val();
  var email_filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if($.trim(email) == '')
    {
      // toastr.options.timeOut = 1500; // 1.5s
      // toastr.error('Please Enter Email.');
      $('.resetpasswordlink').text('Please Enter Email.');
      return false;
    }
    else if(!email_filter.test(email))
    {
      // toastr.options.timeOut = 1500; // 1.5s
      // toastr.error('Please Enter Valid Email.');
      $('.resetpasswordlink').text('Please Enter Valid Email.');
      return false;
    }else{
      // toastr.options.timeOut = 1500; // 1.5s
      // toastr.error('Email has been sent to your verify email Id');
      $('.resetpasswordsuccess').text('Email has been sent to your verify email Id');
      document.getElementById("forgot-password").submit();
      return false;
  }
});
});
</script>



<script type="text/javascript">
$(document).on('click', '.like_artist', function(){
    var artist_id = $(this).attr('data-artist-id');
    var this_like = $(this);
    $.ajax({
        url: "{{url('like_artist')}}",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {artist_id:artist_id},

        success: function(res){
            if(res.status=="200"){
                $(this_like).parents('.artistHeaderLeft').find('.followersNum').html(res.all_count);
                $(this_like).parents('.stats').find('.all_follower span').html(res.all_count);
                $(this_like).html(res.like_count);
            }else{
                
            }
        },
        error: function (errormessage) {
            console.log(errormessage);
        }
    });
})

$(document).on('click', '.like_users', function(){
    var user_id = $(this).attr('data-user-id');
    var btn_type = $(this).attr('data-btn-type');
    //var this_like = $(this);
    $.ajax({
        url: "{{url('like_users')}}",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {user_id:user_id, btn_type:btn_type},

        success: function(res){
            if(res.status=="200"){
              if(btn_type == "like"){
                console.log(res.html);
                $('#users_like_list').html(res.html);
              }
              if(btn_type == "followers"){
                console.log(res.html);
                $('#FollowersModelBody').html(res.html);
              }
              if(btn_type == "follow"){
                console.log(res.html);
                $('#FollowModelBody').html(res.html);
              }
            }else{
                
            }
        },
        error: function (errormessage) {
            console.log(errormessage);
        }
    });
})
$(document).on('click', '.like_artwork', function(){
    var artwork_id = $(this).attr('data-artwork-id');
    var this_like = $(this);
    $.ajax({
        url: "{{url('like_artwork')}}",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {artwork_id:artwork_id},

        success: function(res){
            if(res.status=="200"){
                $(this_like).find('.like_image').attr('src', res.img_source);
                $(this_like).parents('.rightBlock').find('.likes').html(res.like_count);
                $(this_like).parents('.actionBlock').find('.likes').html(res.like_count);
                $(this_like).parents('.profilePage').find('.like_stats span').html(res.all_likes);
            }else{
                
            }
        },
        error: function (errormessage) {
            console.log(errormessage);
        }
    });
});
$(document).on('click', '.save_artwork', function(){
    var artwork_id = $(this).attr('data-artwork-id');
    var this_like = $(this);

    var PATH = $(location).attr('pathname');
    var arr = PATH.split('/');
    if(arr[1] == "saved_artwork"){
        $(this).parents('.col-lg-4').remove();
    }
    $.ajax({
        url: "{{url('save_artwork')}}",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {artwork_id:artwork_id},

        success: function(res){
            if(res.status=="200"){
                // toastr.options.timeOut = 2000;
                // toastr.success(res.msg);
                $(this_like).find('.save_image').attr('src', res.img_source);
                $(document).find('.saved_count').html(res.saved_count);
            }else{
                
            }
        },
        error: function (errormessage) {
            console.log(errormessage);
        }
    });
})
$(document).on('click', '.add_to_cart', function(){
    var artwork_id = $(this).attr('data-artwork-id');
    var this_like = $(this);
    $.ajax({
        url: "{{url('add_to_cart')}}",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {artwork_id:artwork_id},

        success: function(res){
            if(res.status=="200"){
                this_like.html(res.btn_text)
                toastr.options.timeOut = 2000; // 2s
                toastr.success(res.msg);
                $(document).find('.cart_count').html(res.saved_count);
            }else{
                
            }
        },
        error: function (errormessage) {
            console.log(errormessage);
        }
    });
})
</script>
<script>
  $(function(){
    setTimeout(function() {
      $("#loader_gif").hide();
    }, 600); 
   
  });
</script>
<script type="text/javascript">
  $('.markRead').click(function(){
      $('#loader_gif').show();
      $.ajax({
        url: "{{ url('/mark_all_as_read') }}",
        type: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res){
            if(res.status=="200"){
                window.location.reload();
            }else{
                
            }
        },
        error: function (errormessage) {
            console.log(errormessage);
        }
      });
    });
  $('document').ready(function() {
    

    $('.chatId').click(function(){
      var user_type= $(this).attr('data-user-type');
      var user_id= $(this).attr('data-user-id');
      if(user_id){

      }else{
        $('.navbar-toggler').click();  
      }
      
      var url = '/'+user_type+'/chat';
      // alert(url);
      $('#loader_gif').show();
      $.ajax({
        url: url,
        type: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res){
            if(res.status=="200"){
                $("#chatModal").html(res.result);
                // $('.navbar-toggler').click();
                // if( user_id ) {
                //   console.log(user_id);
                //   setTimeout(function () {
                //     $('.list-group-item[data-user-id="'+ user_id +'"]').get(0).click();
                //     $('#loader_gif').hide();
                //   }, 2500);
                // }else{
                //   $('#loader_gif').hide();
                // }
                $('#loader_gif').hide();

                
            }else{
                
            }
        },
        error: function (errormessage) {
            console.log(errormessage);
        }
    });
    });
      var PATH = $(location).attr('pathname');
      var arr = PATH.split('/');
     
      if(arr[2] == "add_blog"){
        var ckview = document.getElementById("des_first");
          CKEDITOR.replace(des_first,{
              language:'en-gb'
          });
       
      }
      if(arr[2] == "edit_blog"){
        var ckview = document.getElementById("des_first");
          CKEDITOR.replace(des_first,{
              language:'en-gb'
          });
       
      }

      $('.delete_blog').click(function(event) {
          event.preventDefault();
          var link = $(this).attr('href');
          swal({
              title: "Please confirm this action",
              text: "By this action you are confirming that the selected Blog will be deleted permanently.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: '#DD6B55',
              confirmButtonText: 'Yes, I am sure!',
              cancelButtonText: "No, cancel it!",
              closeOnConfirm: false,
              closeOnCancel: false
          },
          function(isConfirm) {
              if (isConfirm) {
                  window.location = link;
              } else {
                 swal("Cancelled", "You cancelled this action", "error");
              }
          });
      });
      $('.change_blog_status').click(function(event) {
          event.preventDefault();
          var link = $(this).attr('href');
          swal({
              title: "Please confirm this action",
              text: "By this action you are confirming that the selected Blog's status will be changed.",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: '#DD6B55',
              confirmButtonText: 'Yes, I am sure!',
              cancelButtonText: "No, cancel it!",
              closeOnConfirm: false,
              closeOnCancel: false
          },
          function(isConfirm) {
              if (isConfirm) {
                  window.location = link;
              } else {
                 swal("Cancelled", "You cancelled this action", "error");
              }
          });
      }); 
      
  });

  $('#update-blog').on('click', function(e) {
        e.preventDefault();
        var title = $("input[name=title]").val();
        //var description = $('textarea[name=description]').val();
        if ($.trim(title) == '') {
            toastr.options.timeOut = 2500; // 2s
            toastr.error('Title is Required');
            return false;
        }
      // else if ($.trim(description) == '') {
      //       toastr.options.timeOut = 2500; // 2s
      //       toastr.error('Description is Required');
      //       return false;
      //   }

        else {
            document.getElementById("add_blog").submit();
        }
    });

  
        
</script>
<script type="text/javascript">
$(document).on('click', '.category_li', function(){
  $(this).parents('ul').find('.category_li').removeClass('active');
  $(this).addClass('active');
})
</script>
<script type="text/javascript">
// $(document).on('click', '.checkout_btn', function(){
//   $("#checkout_form").submit();
// })

$(document).on('click', '.checkout_btn', function(){

  var firstName = $('#firstName').val();
  var lastName = $('#lastName').val();
  var address = $('#address').val();
  var country = $('#country').val();
  var state = $('#state').val();
  var postal_code = $('#postal_code').val();

  if($.trim(firstName) == ''){
    toastr.options.timeOut = 1500; // 2s
    toastr.error('Please Enter First Name');
    return false;
  }else if($.trim(lastName)==''){
    toastr.options.timeOut = 1500; // 2s
    toastr.error('Please Enter Last Name');
    return false;
  }else if ($.trim(address)==''){
    toastr.options.timeOut = 1500; // 2s
    toastr.error('Please Enter Address');
    return false;
  }else if($.trim(country)==''){
    toastr.options.timeOut = 1500; // 1.5s
    toastr.error('Please Enter Country.');
    return false;
  }else if($.trim(state)==''){
    toastr.options.timeOut = 1500; // 2s
    toastr.error('Please Enter State');
    return false;
  }else if($.trim(postal_code)==''){
    toastr.options.timeOut = 1500; // 1.5s
    toastr.error('Please Enter Postal Code.');
    return false;
  }else{
    $('.checkout_btn').removeClass('checkout_btn');
    $("#checkout_form").submit();
  }
})

</script>
<script type="text/javascript">
$(document).on('click', '.shipping_status', function(){
  var order_id = $(this).attr('data-order-id');
  $.ajax({
      url: "{{ url('/get_shipping_status') }}",
      type: "post",
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {order_id:order_id},
      success: function(res){
          if(res.status=="200"){
              $("#changeShippingStatus").html(res.data);
          }else{
              
          }
      },
      error: function (errormessage) {
          console.log(errormessage);
      }
  });

})
</script>

<script type="text/javascript">
$(document).on('click', '#change_shipping_status', function(){
  $('#summary_info').hide();
  $('#shipping_status').show();
});

$(document).on('click', '.close_modal, .reset_filter', function(){
  // $("#changeShippingStatus").removeClass("show"); 
  // $("#changeShippingStatus").removeAttr("style"); 
  // $("#changeShippingStatus").html(""); 
  // $(".modal-backdrop").remove(); 
  // $('body').removeClass("modal-open"); 
  window.location.reload();
});

$(document).on('click', '#closeChatList', function(){
  $('#chatModal').html('');
})

$(document).on('click', '.chat_with_user', function(){
  document.getElementById("chatId").click();
  var username = $(this).attr('data-user-id');
  setTimeout(function () {
    $('li.list-group-item[data-user-id = '+username+']').trigger('click');
   }, 1000);
});

$(document).on('click', '.save_artist', function(){
    var artist_id = $(this).attr('data-artist-id');
    var this_like = $(this);
    $.ajax({
        url: "{{url('save_artist')}}",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {artist_id:artist_id},

        success: function(res){
            if(res.status=="200"){
                // $(document).find('.saved_count').html(res.saved_count);
            }else{
                
            }
        },
        error: function (errormessage) {
            console.log(errormessage);
        }
    });
}); 



$(document).on('click', '.setUserRole', function(){
    var artist_role = $(this).attr('data-btn-val');
    console.log(artist_role);
    $('#user_role').val(artist_role);
    $.ajax({
        url: "{{url('set_userrole')}}",
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {role:artist_role},

        success: function(res){
            if(res.status=="200"){
              // alert(res.result);
                // $(document).find('.saved_count').html(res.saved_count);
            }else{
                
            }
        },
        error: function (errormessage) {
            console.log(errormessage);
        }
    });
}); 





</script>
<script type="text/javascript">
  $(document).ready(function() {
    // alert('ok');
  $(".clickcheckbox").click(function(event) {
    if ($(this).is(":checked"))
      $(".showSignup").show();
    else
      $(".showSignup").hide();
  });
}); 
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('.blah').attr('src', e.target.result);
    }
    
    reader.readAsDataURL(input.files[0]);
  }
}

$(".imgInp").change(function() {
  readURL(this);
});

// $(document).on('click', '.req_comm', function(){
//     var user_id = $(this).attr('user-id');
//     var artist_id = $(this).attr('artist-id');
//     $.ajax({
//         url: "{{url('req_comm')}}",
//         type: 'POST',
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         data: {user_id:user_id, artist_id:artist_id},

//         success: function(res){
            
//         },
//         error: function (errormessage) {
//             console.log(errormessage);
//         }
//     });
// })

$(document).on('click', '.req_comm', function(){
    event.preventDefault();
    var link = $(this).attr('href');
    swal({
        title: "Please confirm this action",
        text: "By this action you are confirming that You are requesting commission.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, I am sure!',
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function(isConfirm) {
        if (isConfirm) {
            window.location = link;
        } else {
           swal("Cancelled", "You cancelled this action", "error");
        }
    });
});

</script>
<script src="//code.tidio.co/qq8ktjrfkomjp9wjbaxfmpvwy1jay6a8.js" async></script>
</body>
</html>