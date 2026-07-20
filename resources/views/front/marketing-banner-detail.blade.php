@extends('front.layouts.app')

@section('content')

{{-- ===========================
    HERO
=========================== --}}
<section style="position:relative;background:#0D0D0D;color:#fff;padding:70px 0 60px;overflow:hidden;">

    <div style="position:absolute;inset:0;background-image:radial-gradient(rgba(194,90,42,.08) 1px,transparent 1px);background-size:32px 32px;"></div>

    <div style="max-width:1280px;margin:auto;padding:0 24px;position:relative;">

        <a href="{{ route('front.banners.index') }}"
           style="display:inline-flex;align-items:center;gap:8px;
                  color:#C25A2A;
                  text-decoration:none;
                  font-size:14px;
                  margin-bottom:25px;
                  font-family:Poppins,sans-serif;">

            <i data-lucide="arrow-left" style="width:18px;height:18px;"></i>

            Back to Promotions

        </a>

        <div style="display:inline-flex;
                    align-items:center;
                    gap:8px;
                    background:rgba(194,90,42,.18);
                    border:1px solid rgba(194,90,42,.35);
                    padding:8px 18px;
                    border-radius:999px;">

            <i data-lucide="megaphone"
               style="width:15px;height:15px;color:#C25A2A;"></i>

            <span style="font-size:12px;
                         color:#C25A2A;
                         font-weight:600;
                         font-family:Poppins,sans-serif;">
                {{ $banner->category?->name }}
            </span>

        </div>

        <h1 style="font-size:46px;
                   font-family:Poppins,sans-serif;
                   font-weight:800;
                   margin-top:25px;
                   line-height:1.2;">

            {{ $banner->title }}

        </h1>

        @if($banner->subtitle)

            <p style="margin-top:18px;
                    font-size:18px;
                    color:#D1D5DB;
                    max-width:700px;
                    line-height:1.8;">

                {{ $banner->subtitle }}

            </p>

        @endif

    </div>

</section>


{{-- ===========================
    CONTENT
=========================== --}}
<section
    style="
        background:#F7F4EE;
        padding:70px 0;
    "
