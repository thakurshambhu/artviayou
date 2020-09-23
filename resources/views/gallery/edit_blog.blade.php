@include('layouts.frontend.header')
<!-- Artworks Section -->
<section class="artworksSection">
   <div class="container">
      <div class="row">
        <div class="col-12 col-md-8 col-lg-12">
            <form method="post" id="add_blog"  action="{{ url('/gallery/update_blog') }}" enctype="multipart/form-data" id="buyer-profile-form">
            @csrf
                <input type="hidden" name="id" value="{{$blog->id}}">
                 <div class="col-sm-12">
                    <div class="form-group">
                        <label for="first_name">Title</label>
                        <input type="text" class=" form-control"  placeholder="Enter titile" value="{{$blog->title}}" name="title" id="titile_id">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="last_name">Description</label>
                       <textarea name="des_first" id="des_first" cols="30" rows="10"><?=htmlspecialchars_decode($blog->des_first)?></textarea>
                    </div>
                </div>
                 <div class="col-sm-12">
                  <img src="@if(!empty($blog->media_url)){{$blog->media_url}}@endif" class="picture-src editblogImage" id="wizardPicturePreview" title="">
                    <div class="form-group blogImageAdd">
                      <label  for="blogImage"><i class="far fa-image"></i> Upload Image
                       <input type="file" id="blogImage" class=" form-control" value="" name="media_url">
                       </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center" >
                        <button type="submit" class="btn btn-default editblog" id="update-blog">Update</button>
                    </div>
                </div>
            </form>
         </div>

      </div>
   </div>
</section>

@include('layouts.frontend.comman_footer')
<script>
  $( window ).on( "load", function() {
    getSubCategory(1);
});
</script>

