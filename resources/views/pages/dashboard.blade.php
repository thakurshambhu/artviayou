@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'dashboard'
])

@section('content')
    <div class="content">
        <div class="message-alert-top">
            @if(Session::has('success_message'))
            <div><div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('success_message') !!}</em></div></div>
            @endif
            @if(Session::has('error_message'))
            <div><div class="alert alert-danger"><em> {!! session('error_message') !!}</em></div></div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
            // demo.initChartsPages();
        });
    </script>
@endpush