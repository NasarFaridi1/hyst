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

    <form method="POST" action="/forgot-password" onsubmit="let btn = this.querySelector('button[type=submit]'); if(btn.disabled) return false; btn.disabled = true; btn.style.opacity = '0.7'; btn.innerText = 'Sending Reset Link...';">

        @csrf

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
            class="w-full border p-4 rounded-xl mb-4">

        

        <button
            type="submit"
            class="w-full bg-[#c25a2a] text-white p-4 rounded-xl font-bold hover:bg-[#c25a2a]/90 transition">

            Send Reset Link

        </button>

    </form>

</div>

</div>

@if ($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        text: "{{ $errors->first() }}",
        confirmButtonColor: '#111827'
    });
});
</script>
@endif

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