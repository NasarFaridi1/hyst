<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hyst Login</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

</head>

{{-- {{dd(session()->all());}} --}}

<body class="min-h-screen bg-[rgba(245, 240, 232, 0.95)] flex items-center justify-center p-5">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-3xl shadow-2xl p-10">

            <div class="text-center mb-8">

                <a href="/" style="display:flex; align-items:center; justify-content:center; gap:10px; text-decoration:none;">
                    <div
                        style="width:38px; height:38px; background:#C25A2A; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i data-lucide="utensils" style="color:#fff; width:20px; height:20px;"></i>
                    </div>
                    <span
                        style="font-family:'Poppins',sans-serif; font-weight:800; font-size:20px; color:#0D0D0D; letter-spacing:-.3px;">
                        HYST
                    </span>
                </a>

                <h1 class="text-4xl mt-2 font-bold text-gray-800 mb-2">

                    Hyst Login

                </h1>

                <p class="text-gray-500 text-sm">

                    Login to continue ordering food

                </p>

            </div>

            <form method="POST" action="{{ route('login.submit') }}">

                @csrf

                <input type="hidden"
                name="redirect"
                value="{{ old('redirect', $redirect ?? '/') }}">

                <div class="mb-5">

                    <label class="text-gray-700 text-sm font-semibold mb-2 block">

                        Email

                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your email"
                        class="w-full border border-gray-200 p-4 rounded-2xl outline-none focus:border-red-400">

                </div>

                {{-- <div class="mb-7">

                    <label class="text-gray-700 text-sm font-semibold mb-2 block">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        class="w-full border border-gray-200 p-4 rounded-2xl outline-none focus:border-red-400">

                </div> --}}
                <div class="mb-7">
                    <label class="text-gray-700 text-sm font-semibold mb-2 block">
                        Password
                    </label>

                    <div class="relative">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Enter your password"
                            class="w-full border border-gray-200 p-4 pr-12 rounded-2xl outline-none focus:border-red-400">

                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-gray-700">

                            <!-- Eye -->
                            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm6.936 0C20.494 15.563 16.732 18 12 18S3.506 15.563 2.064 12C3.506 8.437 7.268 6 12 6s8.494 2.437 9.936 6z" />
                            </svg>

                            <!-- Eye Off -->
                            <svg id="eyeClose" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.732 0-8.494-2.437-9.936-6a9.956 9.956 0 012.293-3.95M9.88 9.88A3 3 0 0114.12 14.12M6.1 6.1L3 3m18 18l-3.1-3.1M9.88 9.88L6.1 6.1m8.02 8.02l3.78 3.78M14.12 14.12L17.9 17.9" />
                            </svg>

                        </button>
                    </div>
                </div>

                <script>
                function togglePassword() {
                    const password = document.getElementById('password');
                    const eyeOpen = document.getElementById('eyeOpen');
                    const eyeClose = document.getElementById('eyeClose');

                    if (password.type === 'password') {
                        password.type = 'text';
                        eyeOpen.classList.add('hidden');
                        eyeClose.classList.remove('hidden');
                    } else {
                        password.type = 'password';
                        eyeOpen.classList.remove('hidden');
                        eyeClose.classList.add('hidden');
                    }
                }
                </script>
                <div class="text-end mb-4 flex justify-end">
                    <a href="/forgot-password"
                        class="text-[#c25a2a] font-semibold">
                        Forgot Password?
                    </a>
                </div>

                <button
                    class="w-full bg-[#c25a2a] hover:scale-[1.02] transition-all text-white font-bold py-4 rounded-2xl shadow-lg">

                    Login Now

                </button>

            </form>
                <div class="text-center mt-4 flex justify-center">
                    <a href="/register"
                        class="text-[#c25a2a] font-semibold">
                        Don't have an HYST account ? Sign Up
                    </a>
                </div>
        </div>

    </div>

@if(session('message'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: @json(session('type', 'success')),
            title: @json(ucfirst(session('type', 'success'))),
            text: @json(session('message')),
            confirmButtonColor: '#111827'
        });
    });
</script>
@endif

<script>
    lucide.createIcons();
</script>

</body>

</html>