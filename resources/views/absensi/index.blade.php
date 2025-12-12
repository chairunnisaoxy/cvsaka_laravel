<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Absensi - Sistem Penggajian CV Saka Pratama</title>
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

        /* Welcome Section - Sama dengan karyawan/index */
        .welcome-section {
            background: linear-gradient(135deg, #2c3e50 0%, #1a2530 100%);
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
            margin-bottom: 0;
            font-size: 1.1rem;
        }

        .welcome-icon {
            font-size: 4rem;
            color: rgba(255, 255, 255, 0.2);
        }

        /* Action Bar - Sama dengan karyawan/index */
        .action-bar {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
            margin-bottom: 1.5rem;
        }

        .search-box {
            max-width: 400px;
        }

        .search-box .input-group {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .search-box .form-control {
            border: 1px solid #e9ecef;
            border-right: none;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }

        .search-box .btn {
            border: 1px solid #e9ecef;
            border-left: none;
            padding: 0.75rem 1rem;
        }

        /* Card - Sama dengan karyawan/index */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            padding: 1.25rem 1.5rem;
            border-bottom: none;
        }

        .card-header h5 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }

        .card-header h5 i {
            margin-right: 0.75rem;
            font-size: 1.3rem;
        }

        /* Table - Sama dengan karyawan/index */
        .table {
            margin: 0;
        }

        .table th {
            background-color: #2c3e50;
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem 0.75rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Button Action - Sama dengan karyawan/index */
        .btn-action {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
            border-radius: 6px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-action:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
        }

        /* Empty State - Sama dengan karyawan/index */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        /* Modal Header - Sama dengan karyawan/index */
        .modal-header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            border-bottom: none;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        /* PAGINATION STYLES - Sama dengan karyawan/index */
        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background: white;
            border-top: 1px solid #e9ecef;
        }

        .pagination-info {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 0.25rem;
        }

        .page-item {
            margin: 0;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0.5rem;
            background: white;
            border: 1px solid #e9ecef;
            color: #2c3e50;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .page-link:hover:not(.disabled) {
            background: #3498db;
            color: white;
            border-color: #3498db;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(52, 152, 219, 0.2);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border-color: #3498db;
            box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
        }

        .page-item.disabled .page-link {
            background: #f8f9fa;
            color: #6c757d;
            border-color: #e9ecef;
            cursor: not-allowed;
            opacity: 0.6;
        }

        .page-item.disabled .page-link:hover {
            background: #f8f9fa;
            color: #6c757d;
            border-color: #e9ecef;
            transform: none;
            box-shadow: none;
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

            .pagination-wrapper {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .action-bar {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .search-box {
                max-width: 100%;
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

            .table-responsive {
                font-size: 0.9rem;
            }

            .btn-action {
                padding: 0.3rem 0.5rem;
                font-size: 0.75rem;
            }

            .pagination {
                flex-wrap: wrap;
                justify-content: center;
            }

            .page-link {
                min-width: 35px;
                height: 35px;
                padding: 0.4rem;
                font-size: 0.85rem;
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

            .pagination-info {
                font-size: 0.8rem;
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
                <a href="{{ route('dashboard') }}"
                    class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
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
                    <a href="{{ route('absensi.index') }}"
                        class="menu-item {{ request()->routeIs('absensi.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Absensi</span>
                    </a>
                @endif

                @if (in_array(auth('karyawan')->user()->jabatan, ['pemilik', 'supervisor']))
                    <a href="{{ route('produk.index') }}"
                        class="menu-item {{ request()->routeIs('produk*') ? 'active' : '' }}">
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
                                        <a class="dropdown-item text-danger" href="{{ route('logout.confirm') }}">
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
                                <h1>Data Absensi</h1>
                                <p>Kelola data absensi karyawan CV Saka Pratama</p>
                                <p class="small mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Jam masuk default 07:00 untuk semua operator
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <i class="fas fa-calendar-check welcome-icon"></i>
                        </div>
                    </div>
                </div>

                <!-- Alert Messages -->
                <div id="alertContainer"></div>

                <!-- Action Bar -->
                <div class="action-bar d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"
                        style="padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-plus me-2"></i>Tambah Absensi
                    </button>

                    <!-- Search Form -->
                    <form method="GET" class="d-flex search-box">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search"
                                placeholder="Cari ID Absensi atau tanggal..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            @if (request('search'))
                                <a href="{{ route('absensi.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Data Table -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-list me-2"></i>Daftar Absensi</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>ID Absensi</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th width="150">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($absensi->count() > 0)
                                        @foreach ($absensi as $a)
                                            <tr>
                                                <td><strong>{{ $a->id_absensi }}</strong></td>
                                                <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') }}</td>
                                                <td>07:00</td>
                                                <td>{{ $a->jam_keluar ? \Carbon\Carbon::parse($a->jam_keluar)->format('H:i') : '-' }}
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group"> <a
                                                            href="{{ route('absensi.karyawan', $a->id_absensi) }}"
                                                            class="btn btn-info btn-sm btn-action"
                                                            title="Detail Karyawan">
                                                            <i class="fas fa-list"></i>
                                                        </a>
                                                        <button type="button"
                                                            class="btn btn-warning btn-sm btn-action edit-btn"
                                                            data-id="{{ $a->id_absensi }}" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm btn-action hapus-btn"
                                                            data-id="{{ $a->id_absensi }}"
                                                            data-tanggal="{{ \Carbon\Carbon::parse($a->tanggal)->format('d/m/Y') }}"
                                                            title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="empty-state">
                                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                                    <p class="text-muted">Tidak ada data absensi</p>
                                                    @if (request('search'))
                                                        <a href="{{ route('absensi.index') }}"
                                                            class="btn btn-primary">Tampilkan Semua</a>
                                                    @else
                                                        <button type="button" class="btn btn-primary"
                                                            data-bs-toggle="modal" data-bs-target="#tambahModal">
                                                            Tambah Absensi Pertama
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- PAGINATION -->
                        @if ($absensi->hasPages())
                            <div class="pagination-wrapper">
                                <div class="pagination-info">
                                    Menampilkan <strong>{{ $absensi->firstItem() ?: 0 }}</strong> -
                                    <strong>{{ $absensi->lastItem() ?: 0 }}</strong> dari
                                    <strong>{{ $absensi->total() }}</strong> data
                                </div>
                                <nav>
                                    <ul class="pagination">
                                        {{-- Previous Page Link --}}
                                        @if ($absensi->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">
                                                    <i class="fas fa-chevron-left"></i>
                                                </span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $absensi->previousPageUrl() }}">
                                                    <i class="fas fa-chevron-left"></i>
                                                </a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @php
                                            $currentPage = $absensi->currentPage();
                                            $lastPage = $absensi->lastPage();
                                            $start = max($currentPage - 2, 1);
                                            $end = min($currentPage + 2, $lastPage);
                                        @endphp

                                        {{-- First Page Link --}}
                                        @if ($start > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $absensi->url(1) }}">1</a>
                                            </li>
                                            @if ($start > 2)
                                                <li class="page-item disabled">
                                                    <span class="page-link">...</span>
                                                </li>
                                            @endif
                                        @endif

                                        {{-- Array Of Links --}}
                                        @for ($i = $start; $i <= $end; $i++)
                                            @if ($i == $currentPage)
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $i }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link"
                                                        href="{{ $absensi->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                        {{-- Last Page Link --}}
                                        @if ($end < $lastPage)
                                            @if ($end < $lastPage - 1)
                                                <li class="page-item disabled">
                                                    <span class="page-link">...</span>
                                                </li>
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $absensi->url($lastPage) }}">{{ $lastPage }}</a>
                                            </li>
                                        @endif

                                        {{-- Next Page Link --}}
                                        @if ($absensi->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $absensi->nextPageUrl() }}">
                                                    <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">
                                                    <i class="fas fa-chevron-right"></i>
                                                </span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>&copy; {{ date('Y') }} CV Saka Pratama - Sistem Penggajian. All rights reserved.</p>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Absensi -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">
                        <i class="fas fa-plus me-2"></i>Tambah Absensi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambah" action="{{ route('absensi.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_absensi" class="form-label">ID Absensi <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="id_absensi" name="id_absensi"
                                    required pattern="[A-Za-z0-9]+" title="Hanya huruf dan angka diperbolehkan">
                                <small class="text-muted">Contoh: ABS001, ABS002, dll.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="tanggal" class="form-label">Tanggal <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Masuk</label>
                                <input type="text" class="form-control" value="07:00" readonly disabled>
                                <small class="text-muted">Default jam masuk operator</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jam_keluar" class="form-label">Jam Keluar</label>
                                <input type="time" class="form-control" id="jam_keluar" name="jam_keluar"
                                    step="60">
                                <small class="text-muted">Waktu operator pulang</small>
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

    <!-- Modal Edit Absensi -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Absensi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id_absensi" name="id_absensi">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ID Absensi</label>
                                <input type="text" class="form-control" id="edit_id_display" readonly disabled>
                                <small class="text-muted">ID Absensi tidak dapat diubah</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_tanggal" class="form-label">Tanggal <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_tanggal" name="tanggal"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Masuk</label>
                                <input type="text" class="form-control" value="07:00" readonly disabled>
                                <small class="text-muted">Default jam masuk operator</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_jam_keluar" class="form-label">Jam Keluar</label>
                                <input type="time" class="form-control" id="edit_jam_keluar" name="jam_keluar"
                                    step="60">
                                <small class="text-muted">Waktu operator pulang</small>
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
                    <p>Apakah Anda yakin ingin menghapus data absensi tanggal <strong id="hapusTanggal"></strong>?</p>
                    <p class="text-muted">Data absensi akan dihapus secara permanen dari sistem.</p>
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

        // Set today's date as default
        document.getElementById('tanggal').valueAsDate = new Date();

        // Form Tambah Absensi
        document.getElementById('formTambah').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validasi jam keluar
            const jamKeluar = document.getElementById('jam_keluar').value;
            if (jamKeluar && jamKeluar <= '07:00') {
                showAlert('Jam keluar harus setelah jam masuk (07:00)', 'danger');
                return;
            }

            const formData = new FormData(this);

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
            submitBtn.disabled = true;

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        document.getElementById('tambahModal').querySelector('.btn-close').click();
                        this.reset();
                        document.getElementById('tanggal').valueAsDate = new Date();
                        setTimeout(() => location.reload(), 1000);
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

        // Form Edit Absensi
        document.getElementById('formEdit').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validasi jam keluar
            const jamKeluar = document.getElementById('edit_jam_keluar').value;
            if (jamKeluar && jamKeluar <= '07:00') {
                showAlert('Jam keluar harus setelah jam masuk (07:00)', 'danger');
                return;
            }

            const formData = new FormData(this);

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengupdate...';
            submitBtn.disabled = true;

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        document.getElementById('editModal').querySelector('.btn-close').click();
                        setTimeout(() => location.reload(), 1000);
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
                const id = this.getAttribute('data-id');

                fetch(`/absensi/${id}/edit`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const absensi = data.data;
                            document.getElementById('edit_id_absensi').value = absensi.id_absensi;
                            document.getElementById('edit_id_display').value = absensi.id_absensi;
                            document.getElementById('edit_tanggal').value = absensi.tanggal;
                            document.getElementById('edit_jam_keluar').value = absensi.jam_keluar ?
                                absensi.jam_keluar.substring(0, 5) : '';

                            document.getElementById('formEdit').action =
                                `/absensi/${absensi.id_absensi}`;
                            new bootstrap.Modal(document.getElementById('editModal')).show();
                        } else {
                            showAlert(data.message, 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading attendance data:', error);
                        showAlert('Gagal memuat data absensi: ' + error.message, 'danger');
                    });
            });
        });

        // Hapus button click
        let currentHapusId = null;
        document.querySelectorAll('.hapus-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const tanggal = this.getAttribute('data-tanggal');
                currentHapusId = id;
                document.getElementById('hapusTanggal').textContent = tanggal;
                new bootstrap.Modal(document.getElementById('hapusModal')).show();
            });
        });

        // Confirm hapus
        document.getElementById('confirmHapus').addEventListener('click', function() {
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghapus...';
            btn.disabled = true;

            fetch(`/absensi/${currentHapusId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.message, 'success');
                        document.getElementById('hapusModal').querySelector('.btn-close').click();
                        setTimeout(() => location.reload(), 1000);
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
                    currentHapusId = null;
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

        // Logout confirmation
        document.addEventListener('DOMContentLoaded', function() {
            // Hanya handle logout link yang langsung POST
            const directLogoutLinks = document.querySelectorAll('a[href="{{ route('logout') }}"]');
            directLogoutLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.location.href = "{{ route('logout.confirm') }}";
                });
            });
        });
    </script>
</body>

</html>
