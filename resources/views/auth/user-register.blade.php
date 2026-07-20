<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create HYST Account</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">


</head>

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

                    Create HYST Account

                </h1>

                <p class="text-gray-500 text-sm">

                   Register with HYST and start ordering delicious food

                </p>

            </div>

            <form method="POST" action="/register-user">

                @csrf

                <div class="mb-5">

                    <label class="text-gray-700 text-sm font-semibold mb-2 block">

                        Full Name

                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="Enter full name"
                        class="w-full border border-gray-200 p-4 rounded-2xl outline-none focus:border-green-400">

                </div>

                <div class="mb-5">

                    <label class="text-gray-700 text-sm font-semibold mb-2 block">

                        Email Address

                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="Enter email address"
                        class="w-full border border-gray-200 p-4 rounded-2xl outline-none focus:border-green-400">

                </div>

                <div class="mb-7">

                    <label class="text-gray-700 text-sm font-semibold mb-2 block">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Create password"
                        class="w-full border border-gray-200 p-4 rounded-2xl outline-none focus:border-green-400">

                </div>

                <button
                    class="w-full bg-[#c25a2a] hover:scale-[1.02] transition-all text-white font-bold py-4 rounded-2xl shadow-lg">

                    Create Account

                </button>

            </form>

                <div class="text-center mt-4 flex justify-center">
                    <a href="/login"
                        class="text-[#c25a2a] font-semibold">
                       Already have an HYST account? Login
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