@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'payment_history'
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
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Payment History') }}</h3>
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

                                        <table id="paymeny_datatable" class="table table-striped table-bordered table-responsive-sm" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ __('Artwork') }}</th>
                                                    <th scope="col">{{ __('Buyer') }}</th>
                                                    <th scope="col">{{ __('Artist') }}</th>
                                                    <th class="disabled-sorting text-right">Amount (In £)</th>
                                                    <th>Payment Id</th>
                                                    <th>Shipping Status</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>Totals</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @if(count($payment_history)>0)
                                                <?php $total_amout = 0;?>
                                                @foreach($payment_history as $key => $payment)
                                                <?php
                                                $json_info = json_decode($payment->artwork_info);
                                                $order_info = json_decode($payment->paypal_response);
                                                $total_amout = $total_amout + $json_info->variants[0]->price;
                                                ?>
                                                <tr>
                                                    <td><a href="{{url('admin/view_artwork')}}/{{$json_info->id}}"><img src="{{$json_info->artwork_images[0]->media_url}}"></a></td>
                                                    <td>{{$order_info->payer->payer_info->first_name}} {{$order_info->payer->payer_info->last_name}}</td>
                                                    <td>{{$json_info->artist->first_name}} {{$json_info->artist->last_name}}</td>
                                                    <td>{{$json_info->variants[0]->price}}</td>
                                                    <td>{{$payment->payment_id}}</td>
                                                    <td>{{$payment->shipping_status}}</td>
                                                    
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div><!-- end content----->
                                </div><!--  end card  -->
                            </div> <!-- end col-md-12 -->
                        </div> <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection