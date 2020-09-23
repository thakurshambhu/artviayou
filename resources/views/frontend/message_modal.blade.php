<ul>
    @if(count($result) > 0)
        @foreach($result as $key => $value)
            @foreach($value->artwork_like as $keyz => $user)
                @if(!empty($user->users))
                <li><a href="{{url('profile_details')}}/{{$user->users->id}}"><span class="image"><img src="{{ $user->users->media_url ? $user->users->media_url : url('/assets/images/default.png') }} " alt=""></span><span>{{$user->users->first_name}} {{$user->users->last_name}} </span></a> <span class="liked">Liked</span>  <a href="{{url('artwork_details')}}/{{$value->id}}"><span>{{$value->title}}.</span></a></li>
                @else
                <li>Guest User</li>
                @endif
            @endforeach
        @endforeach
    @else
    <li>No Likes Found</li>
    @endif
</ul>
