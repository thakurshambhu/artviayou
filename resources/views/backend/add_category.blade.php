@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'subject',
])

@section('content')
    <div class="content">
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-12 order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center flex-wrap">
                                <div class="col-md-8">
                                    <h3 class="mb-0">{{ __('Add category') }}</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="{{ url('/admin/category') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                </div>
                            </div>
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
                            <form method="post" enctype="multipart/form-data" action="{{ url('/admin/update_category') }}" autocomplete="off">
                                @csrf
                                <input type="hidden" name="user_type" value="category">
                                <h6 class="heading-small text-muted mb-4">{{ __('Add Category') }}</h6>
                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-12 p-0">
                                        <div class="picture-container">
                                            <div class="picture">
                                                <input class="form-control" type="file" id="wizard-picture" name="media_url">
                                            </div>
                                        </div>
                                    </div>
                                    
                                   
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection