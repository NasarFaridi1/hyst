<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="min-h-screen bg-[rgba(245, 240, 232, 0.95)] flex items-center justify-center p-5">

    <div class="w-full max-w-md">

        <div class="bg-gray-900 border border-white/20 rounded-3xl shadow-2xl p-10">

            <div class="text-center mb-8">

                

                <h1 class="text-4xl font-extrabold text-white mb-2">

                    Login

                </h1>

                <p class="text-gray-300 text-sm">

                    Welcome back administrator

                </p>

            </div>

            @if(session('error'))

                <div class="bg-red-500/20 border border-red-400 text-red-200 p-4 rounded-2xl mb-6">

                    {{ session('error') }}

                </div>

            @endif

            <form method="POST" action="{{ route('admin.login') }}">

                @csrf

                <div class="mb-5">

                    <label class="text-gray-200 text-sm mb-2 block">

                        Email Address

                    </label>

                    <input
                        type="email"
                        name="email"
                        placeholder="Enter admin email"
                        class="w-full bg-white/10 border border-white/20 text-white placeholder-gray-400 p-4 rounded-2xl outline-none focus:border-blue-400">

                </div>

                <div class="mb-7">

                    <label class="text-gray-200 text-sm mb-2 block">

                        Password

                    </label>

                    <input
                        type="password"
                        name="password"
                        placeholder="Enter password"
                        class="w-full bg-white/10 border border-white/20 text-white placeholder-gray-400 p-4 rounded-2xl outline-none focus:border-blue-400">

                </div>

                <button
                    class="w-full bg-[#c25a2a] hover:scale-[1.02] transition-all text-white font-bold py-4 rounded-2xl shadow-xl">

                    Login Admin

                </button>

            </form>

        </div>

    </div>

</body>

</html>