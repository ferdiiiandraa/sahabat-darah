<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahabat Darah - Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .register-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }
        .left-side {
            width: 40%;
            background-color: #b30000;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
        }
        .left-side::before {
            content: '';
            position: absolute;
            top: -20%;
            left: -20%;
            width: 140%;
            height: 140%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            z-index: 1;
        }
        .left-side::after {
            content: '';
            position: absolute;
            bottom: -30%;
            right: -30%;
            width: 80%;
            height: 80%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            z-index: 1;
        }
        .logo {
            font-size: 48px;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }
        .right-side {
            width: 60%;
            background-color: white;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
        }
        .form-title {
            font-size: 32px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        .form-subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }
        .form-group {
            flex: 1;
        }
        .form-label {
            display: block;
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        .password-field {
            position: relative;
        }
        .eye-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
        .terms-checkbox {
            display: flex;
            align-items: center;
            margin: 20px 0;
            font-size: 14px;
            color: #666;
        }
        .terms-checkbox input {
            margin-right: 10px;
        }
        .terms-link {
            color: #b30000;
            text-decoration: none;
            margin: 0 5px;
        }
        .create-account-btn {
            background-color: #b30000;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            margin: 20px 0;
        }
        .login-link {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-top: 20px;
        }
        .login-link a {
            color: #b30000;
            text-decoration: none;
            font-weight: 500;
        }
        .or-divider {
            text-align: center;
            position: relative;
            margin: 20px 0;
        }
        .or-divider::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background-color: #ddd;
        }
        .or-divider::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            width: 45%;
            height: 1px;
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Left side with logo and design elements -->
        <div class="left-side">
            <div class="logo">Sahabat<br>Darah</div>
        </div>
        
        <!-- Right side with registration form -->
        <div class="right-side">
            <h1 class="form-title">Sign up</h1>
            <p class="form-subtitle">Let's get you all set up so you can access your personal account.</p>
            
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group mb-4">
                    <label class="form-label">Nama Instansi</label>
                    <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" class="form-input" value="{{ old('phone') }}" required>
                        @error('phone')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                

                

                
                <div class="form-group mb-4">
                    <label class="form-label">Password</label>
                    <div class="password-field">
                        <input type="password" name="password" class="form-input" required>
                        <span class="eye-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                        </span>
                    </div>
                    @error('password')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group mb-4">
                    <label class="form-label">Confirm Password</label>
                    <div class="password-field">
                        <input type="password" name="password_confirmation" class="form-input" required>
                        <span class="eye-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                        </span>
                    </div>
                </div>
                
                <div class="form-group mb-4">
                    <label class="form-label">Role</label>
                    <select name="role" id="role-select" class="form-input" required>
                        <option value="">Select your role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" data-slug="{{ $role->slug }}" {{ old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" id="document-label">Upload Document</label>
                    <input type="file" name="document" class="form-input" required>
                    <input type="hidden" name="document_type" id="document_type" value="identification">
                    <p class="text-xs text-gray-500 mt-1" id="document-help-text">Upload your identification document (PDF, JPG, PNG format)</p>
                    @error('document')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">I agree to all the <a href="#" class="terms-link">Terms</a> and <a href="#" class="terms-link">Privacy Policies</a></label>
                </div>
                
                <button type="submit" class="create-account-btn">Create account</button>
                
                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Login</a>
                </div>
                
                <div class="or-divider">
                    <span>Or Sign up with</span>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.eye-icon').forEach(icon => {
            icon.addEventListener('click', function() {
                const input = this.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                } else {
                    input.type = 'password';
                }
            });
        });
        
        // Update document upload field based on selected role
        const roleSelect = document.getElementById('role-select');
        const documentLabel = document.getElementById('document-label');
        const documentHelpText = document.getElementById('document-help-text');
        const documentTypeField = document.getElementById('document_type');
        
        roleSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const roleSlug = selectedOption.getAttribute('data-slug');
            
            if (roleSlug === 'admin-rs') {
                documentLabel.textContent = 'Upload Hospital License';
                documentHelpText.textContent = 'Upload your hospital license document (PDF, JPG, PNG format)';
                documentTypeField.value = 'hospital_license';
            } else if (roleSlug === 'admin-pmi') {
                documentLabel.textContent = 'Upload PMI ID Card';
                documentHelpText.textContent = 'Upload your PMI identification card (PDF, JPG, PNG format)';
                documentTypeField.value = 'pmi_id_card';
            } else {
                documentLabel.textContent = 'Upload Document';
                documentHelpText.textContent = 'Upload your identification document (PDF, JPG, PNG format)';
                documentTypeField.value = 'identification';
            }
        });
        
        // Run on page load
        const selectedOption = roleSelect.options[roleSelect.selectedIndex];
        const roleSlug = selectedOption.getAttribute('data-slug');
            
        if (roleSlug === 'admin-rs') {
            documentLabel.textContent = 'Upload Hospital License';
            documentHelpText.textContent = 'Upload your hospital license document (PDF, JPG, PNG format)';
            documentTypeField.value = 'hospital_license';
        } else if (roleSlug === 'admin-pmi') {
            documentLabel.textContent = 'Upload PMI ID Card';
            documentHelpText.textContent = 'Upload your PMI identification card (PDF, JPG, PNG format)';
            documentTypeField.value = 'pmi_id_card';
        } else {
            documentLabel.textContent = 'Upload Document';
            documentHelpText.textContent = 'Upload your identification document (PDF, JPG, PNG format)';
            documentTypeField.value = 'identification';
        }
    </script>
</body>
</html>
