@include('layouts.frontend.header')
<!-- Artworks Section -->
<section class="artworksSection">
   <div class="container">

    <div class="row">
   <div class="col-md-12 d-flex justify-content-between align-items-center py-3">
                                    <h3 class="mb-0">{{ __('Blog') }}</h3>

                 <a href="{{ url('/gallery/add_blog') }}" class="btn btn-sm btn-default btn-sm ">{{ __('Add Blog') }}</a>
          </div>
    </div>
      <div class="row">
        <div class="col-12 col-md-8 col-lg-12">
       
         <table id="example" class="table table-striped table-bordered table-responsive-sm">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Creation Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
           @foreach($blogs as $blog)
              <tr>
                <td>{{$blog->title}}</td>
                <td><?php echo substr(htmlspecialchars_decode($blog->des_first), 0, 100) . '...' ?></td>
                <td>{{$blog->created_at->format('d/m/Y H:i')}}</td>
                <td class="text-right">
                  <div class="d-flex justify-content-between align-items-center tableIcons">
              <a href="{{url('/exhibition_details')}}/{{$blog->id}}" class="btn  btn-link btn-sm" title="View"><i class="fa fa-eye"></i></a>
                <a href="{{url('/gallery/edit_blog')}}/{{$blog->id}}" class="btn  btn-link btn-sm edit" title="Edit"><i class="fa fa-edit"></i></a>
                <a href="{{url('/gallery/delete_blog')}}/{{$blog->id}}" class="btn  btn-link btn-sm remove delete_blog" title="Delete"><i class="fa fa-times"></i></a>
                <a href="{{url('/gallery/change_blog_status')}}/{{$blog->id}}/{{$blog->is_active}}" class="btn  btn-link btn-sm change_blog_status" title="@if($blog->is_active == 'yes') Deactivate @else Activate @endif"><i class="fa fa-power-off"></i></a>

                  </div>
                           </td>
              </tr>
            @endforeach
           
           
        </tbody>
    </table>
           
        </div>

      </div>
   </div>
</section>

@include('layouts.frontend.comman_footer')
<script>
  $( window ).on( "load", function() {
    getSubCategory(1);
});
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>

