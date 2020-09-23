@include('layouts.frontend.header')
<!-- Page Header Title ---->

@if(!empty($about) > 0)
<div class="page-title">
<div class="page-title-inner">
   <span class="pagetitleText">{{$about->title}}</span> 
   <img src="{{asset('assets/images/about-graphic.svg')}}" class="title-img" alt="">
</div>
</div>
<!--End Page Header Title -->
<!-- About text 1 -->
<section class="about aboutText-1">
<div class="container">
   <div class="row">
      <div class="col-md-6">
        <?=htmlspecialchars_decode($about->des_first)?>
      </div>
      <div class="col-md-5 offset-md-1 text-center">
         <div class="aboutTextImage-1">
            <img src="{{$about->first_img_url}}"  class="img-fluid" alt="">
         </div>
      </div>
   </div>
</div>
</section>
<!-- End About text 1 -->
<!-- About text 2 -->
<section class="about aboutText-2">
<div class="container">
   <div class="row align-items-center">
      <div class="col-md-5  text-center">
         <div class="aboutTextImage-1">
            <img src="{{$about->second_img_url}}" class="img-fluid" alt="">
         </div>
      </div>
      <div class="col-md-7 pl-4 ">
        <?=htmlspecialchars_decode($about->des_second)?>
      </div>
   </div>
</div>
</section>
@endif
<!-- End About text 2 -->
@include('layouts.frontend.comman_footer')