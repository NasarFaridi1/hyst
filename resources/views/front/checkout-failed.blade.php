@extends('front.layouts.app')

@section('content')

<div class="container text-center py-5">

    <div style="font-size:70px;">❌</div>

    <h2>Payment Failed</h2>

    <p>Your payment could not be completed.</p>

    <a href="{{ url('/checkout') }}" class="btn btn-primary">
        Try Again
    </a>

</div>

@endsection