@if(count($artwork_images) > 0)
@foreach($artwork_images as $images)
<div class="addedImage" style="margin-left: 15px;">
 <div class="imageBox">
    <img src="{{$images->media_url}}" alt="">
  <button type="button" onClick="removeImage({{$images->id}},{{$images->artwork_id}})"><i class="fa fa-trash" aria-hidden="true"></i></button>
 </div>
</div>
@endforeach
<div class="addedImage" style="display: none;">
	<div class="imageBox">
		<img src="{{asset('assets/images/image_placeholder.jpg')}}" alt="">
		<button><i class="fa fa-trash" aria-hidden="true"></i></button>
	</div>
</div>
<button class="addImage">+<input type="file" multiple id="gallery-photo-add" name="upload_files[]"></button>
@else
<div class="addedImage" style="display: none;">
	<div class="imageBox">
		<img src="{{asset('assets/images/image_placeholder.jpg')}}" alt="">
		<button><i class="fa fa-trash" aria-hidden="true"></i></button>
	</div>
</div>
<button class="addImage">+<input type="file" multiple id="gallery-photo-add" name="upload_files[]"></button>
@endif


