<!DOCTYPE html>
<html>

<head>
    <title>Forgot Password</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">

<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

.reset-page{
    background:rgba(245,240,232,.95);
    min-height:100vh;
    padding:40px 16px 100px;
    width:100%;
}

.reset-wrap{
    max-width:1100px;
    margin:0 auto;
    display:grid;
    grid-template-columns:1fr;
    gap:24px;
    align-items:start;
}

.reset-card{
    background:#fff;
    border:1px solid #E8E6E0;
    border-radius:24px;
    padding:40px;
}

.reset-title{
    font-size:32px;
    font-weight:700;
    color:#111;
    margin-bottom:10px;
}

.reset-subtitle{
    color:#777;
    margin-bottom:35px;
    line-height:28px;
}

.form-group{
    margin-bottom:22px;
}

.form-label{
    display:block;
    margin-bottom:10px;
    font-weight:600;
    color:#222;
    font-size:15px;
}

.form-control{
    width:100%;
    height:54px;
    border:1px solid #ddd;
    border-radius:14px;
    padding:0 18px;
    font-size:15px;
    outline:none;
    transition:.2s;
    box-sizing:border-box;
}

.form-control:focus{
    border-color:#E63946;
    box-shadow:0 0 0 4px rgba(230,57,70,.12);
}

.reset-btn{
    width:100%;
    height:56px;
    border:none;
    border-radius:14px;
    background:#E63946;
    color:#fff;
    font-size:17px;
    font-weight:700;
    cursor:pointer;
    transition:.2s;
}

.reset-btn:hover{
    background:#c52f3c;
}

.password-box{
    position:relative;
}

.toggle-password{
    position:absolute;
    right:18px;
    top:17px;
    cursor:pointer;
    color:#888;
}

@media(max-width:900px){

.reset-wrap{
grid-template-columns:1fr;
}

}

@media(max-width:600px){

.reset-card{
padding:25px;
}

.reset-title{
font-size:26px;
}

}
</style>

<div class="reset-page">

    <div class="reset-wrap">

        

        {{-- Content --}}
        <div>

            <div class="reset-card">

                <h2 class="reset-title">
                    Reset Password
                </h2>

                <p class="reset-subtitle">
                    Enter your new password below.
                </p>

                @if ($errors->any())
                    <div style="background:#ffe8e8;border:1px solid #ffb4b4;padding:15px;border-radius:12px;margin-bottom:25px;color:#b40000;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}"  id="resetForm">

                    @csrf

                    <input
                        type="hidden"
                        name="email"
                        value="{{ $email }}"
                    >

                    <div class="form-group">

                        <label class="form-label">
                            New Password
                        </label>

                        <div class="password-box">

                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                required
                                minlength="6"
                            >

                            <span
                                class="toggle-password"
                                onclick="togglePassword('password',this)"
                            >
                                👁
                            </span>

                        </div>

                    </div>

                    

                    <div class="form-group">

                        <label class="form-label">
                            Confirm Password
                        </label>

                        <div class="password-box">

                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                            >

                            <span
                                class="toggle-password"
                                onclick="togglePassword('password_confirmation',this)"
                            >
                                👁
                            </span>

                        </div>

                    </div>

                    <div id="passwordStrength" style="margin-top:12px;"></div>

                    <div id="passwordRules" style="margin-top:15px;font-size:14px;line-height:28px;">

                        <div id="lengthRule">❌ At least 8 characters</div>
                        <div id="upperRule">❌ One uppercase letter (A-Z)</div>
                        <div id="lowerRule">❌ One lowercase letter (a-z)</div>
                        <div id="numberRule">❌ One number (0-9)</div>
                        <div id="specialRule">❌ One special character (!@#$%^&*)</div>

                    </div>

                    <button class="reset-btn mt-4">
                        Update Password
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

<script>

   function togglePassword(id, el) {

    let input = document.getElementById(id);

    if (input.type === "password") {
        input.type = "text";
        el.innerHTML = "🙈";
    } else {
        input.type = "password";
        el.innerHTML = "👁";
    }

}

const password = document.getElementById("password");
const strength = document.getElementById("passwordStrength");

password.addEventListener("keyup", function () {

    const value = this.value;

    const length = value.length >= 8;
    const upper = /[A-Z]/.test(value);
    const lower = /[a-z]/.test(value);
    const number = /[0-9]/.test(value);
    const special = /[!@#$%^&*(),.?":{}|<>]/.test(value);

    updateRule("lengthRule", length);
    updateRule("upperRule", upper);
    updateRule("lowerRule", lower);
    updateRule("numberRule", number);
    updateRule("specialRule", special);

    let score = 0;

    if (length) score++;
    if (upper) score++;
    if (lower) score++;
    if (number) score++;
    if (special) score++;

    if (value.length === 0) {

        strength.innerHTML = "";

    }
    else if (score <= 2) {

        strength.innerHTML =
            '<span style="color:#dc2626;font-weight:bold;">Weak Password</span>';

    }
    else if (score == 3 || score == 4) {

        strength.innerHTML =
            '<span style="color:#f59e0b;font-weight:bold;">Medium Password</span>';

    }
    else {

        strength.innerHTML =
            '<span style="color:#16a34a;font-weight:bold;">Strong Password ✓</span>';

    }

});

function updateRule(id, valid) {

    let el = document.getElementById(id);

    if (valid) {

        el.innerHTML = "✅ " + el.innerHTML.substring(2);
        el.style.color = "#16a34a";

    } else {

        el.innerHTML = "❌ " + el.innerHTML.substring(2);
        el.style.color = "#dc2626";

    }

}

document.getElementById("resetForm").addEventListener("submit", function (e) {

    const value = password.value;

    const valid =
        value.length >= 8 &&
        /[A-Z]/.test(value) &&
        /[a-z]/.test(value) &&
        /[0-9]/.test(value) &&
        /[!@#$%^&*(),.?":{}|<>]/.test(value);

    if (!valid) {

        e.preventDefault();

        Swal.fire({
            icon: 'error',
            title: 'Weak Password',
            text: 'Please create a strong password before continuing.'
        });

    }

});

</script>

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