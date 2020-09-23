@include('layouts.frontend.header')
<!-- Page Header Title -->
<!-- End Header Navigation -->
<!-- Page Header Title -->
<div class="page-title">
<h1 class="page-title-inner">
   <span class="pagetitleText">contact</span> 
   <img src="{{asset('assets/images/contact-graphic.svg')}}" class="title-img" alt="">
</h1>
</div>
<!--End Page Header Title -->
<!-- About text 1 -->
<!-- Contact Page -->

<section class="contactPage" >
<div class="container contact">
   <div class="row">
      <div class="col-12">
         <div class="contact-frame">
            <div class="contact-text">
               <h3>Contact</h3>
               <h4>Have any <span>question</span> in mind?</h4>
               <p class="link"><a href="javascript:;">Let’s ask now <i class="fas fa-arrow-right"></i></a></p>

               <h5>Email</h5>
               <p><a href="mailto:contact@artviayou.com">contact@artviayou.com</a></p>

               <h5>Phone</h5>
               <p><a href="tel:02036421140">0203-642-1140</a></p>

               <h5>Address</h5>
               <p>20-22 Wenlock Road</p>
               
               <p>London N1 7GU</p>
            </div>
            <div class="contact-form">
               <h3>Fill the form</h3>
               <p>Please fill form below. We will respond to you in a timely manner.</p>

               <form class="row" method="POST" action="{{url('/save_contact_form')}}" id="contact-us-form">
                  @csrf
                  <div class="col-12 col-sm-6 form-group">
                     <input type="text" class="form-control" placeholder="Your Name" name="name" id="name">
                  </div>
                  <div class="col-12 col-sm-6 form-group">
                     <input type="tel" class="form-control" placeholder="Phone" name="mobile_number" id="mobile_number">
                  </div>
                  <div class="col-12 form-group">
                     <input type="email" class="form-control"  placeholder="Email Address" name="email" id="address">
                  </div>
                  <div class="col-12 form-group">
                     <textarea class="form-control" placeholder="Message" name="message"></textarea>
                  </div>
                  <div class="col-12">
                     <button type="submit" class="btn btn-default" id="contact-form">Submit</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="map">
   <!-- <img src="assets/images/map.jpg" alt="map" /> -->
  <iframe src="https://maps.google.com/maps?q=20-22%20Wenlock%20Rd%2C%20Hoxton%2C%20London%20N1%207GU%2C%20UK&t=&z=13&ie=UTF8&iwloc=&output=embed" width="800" height="800" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
</section>
<!-- End contact page -->
@include('layouts.frontend.comman_footer')

<script type="text/javascript">
  $(document).ready(function() {
    $('#contact-form').click(function(e) {
      e.preventDefault();
      var name = $('#name').val();
      var mobile_number = $('#mobile_number').val();
      var contact_email = $('#address').val();
      var email_filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      var mobile_filter = /^[0-9-+]+$/;
      console.log('email',contact_email);
      if($.trim(name) == ''){
        toastr.options.timeOut = 1500; // 2s
        toastr.error('Please Enter Name');
        return false;
      }else if($.trim(mobile_number)==''){
              toastr.options.timeOut = 1500; // 2s
              toastr.error('Please Enter Mobile Number');
              return false;
      }else if(!mobile_filter.test(mobile_number)){
              toastr.options.timeOut = 1500; // 2s
              toastr.error('Please Enter Valid Mobile Number');
              return false;
      }else if ($.trim(contact_email)==''){
              toastr.options.timeOut = 1500; // 2s
              toastr.error('Please Enter Email');
              return false;
      }else if(!email_filter.test(contact_email)){
              toastr.options.timeOut = 1500; // 1.5s
              toastr.error('Please Enter Valid Email.');
              return false;
      }else{
            toastr.options.timeOut = 3000; // 1.5s
            toastr.success('Form Submitted. We will Contact You Soon....!');
            setTimeout(function(){
               document.getElementById("contact-us-form").submit();
            }, 2000);
            
           
      }
    });
  });
</script>
