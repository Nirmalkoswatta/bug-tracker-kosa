@extends('layouts.app')

@section('content')
<style>
    /* Unified background comes from layout; center content similarly to login */
    .login-page {
        /* reuse existing login page class styling from login view */
        min-height: calc(100vh - 80px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 16px 60px;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.13);
        border-radius: 18px;
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.18);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 2px solid rgba(255, 255, 255, 0.18);
        padding: 38px 36px 28px 36px;
        width: 370px;
        max-width: 95vw;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .glass-card h2 {
        color: #111;
        /* make heading black */
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 32px;
        text-align: center;
        letter-spacing: 1px;
    }

    .glass-card .input-group {
        width: 100%;
        margin-bottom: 22px;
        position: relative;
    }

    .glass-card .input-group input,
    .glass-card .input-group select {
        width: 100%;
        border-radius: 30px;
        border: 2px solid #000;
        /* black border */
        padding: 14px 48px 14px 44px;
        font-size: 1.08rem;
        background: #fff;
        /* solid white for clarity */
        color: #111;
        outline: none;
        transition: border 0.2s, background 0.2s;
        box-shadow: none;
        appearance: none;
    }

    .glass-card .input-group select option {
        color: #111;
    }

    .glass-card .input-group input:focus,
    .glass-card .input-group select:focus {
        border: 2px solid #000;
        background: #f8f8f8;
    }

    .glass-card .input-group .input-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #111;
        /* icon black */
        font-size: 1.2em;
        opacity: 0.75;
    }

    .glass-card .btn-signup {
        width: 100%;
        border-radius: 30px;
        background: #111;
        color: #fff;
        font-weight: 600;
        font-size: 1.1em;
        border: 2px solid #000;
        /* black border */
        padding: 13px 0;
        margin: 18px 0 10px 0;
        transition: background 0.2s, color 0.2s;
        box-shadow: 0 2px 8px rgba(31, 38, 135, 0.08);
    }

    .glass-card .btn-signup:hover {
        background: #000;
        color: #fff;
    }

    .glass-card .links {
        text-align: center;
        margin-top: 10px;
        font-size: 1em;
        color: #111;
        /* black */
    }

    .glass-card .links a {
        color: #111;
        font-weight: 600;
        text-decoration: underline;
    }
</style>
<div class="login-page">
    <form method="POST" action="{{ route('register') }}" class="glass-card">
        <h2 style="color:#111;">Register</h2>
        @csrf
        <div class="input-group">
            <span class="input-icon"><i class="fa fa-user"></i></span>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Name" class="@error('name') is-invalid @enderror">
            @error('name')
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class="input-group">
            <span class="input-icon"><i class="fa fa-envelope"></i></span>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="Email" class="@error('email') is-invalid @enderror">
            @error('email')
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class="input-group">
            <span class="input-icon"><i class="fa fa-users"></i></span>
            <select id="role" name="role" class="@error('role') is-invalid @enderror" required>
                <option value="">Register As...</option>
                <option value="QA" {{ old('role') == 'QA' ? 'selected' : '' }}>QA</option>
                <option value="Dev" {{ old('role') == 'Dev' ? 'selected' : '' }}>Developer</option>
                <option value="PM" {{ old('role') == 'PM' ? 'selected' : '' }}>Project Manager</option>
            </select>
            @error('role')
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class="input-group position-relative">
            <span class="input-icon"><i class="fa fa-lock"></i></span>
            <input id="password" type="password" name="password" required placeholder="Password" class="@error('password') is-invalid @enderror" oninput="showEyeIcon('password-eye', this)">
            <button id="password-eye" type="button" onclick="togglePassword('password', this)" tabindex="-1" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; color:#333; font-size:1.2em; display:none;">
                <i class="fa fa-eye"></i>
            </button>
            @error('password')
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class="input-group position-relative">
            <span class="input-icon"><i class="fa fa-lock"></i></span>
            <input id="password-confirm" type="password" name="password_confirmation" required placeholder="Confirm Password" oninput="showEyeIcon('password-confirm-eye', this)">
            <button id="password-confirm-eye" type="button" onclick="togglePassword('password-confirm', this)" tabindex="-1" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; color:#333; font-size:1.2em; display:none;">
                <i class="fa fa-eye"></i>
            </button>
        </div>
        @push('scripts')
        <script>
            function togglePassword(id, btn) {
                const input = document.getElementById(id);
                if (input.type === 'password') {
                    input.type = 'text';
                    btn.innerHTML = '<i class="fa fa-eye-slash"></i>';
                } else {
                    input.type = 'password';
                    btn.innerHTML = '<i class="fa fa-eye"></i>';
                }
            }

            function showEyeIcon(eyeId, input) {
                const eyeBtn = document.getElementById(eyeId);
                if (input.value.length > 0) {
                    eyeBtn.style.display = 'block';
                } else {
                    eyeBtn.style.display = 'none';
                }
            }
        </script>
        @endpush
        <button type="submit" class="btn btn-signup">Sign Up</button>
    </form>
    <div class="links" style="text-align:center; margin-top:18px; font-size:1.05em; color:#111; width:100%;">
        Have an Account? <a href="{{ route('login') }}" style="color:#111; text-decoration:underline; font-weight:600;">Login Here</a>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
@endsection