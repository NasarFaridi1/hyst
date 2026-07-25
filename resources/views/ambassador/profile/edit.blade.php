@extends('layouts.app')

@section('content')

<style>
    :root {
        --cream:     #F6F1E8;
        --cream2:    #EDE5D4;
        --cream3:    #E0D5C0;
        --terra:     #C25A2A;
        --terra-l:   #D97040;
        --terra-d:   #8C3D1A;
        --terra-bg:  rgba(194,90,42,0.08);
        --terra-bg2: rgba(194,90,42,0.14);
        --ink:       #1A1208;
        --ink2:      #2E2318;
        --muted:     #8A7A62;
        --muted2:    #6B5C46;
        --green:     #3D8C5A;
        --green-bg:  rgba(61,140,90,0.1);
        --red:       #C23A2A;
        --red-bg:    rgba(194,58,42,0.08);
        --blue:      #2A6CC2;
        --blue-bg:   rgba(42,108,194,0.08);
        --border:    rgba(194,90,42,0.12);
        --border2:   rgba(194,90,42,0.22);
        --shadow:    0 2px 16px rgba(26,18,8,0.08);
        --shadow2:   0 8px 32px rgba(26,18,8,0.12);
        --ease:      cubic-bezier(0.16,1,0.3,1);
    }

    .amb-wrap * { box-sizing: border-box; }

    .amb-wrap {
        background: var(--cream);
        min-height: 100%;
        padding: 32px 8px;
        border-radius: 18px;
    }

    .amb-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 14px;
    }

    .amb-header h2 {
        color: var(--ink);
        font-weight: 700;
        margin-bottom: 2px;
        letter-spacing: -0.02em;
        font-size: 1.4rem;
    }

    .amb-header p {
        color: var(--muted2);
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    .btn-terra-outline {
        background: #fff;
        border: 1px solid var(--border2);
        color: var(--terra-d);
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 10px;
        transition: background .2s var(--ease), border-color .2s var(--ease), transform .2s var(--ease);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-terra-outline:hover {
        background: var(--terra-bg);
        border-color: var(--terra);
        color: var(--terra-d);
        transform: translateY(-1px);
    }

    .btn-terra {
        background: var(--terra);
        border: 1px solid var(--terra);
        color: #fff;
        font-weight: 600;
        padding: 11px 26px;
        border-radius: 10px;
        transition: background .2s var(--ease), transform .2s var(--ease), box-shadow .2s var(--ease);
        box-shadow: var(--shadow);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-terra:hover {
        background: var(--terra-l);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: var(--shadow2);
    }

    .btn-terra svg, .btn-terra-outline svg{ width:16px; height:16px; }

    .amb-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: var(--shadow);
    }

    .amb-card-body {
        padding: 32px;
    }

    .amb-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--cream3);
        box-shadow: var(--shadow);
    }

    .amb-form-label {
        color: var(--muted2);
        font-weight: 600;
        font-size: 0.88rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 6px;
        display: block;
    }

    .amb-form-control {
        background: var(--cream);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 11px 14px;
        color: var(--ink);
        font-size: 0.98rem;
        transition: border-color .2s var(--ease), box-shadow .2s var(--ease), background .2s var(--ease);
        width: 100%;
    }

    .amb-form-control:focus {
        outline: none;
        border-color: var(--terra);
        background: #fff;
        box-shadow: 0 0 0 3px var(--terra-bg);
    }

    .amb-form-control[readonly] {
        background: var(--cream2);
        color: var(--muted2);
        cursor: not-allowed;
    }

    .amb-form-control[type="file"] {
        padding: 8px 14px;
    }

    .amb-field {
        margin-bottom: 18px;
    }

    .amb-error {
        color: var(--red);
        font-size: 0.82rem;
        margin-top: 4px;
        display: block;
    }

    .amb-divider {
        border: none;
        border-top: 1px solid var(--border);
        margin: 28px 0 20px;
    }

    .amb-section-title {
        color: var(--terra-d);
        font-weight: 700;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .amb-section-title::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--terra);
        display: inline-block;
    }

    .amb-hint {
        color: var(--muted);
        font-size: 0.82rem;
        margin-top: 6px;
    }
</style>

<div class="amb-wrap">

    <div class="amb-header">
        <div>
            <h2>Edit Profile</h2>
            <p>Update your profile information</p>
        </div>

        <a href="{{ route('ambassador.profile.index') }}" class="btn-terra-outline">
            <i data-lucide="arrow-left"></i>
            Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12">

        <div class="lg:col-span-8 lg:col-start-3">

            <div class="amb-card">
                <div class="amb-card-body">

                    <form action="{{ route('ambassador.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-4">
                            @if($user->profile_image)
                                <img src="{{ asset('storage/'.$user->profile_image) }}" class="amb-avatar mx-auto">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=150&background=C25A2A&color=fff" class="amb-avatar mx-auto">
                            @endif
                        </div>

                        <div class="amb-field">
                            <label class="amb-form-label">Full Name</label>
                            <input type="text" name="name" value="{{ old('name',$user->name) }}" class="amb-form-control">
                            @error('name')
                                <small class="amb-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="amb-field">
                            <label class="amb-form-label">Email</label>
                            <input type="email" value="{{ $user->email }}" class="amb-form-control" readonly>
                        </div>

                        <div class="amb-field">
                            <label class="amb-form-label">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone',$user->phone) }}" class="amb-form-control">
                            @error('phone')
                                <small class="amb-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="amb-field">
                            <label class="amb-form-label">Profile Image</label>
                            <input type="file" name="profile_image" class="amb-form-control">
                            <div class="amb-hint">JPG or PNG, square image recommended.</div>
                            @error('profile_image')
                                <small class="amb-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <hr class="amb-divider">

                        <h5 class="amb-section-title">Change Password</h5>

                        <div class="amb-field">
                            <label class="amb-form-label">New Password</label>
                            <input type="password" name="password" class="amb-form-control">
                            @error('password')
                                <small class="amb-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="amb-field" style="margin-bottom:24px;">
                            <label class="amb-form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="amb-form-control">
                        </div>

                        <button type="submit" class="btn-terra">
                            <i data-lucide="save"></i>
                            Update Profile
                        </button>

                    </form>

                </div>
            </div>

        </div>

    </div>

</div>

<script>
    if (window.lucide) { lucide.createIcons(); }
</script>

@endsection