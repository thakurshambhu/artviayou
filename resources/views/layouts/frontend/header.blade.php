<?php  
use \App\Http\Controllers\Frontend\HomeController;
HomeController::header_counter(); 

$meta_description = Session::get('meta_description');
$meta_title = Session::get('meta_title');
$meta_artist = Session::get('meta_artist');
$all_message_count = Session::get('message_count');
$message_count = 0;
$all_messages = Session::get('all_messages');
if(!empty($all_messages)){
  foreach($all_messages as $key => $msg){
    if(isset($msg->sender)){
      $message_count++;
    }
  }
}
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Buy Urban & Contemporary Art, from aspiring artists worldwide; welcoming you to the world where we adorn your artistic ideas with the cloak of reality while giving you a chance to make money with your passion for art">
    <meta name="author" content="Artviayou">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    

    <meta property="og:title" content="Artviayou" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://artviayou.com" />
    <meta property="og:image" content="{{asset('assets/images/logo.png')}}" />
    <meta property="og:description" content="Buy Urban & Contemporary Art, from aspiring artists worldwide; welcoming you to the world where we adorn your artistic ideas with the cloak of reality while giving you a chance to make money with your passion for art" />

    <link rel="canonical" href="{{url('/')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/images/default.png')}}">
    <title>Buy Urban & Contemporary Art | Artviayou</title>
    <!-- Bootstrap Core CSS -->
    <!-- <link rel="stylesheet" href="{{asset('assets/css/all.css')}}" > -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" >
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700&display=swap" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Theme CSS -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/animate.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/owl.carousel.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/owl.theme.min.css')}}">
    <link href="{{asset('assets/css/toastr.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap-slider.min.css')}}">
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1104844636528956');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1104844636528956&ev=PageView&noscript=1"
    /></noscript>

  </head>
  <body>
    <div id="loader_gif">
      <img src="{{asset('assets/images/loader.gif')}}">
    </div>
    <!-- Wrapper -->
    <div class="wrapper">
      <!-- Header Navigation -->
      <nav class="navbar navbar-expand-lg navbar-header flex-column">
        <!-- Top Bar -->
        <div class="topbar">
          <div class="container d-flex ">
            <!-- <ul class="navbar-nav mr-auto topBarOptions">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Country
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#">USA</a>
                  <a class="dropdown-item" href="#">UNITED KINGDOM</a>
                  
                  
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Sizes
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="#">CM</a>
                  <a class="dropdown-item" href="#">INCHES</a>
                  
                </div>
              </li>
            </ul> -->
            
            <div class="collapse navbar-collapse mainNavbar" id="navbarToggle">
              <ul class="navbar-nav nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('artworks')}}">Artwork</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('exhibitions')}}">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="{{url('about_us')}}">About</a></li>
                <li class="nav-item"><a href="{{url('contact_us')}}" class="nav-link">Contact</a></li>
                 @if (Auth::user())
                    <!-- <li class="nav-item chatId" data-user-type="{{Auth::user()->role}}"><a href="javascript:void(0);" class="nav-link" id="chatId"  ><i class="fas fa-comments"></i> Chat</a></li> -->
                 @endif
              </ul>
            </div>
          </div>
        </div>
        <!-- Top Bar -->
        <!-- Header -->
        <div class="header">
          <div class="container d-flex align-items-center flex-wrap">
            <a class="navbar-brand" href="/"><img src="{{asset('assets/images/logo.png')}}" alt="" class="img-fluid" /></a>
              <div class="searchbar">
                <form method="get" action="{{ url('/filter_search') }}" autocomplete="off">
                  <input type="hidden" name="data_from" value="form">
                  <input id="site_filter" type="text" class="form-control" name="filter_key" placeholder="Search for paintings, drawings">
                  <button class="btn-search" type="submit"><img src="{{asset('assets/images/search.svg')}}" alt="" /></button>
                  <div class="filter_result">
                    
                  </div>
                </form>
              </div>
            <div class="ml-auto d-flex align-items-center">
              <ul class="navbar-nav nav navbar-icon navbar-icons-only align-items-center">
                <li class="nav-item" ><a class="nav-link" href="{{url('cart')}}"><img src="{{asset('assets/images/shopping-cart.svg')}}" alt="" /><span class="count cart_count">{{session('cart_count')}}</span></a></li>
                
                <li class="nav-item"><a class="nav-link" href="{{url('saved_artwork')}}"><img src="{{asset('assets/images/saved.svg')}}" alt="" /><span class="count saved_count">{{session('saved_count')}}</span></a></li>

                @if (Auth::user())
                <!-- <li class="nav-item" >

                  <div class="dropdown headerMessages">
                   

                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);"><img src="{{asset('assets/images/chat.png')}}" alt="" /><span data-user-id="{{Auth::user()->id}}" class="count get_chat_message">{{$message_count}}</span></a>
                    <div class="dropdown-menu">
                      @if($message_count > 0)
                      <a href="javascript:void(0);" class="markRead">Mark all as read</a>
                      <ul class="list-group">
                        @foreach($all_messages as $key => $msg)
                          @if(isset($msg->sender))
                            <li class="list-group-item chatId" data-user-type="{{Auth::user()->role}}" data-user-id="{{$msg->sender->id}}"><span class="sender_name">{{$msg->sender->first_name}} {{$msg->sender->last_name}}</span>{{$msg->message}}</li>
                          @endif
                        @endforeach
                      </ul>
                      @else
                      <ul class="list-group">
                        <li class="list-group-item" style="text-align: center;">No New Message For you</li>
                      </ul>
                      @endif
                    </div>
                  </div>
                  
                </li> -->

          


                <li class="nav-item dropdown">
                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><img src="{{asset('assets/images/avatar.svg')}}" alt="" />
                    {{ Auth::user()->first_name }} <span class="caret"></span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="/{{Auth::user()->role}}/dashboard">Dashboard</a>
                  @if(Auth::user()->role == "gallery")
                  <a class="dropdown-item" href="{{url('gallery/blog')}}">Exhibition</a>
                  @endif
                  <a class="dropdown-item" href="{{url(Auth::user()->role)}}/profile/{{Auth::user()->id}}">My Profile</a>
                  <a class="dropdown-item" href="{{url(Auth::user()->role)}}/order_list">Orders</a>
                    <a class="dropdown-item" href="{{ url('logout') }}"> {{ __('Logout') }} </a>
                  </div>
                </li>
                @else
                <li class="nav-divider"></li>
                @endif

                <!-- <li class="nav-item"><a class="nav-link" href="javascript:void(0);"><img src="{{asset('assets/images/avatar.svg')}}" alt="" /></a></li> -->
              </ul>
              <ul class="navbar-nav nav navbar-icon  align-items-center">
                @if (Auth::user())
                
                @else
                <li class="nav-btn"><a href="#" class="btn btn-default" data-toggle="modal" data-target="#LoginModal" id="show-toaster">SIGN IN</a></li>
                @endif
                <li class="humburger-btn"><button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarToggle" aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
                  <span></span>
                  <span></span>
                  <span></span>
                  <span></span>
                </button></li>
              </ul>
              
            </div>
          </div>
        </div>
        <!-- //Header -->
      </nav>
      <!-- End Header Navigation -->