>
    <div
        style="
            max-width:1280px;
            margin:auto;
            padding:0 24px;
        "
    >
        <div class="detail-grid">
            {{-- LEFT --}}
            <div>
                <div
                    style="
                        background:#fff;
                        border-radius:22px;
                        overflow:hidden;
                        border:1px solid #eee;
                        box-shadow:0 8px 25px rgba(0,0,0,.06);
                    "
                >
                    @if ($banner->banner_image)
                        <img
                            src="{{ asset($banner->banner_image) }}"
                            style="
                                width:100%;
                                height:500px;
                                object-fit:cover;
                            "
                        >
                    @else
                        <div
                            style="
                                height:500px;
                                display:flex;
                                justify-content:center;
                                align-items:center;
                                background:#111;
                            "
                        >
                            <i
                                data-lucide="image"
                                style="
                                    width:70px;
                                    height:70px;
                                    color:#777;
                                "
                            ></i>
                        </div>
                    @endif
                </div>

                <div
                    style="
                        margin-top:35px;
                        background:#fff;
                        padding:35px;
                        border-radius:20px;
                        border:1px solid #ececec;
                    "
                >
                    <h2
                        style="
                            font-family:Poppins,sans-serif;
                            font-size:30px;
                            margin-bottom:20px;
                            font-weight:700;
                        "
                    >
                        About this Promotion
                    </h2>

                    @if ($banner->description)
                        <div
                            style="
                                font-size:16px;
                                line-height:2;
                                color:#555;
                            "
                        >
                            {!! nl2br(e($banner->description)) !!}
                        </div>
                    @else
                        <p>No description available.</p>
                    @endif
                </div>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div>
                <div
                    style="
                        background:#fff;
                        padding:28px;
                        border-radius:20px;
                        border:1px solid #ececec;
                        position:sticky;
                        top:120px;
                    "
                >
                    <h3
                        style="
                            font-family:Poppins,sans-serif;
                            font-size:24px;
                            margin-bottom:25px;
                            font-weight:700;
                        "
                    >
                        Promotion Details
                    </h3>

                    <div
                        style="
                            display:flex;
                            gap:15px;
                            margin-bottom:20px;
                        "
                    >
                        <div
                            style="
                                width:48px;
                                height:48px;
                                background:#F6EEE8;
                                display:flex;
                                justify-content:center;
                                align-items:center;
                                border-radius:12px;
                            "
                        >
                            <i
                                data-lucide="tag"
                                style="
                                    width:20px;
                                    height:20px;
                                    color:#C25A2A;
                                "
                            ></i>
                        </div>

                        <div>
                            <div
                                style="
                                    font-size:13px;
                                    color:#888;
                                "
                            >
                                Category
                            </div>

                            <div style="font-weight:600;">
                                {{ $banner->category?->name }}
                            </div>
                        </div>
                    </div>

                    @if ($banner->email)
                        <div
                            style="
                                display:flex;
                                gap:15px;
                                margin-bottom:20px;
                            "
                        >
                            <div
                                style="
                                    width:48px;
                                    height:48px;
                                    background:#F6EEE8;
                                    display:flex;
                                    justify-content:center;
                                    align-items:center;
                                    border-radius:12px;
                                "
                            >
                                <i
                                    data-lucide="mail"
                                    style="
                                        width:20px;
                                        height:20px;
                                        color:#C25A2A;
                                    "
                                ></i>
                            </div>

                            <div>
                                <div
                                    style="
                                        font-size:13px;
                                        color:#888;
                                    "
                                >
                                    Email
                                </div>

                                <div>
                                    {{ $banner->email }}
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($banner->phone)
                        <div
                            style="
                                display:flex;
                                gap:15px;
                                margin-bottom:20px;
                            "
                        >
                            <div
                                style="
                                    width:48px;
                                    height:48px;
                                    background:#F6EEE8;
                                    display:flex;
                                    justify-content:center;
                                    align-items:center;
                                    border-radius:12px;
                                "
                            >
                                <i
                                    data-lucide="phone"
                                    style="
                                        width:20px;
                                        height:20px;
                                        color:#C25A2A;
                                    "
                                ></i>
                            </div>

                            <div>
                                <div
                                    style="
                                        font-size:13px;
                                        color:#888;
                                    "
                                >
                                    Phone
                                </div>

                                <div>
                                    {{ $banner->phone }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div
                        style="
                            display:flex;
                            gap:15px;
                            margin-bottom:30px;
                        "
                    >
                        <div
                            style="
                                width:48px;
                                height:48px;
                                background:#F6EEE8;
                                display:flex;
                                justify-content:center;
                                align-items:center;
                                border-radius:12px;
                            "
                        >
                            <i
                                data-lucide="calendar"
                                style="
                                    width:20px;
                                    height:20px;
                                    color:#C25A2A;
                                "
                            ></i>
                        </div>

                        <div>
                            <div
                                style="
                                    font-size:13px;
                                    color:#888;
                                "
                            >
                                Published
                            </div>

                            <div>
                                {{ $banner->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </div>

                    <button
                        onclick="openContactModal()"
                        style="
                            width:100%;
                            padding:15px;
                            border:none;
                            background:#C25A2A;
                            color:#fff;
                            font-family:Poppins,sans-serif;
                            font-size:16px;
                            font-weight:600;
                            border-radius:12px;
                            cursor:pointer;
                            transition:.25s;
                        "
                    >
                        Contact Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>



{{-- CTA --}}

<section
    style="
        background:#0D0D0D;
        padding:70px 0;
        text-align:center;
    "
>
    <div
        style="
            max-width:900px;
            margin:auto;
            padding:0 24px;
        "
    >
        <h2
            style="
                color:#fff;
                font-family:Poppins,sans-serif;
                font-size:40px;
                font-weight:800;
            "
        >
            Interested in this Offer?
        </h2>

        <p
            style="
                color:#D1D5DB;
                margin:18px auto 35px;
                max-width:600px;
                line-height:1.8;
            "
        >
            Get in touch with us today to learn more about this promotion.
        </p>

        <button
            onclick="openContactModal()"
            style="
                padding:16px 40px;
                background:#C25A2A;
                color:#fff;
                border:none;
                border-radius:12px;
                font-size:16px;
                font-weight:700;
                cursor:pointer;
            "
        >
            Contact Now
        </button>
    </div>
</section>



<style>
    .detail-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 35px;
    }

    @media (max-width: 992px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- ===========================================
    CONTACT MODAL
=========================================== --}}

@if (session('success'))
    <div
        id="successToast"
        style="
            position:fixed;
            top:30px;
            right:30px;
            z-index:99999;
            background:#16a34a;
            color:#fff;
            padding:16px 22px;
            border-radius:12px;
            font-family:Poppins,sans-serif;
            box-shadow:0 12px 30px rgba(0,0,0,.18);
        "
    >
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('successToast').style.display = 'none';
        }, 4000);
    </script>
