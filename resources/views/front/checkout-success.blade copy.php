@extends('front.layouts.app')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card border-0 shadow-lg rounded-4">

                <div class="card-body p-5">

                    <div class="text-center">

                        <div class="success-icon mb-4">
                            ✓
                        </div>

                        <h2 class="fw-bold text-success">
                            Payment Successful
                        </h2>

                        <p class="text-muted">
                            Thank you! Your payment has been processed successfully.
                        </p>

                    </div>

                    <hr class="my-4">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="detail-box">
                                <small>Payment Status</small>
                                <h6 class="text-success mb-0">
                                    {{ str_replace('_',' ', $result['status']) }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-box">
                                <small>Amount Paid</small>
                                <h6 class="mb-0">
                                    £{{ number_format($result['transaction']['amount'],2) }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-box">
                                <small>Transaction Reference</small>
                                <h6 class="mb-0">
                                    {{ $result['transaction']['reference'] }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-box">
                                <small>Transaction Token</small>
                                <h6 class="mb-0 text-break">
                                    {{ $result['token'] }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-box">
                                <small>Customer</small>
                                <h6 class="mb-0">
                                    {{ $result['payer']['givenName'] }}
                                    {{ $result['payer']['familyOrBusinessName'] }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-box">
                                <small>Email</small>
                                <h6 class="mb-0 text-break">
                                    {{ $result['payer']['email'] }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-box">
                                <small>Payment Time</small>
                                <h6 class="mb-0">
                                    {{ \Carbon\Carbon::parse($result['time'])->format('d M Y h:i A') }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-box">
                                <small>Payment Type</small>
                                <h6 class="mb-0">
                                    {{ $result['type'] }}
                                </h6>
                            </div>
                        </div>

                    </div>

                    <div class="alert alert-success mt-4">

                        <strong>Your order has been received.</strong>

                        <br>

                        We are preparing your food and will notify you once the restaurant accepts your order.

                    </div>

                    <div class="text-center mt-4">

                        <div class="spinner-border text-success mb-3"></div>

                        <h5 class="fw-bold">
                            Redirecting to My Orders
                        </h5>

                        <p class="text-muted">
                            Please don't close this page.
                        </p>

                        <h3 class="text-success">

                            <span id="countdown">5</span>

                        </h3>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>

.success-icon{

    width:110px;
    height:110px;
    border-radius:50%;
    background:#e9fff2;
    color:#28a745;
    font-size:60px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;

}

.detail-box{

    background:#fafafa;
    border:1px solid #ececec;
    border-radius:12px;
    padding:18px;
    height:100%;

}

.detail-box small{

    color:#888;
    display:block;
    margin-bottom:5px;

}

.detail-box h6{

    font-weight:700;
}

@media(max-width:768px){

.success-icon{

width:90px;
height:90px;
font-size:45px;

}

.card-body{

padding:25px;

}

h2{

font-size:28px;

}

.detail-box{

margin-bottom:12px;

}

}

</style>

<script>

let seconds = 5;

const countdown = document.getElementById('countdown');

const timer = setInterval(function(){

    seconds--;

    countdown.innerHTML = seconds;

    if(seconds<=0){

        clearInterval(timer);

        window.location.href="{{ route('my.orders') }}";

    }

},1000);

</script>

@endsection