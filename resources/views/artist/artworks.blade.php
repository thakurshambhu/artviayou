@extends('layouts.frontend.artist.app', [
    'class' => '',
    'elementActive' => 'artworks',
])
@section('content')
    <div class="content p-0">
        <div class="container-fluid mt--7 p-0">
            <div class="row noRowMargin">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row noRowMargin align-items-center">
                                <div class="col-md-12 d-flex justify-content-between align-items-center">
                                    <h3 class="mb-0">{{ __('Your Artworks') }}</h3>

                                       <a href="{{ url('/artist/add_artwork') }}" class="btn btn-sm btn-primary">{{ __('Add Artwork') }}</a>
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


                        <div class="row noRowMargin">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <table id="datatable" class="table table-striped table-bordered table-responsive-sm" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Title</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($artworks as $key => $artwork)
                                                <tr>
                                                    <td><a href="{{url('/artist/edit_artwork')}}/{{$artwork->id}}"><img src="@if(count($artwork->artwork_images) > 0){{$artwork->artwork_images[0]->media_url}} @endif" class="show_slider"  data-artwork-id="{{$artwork->id}}" data-toggle="modal" data-target="#myModal"></a></td>
                                                    <td>{{$artwork->title}}</td>
                                                    
                                                    <td class="text-right">
                                                        <div class="d-flex justify-content-between">
                                                               <a href="{{url('/artist/view_artwork')}}/{{$artwork->id}}" class="btn btn-danger btn-link btn-sm view view_artwork" title="View artwork"><i class="fa fa-eye"></i></a>
                                                        <a href="{{url('/artist/change_artwork_status')}}/{{$artwork->id}}/{{$artwork->is_publised}}/artworks/{{$artwork->user_id}}" class="btn btn-danger btn-link btn-sm change_artwork_status" title="@if($artwork->is_publised == 'publish') Click to Un-Publish @else Click to Publish @endif"><i class="fa fa-power-off"></i></a>
                                                        <a href="{{url('/artist/delete_artwork')}}/{{$artwork->id}}" class="btn btn-danger btn-link btn-sm remove delete_artwork" title="Delete"><i class="fa fa-times"></i></a>
                                                        </div>
                                                     
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div><!-- end content-->
                                </div><!--  end card  -->
                            </div> <!-- end col-md-12 -->
                        </div> <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
