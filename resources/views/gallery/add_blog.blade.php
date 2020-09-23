@include('layouts.frontend.header')
<!-- Artworks Section -->
<section class="artworksSection">
   <div class="container">
      <div class="row">

        <div class="col-12 col-md-8 col-lg-12">
            <form method="post" id="add_blog" action="{{ url('/gallery/update_blog') }}" enctype="multipart/form-data" id="buyer-profile-form">
            @csrf
                 <div class="col-sm-12">
                    <div class="form-group">
                        <label for="first_name">Title</label>
                        <input type="text" class=" form-control"  placeholder="Enter titile" value="" name="title" id="title_id">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="last_name">Description</label>
                       <textarea name="des_first" id="des_first" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group blogImageAdd">
                      <label  for="blogImage"><i class="far fa-image"></i> Upload Image
                       <input type="file" id="blogImage" class=" form-control" value="" name="media_url">
                       </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center" >
                        <button type="submit" class="btn btn-default addblog" id="update-blog">Submit</button>
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

