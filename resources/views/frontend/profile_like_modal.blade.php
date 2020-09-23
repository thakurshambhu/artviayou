@if($type == "like")
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
@endif

@if($type == "followers")
    @if(count($result) > 0)
        @foreach($result as $keyz => $user)
            @if(!empty($user->users))
            <li class="d-flex align-items-center"><a href="{{url('profile_details')}}/{{$user->users->id}}"><span class="image"><img src="{{ $user->users->media_url ? $user->users->media_url : url('/assets/images/default.png') }} " alt=""></span> <span>{{$user->users->first_name}} {{$user->users->last_name}}</span></a> <span class="ml-2">is following you.</span></li>
            @else
            <li>Guest User</li>
            @endif
        @endforeach
    @else
    <li>No Follower Found</li>
    @endif
@endif

@if($type == "follow")
    @if(count($result) > 0)
        @foreach($result as $keyz => $user)
            @if(!empty($user->users))
            <li><span class="heading">You are following</span> <a href="{{url('profile_details')}}/{{$user->artist->id}}"><span  class="image"><img src="{{ $user->users->media_url ? $user->users->media_url : url('/assets/images/default.png') }} " alt=""></span><span>{{$user->artist->first_name}} {{$user->artist->last_name}} .</span></a></li>
            @else
            <li>Guest User</li>
            @endif
        @endforeach
    @else
    <li>You are no Following anyone</li>
    @endif
@endif