<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Logout - CV Saka Pratama</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">


    <!-- Bootstrap 5 -->
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

        .logout-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 20px;
            margin: auto;
        }

        .logout-card {
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

        .logout-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow:
                0 35px 70px rgba(0, 0, 0, 0.12),
                0 25px 45px rgba(0, 0, 0, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
        }

        .logout-card::before {
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

        .logout-header {
            background: linear-gradient(135deg, var(--primary), #34495e);
            color: white;
            padding: 40px 30px 30px;
            text-align: center;
            position: relative;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        .logout-header::after {
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

        .logout-header h4 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .logout-header p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0;
            font-weight: 300;
        }

        .logout-body {
            padding: 40px 35px 35px;
            text-align: center;
        }

        .logout-icon {
            font-size: 4rem;
            color: #e74c3c;
            margin-bottom: 25px;
            animation: pulse-icon 2s ease-in-out infinite;
        }

        @keyframes pulse-icon {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .logout-message {
            color: #2c3e50;
            margin-bottom: 10px;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .logout-detail {
            color: #7f8c8d;
            margin-bottom: 30px;
            line-height: 1.6;
            font-size: 0.95rem;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 25px;
        }

        .btn {
            padding: 16px 25px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-cancel {
            background: linear-gradient(135deg, #95a5a6, #7f8c8d);
            color: white;
        }

        .btn-cancel:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(149, 165, 166, 0.4);
            background: linear-gradient(135deg, #7f8c8d, #95a5a6);
            color: white;
        }

        .btn-logout {
            background: linear-gradient(135deg, var(--secondary), #c0392b);
            color: white;
        }

        .btn-logout:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(231, 76, 60, 0.4);
            background: linear-gradient(135deg, #c0392b, var(--secondary));
            color: white;
        }

        .logout-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .logout-footer a {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .logout-footer a:hover {
            color: var(--accent);
        }

        .logout-footer i {
            margin-right: 6px;
            font-size: 0.8rem;
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

        /* User info box */
        .user-info {
            background: rgba(52, 152, 219, 0.1);
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 25px;
            font-size: 0.9rem;
            color: #2980b9;
            border-left: 4px solid #3498db;
            box-shadow: 0 2px 10px rgba(52, 152, 219, 0.1);
            text-align: left;
        }

        .user-info strong {
            display: block;
            font-size: 1rem;
            margin-bottom: 5px;
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

            .logout-container {
                padding: 10px;
                margin: 20px auto;
            }

            .logout-body {
                padding: 30px 25px 25px;
            }

            .logout-header {
                padding: 30px 25px 25px;
            }

            .button-group {
                flex-direction: column;
            }

            .bg-shape-1,
            .bg-shape-2,
            .bg-shape-3 {
                display: none;
            }

            .logout-card:hover {
                transform: none;
            }
        }

        @media (max-width: 768px) and (min-width: 481px) {
            body {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <!-- Background Shapes -->
    <div class="bg-shape-1"></div>
    <div class="bg-shape-2"></div>
    <div class="bg-shape-3"></div>

    <div class="logout-container">
        <div class="logout-card">
            <div class="logout-header">
                <div class="logo">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <h4>Konfirmasi Logout</h4>
                <p>Sistem Penggajian CV Saka Pratama</p>
            </div>

            <div class="logout-body">

                <div class="logout-icon">
                    <i class="fas fa-door-open"></i>
                </div>

                <h5 class="logout-message">Yakin ingin keluar dari sistem?</h5>
                <p class="logout-detail">
                    Anda akan logout dari akun Anda dan harus login kembali untuk mengakses sistem penggajian.
                </p>

                <div class="button-group">
                    <button type="button" class="btn btn-cancel" onclick="cancelLogout()" id="cancelBtn">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm" style="display: none;">
                        @csrf
                    </form>
                    <button type="button" class="btn btn-logout" onclick="confirmLogout()" id="logoutBtn">
                        <i class="fas fa-sign-out-alt"></i> Ya, Logout
                    </button>
                </div>

                <div class="logout-footer">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmLogout() {
            // Tambah efek loading sebelum submit
            const btn = document.getElementById('logoutBtn');
            const cancelBtn = document.getElementById('cancelBtn');

            btn.classList.add('btn-loading');
            btn.disabled = true;
            cancelBtn.disabled = true;

            // Submit form setelah 1 detik
            setTimeout(() => {
                document.getElementById('logoutForm').submit();
            }, 1000);
        }

        function cancelLogout() {
            // Kembali ke halaman dashboard
            window.location.href = "{{ route('dashboard') }}";
        }

        // Tambahkan event listener untuk keyboard
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                cancelLogout();
            } else if (event.key === 'Enter' && !event.target.matches('input, textarea')) {
                const logoutBtn = document.getElementById('logoutBtn');
                if (logoutBtn) {
                    confirmLogout();
                }
            }
        });

        // Focus management untuk aksesibilitas
        document.addEventListener('DOMContentLoaded', function() {
            const cancelBtn = document.getElementById('cancelBtn');
            if (cancelBtn) {
                cancelBtn.focus();
            }
        });
    </script>
</body>

</html>
