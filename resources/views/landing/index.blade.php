<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penggajian Karyawan - CV Saka Pratama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #e74c3c;
            --accent: #3498db;
            --dark: #2c3e50;
            --light: #ecf0f1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        /* Header & Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
        }

        .navbar-brand i {
            color: var(--secondary);
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            margin: 0 0.5rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--secondary) !important;
        }

        .btn-login {
            background: var(--secondary);
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary) 0%, #34495e 100%);
            color: white;
            padding: 120px 0 100px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff" fill-opacity="0.03" points="0,800 1000,400 1000,1000 0,1000"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-badge {
            background: var(--secondary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .btn-hero {
            background: var(--accent);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-hero:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(52, 152, 219, 0.3);
            color: white;
        }

        /* Features Section */
        .features {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .section-title p {
            font-size: 1.1rem;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto;
        }

        .feature-card {
            background: white;
            padding: 2.5rem 2rem;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 1px solid #f0f0f0;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent), #2980b9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
        }

        .feature-card h4 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .feature-card p {
            color: #6c757d;
            line-height: 1.6;
        }

        /* About Section */
        .about {
            padding: 80px 0;
            background: white;
        }

        .about-content {
            display: flex;
            align-items: center;
            gap: 4rem;
        }

        .about-text {
            flex: 1;
        }

        .about-image {
            flex: 1;
            text-align: center;
        }

        .about-image-placeholder {
            width: 100%;
            height: 400px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .about h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .about p {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }

        /* Stats Section */
        .stats {
            background: linear-gradient(135deg, var(--primary), #34495e);
            color: white;
            padding: 60px 0;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--accent);
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Login Info Section */
        .login-info {
            background: var(--light);
            padding: 60px 0;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-card h3 {
            color: var(--dark);
            margin-bottom: 1.5rem;
        }

        .role-badge {
            background: var(--accent);
            color: white;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            margin: 0.5rem;
            display: inline-block;
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 60px 0 30px;
        }

        .footer h5 {
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--accent);
        }

        .footer p,
        .footer a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: var(--accent);
        }

        .footer-bottom {
            border-top: 1px solid #34495e;
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: #95a5a6;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .about-content {
                flex-direction: column;
                gap: 2rem;
            }

            .feature-card {
                margin-bottom: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('landing') }}">
                <i class="fas fa-cash-register me-2"></i>CV Saka Pratama
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="{{ route('login') }}" class="btn btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <span class="hero-badge">Sistem Terintegrasi</span>
                        <h1>Manajemen Penggajian & Produksi Karyawan</h1>
                        <p>Kelola penggajian, absensi, dan monitoring produksi karyawan dengan sistem yang mudah,
                            akurat, dan efisien untuk mendukung produktivitas perusahaan.</p>
                        <a href="{{ route('login') }}" class="btn btn-hero me-3">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Sistem
                        </a>
                        <a href="#features" class="btn btn-hero"
                            style="background: transparent; border: 2px solid white;">
                            <i class="fas fa-info-circle me-2"></i>Pelajari Fitur
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <!-- Placeholder for hero image -->
                    <div style="text-align: center; color: white; opacity: 0.8;">
                        <i class="fas fa-chart-line" style="font-size: 15rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-title">
                <h2>Fitur Unggulan Sistem</h2>
                <p>Solusi lengkap untuk manajemen karyawan dan penggajian yang terintegrasi</p>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Manajemen Karyawan</h4>
                        <p>Kelola data karyawan, jabatan (Pemilik, Supervisor, Operator), gaji harian, dan status
                            kepegawaian dengan sistem terpusat</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h4>Absensi Digital</h4>
                        <p>Catat kehadiran karyawan dengan status Hadir, Cuti, dan Tidak Hadir. Terintegrasi langsung
                            dengan perhitungan gaji</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <h4>Perhitungan Gaji</h4>
                        <p>Hitung gaji otomatis Rp 100.000/hari, bonus lembur Rp 20.000, dan potongan dengan sistem yang
                            transparan</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h4>Monitoring Produksi</h4>
                        <p>Pantau target dan realisasi produksi karyawan dengan dashboard yang informatif dan real-time
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h4>Laporan Otomatis</h4>
                        <p>Generate laporan penggajian, absensi, dan produksi secara otomatis dengan format yang rapi
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Keamanan Data</h4>
                        <p>Sistem dengan enkripsi data dan hak akses berdasarkan jabatan untuk keamanan informasi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>Tentang Sistem Penggajian CV Saka Pratama</h2>
                    <p>Sistem Penggajian CV Saka Pratama adalah solusi terintegrasi yang dirancang khusus untuk
                        perusahaan manufacturing dalam mengelola seluruh aspek penggajian, absensi, dan produktivitas
                        karyawan dalam satu platform.</p>
                    <p>Dengan sistem ini, perusahaan dapat mengoptimalkan proses administrasi, meningkatkan akurasi
                        perhitungan gaji, memantau kinerja karyawan secara real-time, dan mengelola target produksi
                        dengan efisien.</p>
                    <p>Kami berkomitmen untuk menyediakan sistem yang user-friendly, aman, dan efisien untuk mendukung
                        operasional perusahaan yang lebih baik dan terorganisir.</p>

                    <div class="mt-4">
                        <h5>Teknologi yang Digunakan:</h5>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <span class="badge bg-primary">Laravel 10</span>
                            <span class="badge bg-success">MySQL</span>
                            <span class="badge bg-info">Bootstrap 5</span>
                            <span class="badge bg-warning">JavaScript</span>
                            <span class="badge bg-danger">Chart.js</span>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <div class="about-image-placeholder">
                        <div>
                            <i class="fas fa-industry fa-5x mb-3"></i>
                            <p>Sistem Manajemen Terintegrasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number">10+</div>
                        <div class="stat-label">Karyawan Terkelola</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Akurasi Perhitungan</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Akses Sistem</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-item">
                        <div class="stat-number">3</div>
                        <div class="stat-label">Level Jabatan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Info Section -->
    <section class="login-info">
        <div class="container">
            <div class="login-card">
                <h3>Akses Sistem Penggajian</h3>
                <p class="mb-4">Login ke sistem menggunakan akun yang telah diberikan berdasarkan jabatan Anda</p>

                <div class="mb-4">
                    <h5 class="mb-3">Role yang Tersedia:</h5>
                    <div>
                        <span class="role-badge bg-danger">Pemilik</span>
                        <span class="role-badge bg-warning">Supervisor</span>
                        <span class="role-badge bg-info">Operator</span>
                    </div>
                </div>

                <p class="mb-4">Setiap role memiliki hak akses dan fitur yang berbeda sesuai dengan kebutuhan
                    pekerjaan</p>

                <a href="{{ route('login') }}" class="btn btn-hero" style="background: var(--secondary);">
                    <i class="fas fa-sign-in-alt me-2"></i>Login ke Sistem
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>CV Saka Pratama</h5>
                    <p>Sistem Penggajian dan Manajemen Produksi Terintegrasi untuk meningkatkan efisiensi operasional
                        perusahaan manufacturing.</p>
                    <div class="mt-3">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-whatsapp fa-lg"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Kontak</h5>
                    <p><i class="fas fa-map-marker-alt me-2"></i>Jl. Raya Ps. Kemis No.80, Sukamantri, Kec. Ps. Kemis,
                        Kabupaten Tangerang, Banten 15560</p>
                    <p><i class="fas fa-phone me-2"></i>0821 1004 6388</p>
                    <p><i class="fas fa-envelope me-2"></i>info@sakapratama.com</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Quick Links</h5>
                    <p><a href="#home">Beranda</a></p>
                    <p><a href="#features">Fitur Sistem</a></p>
                    <p><a href="#about">Tentang</a></p>
                    <p><a href="{{ route('login') }}">Login Sistem</a></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 CV Saka Pratama - Sistem Penggajian. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            }
        });

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId !== '#') {
                    document.querySelector(targetId).scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Active nav link on scroll
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.navbar .nav-link');

            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (scrollY >= (sectionTop - 100)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>
