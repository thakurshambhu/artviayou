 @include('layouts.frontend.header')
 <!-- End Header Navigation -->
         <!-- Page Header Title -->
         <div class="page-title">
            <h1 class="page-title-inner">
               <span class="pagetitleText">Exhibitions</span> 
             <img src="{{asset('assets/images/contact-graphic.svg')}}" class="title-img" alt="">
            </h1>
         </div>
         <!--End Page Header Title -->
         <!-- About text 1 -->
         <!-- Contact Page -->

         <section class="postPage py-5" >

            <div class="container">
               <div class="row">
                  <div class="col-md-8 offset-md-2">
                     @if(!empty($blogs) > 0)
                     @foreach($blogs as $key => $blog)
                     <div class="@if($key % 2 == 1) orderChange @endif postBlock d-flex align-items-center">
                        <div class="image"><img src="{{$blog->media_url}}" alt=""></div>
                        <div class="postText text-center">
                          <!--  <span class="heading">uncategorised</span> -->
                           <span class="title">{{$blog->title}}</span>
                           <span class="date">{{date('M d, Y', strtotime($blog->created_at))}}</span>
                           <div>
  <?php echo substr(htmlspecialchars_decode($blog->des_first), 0, 250) . '...' ?>
                           </div>
                         
                           <a href="{{url('exhibition_details')}}/{{$blog->id}}" class="btn btn-default btn-sm">Read More</a>
                        </div>
                     </div>
                     @endforeach
                     @endif
                  </div>
               </div>
            </div>
            <div class="container">
  
             <div class="col-lg-12  py-4 border d-flex paginationContainer">
                 <ul class="pagination mx-auto">
                  {{ $blogs->links() }}
                   
                 </ul>
             </div>
              
           </div>
        
         </section>
         <!-- End contact page -->
@include('layouts.frontend.comman_footer')