@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'paypal',
])

@section('content')
    <div class="content">
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-12 order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">{{ __('Gallery User Management') }}</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="{{ url('gallery') }}" class="btn btn-sm btn-primary">{{ __('Back to list') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="w3-container w3-display-middle w3-card-4 w3-padding-16" method="POST" id="payment-form" action="{!! URL::to('paypal') !!}">
                              <div class="w3-container w3-teal w3-padding-16">Paywith Paypal</div>
                              {{ csrf_field() }}
                              <h2 class="w3-text-blue">Payment Form</h2>
                              <p>Demo PayPal form - Integrating paypal in laravel</p>
                              <label class="w3-text-blue"><b>Enter Amount</b></label>
                              <input class="w3-input w3-border" id="amount" type="text" name="amount"></p>
                              <button class="w3-btn w3-blue">Pay with PayPal</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection