@extends('frontend.layout.main')
@section('content')
<style>
        .login-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 4rem 0;
            background: linear-gradient(135deg, var(--color-dark-navy) 0%, var(--color-navy-light) 100%);
            position: relative;
            overflow: hidden;
        }

        .login-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -25%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.1) 0%, transparent 70%);
            animation: float 20s ease-in-out infinite;
        }

        .login-container {
            position: relative;
            z-index: 2;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(245, 158, 11, 0.2);
            border-radius: var(--border-radius-premium);
            backdrop-filter: blur(20px);
            box-shadow: var(--shadow-premium);
            overflow: hidden;
            max-width: 500px;
            margin: 0 auto;
        }

        .login-header {
            background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-dark) 100%);
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .login-header h1 {
            color: var(--color-dark-navy);
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: rgba(13, 13, 30, 0.8);
            font-size: 1rem;
        }

        .login-body {
            padding: 2.5rem 2rem;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }
    </style>

<section class="login-section">
    <div class="premium-container login-container">
        <div class="login-card premium-fade-in">
            <div class="login-header">
                <h1><i class="fas fa-lock me-2"></i>Welcome Back</h1>
                <p>Sign in to continue to your account</p>
            </div>

            <div class="login-body">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <div class="premium-form-group">
                        <label for="email" class="premium-form-label">
                            <i class="fas fa-envelope me-2 text-accent"></i>Email Address
                        </label>
                        <input type="email" id="email" name="email" class="premium-form-input" 
                            value="{{ old('email') }}" placeholder="Enter your email" required>
                        @error('email')
                            <span class="error-message"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="premium-form-group">
                        <label for="password" class="premium-form-label">
                            <i class="fas fa-key me-2 text-accent"></i>Password
                        </label>
                        <input type="password" id="password" name="password" class="premium-form-input" 
                            placeholder="Enter your password" required>
                        @error('password')
                            <span class="error-message"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input type="checkbox" id="remember" name="remember" class="form-check-input">
                            <label for="remember" class="form-check-label text-dim">Remember me</label>
                        </div>
                        <a href="#" class="text-accent" style="text-decoration: none; font-weight: 600;">
                            Forgot Password?
                        </a>
                    </div>

                    <button type="submit" class="btn-premium btn-premium-primary w-100 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                    </button>

                    <div class="text-center">
                        <p class="text-dim mb-3">Or sign in with</p>
                        <div class="d-flex gap-2 justify-content-center mb-4">
                            <button type="button" class="btn-premium btn-premium-secondary" style="flex: 1;">
                                <i class="fab fa-google me-2"></i>Google
                            </button>
                            <button type="button" class="btn-premium btn-premium-secondary" style="flex: 1;">
                                <i class="fab fa-facebook-f me-2"></i>Facebook
                            </button>
                        </div>
                    </div>

                    <div class="text-center">
                        <p class="text-dim">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="text-accent" style="text-decoration: none; font-weight: 700;">
                                Sign Up <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection
