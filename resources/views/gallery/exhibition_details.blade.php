@include('layouts.frontend.header') 
 <section class="blogDetails">
    <div class="container">
        <div class="row">
       @if(!empty($blog_detail) > 0)
          <div class="col-md-8">
  
            <div class="card mb-4">
              <img class="card-img-top" src="{{$blog_detail->media_url}}" alt="">
              <div class="card-body">
                <h2 class="card-title">{{$blog_detail->title}}</h2>
                <p class="card-text"><?=htmlspecialchars_decode($blog_detail->des_first)?></p>
         
              </div>
              <div class="card-footer text-muted">
                Posted on {{date('M d, Y', strtotime($blog_detail->created_at))}} by&nbsp;
                <a href="{{url('profile_details')}}/{{$blog_detail->user->id}}">{{$blog_detail->user->first_name}}</a>
              </div>
            </div>
  
          </div>
          @endif
          <div class="col-md-4">
            <div class="card my-3">
              <h5 class="card-header">Leatest</h5>
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12">
                  @foreach($leatests as $key=>$leatest)
                  <a href="{{url('/exhibition_details')}}/{{$leatest->id}}">
                   <div class="blogSnippet">
                       <div class="image">
                       <img src="{{$leatest->media_url}}" alt="">
                       </div>

                       <div class="blogText">
                        <p><?php echo substr(htmlspecialchars_decode($leatest->des_first), 0, 50) . '...' ?></p>
                       </div>
                   </div>
                   </a>
                  @endforeach
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
 </section>
 @include('layouts.frontend.comman_footer')
        