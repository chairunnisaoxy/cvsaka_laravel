<!-- Mobile Sidebar Toggle -->
<button class="mobile-sidebar-toggle" id="sidebarToggle">
    <i class="fas fa-bars"></i>
</button>

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

        <!-- Menu Absensi: Hanya untuk supervisor dan bukan pemilik@gmail.com -->
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

        <a href="{{ route('logout.confirm') }}" class="menu-item">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </div>
</div>

{{-- <!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form> --}}

<style>
    :root {
        --primary: #2c3e50;
        --secondary: #e74c3c;
        --accent: #3498db;
        --light: #f8f9fa;
        --dark: #2c3e50;
        --gray: #6c757d;
        --border: #e9ecef;
    }

    /* Mobile Sidebar Toggle */
    .mobile-sidebar-toggle {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1100;
        display: none;
        background: var(--primary);
        border: none;
        border-radius: 10px;
        width: 50px;
        height: 50px;
        color: white;
        font-size: 1.3rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        cursor: pointer;
        align-items: center;
        justify-content: center;
    }

    .mobile-sidebar-toggle:hover {
        background: var(--secondary);
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .mobile-sidebar-toggle:active {
        transform: scale(0.95);
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
        box-shadow: 2px 0 15px rgba(0, 0, 0, 0.2);
        top: 0;
        left: 0;
    }

    .sidebar-wrapper.mobile-open {
        transform: translateX(0);
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
        margin-bottom: 0.25rem;
    }

    .user-profile small {
        font-size: 0.75rem;
        opacity: 0.7;
        display: block;
        margin-top: 0.5rem;
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
        cursor: pointer;
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

    /* Overlay for mobile */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }

    .sidebar-overlay.active {
        display: block;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .mobile-sidebar-toggle {
            display: flex;
        }

        .sidebar-wrapper {
            transform: translateX(-100%);
        }

        /* Add overlay when sidebar is open */
        .sidebar-open .sidebar-overlay {
            display: block;
        }
    }

    @media (max-width: 768px) {
        .mobile-sidebar-toggle {
            top: 15px;
            left: 15px;
            width: 45px;
            height: 45px;
            font-size: 1.2rem;
        }

        .sidebar-wrapper {
            width: 260px;
        }
    }

    @media (max-width: 576px) {
        .mobile-sidebar-toggle {
            top: 10px;
            left: 10px;
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
        }

        .sidebar-wrapper {
            width: 250px;
        }

        .sidebar-header {
            padding: 1.25rem 1rem 0.75rem;
        }

        .user-profile {
            padding: 1.25rem;
        }

        .menu-item {
            padding: 0.75rem 1.25rem;
        }
    }

    /* Animation for smooth opening */
    @keyframes slideIn {
        from {
            transform: translateX(-100%);
        }

        to {
            transform: translateX(0);
        }
    }

    .sidebar-wrapper.mobile-open {
        animation: slideIn 0.3s ease;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const body = document.body;

        // Create overlay element
        const overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        document.body.appendChild(overlay);

        // Toggle sidebar on mobile
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                e.preventDefault();

                console.log('Hamburger menu clicked');

                sidebar.classList.toggle('mobile-open');
                overlay.classList.toggle('active');
                body.classList.toggle('sidebar-open');

                // Prevent body scroll when sidebar is open
                if (sidebar.classList.contains('mobile-open')) {
                    body.style.overflow = 'hidden';
                } else {
                    body.style.overflow = '';
                }
            });
        }

        // Close sidebar when clicking on overlay
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('mobile-open');
            overlay.classList.remove('active');
            body.classList.remove('sidebar-open');
            body.style.overflow = '';
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <= 992 &&
                sidebar &&
                sidebarToggle &&
                !sidebar.contains(event.target) &&
                !sidebarToggle.contains(event.target) &&
                sidebar.classList.contains('mobile-open')) {

                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                body.classList.remove('sidebar-open');
                body.style.overflow = '';
            }
        });

        // Close sidebar when pressing Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' &&
                window.innerWidth <= 992 &&
                sidebar.classList.contains('mobile-open')) {

                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                body.classList.remove('sidebar-open');
                body.style.overflow = '';
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 992) {
                // Close sidebar and remove overlay on larger screens
                sidebar.classList.remove('mobile-open');
                overlay.classList.remove('active');
                body.classList.remove('sidebar-open');
                body.style.overflow = '';
            }
        });

        // Prevent sidebar close when clicking inside sidebar
        if (sidebar) {
            sidebar.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Debug: Log window width and sidebar state
        console.log('Window width:', window.innerWidth);
        console.log('Sidebar state:', sidebar.classList.contains('mobile-open') ? 'open' : 'closed');
    });
</script>
