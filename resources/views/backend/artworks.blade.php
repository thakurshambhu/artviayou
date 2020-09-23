@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'manage_artworks'
])
@section('content')
    <div class="content">
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="mb-0">{{ __('Artwork') }}</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="{{ url('/admin/artist') }}" class="btn btn-sm btn-primary">{{ __('Back to Artist') }}</a>
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


                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <table id="datatable" class="table table-striped table-bordered table-responsive-sm" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Category</th>
                                                    <th>Sub Category</th>
                                                    <th>Main Image</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($artworks as $key => $artwork)
                                                <tr>
                                                    <td><a href="{{url('/admin/view_artwork')}}/{{$artwork->id}}">{{$artwork->title}}</a></td>
                                                    <td>{{$artwork->category_detail->name}}</td>
                                                    <td>@if(!empty($artwork->sub_category_detail)){{$artwork->sub_category_detail->name}}@endif</td>
                                                    <td><img src="{{$artwork->artwork_images[0]->media_url}}" class="show_slider" height="50px" width="100px" data-artwork-id="{{$artwork->id}}" data-toggle="modal" data-target="#myModal"></td>
                                                    <td class="text-right">
                                                        <a href="{{url('/admin/delete_artwork')}}/{{$artwork->id}}/list/{{$artwork->user_id}}" class="btn btn-danger btn-link btn-sm delete_artwork" title="Delete Artwork"><i class="fa fa-trash"></i></a>
                                                        <a href="{{url('/admin/change_artwork_status')}}/{{$artwork->id}}/{{$artwork->is_publised}}/list/{{$artwork->user_id}}" class="btn btn-danger btn-link btn-sm change_artwork_status" title="@if($artwork->is_publised == 'publish') Un-Publish @else Publish @endif"><i class="fa fa-power-off"></i></a>
                                                        <a href="{{url('/admin/change_top_status')}}/{{$artwork->id}}/{{$artwork->top}}/list/{{$artwork->user_id}}" class="btn btn-danger btn-link btn-sm change_top_status" title="@if($artwork->top == 'yes') Remove From Top @else Add to Top @endif">@if($artwork->top == 'yes') <i class="fa fa-minus-square"></i> @else <i class="fa fa-plus-square"></i> @endif</a>
                                                        <a href="{{url('/admin/change_trending_status')}}/{{$artwork->id}}/{{$artwork->trending}}/list/{{$artwork->user_id}}" class="btn btn-danger btn-link btn-sm change_trending_status" title="@if($artwork->trending == 'yes') Remove From Featured @else Add to Featured @endif">@if($artwork->trending == 'yes') <i class="fa fa-minus-square"></i> @else <i class="fa fa-plus-square"></i> @endif</a>
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



    <!--begin modal window-->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Gallery Images</h5>
            </div>
            <div class="modal-body">
                <!--CAROUSEL CODE GOES HERE-->

                <!--end modal-body-->
            </div>
            <div class="modal-footer">
                <button class="btn-sm close" type="button" data-dismiss="modal">Close</button>
                <!--end modal-footer-->
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialoge-->
    </div>
    <!--end myModal-->
</div>
@endsection