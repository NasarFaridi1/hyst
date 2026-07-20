<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">

<div class="bg-white p-10 rounded-3xl w-full max-w-md shadow">

    <h2 class="text-3xl font-bold mb-6">
        Reset Password
    </h2>

    <form method="POST" action="/forgot-password">

        @csrf

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
            class="w-full border p-4 rounded-xl mb-4">

        

        <button
            class="w-full bg-[#c25a2a] text-white p-4 rounded-xl">

            Update Password

        </button>

    </form>

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

</body>
</html>