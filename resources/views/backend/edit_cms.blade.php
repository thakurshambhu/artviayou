@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'manage_cms/'.$slug,
])

@section('content')
    <div class="content">
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-12 order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ $title }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="message-alert-top">
                            @if(Session::has('success_message'))
                            <div><div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('success_message') !!}</em></div></div>
                            @endif
                            @if(Session::has('error_message'))
                            <div><div class="alert alert-danger"><em> {!! session('error_message') !!}</em></div></div>
                            @endif
                        </div>
                        <div class="message-alert-top">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($slug == "about_us")
                            <form method="post" action="{{ url('/admin/update_aboutus') }}" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="pl-lg-4">
                                    <input type="hidden" name="slug" value="{{$slug}}">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Title') }}</label>
                                        <input type="text" name="title" id="input-name" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" value="@if(!empty($cms_info->title)){{$cms_info->title}} @else {{ old('title') }} @endif" required autofocus>

                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group{{ $errors->has('des_first') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Description') }}</label>
                                        <textarea name="des_first" id="des_first" cols="30" rows="10">@if(!empty($cms_info->des_first)){{$cms_info->des_first}}@else {{old('des_first')}}@endif</textarea>

                                        @if ($errors->has('des_first'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('des_first') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4 p-0">
                                        <div class="picture-container">
                                            <div class="picture">
                                                <img src="@if(!empty($cms_info->first_img_url)){{$cms_info->first_img_url}}@endif" class="picture-src" id="wizardPicturePreview" title="">
                                                <input class="form-control" type="file" id="wizard-picture" name="first_img_url">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group{{ $errors->has('second_img_url') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Image Upload') }}</label>
                                         <input type="file" name="first_img_url">

                                        @if ($errors->has('first_img_url'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('first_img_url') }}</strong>
                                            </span>
                                        @endif
                                    </div> -->
                                    <div class="form-group{{ $errors->has('des_second') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Description') }}</label>
                                        <textarea name="des_second" id="des_second" cols="30" rows="10">@if(!empty($cms_info->des_second)){{$cms_info->des_second}}@else {{old('des_second')}} @endif</textarea>

                                        @if ($errors->has('des_second'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('des_second') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4 p-0">
                                        <div class="picture-container">
                                            <div class="picture">
                                                <img src="@if(!empty($cms_info->second_img_url)){{$cms_info->second_img_url}}@endif" class="picture-src" id="wizardPicturePreview" title="">
                                                <input class="form-control" type="file" id="wizard-picture" name="second_img_url">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="form-group{{ $errors->has('second_img_url') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Image Upload') }}</label>
                                         <input class="form-control form-control-alternative" type="file" name="second_img_url"/>

                                        
                                    </div> -->
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>

                            @elseif($slug == "home_page")
                            <form method="post" action="{{ url('/admin/update_home') }}" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="pl-lg-4">
                                    <input type="hidden" name="slug" value="{{$slug}}">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Title') }}</label>
                                        <input type="text" name="title" id="input-name" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" value="@if(!empty($cms_info->title)){{$cms_info->title}} @else {{ old('title') }} @endif" autofocus>

                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group{{ $errors->has('des_first') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Description') }}</label>
                                        <textarea name="des_first" id="des_first" cols="30" rows="10">@if(!empty($cms_info->des_first)){{$cms_info->des_first}}@else {{old('des_first')}}@endif</textarea>

                                        @if ($errors->has('des_first'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('des_first') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4 p-0">
                                        <div class="picture-container">
                                            <div class="picture">
                                                <img src="@if(!empty($cms_info->first_img_url)){{$cms_info->first_img_url}}@endif" class="picture-src" id="wizardPicturePreview" title="">
                                                <input class="form-control" type="file" id="wizard-picture" name="first_img_url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                            @else
                            <form method="post" action="{{ url('/admin/update_cms') }}" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <input type="hidden" name="slug" value="{{$slug}}">
                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Title') }}</label>
                                        <input type="text" name="title" id="input-name" class="form-control form-control-alternative{{ $errors->has('title') ? ' is-invalid' : '' }}" placeholder="{{ __('Title') }}" value="@if(!empty($cms_info)){{$cms_info->title}} @else {{ old('title') }} @endif" required autofocus>

                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                   	</div>
                                   	
                                   	<div class="form-group{{ $errors->has('des_first') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Description') }}</label>
										<textarea name="des_first" id="des_first" cols="30" rows="10">@if(!empty($cms_info)){{$cms_info->des_first}}@endif</textarea>

                                        @if ($errors->has('des_first'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('des_first') }}</strong>
                                            </span>
                                        @endif
                                   	</div>
                                   
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection