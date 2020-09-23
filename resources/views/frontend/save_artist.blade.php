    @include('layouts.frontend.header')
     <!-- Page Header Title -->
     <div class="page-title">
          <div class="page-title-inner">
             <span class="pagetitleText">saved</span> 
             <img src="{{asset('assets/images/saved-graphic.svg')}}" class="title-img" alt="">
          </div>
       </div>
       <!--End Page Header Title -->
<!-- Top Artworks Section -->
<section class="savedArtworks">
  <div class="container">
     <div class="sectionHeading">
        <h2 >Saved Artworks</h2>
     </div>
  </div>
  <div class="container">
     <div class="row">
        <div class="col-lg-4 col-md-6">
              <div class="artPost">
                 <div class="postHeader">
                    <div class="username">
                       <div class="image"><img src="{{asset('assets/images/profile-sm.jpg')}}" alt=""></div>
                       <span class="name">Amenda Berry</span>
                    </div>
                    <span class="Posted">2 hours ago</span>
                 </div>
                 <div class="postImage">
                   <a href="#"><img src="{{asset('assets/images/post.jpg')}}" alt=""></a> 
                 </div>
                 <div class="postFooter">
                    <div class="leftBlock">
                       <h5>The Wave</h5>
                       <h6>$2076</h6>
                    </div>
                    <div class="rightBlock">
                       <span class="likes">456 Likes</span> 
                       <div class="actionIcons">
           <a href="#"><img src="{{asset('assets/images/like.png')}}" alt=""></a>
           <a href="#"><img src="{{asset('assets/images/dislike.png')}}" alt=""></a>
           <a href="#"><img src="{{asset('assets/images/saved.png')}}" alt=""></a>
           </div></div>
           </div>
           </div>
        
        </div>
        <div class="col-lg-4 col-md-6">
    
              <div class="artPost">
                 <div class="postHeader">
                    <div class="username">
                       <div class="image"><img src="{{asset('assets/images/profile-sm.jpg')}}" alt=""></div>
                       <span class="name">Amenda Berry</span>
                    </div>
                    <span class="Posted">2 hours ago</span>
                 </div>
                 <div class="postImage">
                      <a href="#"><img src="{{asset('assets/images/post.jpg')}}" alt=""></a>
                 </div>
                 <div class="postFooter">
                    <div class="leftBlock">
                       <h5>The Wave</h5>
                       <h6>$2076</h6>
                    </div>
                    <div class="rightBlock">
                       <span class="likes">456 Likes</span> 
                       <div class="actionIcons">
           <a href="#"><img src="{{asset('assets/images/like.png')}}" alt=""></a>
           <a href="#"><img src="{{asset('assets/images/dislike.png')}}" alt=""></a>
           <a href="#"><img src="{{asset('assets/images/saved.png')}}" alt=""></a>
           </div></div>
           </div>
           </div>
     
        </div>
        <div class="col-lg-4 col-md-6">
      
              <div class="artPost">
                 <div class="postHeader">
                    <div class="username">
                       <div class="image"><img src="{{asset('assets/images/profile-sm.jpg')}}" alt=""></div>
                       <span class="name">Amenda Berry</span>
                    </div>
                    <span class="Posted">2 hours ago</span>
                 </div>
                 <div class="postImage">
                      <a href="#"> <img src="{{asset('assets/images/post.jpg')}}" alt=""></a>
                 </div>
                 <div class="postFooter">
                    <div class="leftBlock">
                       <h5>The Wave</h5>
                       <h6>$2076</h6>
                    </div>
                    <div class="rightBlock">
                       <span class="likes">456 Likes</span> 
                       <div class="actionIcons">
           <a href="#"><img src="{{asset('assets/images/like.png')}}" alt=""></a>
           <a href="#"><img src="{{asset('assets/images/dislike.png')}}" alt=""></a>
           <a href="#"><img src="{{asset('assets/images/saved.png')}}" alt=""></a>
           </div></div>
           </div>
           </div>
          
        </div>
     </div>
  </div>

  
  <div class="container">
    
          <div class="col-lg-12  py-4 border d-flex paginationContainer">
              <ul class="pagination mx-auto">
                  <li class="page-item disabled">
                      <a class="page-link" href="#" aria-label="Previous">
                          <span aria-hidden="true"> <img src="{{asset('assets/images/left-arrow.svg')}}" alt=""> Previous</span>
                         
                      </a>
                  </li>
                  <li class="page-item active">
                      <a class="page-link" href="#">1</a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">4</a></li>
                  <li class="page-item"><a class="page-link" href="#">5</a></li>
                  <li class="page-item"><a class="page-link" href="#">6</a></li>
                  <li class="page-item"><a class="page-link" href="#">.....</a></li>
                  <li class="page-item"><a class="page-link" href="#">87</a></li>
                                          <li class="page-item">
                      <a class="page-link" href="#" aria-label="Next">
                          <span aria-hidden="true">Next <img src="{{asset('assets/images/right-arrow.svg')}}" alt=""></span>
                          
                      </a>
                  </li>
              </ul>
          </div>
     
  </div>
</section>
<!-- End Top Artworks Section -->

<!-- End Top Artists Section -->
@include('layouts.frontend.comman_footer')