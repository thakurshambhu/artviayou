@include('layouts.frontend.header')
<!-- Page Header Title -->
@if(!empty($policy)>0)
<div class="page-title">
<div class="page-title-inner">
   <span class="pagetitleText">{{$policy->title}}</span> 
   <img src="{{asset('assets/images/about-graphic.svg')}}" class="title-img" alt="">
</div>
</div>
<!--End Page Header Title -->
<!-- About text 1 -->
<section class="about aboutText-1">
<div class="container">
   <div class="row">
      <div class="col-md-12">
         <?=htmlspecialchars_decode($policy->des_first)?>
      </div>
   </div>
</div>
</section>
@endif
@include('layouts.frontend.comman_footer')