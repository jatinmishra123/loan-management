<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Forgot Password - Admin Dashboard</title>
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

        .btn-primary {
            background-color: var(--green);
            border-color: var(--green);
            height: 50px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s;
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

        @media (max-width: 992px) {
            .auth-container {
                flex-direction: column;
            }

            .auth-left-panel {
                min-height: 40vh;
            }

            .auth-right-panel {
                min-height: 60vh;
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-left-panel">
            <div class="auth-content">
                <h1>Reset Your Password</h1>
                <p>Enter your email address and we'll send you an OTP to reset your password.</p>
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
                        <h2>Forgot Password</h2>
                        <p>Enter your email to receive OTP</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('admin.send-otp') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" placeholder="Enter your email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary w-100" type="submit">
                                Send OTP
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
</body>

</html>