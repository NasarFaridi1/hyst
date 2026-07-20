@extends('front.layouts.app')

@section('content')
<section style="
    background:rgba(245,240,232,0.95);
    min-height:100vh;
    padding:60px 20px;
">
    <div style="max-width:1000px;margin:auto;">

        <div style="text-align:center;margin-bottom:40px;">
            <h1 style="
                font-size:42px;
                font-weight:800;
                color:#111827;
                font-family:'Syne',sans-serif;
                margin-bottom:15px;
            ">
               {{ $restaurant->name }} Terms & Conditions
            </h1>

            <p style="
                color:#6B7280;
                font-size:18px;
                max-width:700px;
                margin:auto;
            ">
                Please read these Terms and Conditions carefully before using our services.
            </p>
        </div>

        <div style="
            background:#fff;
            border-radius:24px;
            padding:50px;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
            border:1px solid #F1F1F1;
        ">

           {!! $terms->content ?? '<p>No terms and conditions available.</p>' !!}

        </div>

    </div>
</section>

<style>
    .ck-content h1,
    .ck-content h2,
    .ck-content h3,
    .ck-content h4,
    .ck-content h5,
    .ck-content h6,
    div h1,
    div h2,
    div h3 {
        color: #111827;
        margin-top: 20px;
        margin-bottom: 15px;
        font-family: 'Syne', sans-serif;
    }

    div p {
        line-height: 1.9;
        color: #4B5563;
    }

    div ul,
    div ol {
        padding-left: 20px;
        margin-bottom: 20px;
    }

    div li {
        line-height: 1.9;
        margin-bottom: 10px;
    }

    @media(max-width:768px){
        section h1{
            font-size:30px !important;
        }

        div[style*="padding:50px"]{
            padding:25px !important;
        }
    }
</style>
@endsection