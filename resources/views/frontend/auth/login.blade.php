<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Your Account</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }

        .header {
            background: #4e54c8;
            color: white;
            text-align: center;
            padding: 30px 20px;
        }

        .header h1 {
            font-weight: 600;
            font-size: 28px;
        }

        .header p {
            margin-top: 10px;
            opacity: 0.9;
        }

        .form-container {
            padding: 30px;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .input-group input {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border 0.3s;
        }

        .input-group input:focus {
            border-color: #4e54c8;
            outline: none;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 42px;
            color: #777;
            font-size: 18px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember input {
            width: 16px;
            height: 16px;
        }

        .forgot-password {
            color: #4e54c8;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-password:hover {
            color: #3a3fb8;
            text-decoration: underline;
        }

        .submit-btn {
            width: 100%;
            padding: 16px;
            background: #4e54c8;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            margin-bottom: 20px;
        }

        .submit-btn:hover {
            background: #3a3fb8;
        }

        .social-login {
            text-align: center;
            margin-bottom: 20px;
        }

        .social-login p {
            margin-bottom: 15px;
            color: #666;
            position: relative;
        }

        .social-login p::before,
        .social-login p::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background: #ddd;
        }

        .social-login p::before {
            left: 0;
        }

        .social-login p::after {
            right: 0;
        }

        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .social-icon:hover {
            transform: translateY(-3px);
        }

        .facebook {
            background: #3b5998;
        }

        .google {
            background: #dd4b39;
        }

        .twitter {
            background: #1da1f2;
        }

        .signup-link {
            text-align: center;
            color: #666;
        }

        .signup-link a {
            color: #4e54c8;
            text-decoration: none;
            font-weight: 500;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .social-login p::before,
            .social-login p::after {
                width: 25%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        @include('components.toast')
        <div class="header">
            <h1>Welcome Back</h1>
            <p>Sign in to continue to your account</p>
        </div>

        <div class="form-container">
            <form id="loginForm" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-forgot">
                    <div class="remember">
                        <input type="checkbox" id="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>

                <button type="submit" class="submit-btn">Sign In</button>

                <div class="social-login">
                    <p>Or sign in with</p>
                    <div class="social-icons">
                        <div class="social-icon facebook">
                            <i class="fab fa-facebook-f"></i>
                        </div>
                        <div class="social-icon google">
                            <i class="fab fa-google"></i>
                        </div>
                        <div class="social-icon twitter">
                            <i class="fab fa-twitter"></i>
                        </div>
                    </div>
                </div>

                <div class="signup-link">
                    Don't have an account? <a href="{{ route('register') }}">Sign Up</a>
                </div>
            </form>
        </div>
    </div>

    <script>

        // Add click events to social icons
        document.querySelectorAll('.social-icon').forEach(icon => {
            icon.addEventListener('click', function() {
                const platform = this.classList[1];
                alert(`Signing in with ${platform.charAt(0).toUpperCase() + platform.slice(1)}`);
            });
        });
    </script>
</body>

</html>
