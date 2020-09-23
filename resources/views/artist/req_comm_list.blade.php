@extends('layouts.frontend.artist.app', [
    'class' => '',
    'elementActive' => 'req_comm_list',
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
                                    <h3 class="mb-0">{{ __('Commission List') }}</h3>

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
                                                    <th>Name</th>
                                                    <th class="disabled-sorting text-right">Request Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($req_comm_user as $key => $req_comm)
                                                @if(!empty($req_comm->users))
                                                <tr>
                                                    <td><a href="{{url('profile')}}/{{$req_comm->users->user_name}}" target="_blank">{{$req_comm->users->name}}</a></td>
                                                    <td class="text-right">
                                                        <div class="d-flex ">
                                                            @if($req_comm->request_status=='Accepted')
                                                                <a href="javascript:void()" class="btn btn-round btn-success">Accepted</a>
                                                            @elseif($req_comm->request_status=='Decline')
                                                                <a href="javascript:void()" class="btn btn-round btn-danger">DECLINED</a>
                                                            @else
                                                                <a href="{{url('/artist/change_commition_status')}}/{{$req_comm->id}}/Accepted"  class="btn btn-round btn-success change_commition_status mr-2">Accept</a>
                                                                <a href="{{url('/artist/change_commition_status')}}/{{$req_comm->id}}/Decline"  class="btn btn-round btn-danger change_commition_status ">Decline</a>
                                                            @endif
                                                        </div>
                                                     
                                                    </td>
                                                    
                                                </tr>
                                                @endif
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
