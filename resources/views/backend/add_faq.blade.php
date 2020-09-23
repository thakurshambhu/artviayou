@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'faq',
])

@section('content')
    <div class="content">
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-12 order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="mb-0">{{ __('Add Faq') }}</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="{{ url('/admin/faq') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ url('/admin/update_faq') }}" autocomplete="off">
                                @csrf
                                <h6 class="heading-small text-muted mb-4">{{ __('Add Faq') }}</h6>
                                <div class="pl-lg-4">
                                    <div class="form-group{{ $errors->has('qus') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Question') }}</label>
                                        <input type="text" name="qus" id="input-name" class="form-control form-control-alternative{{ $errors->has('qus') ? ' is-invalid' : '' }}" placeholder="{{ __('Question') }}" value="{{ old('qus') }}" required autofocus>

                                        @if ($errors->has('qus'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('qus') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group{{ $errors->has('ans') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Answer') }}</label>

                                        <textarea name="ans" id="ans" cols="30" rows="10">{{old('ans')}}</textarea>
                                        

                                        @if ($errors->has('ans'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('ans') }}</strong>
                                            </span>
                                        @endif
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