<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Reset Password - Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Admin Dashboard" name="description" />
    <meta content="Management" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/assets/images/favicon.ico') }}">
    <link href="{{ asset('assets/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        :root {
            --saffron: #FF9933;
            --white: #FFFFFF;
            --green: #138808;
            --dark-green: #0d6e03;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .auth-container {
            display: flex;
            min-height: 100vh;
        }

        .auth-left-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: linear-gradient(135deg, var(--saffron) 0%, var(--green) 100%);
            position: relative;
            overflow: hidden;
        }

        .auth-left-panel::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            animation: backgroundMove 20s linear infinite;
        }

        @keyframes backgroundMove {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(-50px, -50px);
            }
        }

        .auth-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
            max-width: 500px;
        }

        .auth-content h1 {
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }

        .auth-content p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .auth-right-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: white;
        }

        .auth-form-container {
            width: 100%;
            max-width: 400px;
        }

        .logo {
            display: block;
            margin-bottom: 2rem;
            text-align: center;
        }

        .logo img {
            max-height: 80px;
        }

        .auth-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            border: none;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header h2 {
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .auth-header p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #495057;
        }

        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #e1e5e9;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 0.2rem rgba(19, 136, 8, 0.25);
        }

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .password-strength.weak {
            color: #dc3545;
        }

        .password-strength.medium {
            color: #fd7e14;
        }

        .password-strength.strong {
            color: var(--green);
        }

        .btn-primary {
            background-color: var(--green);
            border-color: var(--green);
            height: 50px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(19, 136, 8, 0.3);
        }

        .back-to-login {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-to-login a {
            color: var(--green);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .back-to-login a:hover {
            color: var(--dark-green);
        }

        .alert {
            border-radius: 8px;
            border: none;
            padding: 0.75rem 1.25rem;
        }

        .alert-success {
            background-color: rgba(19, 136, 8, 0.1);
            color: var(--green);
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 38px;
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
        }

        @media (max-width: 992px) {
            .auth-container {
                flex-direction: column;
            }

            .auth-left-panel {
                min-height: 30vh;
                padding: 1.5rem;
            }

            .auth-right-panel {
                min-height: 70vh;
                padding: 1.5rem;
            }

            .auth-content h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-left-panel">
            <div class="auth-content">
                <h1>Set New Password</h1>
                <p>Create a strong password to secure your account</p>
            </div>
        </div>

        <div class="auth-right-panel">
            <div class="auth-form-container">
                <div class="logo">
                    <a href="{{ route('admin.login') }}">
                        <img src="{{ asset(path: 'assets/assets/images/users/reset.jpg') }}" alt="logo">
                    </a>
                </div>

                <div class="auth-card">
                    <div class="auth-header">
                        <h2>Reset Password</h2>
                        <p>Enter your new password</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('admin.reset-password') }}">
                        @csrf
                        <div class="form-group">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Enter new password" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="mdi mdi-eye-outline"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="password-strength" id="passwordStrength"></div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirm new password" required>
                            <button type="button" class="password-toggle" id="toggleConfirmPassword">
                                <i class="mdi mdi-eye-outline"></i>
                            </button>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">
                                Reset Password
                            </button>
                        </div>

                        <div class="back-to-login">
                            <a href="{{ route('admin.login') }}">
                                <i class="mdi mdi-arrow-left me-1"></i> Back to Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/assets/js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const passwordStrength = document.getElementById('passwordStrength');

            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                this.querySelector('i').classList.toggle('mdi-eye-outline');
                this.querySelector('i').classList.toggle('mdi-eye-off-outline');
            });

            toggleConfirmPassword.addEventListener('click', function () {
                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPassword.setAttribute('type', type);
                this.querySelector('i').classList.toggle('mdi-eye-outline');
                this.querySelector('i').classList.toggle('mdi-eye-off-outline');
            });

            // Password strength indicator
            password.addEventListener('input', function () {
                const value = password.value;
                let strength = 'Weak';
                let strengthClass = 'weak';

                if (value.length >= 8) {
                    const hasUpperCase = /[A-Z]/.test(value);
                    const hasLowerCase = /[a-z]/.test(value);
                    const hasNumbers = /\d/.test(value);
                    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(value);

                    let score = 0;
                    if (hasUpperCase) score++;
                    if (hasLowerCase) score++;
                    if (hasNumbers) score++;
                    if (hasSpecialChar) score++;

                    if (score >= 3 && value.length >= 10) {
                        strength = 'Strong';
                        strengthClass = 'strong';
                    } else if (score >= 2) {
                        strength = 'Medium';
                        strengthClass = 'medium';
                    }
                }

                if (value.length === 0) {
                    passwordStrength.textContent = '';
                    passwordStrength.className = 'password-strength';
                } else {
                    passwordStrength.textContent = `Password strength: ${strength}`;
                    passwordStrength.className = `password-strength ${strengthClass}`;
                }
            });
        });
    </script>
</body>

</html>