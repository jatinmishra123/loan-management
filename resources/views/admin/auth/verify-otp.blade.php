<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Verify OTP - Admin Dashboard</title>
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

        .otp-animation {
            font-size: 4rem;
            margin-bottom: 2rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
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

        .otp-input-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .otp-input {
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            background: #f8f9fa;
            transition: all 0.3s;
        }

        .otp-input:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 0.2rem rgba(19, 136, 8, 0.25);
            background: white;
            transform: translateY(-2px);
        }

        .otp-input.filled {
            border-color: var(--green);
            background: rgba(19, 136, 8, 0.05);
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
            width: 100%;
        }

        .btn-primary:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(19, 136, 8, 0.3);
        }

        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-link a {
            color: var(--green);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .back-link a:hover {
            color: var(--dark-green);
        }

        .alert {
            border-radius: 8px;
            border: none;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: rgba(19, 136, 8, 0.1);
            color: var(--green);
        }

        .alert-info {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
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

        .timer {
            text-align: center;
            margin: 1rem 0;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .resend-otp {
            text-align: center;
            margin-top: 1rem;
        }

        .resend-otp a {
            color: var(--green);
            text-decoration: none;
            font-weight: 500;
        }

        .resend-otp a:hover {
            color: var(--dark-green);
        }

        .resend-otp a:disabled {
            color: #6c757d;
            cursor: not-allowed;
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

            .otp-animation {
                font-size: 3rem;
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-left-panel">
            <div class="auth-content">
                <div class="otp-animation">
                    <i class="mdi mdi-shield-lock-outline"></i>
                </div>
                <h1>Verify Your Identity</h1>
                <p>Enter the 6-digit verification code sent to your email address</p>
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
                        <h2>Verify OTP</h2>
                        <p>Enter the 6-digit OTP sent to your email</p>
                    </div>

                    @if (session('otp'))
                        <div class="alert alert-info">
                            <strong>OTP for testing:</strong> {{ session('otp') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('admin.verify-otp') }}" id="otpForm">
                        @csrf

                        <div class="otp-input-container">
                            <input type="text" class="otp-input" maxlength="1" data-index="1" autocomplete="off">
                            <input type="text" class="otp-input" maxlength="1" data-index="2" autocomplete="off">
                            <input type="text" class="otp-input" maxlength="1" data-index="3" autocomplete="off">
                            <input type="text" class="otp-input" maxlength="1" data-index="4" autocomplete="off">
                            <input type="text" class="otp-input" maxlength="1" data-index="5" autocomplete="off">
                            <input type="text" class="otp-input" maxlength="1" data-index="6" autocomplete="off">
                        </div>

                        <input type="hidden" name="otp" id="otpField">

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" id="verifyBtn">
                                Verify OTP
                            </button>
                        </div>

                        <div class="timer">
                            <span id="countdown">02:00</span>
                        </div>

                        <div class="resend-otp">
                            <a href="#" id="resendLink" onclick="resendOTP()">Resend OTP</a>
                        </div>

                        <div class="back-link">
                            <a href="{{ route('admin.forgot-password') }}">
                                <i class="mdi mdi-arrow-left me-1"></i> Back to Forgot Password
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/assets/js/app.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const otpInputs = document.querySelectorAll('.otp-input');
            const otpField = document.getElementById('otpField');
            const verifyBtn = document.getElementById('verifyBtn');
            const resendLink = document.getElementById('resendLink');
            const countdownElement = document.getElementById('countdown');

            let timer = 120; // 2 minutes in seconds
            let countdown;

            // Start the countdown timer
            function startTimer() {
                countdown = setInterval(function () {
                    timer--;
                    const minutes = Math.floor(timer / 60);
                    const seconds = timer % 60;
                    countdownElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                    if (timer <= 0) {
                        clearInterval(countdown);
                        resendLink.style.pointerEvents = 'auto';
                        resendLink.style.opacity = '1';
                    }
                }, 1000);
            }

            // Initialize timer
            startTimer();

            // Disable resend link initially
            resendLink.style.pointerEvents = 'none';
            resendLink.style.opacity = '0.5';

            // OTP input handling
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function (e) {
                    const value = e.target.value;

                    if (value.length === 1 && /[0-9]/.test(value)) {
                        // Move to next input
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }

                        // Update filled state
                        input.classList.add('filled');

                        // Update hidden field
                        updateOTPField();
                    } else if (value.length === 0) {
                        input.classList.remove('filled');
                    }
                });

                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });

                input.addEventListener('paste', function (e) {
                    e.preventDefault();
                    const pasteData = e.clipboardData.getData('text').slice(0, 6);
                    if (/^[0-9]+$/.test(pasteData)) {
                        pasteData.split('').forEach((char, charIndex) => {
                            if (charIndex < otpInputs.length) {
                                otpInputs[charIndex].value = char;
                                otpInputs[charIndex].classList.add('filled');
                            }
                        });
                        updateOTPField();
                        if (pasteData.length === 6) {
                            verifyBtn.focus();
                        } else {
                            otpInputs[pasteData.length].focus();
                        }
                    }
                });
            });

            function updateOTPField() {
                const otp = Array.from(otpInputs).map(input => input.value).join('');
                otpField.value = otp;

                // Enable/disable verify button based on OTP length
                verifyBtn.disabled = otp.length !== 6;
            }

            // Form submission
            document.getElementById('otpForm').addEventListener('submit', function (e) {
                const otp = otpField.value;
                if (otp.length !== 6 || !/^[0-9]+$/.test(otp)) {
                    e.preventDefault();
                    alert('Please enter a valid 6-digit OTP');
                }
            });
        });

        function resendOTP() {
            // In a real application, this would make an API call to resend OTP
            alert('OTP has been resent to your email!');

            // Reset timer
            clearInterval(countdown);
            timer = 120;
            startTimer();

            // Disable resend link
            const resendLink = document.getElementById('resendLink');
            resendLink.style.pointerEvents = 'none';
            resendLink.style.opacity = '0.5';

            // Clear OTP inputs
            const otpInputs = document.querySelectorAll('.otp-input');
            otpInputs.forEach(input => {
                input.value = '';
                input.classList.remove('filled');
            });
            document.getElementById('otpField').value = '';

            return false;
        }
    </script>
</body>

</html>