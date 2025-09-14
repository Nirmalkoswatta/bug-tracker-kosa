@extends('layouts.app')

@section('content')
<style>
    /* Scoped login page container; global background now comes from layout */
    .login-page {
        min-height: calc(100vh - 80px);
        display: flex;
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
        color: #fff;
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

    .glass-card .input-group input {
        width: 100%;
        border-radius: 30px;
        border: 1.5px solid #fff;
        padding: 14px 48px 14px 44px;
        font-size: 1.08rem;
        background: rgba(255, 255, 255, 0.18);
        color: #fff;
        outline: none;
        transition: border 0.2s;
        box-shadow: none;
    }

    .glass-card .input-group input:focus {
        border: 1.5px solid #a18cd1;
        background: rgba(255, 255, 255, 0.28);
    }

    .glass-card .input-group .input-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #fff;
        font-size: 1.2em;
        opacity: 0.8;
    }

    .glass-card .form-check,
    .glass-card .forgot-link {
        color: #fff;
        font-size: 0.98em;
        display: inline-block;
    }

    .glass-card .forgot-link {
        float: right;
        margin-top: 2px;
    }

    .glass-card .btn-login {
        width: 100%;
        border-radius: 30px;
        background: #fff;
        color: #3a2e5c;
        font-weight: 600;
        font-size: 1.1em;
        border: none;
        padding: 13px 0;
        margin: 18px 0 10px 0;
        transition: background 0.2s;
        box-shadow: 0 2px 8px rgba(31, 38, 135, 0.08);
    }

    .glass-card .btn-login:hover {
        background: #f3f3f3;
    }

    .glass-card .links {
        text-align: center;
        margin-top: 10px;
        font-size: 1em;
        color: #fff;
    }

    .glass-card .links a {
        color: #fff;
        text-decoration: underline;
    }
</style>
<div class="login-page">
    <form method="POST" action="{{ route('login') }}" class="glass-card">
        <h2>Login</h2>
        @csrf
        <div class="input-group">
            <span class="input-icon"><i class="fa fa-envelope"></i></span>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email ID" class="@error('email') is-invalid @enderror">
            @error('email')
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
        <div class="input-group">
            <span class="input-icon"><i class="fa fa-users"></i></span>
            <select id="role" name="role" class="form-select" required style="padding-left:44px;">
                <option value="">Select Role</option>
                <option value="QA" {{ old('role') == 'QA' ? 'selected' : '' }}>QA</option>
                <option value="Dev" {{ old('role') == 'Dev' ? 'selected' : '' }}>Developer</option>
                <option value="PM" {{ old('role') == 'PM' ? 'selected' : '' }}>Project Manager</option>
                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')
            <span class="invalid-feedback d-block" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
        <div class="d-flex justify-content-between align-items-center w-100 mb-2">
            <div class="form-check" style="padding-left: 1.5em;">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            @if (Route::has('password.request'))
            <a class="forgot-link" href="{{ route('password.request') }}">Forgot Password?</a>
            @endif
        </div>
        <button type="submit" class="btn btn-login">Login</button>
        <div class="links">
            Don't have an account? <a href="{{ route('register') }}">Register</a>
        </div>
    </form>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
@endsection