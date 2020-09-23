@extends('layouts.frontend.artist.app', [
    'class' => '',
    'elementActive' => 'profile',
])
@section('content')
<section class="form-box" >
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

    @if(Session::has('error_message'))
    <div class="alert alert-danger">
    <span class="glyphicon glyphicon-ok"></span>
      <em> {!! session('error_message') !!}</em>
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
            
    
            
      <!-- Form Wizard -->
      <form role="form" enctype="multipart/form-data" action="{{url('artist/update_artist')}}" autocomplete="off" method="post">
         @csrf
         <input type="hidden" name="user_type" value="artist">
         <input type="hidden" name="id" value="{{$artist->id}}">
         <div class="row noRowMargin">

            <div class="col-12 col-sm-6 col-md-4 profile-pic">
               <div class="frame"><img src="{{ $artist->media_url ? $artist->media_url : url('/assets/images/default.png') }}" alt="..." id="blah"></div>
               <button class="browse-btn">
                  <span>Change Picture</span>
                  <input class="image-label" name="media_url" type="file" accept="image/*" id="imgInp"> 

               </button>
               <a class="actionLink" data-toggle="modal" data-target="#ChangePassword"><i class="fas fa-key"></i> Change Password</a>
            </div>

            <div class="col-12 col-sm-6 col-md-8 form-wizard profile-setting">
               <h2 class="text-center">Profile Management</h2>
               @if(!empty($artist))
               <div class="row noRowMargin">
                  <div class="col-12 categorySection">
                     <div class="d-flex justify-content-between cat-sub">
                        <div class="form-group">
                           <label>First Name: <span>*</span></label>
                           <input type="text" name=" first_name" placeholder="First Name" class="form-control" value="{{$artist->first_name}}">
                       </div>
                        <div class="form-group">
                           <label>Last Name: <span>*</span></label>
                           <input  type="text" name="last_name" placeholder="Last Name" class="form-control" value="{{$artist->last_name}}">
                        </div>
                     </div>
                     <div class="form-group">
                           <label>Email: <span>*</span></label>
                           <input  type="email" name="email" placeholder="Email" class="form-control" value="{{$artist->email}}">
                     </div>
                     <div class="form-group">
                           <label>Paypal Email Address: <span>*</span></label>
                           <input  type="email" name="paypal_email" placeholder="Paypal Email Address" class="form-control" value="{{$artist->paypal_email}}">
                     </div>
                     <div class="form-group">
                           <label>Re-enter Paypal Email Address: <span>*</span></label>
                           <input  type="email" name="paypal_email_confirmation" placeholder="Paypal Email Address" class="form-control" value="{{$artist->paypal_email}}">
                     </div>
                     <div class="form-group">
                           <label>Alias: <span>*</span></label>
                           <input  type="text" name="user_name" placeholder="Gallery/artist name" class="form-control" value="{{$artist->user_name}}">
                     </div>
                     <div class="form-group">
                           <label>Biography: <span></span></label>
                           <textarea class="form-control textarea" name="biography" rows="9" cols="50" 
                           value="{{$artist->biography}}">{{$artist->biography}}</textarea>
                     </div>
                     <div class="d-flex justify-content-between cat-sub">
                        <div class="form-group">
                           <label>Address / Street name: <span>*</span></label>
                           <input type="text" name="address" placeholder="Address / Street name" class="form-control" value="{{$artist->address}}">
                        </div>
                        <div class="form-group">

                           <label>Postal code: <span>*</span></label>
                           <input  type="text" name=" postal_code" placeholder="Postal code" class="form-control" value="{{$artist->postal_code}}">

                        </div>
                     </div>
                      <div class="d-flex justify-content-between cat-sub">
                        <div class="form-group">
                           <label>City: <span>*</span></label>
                           <input type="text" name="state" placeholder="City" class="form-control" value="{{$artist->state}}">
                        </div>
                        <div class="form-group">
                           <label>Country: <span>*</span></label>
                           <input  type="text" name=" country" placeholder="Country" class="form-control" value="{{$artist->country}}">
                        </div>
                     </div>
                  </div>

               </div>
               @endif
               <div class="form-wizard-buttons text-center">
                  <button type="submit" class="btn btn-submit">Submit</button>
               </div>
            </div>
         </div>
      </form>
      <!-- Form Wizard -->
   </div>
</section>



 <div class="modal fade getStartedModals SignUpModal2" id="ChangePassword">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
         
          <div class="loginForm">
            <h3 class="text-center">Change Password</h3>
            <div class="col-md-8 offset-md-2">
           
           <div class="change-password">
                       <form  action="{{ url('artist/profile/password') }}" method="POST">
           @csrf
           @method('PUT')
           <div class="card">
          
           <div class="card-header">
                 <!-- <h5 class="title">{{ __('Change Password') }}</h5> -->
           </div>
            <div class="card-body">
                  <div class="row">
                     <label class="col-md-3 col-form-label">{{ __('Old Password') }}</label>
                     <div class="col-md-9">
                        <div class="form-group">
                              <input type="password" name="old_password" class="form-control" placeholder="Old password" required>
                        </div>
                        
                     </div>
                  </div>
                  <div class="row">
                     <label class="col-md-3 col-form-label">{{ __('New Password') }}</label>
                     <div class="col-md-9">
                        <div class="form-group">
                              <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                       
                     </div>
                  </div>
                  <div class="row">
                     <label class="col-md-3 col-form-label">{{ __('Password Confirmation') }}</label>
                     <div class="col-md-9">
                        <div class="form-group">
                              <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirmation" required>
                        </div>
                        
                     </div>
                  </div>
            </div>
            <div class="card-footer ">
                  <div class="row">
                     <div class="col-md-12 text-center form-wizard-buttons">
                        <button type="submit" class="btn btn-submit">{{ __('Save Changes') }}</button>
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
@endsection



