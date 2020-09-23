<div id="myGallery" class="carousel slide" data-interval="false">
    <div class="carousel-inner">
        @if(count($gallery)>0)
        @foreach($gallery as $key => $image)
        <div class="item @if($key == 0) active @endif">
            <img src="{{$image->media_url}}" alt="item{{$key}}">
        </div>
        @endforeach
        @endif
        <!--end carousel-inner-->
    </div>
    <!--Begin Previous and Next buttons-->
    <a class="left carousel-control" href="#myGallery" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myGallery" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span></a>
    <!--end carousel-->
</div>