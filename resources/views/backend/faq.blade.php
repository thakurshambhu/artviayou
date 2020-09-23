@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'faq'
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
                                    <h3 class="mb-0">{{ __('Faq') }}</h3>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="{{ url('/admin/add_faq') }}" class="btn btn-sm btn-primary">{{ __('Add Faq') }}</a>
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
                                                    <th scope="col">{{ __('Question') }}</th>
                                                    <th scope="col">{{ __('Answer') }}</th>
                                        <th scope="col">{{ __('Creation Date') }}</th>
                                                    <th class="disabled-sorting text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($faq as $key => $fa)
                                                <tr>
                                                    <td>{{$fa->qus}}</td>
                                                    <td><?=htmlspecialchars_decode($fa->ans)?></td>
                                                    <td>{{$fa->created_at->format('d/m/Y H:i')}}</td>
                                                    <td class="text-right">
                                                        <a href="{{url('/admin/edit_faq')}}/{{$fa->id}}" class="btn btn-warning btn-link btn-sm edit" title="Edit"><i class="fa fa-edit"></i></a>
                                                        <a href="{{url('/admin/delete_faq')}}/{{$fa->id}}" class="btn btn-danger btn-link btn-sm remove delete_style" title="Delete"><i class="fa fa-times"></i></a>
                                                        <a href="{{url('/admin/change_faq_status')}}/{{$fa->id}}/{{$fa->is_active}}" class="btn btn-danger btn-link btn-sm change_style_status" title="@if($fa->is_active == 'yes') Deactivate @else Activate @endif"><i class="fa fa-power-off"></i></a>
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