@endif



<div
    id="contactModal"
    style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.65);
        backdrop-filter:blur(5px);
        z-index:999999;
        align-items:center;
        justify-content:center;
        padding:25px;
        
    "
>
    <div
        style="
            width:100%;
            max-width:620px;
            background:#fff;
            border-radius:22px;
            overflow:hidden;
            animation:popup .3s;
            height:90vh;
            overflow-y:auto;
        "
    >
        <div
            style="
                background:#0D0D0D;
                padding:28px;
                display:flex;
                justify-content:space-between;
                align-items:center;
            "
        >
            <div>
                <h2
                    style="
                        color:#fff;
                        margin:0;
                        font-size:28px;
                        font-family:Poppins,sans-serif;
                        font-weight:700;
                    "
                >
                    Contact Us
                </h2>

                <p
                    style="
                        margin:8px 0 0;
                        color:#CFCFCF;
                    "
                >
                    Send your enquiry regarding this promotion.
                </p>
            </div>

            <button
                onclick="closeContactModal()"
                style="
                    background:none;
                    border:none;
                    color:#fff;
                    cursor:pointer;
                "
            >
                <i
                    data-lucide="x"
                    style="width:26px;height:26px;"
                ></i>
            </button>
        </div>

        <form
            action="{{ route('front.banners.contact') }}"
            method="POST"
            style="padding:35px;"
        >
            @csrf

            <input
                type="hidden"
                name="banner_id"
                value="{{ $banner->id }}"
            >

            <div class="form-group">
                <label>Your Name</label>

                <input
                    type="text"
                    name="name"
                    required
                    value="{{ old('name') }}"
                >

                @error('name')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Email Address</label>

                <input
                    type="email"
                    name="email"
                    required
                    value="{{ old('email') }}"
                >

                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Phone Number</label>

                <input
                    type="text"
                    name="phone"
                    required
                    value="{{ old('phone') }}"
                >

                @error('phone')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Message</label>

                <textarea
                    name="message"
                    rows="5"
                    required
                >{{ old('message') }}</textarea>

                @error('message')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div
                style="
                    display:flex;
                    gap:15px;
                    margin-top:30px;
                "
            >
                <button
                    type="button"
                    onclick="closeContactModal()"
                    class="cancel-btn"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="submit-btn"
                >
                    <i
                        data-lucide="send"
                        style="width:18px;height:18px;"
                    ></i>

                    Send Enquiry
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openContactModal() {
        document.getElementById('contactModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeContactModal() {
        document.getElementById('contactModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    window.onclick = function (e) {
        let modal = document.getElementById('contactModal');

        if (e.target === modal) {
            closeContactModal();
        }
    };
</script>


<style>
    @keyframes popup {
        from {
            opacity: 0;
            transform: translateY(40px) scale(.95);
        }

        to {
            opacity: 1;
            transform: none;
        }
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-family: Poppins, sans-serif;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 14px 16px;
        border: 1px solid #ddd;
        border-radius: 12px;
        font-size: 15px;
        outline: none;
        transition: .25s;
        font-family: Poppins, sans-serif;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #C25A2A;
        box-shadow: 0 0 0 3px rgba(194, 90, 42, .15);
    }

    .error {
        display: block;
        margin-top: 5px;
        font-size: 13px;
        color: #dc2626;
    }

    .submit-btn {
        flex: 1;
        background: #C25A2A;
        border: none;
        padding: 15px;
        border-radius: 12px;
        color: #fff;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        transition: .25s;
    }

    .submit-btn:hover {
        background: #ab4b1e;
    }

    .cancel-btn {
        flex: 1;
        background: #f3f4f6;
        border: none;
        padding: 15px;
        border-radius: 12px;
        cursor: pointer;
        font-weight: 600;
    }

    .cancel-btn:hover {
        background: #e5e7eb;
    }

    @media (max-width: 768px) {
        #contactModal {
            padding: 15px;
        }

        #contactModal form {
            padding: 22px !important;
        }

        .submit-btn,
        .cancel-btn {
            width: 100%;
        }

        form div[style*="display:flex"] {
            flex-direction: column;
        }
    }
</style>

@if($errors->any())
    <script>
        window.onload=function(){
        openContactModal();
        }
    </script>
@endif

@endsection