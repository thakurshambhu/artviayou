@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'manage_artworks',
])

@section('content')
    <div class="content">
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-12 order-xl-1">
                    <div class="card shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h3 class="mb-0">{{ __('Artwork Details') }}</h3>
                                </div>
                                <div class="col-md-3 text-right">
                                    <a href="{{url('admin/change_artwork_status')}}/{{$artworks->id}}/{{$artworks->is_publised}}/detail/0" class="btn btn-sm btn-primary change_artwork_status"> @if($artworks->is_publised == 'publish') {{ __('Un-Publish') }} @else {{ __('Publish')}} @endif</a>
                                </div>
                                <div class="col-md-3 text-right">
                                    <a href="{{ url('admin/artwork') }}/{{$artist_id}}" class="btn btn-sm btn-primary">{{ __('Back to Artwork') }}</a>
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
                        <div class="card-body">
                            <h6 class="heading-small text-muted mb-4">{{ __('Artwork information') }}</h6>
                            <?php //dd($artworks);?>
                            <div class="pl-lg-4">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-name">{{ __('Title :') }}</label>{{$artworks->title}}
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-email">{{ __('Description :') }}</label>{{$artworks->description}}
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password">{{ __('Category :') }}</label>{{$artworks->category_detail->name}}
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password">{{ __('Sub Category :') }}</label>@if(!empty($artworks->sub_category_detail)){{$artworks->sub_category_detail->name}}@endif
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password">{{ __('Subject :') }}</label>@if(!empty($artworks->subject_detail)){{$artworks->subject_detail->name}}@endif
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="input-password">{{ __('Style :') }}</label>@if(!empty($artworks->style_detail)){{$artworks->style_detail->name}}@endif
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="responsive">
                                @foreach($artworks->artwork_images as $images)
                                <div> <img class="img_preview" style="width:100%" src="{{$images->media_url}}" alt="..."></div>
                                @endforeach
                              

                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <table id="datatable" class="table table-striped table-bordered table-responsive-sm" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Variant Type</th>
                                                    <th>Count</th>
                                                    <th>Width</th>
                                                    <th>Height</th>
                                                    <th>Price (In £)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($artworks->variants as $key => $variants)
                                                <tr>
                                                    <td>{{$variants->variant_type}}</td>
                                                    <td>{{$variants->editions_count}}</td>
                                                    <td>{{$variants->width}}</td>
                                                    <td>{{$variants->height}}</td>
                                                    <td>{{$variants->price}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection