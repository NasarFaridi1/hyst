<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verify Email - HYST</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

</head>

<body class="min-h-screen bg-[rgba(245,240,232,0.95)] flex items-center justify-center p-5">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl shadow-2xl p-10">

            <!-- Logo -->
            <div class="text-center mb-8">

                <a href="/" class="flex items-center justify-center gap-3 no-underline">
                    <div
                        class="w-10 h-10 bg-[#C25A2A] rounded-xl flex items-center justify-center flex-shrink-0">
                        <i data-lucide="utensils" class="text-white w-5 h-5"></i>
                    </div>

                    <span class="font-extrabold text-2xl tracking-tight text-gray-900">
                        HYST
                    </span>
                </a>

                <h1 class="text-4xl font-bold text-gray-800 mt-3 mb-2">
                    Verify Email
                </h1>

                <p class="text-gray-500 text-sm leading-6">
                    We've sent a verification code to your email address.
                    Please enter the OTP below to verify your account.
                </p>

            </div>

            <form method="POST" action="{{ route('ambassador.verify.otp') }}">
    @csrf

                <div class="mb-7">

                    <label class="text-gray-700 text-sm font-semibold mb-2 block">
                        Verification Code
                    </label>

                    <div class="relative">

                        <input
                            type="text"
                            name="otp"
                            maxlength="6"
                            autocomplete="one-time-code"
                            placeholder="Enter 6-digit OTP"
                            class="w-full border border-gray-200 p-4 rounded-2xl outline-none focus:border-[#c25a2a] text-center text-2xl tracking-[10px] font-semibold">

                        <i data-lucide="shield-check"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5"></i>

                    </div>

                </div>
                <input type="hidden" name="token" value="{{ request('token') }}">
                

                <button
                    type="submit"
                    class="w-full bg-[#c25a2a] hover:bg-[#ab4e23] hover:scale-[1.02] transition-all text-white font-bold py-4 rounded-2xl shadow-lg">

                    Verify Email

                </button>

            </form>

            <div class="text-center mt-6">

                <p class="text-gray-500 text-sm">
                    Didn't receive the OTP?
                </p>

                {{-- <a href="/resend-otp"
                    class="inline-block mt-2 text-[#c25a2a] font-semibold hover:underline">
                    Resend OTP
                </a> --}}

                <form method="POST" action="{{ route('ambassador.resend.otp') }}">
    @csrf

    <input type="hidden"
           name="token"
           value="{{ request('token') }}">

    <button type="submit"
        class="inline-block mt-2 text-[#c25a2a] font-semibold hover:underline">
        Resend OTP
    </button>
</form>

            </div>

            <div class="text-center mt-4">

                <a href="/login"
                    class="text-sm text-gray-500 hover:text-[#c25a2a]">
                    ← Back to Login
                </a>

            </div>

        </div>

    </div>

    @if(session('message'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: @json(session('type', 'success')),
                title: @json(ucfirst(session('type', 'success'))),
                text: @json(session('message')),
                confirmButtonColor: '#C25A2A'
            });
        });
    </script>
    @endif

    <script>
        lucide.createIcons();
    </script>

</body>

</html>