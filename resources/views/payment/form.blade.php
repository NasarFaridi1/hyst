@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <h3>TransactWorld Payment Demo</h3>
    <form action="{{ route('payment.pay') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Pay ₹1.00</button>
    </form>
</div>
@endsection
