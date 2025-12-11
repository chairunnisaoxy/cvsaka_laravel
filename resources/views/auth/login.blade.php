<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem - CV Saka Pratama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #e74c3c;
            --accent: #3498db;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: auto;
            padding: 20px;
        }

        /* Background Elements */
        .bg-shape-1 {
            position: fixed;
            top: -100px;
            right: -100px;
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            opacity: 0.05;
            animation: float 8s ease-in-out infinite;
            z-index: 1;
        }

        .bg-shape-2 {
            position: fixed;
            bottom: -150px;
            left: -150px;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            border-radius: 50%;
            opacity: 0.03;
            animation: float 10s ease-in-out infinite reverse;
            z-index: 1;
        }

        .bg-shape-3 {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border-radius: 50%;
            opacity: 0.02;
            animation: pulse 15s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: translate(-50%, -50%) scale(1);
            }

            50% {
                transform: translate(-50%, -50%) scale(1.1);
            }
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 20px;
            margin: auto;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.08),
                0 15px 35px rgba(0, 0, 0, 0.05),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.5);
            overflow: hidden;
            position: relative;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .login-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow:
                0 35px 70px rgba(0, 0, 0, 0.12),
                0 25px 45px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary), var(--accent), var(--primary));
            background-size: 200% 100%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary), #34495e);
            color: white;
            padding: 40px 30px 30px;
            text-align: center;
            position: relative;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
        }

        .logo {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .logo i {
            font-size: 1.8rem;
            color: white;
        }

        .login-header h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-header p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0;
            font-weight: 300;
        }

        .login-body {
            padding: 40px 35px 35px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 10px;
            font-size: 0.9rem;
            display: block;
        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            padding: 15px 20px 15px 50px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: #fff;
            height: 55px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .input-group .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.15);
            background: #fff;
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 3;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .input-group .form-control:focus+.input-icon {
            color: var(--accent);
            transform: translateY(-50%) scale(1.1);
        }

        .btn-login {
            background: linear-gradient(135deg, var(--secondary), #c0392b);
            border: none;
            border-radius: 12px;
            padding: 16px 30px;
            font-weight: 600;
            color: white;
            font-size: 1rem;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.4);
            background: linear-gradient(135deg, #c0392b, var(--secondary));
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .btn-login i {
            margin-right: 8px;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            background: rgba(231, 76, 60, 0.1);
            color: #c0392b;
            border-left: 4px solid #e74c3c;
            box-shadow: 0 2px 10px rgba(231, 76, 60, 0.1);
        }

        .alert-success {
            background: rgba(46, 204, 113, 0.1);
            color: #27ae60;
            border-left: 4px solid #2ecc71;
            box-shadow: 0 2px 10px rgba(46, 204, 113, 0.1);
        }

        .info-box {
            background: rgba(52, 152, 219, 0.1);
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 25px;
            font-size: 0.85rem;
            color: #2980b9;
            border-left: 4px solid #3498db;
            box-shadow: 0 2px 10px rgba(52, 152, 219, 0.1);
        }

        .info-box i {
            margin-right: 8px;
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .login-footer a {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .login-footer a:hover {
            color: var(--accent);
        }

        .login-footer i {
            margin-right: 6px;
            font-size: 0.8rem;
        }

        /* Password toggle */
        .password-toggle {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            z-index: 4;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--accent);
        }

        /* Responsive */
        @media (max-width: 480px) {
            body {
                padding: 10px;
                display: block;
                height: auto;
                min-height: 100vh;
                align-items: flex-start;
            }

            .login-container {
                padding: 10px;
                margin: 20px auto;
            }

            .login-body {
                padding: 30px 25px 25px;
            }

            .login-header {
                padding: 30px 25px 25px;
            }

            .bg-shape-1,
            .bg-shape-2,
            .bg-shape-3 {
                display: none;
            }

            .login-card:hover {
                transform: none;
            }
        }

        @media (max-width: 768px) and (min-width: 481px) {
            body {
                padding: 15px;
            }
        }

        /* Loading animation for button */
        .btn-loading {
            position: relative;
            color: transparent;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-right-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <!-- Background Shapes -->
    <div class="bg-shape-1"></div>
    <div class="bg-shape-2"></div>
    <div class="bg-shape-3"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <i class="fas fa-cash-register"></i>
                </div>
                <h4>Login Sistem</h4>
                <p>Sistem Penggajian CV Saka Pratama</p>
            </div>

            <div class="login-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif

                <div class="info-box">
                    <i class="fas fa-info-circle"></i>
                    Hanya <strong>Pemilik</strong> dan <strong>Supervisor</strong> yang dapat mengakses sistem ini.
                </div>

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <i class="input-icon fas fa-envelope"></i>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                placeholder="masukkan email Anda" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <i class="input-icon fas fa-lock"></i>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="masukkan password Anda" required>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login" id="loginBtn">
                        <i class="fas fa-sign-in-alt"></i> Masuk ke Sistem
                    </button>
                </form>

                <div class="login-footer">
                    <a href="{{ route('landing') }}">
                        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Button loading effect
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            btn.classList.add('btn-loading');
            btn.disabled = true;
            btn.innerHTML = ''; // Clear text
        });

        // Password toggle visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle icon
            const icon = this.querySelector('i');
            if (type === 'password') {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });

        // Add focus effects
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            const icon = input.previousElementSibling;

            input.addEventListener('focus', function() {
                icon.style.color = '#3498db';
                icon.style.transform = 'translateY(-50%) scale(1.1)';
            });

            input.addEventListener('blur', function() {
                if (!this.value) {
                    icon.style.color = '#6c757d';
                    icon.style.transform = 'translateY(-50%)';
                }
            });

            // Check initial value
            if (input.value) {
                icon.style.color = '#3498db';
                icon.style.transform = 'translateY(-50%) scale(1.1)';
            }
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            });
        }, 5000);
    </script>
</body>

</html>
