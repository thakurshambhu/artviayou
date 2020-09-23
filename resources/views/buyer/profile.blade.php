@include('layouts.frontend.header')
<div class="page-title">
<div class="page-title-inner">
   <span class="pagetitleText">Profile Management</span> 
   <img src="{{asset('assets/images/about-graphic.svg')}}" class="title-img" alt="">
</div>
</div>
<section class="artworksSection">  
  
    <div class="container">
        
            <div class="message-alert-top">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                  {{ session('status') }}
                </div>
                @endif
                @if (session('password_status'))
                <div class="alert alert-success" role="alert">
                  {{ session('password_status') }}
                </div>
                @endif
                @if(Session::has('validation'))
                <div class="alert alert-danger">
                  <span class="glyphicon glyphicon-ok"></span>
                  <em> {!! session('success_message') !!}</em>
                </div>
                @endif

                @if(Session::has('success_message'))
                <div class="alert alert-success">
                <span class="glyphicon glyphicon-ok"></span>
                  <em> {!! session('success_message') !!}</em>
                </div>
                @endif


                @if ($errors->any())
                <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
                </ul>
                </div>
                @endif
              </div>
        <form method="post"  action="{{ url('/buyer/update_buyer') }}" enctype="multipart/form-data" id="buyer-profile-form">
            @csrf
            <div class="row">
                <div class="col-sm-4">
                    <div class="picture-container">
                        <div class="picture">
                            <img src="{{ $buyer->media_url ? $gallery->media_url : url('/assets/images/default.png') }}" class="picture-src blah" id="wizardPicturePreview" title="" height="100" width="100" >
                         
                        </div>
                        
                        <div class="pictureUploader">
                            <label for="wizard-picture">
                                Change Picture

                                 <input  type="file" id="wizard-picture" name="media_url" class="imgInp">
                            </label>
                            
                        </div>
                       
                    </div>

                    <a class="actionLink" data-toggle="modal" data-target="#ChangePassword"><i class="fas fa-key"></i> Change Password</a>
                </div>
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="hidden" name="id" value="{{$buyer->id}}">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class=" form-control"  placeholder="Enter First Name" value="{{$buyer->first_name}}" name="first_name" id="buyer-first_name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class=" form-control"  placeholder="Enter Last Name" value="{{$buyer->last_name}}" name="last_name" id="buyer-last_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class=" form-control"  placeholder="Enter Email" value="{{$buyer->email}}" name="email" id="buyer-email" id="buyer-first_name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class=" form-control"  placeholder="Enter Address" value="{{$buyer->address}}" name="address" id="buyer-address">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="postal_code">Postal Code</label>
                                <input type="text" class=" form-control"  placeholder="Enter Postal Code" value="{{$buyer->postal_code}}" name="postal_code" id="buyer-postal_code">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class=" form-control"  placeholder="Enter City" value="{{$buyer->city}}" name="city" id="buyer-city">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="user_name">User Name</label>
                                <input type="text" class=" form-control"  placeholder="Enter UserName" value="{{$buyer->user_name}}" name="user_name" id="buyer-user_name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="postal_code">Country</label>
                                <input type="text" class=" form-control"  placeholder="Enter Country" value="{{$buyer->country}}" name="country" id="buyer-country">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="postal_code">Biography</label>
                                <!-- <textarea type="text" class=" form-control"  placeholder="Enter Biography" value="{{$buyer->biography}}" name="biography" id="buyer-biography"></text-area> -->
                                <textarea class="form-control" rows="2"  value="{{$buyer->biography}}" name="biography" id="buyer-biography">{{$buyer->biography}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 text-center" >
                            <button type="submit" class="btn btn-default" id="update-profile">Update</button>
                        </div>
                    </div>
    </form>


    <div class="modal fade getStartedModals SignUpModal2" id="ChangePassword">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
         
          <div class="loginForm">
            <h3 class="text-center">Change Password</h3>
            <div class="col-md-8 offset-md-2">
           
           <div class="change-password">
                        <form class="col-md-12" action="{{ url('buyer/profile/password') }}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="card">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('password_status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('password_status') }}
                            </div>
                        @endif
                        <div class="card-header">
                            <h5 class="title">{{ __('Change Password') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-12 col-form-label">{{ __('Old Password') }}</label>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="password" name="old_password" class="form-control" placeholder="Old password" required>
                                    </div>
                                    <!-- @if ($errors->has('old_password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif -->
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-12 col-form-label">{{ __('New Password') }}</label>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>
                                    <!-- @if ($errors->has('password'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif -->
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-12 col-form-label">{{ __('Password Confirmation') }}</label>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirmation" required>
                                    </div>
                                    <!-- @if ($errors->has('password_confirmation'))
                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-default">{{ __('Save Changes') }}</button>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </form>
                    </div>
          
          
          
                         </div>
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
