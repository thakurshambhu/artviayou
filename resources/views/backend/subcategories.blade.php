@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'subcategories'
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
                                    <h3 class="mb-0">{{ __('Subcategory') }}</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="{{ url('/admin/add_subcategory') }}" class="btn btn-sm btn-primary">{{ __('Add Subcategory') }}</a>
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
                                                    <th scope="col">{{ __('Name') }}</th>
                                                     <th scope="col">{{ __('Image') }}</th>
                                                     <th scope="col">{{ __('Category Name') }}</th>
                                        <th scope="col">{{ __('Creation Date') }}</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($subcategories as $key => $subcategory)

                                                <tr>
                                                    <td>{{$subcategory->name}}</td>
                                                     <td><img src="{{ $subcategory->media_url }}" height="80px" width="80px" /></td>
                                                    <td>{{$subcategory->category->name}}</td>
                                                    <td>@if(!empty($subcategory->created_at)){{date('d/m/Y H:i', strtotime($subcategory->created_at))}}@endif</td>
                                                    <td class="text-right">
                                                        <a href="{{url('/admin/edit_subcategory')}}/{{$subcategory->id}}" class="btn btn-warning btn-link btn-sm edit" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <!-- <a href="{{url('/admin/delete_subcategory')}}/{{$subcategory->id}}" class="btn btn-danger btn-link btn-sm remove delete_subcategory" title="Delete"><i class="fa fa-times"></i></a> -->
                                                        <a href="{{url('/admin/change_subcategory_status')}}/{{$subcategory->id}}/{{$subcategory->is_active}}" class="btn btn-danger btn-link btn-sm change_subcategory_status" title="@if($subcategory->is_active == 'yes') Deactivate @else Activate @endif"><i class="fa fa-power-off"></i></a>
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