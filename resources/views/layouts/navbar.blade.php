<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            <i class="fas fa-cash-register text-primary me-2"></i>
            <strong>CV Saka Pratama</strong>
        </a>

        <div class="dropdown">
            <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button"
                data-bs-toggle="dropdown">
                <div class="me-2 text-end">
                    <div class="fw-bold">{{ auth()->guard('karyawan')->user()->nama_karyawan }}</div>
                    <small class="text-muted">{{ ucfirst(auth()->guard('karyawan')->user()->jabatan) }}</small>
                </div>
                <div class="rounded-circle bg-primary text-white p-2">
                    <i class="fas fa-user"></i>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a href="{{ route('logout.confirm') }}" class="menu-item">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
