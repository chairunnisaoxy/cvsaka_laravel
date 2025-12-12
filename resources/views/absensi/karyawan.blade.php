<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Karyawan - Absensi {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }} - Sistem Penggajian CV Saka Pratama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #e74c3c;
            --accent: #3498db;
            --light: #f8f9fa;
            --dark: #2c3e50;
            --gray: #6c757d;
            --border: #e9ecef;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #17a2b8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Layout with Sidebar */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar-wrapper {
            width: 280px;
            background: linear-gradient(180deg, var(--primary) 0%, #1a2530 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-header h2 {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .sidebar-header p {
            font-size: 0.85rem;
            opacity: 0.8;
            margin-bottom: 0;
        }

        .user-profile {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-profile small {
            font-size: 0.75rem;
            opacity: 0.7;
            display: block;
            margin-top: 0.5rem;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            border: 4px solid rgba(255, 255, 255, 0.2);
        }

        .user-profile h3 {
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .user-profile p {
            font-size: 0.9rem;
            opacity: 0.8;
            margin-bottom: 0;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .menu-item:hover,
        .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: var(--accent);
        }

        .menu-item i {
            width: 24px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .menu-item span {
            font-weight: 500;
        }

        .menu-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 1.5rem;
        }

        /* Main Content Area */
        .main-content-wrapper {
            flex: 1;
            margin-left: 280px;
            transition: margin-left 0.3s ease;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navigation */
        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            padding: 1rem 0;
            border-bottom: 1px solid var(--border);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: var(--primary) !important;
        }

        .navbar-brand i {
            color: var(--secondary);
        }

        .user-dropdown .dropdown-toggle {
            color: var(--dark);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .user-dropdown .dropdown-toggle:hover {
            background: var(--light);
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        /* Welcome Section */
        .welcome-section {
            background: linear-gradient(135deg, var(--primary) 0%, #1a2530 100%);
            color: white;
            border-radius: 16px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .welcome-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="%23ffffff" fill-opacity="0.05" points="0,800 1000,400 1000,1000 0,1000"/></svg>');
            background-size: cover;
        }

        .welcome-content h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: white;
        }

        .welcome-content p {
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 0.25rem;
            font-size: 1.1rem;
        }

        .welcome-content .welcome-details {
            margin-top: 1rem;
        }

        .welcome-content .welcome-details p {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .welcome-content .welcome-details strong {
            color: white;
        }

        .welcome-icon {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.2);
        }

        /* Action Bar */
        .action-bar {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
        }

        /* Alert Styles */
        #alertContainer {
            margin-bottom: 1.5rem;
        }

        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Table Styles */
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 1.5rem;
        }

        .card-header h5 {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
        }

        .card-body {
            padding: 0;
        }

        .table {
            margin: 0;
        }

        .table thead th {
            background-color: var(--light);
            color: var(--primary);
            font-weight: 600;
            border-bottom: 2px solid var(--border);
            padding: 1rem 1.5rem;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 1rem 1.5rem;
            vertical-align: middle;
            border-color: var(--border);
        }

        .table tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.01);
        }

        .btn-action {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin: 0 2px;
        }

        .btn-group .btn-action {
            margin: 0 1px;
        }

        /* Badge Styles untuk Status Absensi */
        .badge {
            padding: 0.4rem 0.8rem;
            font-weight: 600;
            border-radius: 20px;
        }

        .badge-hadir {
            background: linear-gradient(135deg, #198754, #157347);
            color: white;
        }
        
        .badge-tidak-hadir {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
        }
        
        .badge-cuti {
            background: linear-gradient(135deg, #fd7e14, #e8590c);
            color: white;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: var(--light);
            border-bottom: 1px solid var(--border);
            padding: 1.25rem 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            color: var(--primary);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid var(--border);
            padding: 1.25rem 1.5rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--gray);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .empty-state p {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid var(--border);
            padding: 1.5rem;
            text-align: center;
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Mobile Sidebar Toggle */
        .mobile-sidebar-toggle {
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 9999;
            display: none;
            background: var(--primary);
            border: none;
            border-radius: 10px;
            width: 45px;
            height: 45px;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .mobile-sidebar-toggle:hover {
            background: var(--secondary);
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .main-content-wrapper {
                margin-left: 280px;
            }
        }

        @media (max-width: 992px) {
            .sidebar-wrapper {
                transform: translateX(-100%);
            }

            .sidebar-wrapper.mobile-open {
                transform: translateX(0);
            }

            .main-content-wrapper {
                margin-left: 0;
            }

            .mobile-sidebar-toggle {
                display: flex;
            }

            .main-content {
                padding: 1.5rem;
            }

            .table-responsive {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1.25rem;
            }

            .welcome-section {
                padding: 1.5rem;
            }

            .welcome-content h1 {
                font-size: 1.5rem;
            }

            .welcome-icon {
                font-size: 3rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.75rem 1rem;
            }

            .btn-action {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 1rem;
            }

            .welcome-section {
                padding: 1.25rem;
            }

            .action-bar {
                padding: 1rem;
            }

            .mobile-sidebar-toggle {
                top: 10px;
                left: 10px;
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }

            .modal-dialog {
                margin: 0.5rem;
            }

            .welcome-content h1 {
                font-size: 1.3rem;
            }

            .welcome-content p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <!-- Mobile Sidebar Toggle -->
    <button class="mobile-sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="app-container">
        <!-- Sidebar -->
        <div class="sidebar-wrapper" id="sidebar">
            <div class="sidebar-header">
                <h2>Sistem Penggajian</h2>
                <p>CV Saka Pratama</p>
            </div>

            <div class="user-profile">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h3>{{ auth('karyawan')->user()->nama_karyawan }}</h3>
                <p>{{ ucfirst(auth('karyawan')->user()->jabatan) }}</p>
                <small>{{ auth('karyawan')->user()->email }}</small>
            </div>

            <div class="sidebar-menu">
                <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>

                <div class="menu-divider"></div>

                @if (in_array(auth('karyawan')->user()->jabatan, ['pemilik', 'supervisor']))
                    <a href="{{ route('karyawan.index') }}"
                        class="menu-item {{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Karyawan</span>
                    </a>
                @endif

                @if (auth('karyawan')->user()->jabatan == 'supervisor' ||
                        (auth('karyawan')->user()->jabatan == 'pemilik' && auth('karyawan')->user()->email != 'pemilik@gmail.com'))
                    <a href="{{ route('absensi.index') }}" class="menu-item {{ request()->routeIs('absensi.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Absensi</span>
                    </a>
                @endif

                @if (in_array(auth('karyawan')->user()->jabatan, ['pemilik', 'supervisor']))
                    <a href="{{ route('produk.index') }}" class="menu-item {{ request()->routeIs('produk*') ? 'active' : '' }}">
                        <i class="fas fa-cube"></i>
                        <span>Produk</span>
                    </a>
                @endif

                <a href="#" class="menu-item {{ request()->is('laporan*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Laporan Penggajian</span>
                </a>

                <div class="menu-divider"></div>

                <a href="{{ route('logout') }}" class="menu-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>

        <!-- Logout Form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <!-- Main Content Wrapper -->
        <div class="main-content-wrapper">
            <!-- Navigation -->
            <nav class="navbar">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <a class="navbar-brand" href="{{ route('dashboard') }}">
                            <i class="fas fa-cash-register me-2"></i>Sistem Penggajian CV Saka Pratama
                        </a>
                        <div class="user-dropdown">
                            <div class="dropdown">
                                <a class="dropdown-toggle d-flex align-items-center" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="me-2 text-end">
                                        <div class="fw-bold">{{ auth('karyawan')->user()->nama_karyawan }}</div>
                                        <small style="opacity: 0.8;">
                                            {{ ucfirst(auth('karyawan')->user()->jabatan) }}
                                        </small>
                                    </div>
                                    <div class="avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Welcome Section -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-3">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="welcome-section">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="welcome-content">
                                <h1>Detail Absensi Karyawan</h1>
                                <div class="welcome-details">
                                    <p>Tanggal: <strong>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }}</strong></p>
                                    <p>ID Absensi: <strong>{{ $absensi->id_absensi }}</strong></p>
                                    <p>Jam Masuk: <strong>07:00</strong> | Jam Keluar: <strong>{{ $absensi->jam_keluar ? \Carbon\Carbon::parse($absensi->jam_keluar)->format('H:i') : '-' }}</strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <i class="fas fa-users welcome-icon"></i>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- Action Bar -->
                <div class="action-bar">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                        <i class="fas fa-plus me-2"></i>Tambah Karyawan ke Absensi
                    </button>
                </div>

                <!-- Data Table -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-list me-2"></i>Daftar Karyawan dalam Absensi</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama Karyawan</th>
                                        <th>Jabatan</th>
                                        <th>Gaji</th>
                                        <th>Bonus Lembur</th>
                                        <th>Potongan</th>
                                        <th>Total Bersih</th>
                                        <th>Status</th>
                                        <th width="100">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($karyawanAbsensi->count() > 0)
                                        @foreach ($karyawanAbsensi as $ka)
                                            <tr>
                                                <td>
                                                    <strong>{{ $ka->nama_karyawan }}</strong><br>
                                                    <small class="text-muted">{{ $ka->id_karyawan }}</small>
                                                </td>
                                                <td>{{ ucfirst($ka->jabatan) }}</td>
                                                <td>Rp {{ number_format($ka->total_gaji, 0, ',', '.') }}</td>
                                                <td class="{{ $ka->bonus_lembur > 0 ? 'text-success' : '' }}">
                                                    Rp {{ number_format($ka->bonus_lembur, 0, ',', '.') }}
                                                </td>
                                                <td class="{{ $ka->potongan > 0 ? 'text-danger' : '' }}">
                                                    Rp {{ number_format($ka->potongan, 0, ',', '.') }}
                                                </td>
                                                <td class="fw-bold text-success">
                                                    Rp {{ number_format($ka->total_bersih, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <span class="badge badge-{{ str_replace(' ', '-', $ka->status_absensi) }}">
                                                        {{ ucfirst($ka->status_absensi) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-warning btn-sm btn-action edit-btn"
                                                            data-id-karyawan="{{ $ka->id_karyawan }}"
                                                            data-id-absensi="{{ $ka->id_absensi }}"
                                                            title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-sm btn-action hapus-btn"
                                                            data-id-karyawan="{{ $ka->id_karyawan }}"
                                                            data-id-absensi="{{ $ka->id_absensi }}"
                                                            data-nama="{{ $ka->nama_karyawan }}"
                                                            title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Belum ada karyawan yang ditambahkan ke absensi ini</p>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                                        Tambah Karyawan Pertama
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>&copy; {{ date('Y') }} CV Saka Pratama - Sistem Penggajian. All rights reserved.</p>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Karyawan ke Absensi -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">
                        <i class="fas fa-plus me-2"></i>Tambah Karyawan ke Absensi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambah">
                    @csrf
                    <input type="hidden" name="id_absensi" value="{{ $absensi->id_absensi }}">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Menambahkan karyawan ke absensi tanggal: <strong>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_karyawan" class="form-label">Karyawan <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_karyawan" name="id_karyawan" required>
                                    <option value="">Pilih Karyawan</option>
                                    @foreach ($karyawanBelumDitambahkan as $karyawan)
                                        <option value="{{ $karyawan->id_karyawan }}">
                                            {{ $karyawan->nama_karyawan }} - {{ ucfirst($karyawan->jabatan) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status_absensi" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="status_absensi" name="status_absensi" required>
                                    <option value="">Pilih Status</option>
                                    <option value="hadir">Hadir</option>
                                    <option value="tidak hadir">Tidak Hadir</option>
                                    <option value="cuti">Cuti</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="total_gaji" class="form-label">Total Gaji</label>
                                <input type="number" class="form-control" id="total_gaji" name="total_gaji" value="100000" min="0" step="1000">
                                <small class="text-muted">Gaji pokok</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="bonus_lembur" class="form-label">Bonus Lembur</label>
                                <input type="number" class="form-control" id="bonus_lembur" name="bonus_lembur" value="0" min="0" step="1000">
                                <small class="text-muted">Bonus tambahan</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="potongan" class="form-label">Potongan</label>
                                <input type="number" class="form-control" id="potongan" name="potongan" value="0" min="0" step="1000">
                                <small class="text-muted">Potongan kasbon, dll</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Absensi Karyawan -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Data Karyawan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEdit">
                    @csrf
                    <input type="hidden" id="edit_id_karyawan" name="id_karyawan">
                    <input type="hidden" name="id_absensi" value="{{ $absensi->id_absensi }}">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Mengedit data untuk absensi tanggal: <strong>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Karyawan</label>
                                <input type="text" class="form-control" id="edit_nama_karyawan" readonly disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_status_absensi" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_status_absensi" name="status_absensi" required>
                                    <option value="">Pilih Status</option>
                                    <option value="hadir">Hadir</option>
                                    <option value="tidak hadir">Tidak Hadir</option>
                                    <option value="cuti">Cuti</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="edit_total_gaji" class="form-label">Total Gaji</label>
                                <input type="number" class="form-control" id="edit_total_gaji" name="total_gaji" value="100000" min="0" step="1000">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_bonus_lembur" class="form-label">Bonus Lembur</label>
                                <input type="number" class="form-control" id="edit_bonus_lembur" name="bonus_lembur" value="0" min="0" step="1000">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="edit_potongan" class="form-label">Potongan</label>
                                <input type="number" class="form-control" id="edit_potongan" name="potongan" value="0" min="0" step="1000">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="hapusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="hapusModalLabel">
                        <i class="fas fa-trash me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                    </div>
                    <p>Apakah Anda yakin ingin menghapus <strong id="hapusNama"></strong> dari absensi ini?</p>
                    <p class="text-muted">Data akan dihapus secara permanen dari sistem.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmHapus">
                        <i class="fas fa-trash me-2"></i>Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('mobile-open');
        });

        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');

            if (window.innerWidth <= 992 &&
                !sidebar.contains(event.target) &&
                !toggleBtn.contains(event.target) &&
                sidebar.classList.contains('mobile-open')) {
                sidebar.classList.remove('mobile-open');
            }
        });

        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 992) {
                sidebar.classList.remove('mobile-open');
            }
        });

        // Konstanta URL
        const storeUrl = "{{ route('absensi.karyawan.store') }}";
        const updateUrl = "{{ route('absensi.karyawan.update') }}";
        const destroyUrl = "{{ route('absensi.karyawan.destroy') }}";
        const getDataUrl = "{{ route('absensi.karyawan.get-data') }}";

        // Form Tambah
        document.getElementById('formTambah').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
            submitBtn.disabled = true;

            fetch(storeUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        const modal = bootstrap.Modal.getInstance(document.getElementById('tambahModal'));
                        modal.hide();
                        this.reset();
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showAlert(data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan: ' + error.message, 'danger');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Edit button click
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id_karyawan = this.getAttribute('data-id-karyawan');
                const id_absensi = this.getAttribute('data-id-absensi');

                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                this.disabled = true;

                fetch(`${getDataUrl}?id_karyawan=${encodeURIComponent(id_karyawan)}&id_absensi=${encodeURIComponent(id_absensi)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.success) {
                            document.getElementById('edit_id_karyawan').value = data.data.id_karyawan;
                            document.getElementById('edit_nama_karyawan').value = data.data.nama_karyawan;
                            document.getElementById('edit_total_gaji').value = data.data.total_gaji;
                            document.getElementById('edit_bonus_lembur').value = data.data.bonus_lembur;
                            document.getElementById('edit_potongan').value = data.data.potongan;
                            document.getElementById('edit_status_absensi').value = data.data.status_absensi;

                            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                            editModal.show();
                        } else {
                            showAlert(data?.message || 'Gagal memuat data', 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        showAlert('Gagal memuat data', 'danger');
                    })
                    .finally(() => {
                        this.innerHTML = originalHTML;
                        this.disabled = false;
                    });
            });
        });

        // Form Edit
        document.getElementById('formEdit').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengupdate...';
            submitBtn.disabled = true;

            fetch(updateUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
                        modal.hide();
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showAlert(data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan: ' + error.message, 'danger');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Hapus button click
        let currentHapusKaryawanId = null;
        let currentHapusAbsensiId = null;
        document.querySelectorAll('.hapus-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id_karyawan = this.getAttribute('data-id-karyawan');
                const id_absensi = this.getAttribute('data-id-absensi');
                const nama = this.getAttribute('data-nama');
                currentHapusKaryawanId = id_karyawan;
                currentHapusAbsensiId = id_absensi;
                document.getElementById('hapusNama').textContent = nama;
                new bootstrap.Modal(document.getElementById('hapusModal')).show();
            });
        });

        // Confirm hapus
        document.getElementById('confirmHapus').addEventListener('click', function() {
            const formData = new FormData();
            formData.append('id_karyawan', currentHapusKaryawanId);
            formData.append('id_absensi', currentHapusAbsensiId);

            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghapus...';
            btn.disabled = true;

            fetch(destroyUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        const modal = bootstrap.Modal.getInstance(document.getElementById('hapusModal'));
                        modal.hide();
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showAlert(data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan: ' + error.message, 'danger');
                })
                .finally(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    currentHapusKaryawanId = null;
                    currentHapusAbsensiId = null;
                });
        });

        // Show alert message
        function showAlert(message, type = 'success') {
            const alertContainer = document.getElementById('alertContainer');
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

            alertContainer.innerHTML = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="fas ${iconClass} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;

            setTimeout(() => {
                const alert = alertContainer.querySelector('.alert');
                if (alert) alert.remove();
            }, 5000);
        }

        // Reset form when modal is closed
        document.getElementById('tambahModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('formTambah').reset();
        });

        // Logout confirmation
        document.querySelectorAll('a[href*="logout"]').forEach(link => {
            link.addEventListener('click', function(e) {
                if (!confirm('Anda yakin ingin logout?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>

</html>