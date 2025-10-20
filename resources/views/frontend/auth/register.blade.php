<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Account</title>
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
            max-width: 500px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
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
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 14px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border 0.3s;
        }

        .input-group input:focus,
        .input-group select:focus {
            border-color: #4e54c8;
            outline: none;
        }

        .name-fields {
            display: flex;
            gap: 15px;
        }

        .name-fields .input-group {
            flex: 1;
        }

        .user-type {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .user-option {
            flex: 1;
            text-align: center;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-option:hover {
            background: #f9f9f9;
        }

        .user-option.selected {
            border-color: #4e54c8;
            background: rgba(78, 84, 200, 0.1);
        }

        .user-option i {
            font-size: 24px;
            margin-bottom: 10px;
            color: #4e54c8;
        }

        .picture-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px 0;
        }

        .picture-upload .preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #f1f1f1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .picture-upload .preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .picture-upload .preview i {
            font-size: 40px;
            color: #999;
        }

        .picture-upload label {
            padding: 12px 20px;
            background: #f1f1f1;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .picture-upload label:hover {
            background: #e1e1e1;
        }

        .picture-upload input[type="file"] {
            display: none;
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
        }

        .submit-btn:hover {
            background: #3a3fb8;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }

        .login-link a {
            color: #4e54c8;
            text-decoration: none;
            font-weight: 500;
        }

        @media (max-width: 600px) {
            .name-fields {
                flex-direction: column;
                gap: 0;
            }

            .user-type {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        @include('components.toast')
        <div class="header">
            <h1>Create Your Account</h1>
            <p>Join our community today</p>
        </div>

        <div class="form-container">
            <form id="registrationForm" enctype="multipart/form-data" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="name-fields">
                    <div class="input-group">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstName" value="{{ old('firstName') }}" required>
                        @error('firstName')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" value="{{ old('lastName') }}" required>
                        @error('lastName')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

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

                <div class="input-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label>I am a:</label>
                    <div class="user-type">
                        <div class="user-option" data-value="customer">
                            <i class="fas fa-user"></i>
                            <div>Customer</div>
                        </div>
                        <div class="user-option" data-value="retailer">
                            <i class="fas fa-store"></i>
                            <div>Retailer</div>
                        </div>
                    </div>
                    <input type="hidden" id="userType" name="userType" value="{{ old('userType') }}" required>
                    @error('userType')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group">
                    <label>Profile Picture</label>
                    <div class="picture-upload">
                        <div class="preview">
                            <i class="fas fa-user"></i>
                            <img id="previewImg" src="" alt="Preview">
                        </div>
                        <label for="picture">
                            <i class="fas fa-upload"></i> Choose Image
                        </label>
                        <input type="file" id="picture" name="avatar" accept="image/*">
                    </div>
                    @error('avatar')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-btn">Create Account</button>

                <div class="login-link">
                    Already have an account? <a href="#">Log In</a>
                </div>
            </form>
        </div>

    </div>

    <script>
        // User type selection
        const userOptions = document.querySelectorAll('.user-option');
        const userTypeInput = document.getElementById('userType');

        userOptions.forEach(option => {
            option.addEventListener('click', () => {
                userOptions.forEach(op => op.classList.remove('selected'));
                option.classList.add('selected');
                userTypeInput.value = option.getAttribute('data-value');
            });
        });

        // Image preview
        const pictureInput = document.getElementById('picture');
        const previewImg = document.getElementById('previewImg');
        const previewIcon = document.querySelector('.preview i');

        pictureInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.addEventListener('load', function() {
                    previewImg.src = reader.result;
                    previewImg.style.display = 'block';
                    previewIcon.style.display = 'none';
                });

                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>
