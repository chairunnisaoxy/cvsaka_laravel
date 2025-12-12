@extends('layouts.app')

@section('title', 'Laporan Penggajian')

@push('styles')
    <style>
        /* Welcome Section */
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

        /* Action Bar */
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

        /* Filter Box */
        .filter-box {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: 1px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .filter-box h5 {
            color: #2c3e50;
            margin-bottom: 1rem;
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .filter-box h5 i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        /* Card */
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

        /* Table */
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

        /* Badge */
        .badge-info {
            background-color: #0dcaf0 !important;
            color: white;
        }

        .badge-success {
            background-color: #198754 !important;
            color: white;
        }

        /* Button Action */
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

        /* Empty State */
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

        /* Alert */
        #alertContainer .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-section {
                padding: 1.5rem;
            }

            .welcome-content h1 {
                font-size: 1.5rem;
            }

            .action-bar {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .search-box {
                max-width: 100%;
            }

            .filter-box {
                padding: 1rem;
            }

            .table-responsive {
                font-size: 0.8rem;
            }

            .btn-action {
                padding: 0.3rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .welcome-section {
                padding: 1.25rem;
            }

            .table th,
            .table td {
                padding: 0.75rem 0.5rem;
            }

            .badge {
                font-size: 0.7rem;
                padding: 0.3rem 0.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="welcome-content">
                    <h1>Laporan Penggajian</h1>
                    <p>Arsip laporan penggajian karyawan CV Saka Pratama</p>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <i class="fas fa-file-invoice-dollar welcome-icon"></i>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <div id="alertContainer"></div>

    <!-- Filter Box for Print All -->
    <div class="filter-box">
        <h5><i class="fas fa-filter me-2"></i>FILTER CETAK KESELURUHAN</h5>
        <form method="GET" action="{{ route('laporan.cetak-semua') }}" target="_blank" class="row g-3">
            @csrf
            <div class="col-md-3">
                <label for="start_date" class="form-label">Tanggal Mulai</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-01') }}">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label">Tanggal Akhir</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-t') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" name="cetak_semua" value="1" class="btn btn-success w-100">
                    <i class="fas fa-print me-2"></i>Cetak
                </button>
            </div>
        </form>
    </div>

    <!-- Action Bar -->
    <div class="action-bar d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('karyawan.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Data Karyawan
            </a>
        </div>

        <!-- Search Form -->
        <form method="GET" class="d-flex search-box">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Cari ID Laporan, nama karyawan..."
                    value="{{ $search }}">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if ($search)
                    <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-list me-2"></i>Daftar Laporan Penggajian</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID Laporan</th>
                            <th>Nama Karyawan</th>
                            <th>Periode</th>
                            <th>Jumlah Hari</th>
                            <th>Total Gaji</th>
                            <th>Total Bersih</th>
                            <th>Tanggal Arsip</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($laporan->count() > 0)
                            @foreach ($laporan as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->id_laporan }}</strong>
                                    </td>
                                    <td>
                                        <strong>{{ $item->nama_karyawan }}</strong><br>
                                        <small class="text-muted">{{ $item->id_karyawan }} -
                                            {{ ucfirst($item->jabatan) }}</small>
                                    </td>
                                    <td>
                                        {{ date('d/m/Y', strtotime($item->periode_start)) }}<br>
                                        <small class="text-muted">s/d
                                            {{ date('d/m/Y', strtotime($item->periode_end)) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $item->jumlah_hari }} hari</span>
                                    </td>
                                    <td>Rp {{ number_format($item->total_gaji, 0, ',', '.') }}</td>
                                    <td class="fw-bold text-success">
                                        Rp {{ number_format($item->total_bersih, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <small>{{ date('d/m/Y H:i', strtotime($item->created_at)) }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('laporan.cetak-detail', $item->id_laporan) }}"
                                                class="btn btn-success btn-sm btn-action" title="Cetak Laporan"
                                                target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada laporan penggajian</p>
                                        <p class="text-muted small">Laporan akan terarsip otomatis setelah karyawan mencapai
                                            14 hari kerja</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($laporan->hasPages())
            <div class="pagination-wrapper">
                <div class="pagination-info">
                    Menampilkan <strong>{{ $laporan->firstItem() ?: 0 }}</strong> -
                    <strong>{{ $laporan->lastItem() ?: 0 }}</strong> dari
                    <strong>{{ $laporan->total() }}</strong> data
                </div>
                <nav>
                    <ul class="pagination">
                        {{-- Previous Page Link --}}
                        @if ($laporan->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $laporan->previousPageUrl() }}">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $currentPage = $laporan->currentPage();
                            $lastPage = $laporan->lastPage();
                            $start = max($currentPage - 2, 1);
                            $end = min($currentPage + 2, $lastPage);
                        @endphp

                        {{-- First Page Link --}}
                        @if ($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $laporan->url(1) }}">1</a>
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
                                    <a class="page-link" href="{{ $laporan->url($i) }}">{{ $i }}</a>
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
                                <a class="page-link" href="{{ $laporan->url($lastPage) }}">{{ $lastPage }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($laporan->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $laporan->nextPageUrl() }}">
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
@endsection

@push('scripts')
    <script>
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

        // Set default dates for filter
        document.addEventListener('DOMContentLoaded', function() {
            // Set end date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('end_date').value = today;

            // Set start date to 30 days ago
            const thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
            document.getElementById('start_date').value = thirtyDaysAgo.toISOString().split('T')[0];

            // Check for success message in session
            @if (session('success'))
                showAlert('{{ session('success') }}', 'success');
            @endif
        });

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
@endpush
