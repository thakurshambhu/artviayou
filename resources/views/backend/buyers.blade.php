@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'buyers'
])
<script type="text/javascript">

</script>
@section('content')
    <div class="content">
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h3 class="mb-0">{{ __('Buyers') }}</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="{{ url('/admin/add_buyer') }}" class="btn btn-sm btn-primary">{{ __('Add Buyer') }}</a>
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
                                    <div class="card-body table-responsive">

                                        <table id="datatable" class="table table-striped table-bordered table-responsive-sm" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>City</th>
                                                    <th>Country</th>
                                                    <th>Profile Image</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($buyers as $key => $buyer)
                                                <tr>
                                                    <td>{{$buyer->first_name}}</td>
                                                    <td>{{$buyer->last_name}}</td>
                                                    <td>{{$buyer->email}}</td>
                                                    <td>{{$buyer->city}}</td>
                                                    <td>{{$buyer->country}}</td>
                                                    <td><img src="{{ $buyer->media_url ? $buyer->media_url : url('/assets/images/default.png') }}" height="80px" width="80px" /></td>
                                                    <td class="text-right">
                                                        <a href="{{url('/admin/edit_buyer')}}/{{$buyer->id}}" class="btn btn-warning btn-link btn-sm edit" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="{{url('/admin/delete_buyer')}}/{{$buyer->id}}" class="btn btn-danger btn-link btn-sm remove delete_buyer" title="Delete"><i class="fa fa-times"></i></a>
                                                        <a href="{{url('/admin/change_buyer_status')}}/{{$buyer->id}}/{{$buyer->is_active}}" class="btn btn-danger btn-link btn-sm change_status" title="@if($buyer->is_active == 'yes') Deactivate @else Activate @endif"><i class="fa fa-power-off"></i></a>
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