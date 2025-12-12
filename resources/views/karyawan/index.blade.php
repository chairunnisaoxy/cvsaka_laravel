@extends('layouts.app')

@section('title', 'Data Karyawan')

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
        .badge-pemilik {
            background-color: #dc3545 !important;
            color: white;
        }

        .badge-supervisor {
            background-color: #fd7e14 !important;
            color: white;
        }

        .badge-operator {
            background-color: #198754 !important;
            color: white;
        }

        .badge-aktif {
            background-color: #198754 !important;
            color: white;
        }

        .badge-nonaktif {
            background-color: #6c757d !important;
            color: white;
        }

        /* Status Period */
        .status-period {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
            display: inline-block;
            text-align: center;
            width: 100%;
        }

        .status-full {
            background-color: #e74c3c;
            color: white;
            border: 1px solid #c0392b;
        }

        .status-almost-full {
            background-color: #f39c12;
            color: white;
            border: 1px solid #d68910;
        }

        .status-ongoing {
            background-color: #27ae60;
            color: white;
            border: 1px solid #219653;
        }

        /* Info Badge */
        .badge.bg-info {
            background: linear-gradient(135deg, #3498db, #2980b9) !important;
            border: 1px solid #2980b9;
            padding: 0.5rem 0.8rem;
            font-size: 0.85rem;
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

        /* Modal Header */
        .modal-header {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            color: white;
            border-bottom: none;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        /* Layout kolom */
        .table th:nth-child(8),
        .table td:nth-child(8) {
            min-width: 250px;
            max-width: 300px;
        }

        td:nth-child(8) .d-flex {
            gap: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {

            .table th:nth-child(8),
            .table td:nth-child(8) {
                min-width: 220px;
                max-width: 250px;
            }
        }

        @media (max-width: 992px) {

            .table th:nth-child(8),
            .table td:nth-child(8) {
                min-width: 200px;
                max-width: 220px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem;
            }

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

            .table-responsive {
                font-size: 0.8rem;
            }

            .btn-action {
                padding: 0.3rem 0.5rem;
                font-size: 0.75rem;
            }

            .table th:nth-child(8),
            .table td:nth-child(8) {
                min-width: 180px;
                max-width: 200px;
            }

            .status-period {
                font-size: 0.7rem;
                padding: 0.3rem 0.5rem;
            }

            .badge.bg-info {
                font-size: 0.75rem;
                padding: 0.4rem 0.6rem;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 1rem;
            }

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
                    <h1>Data Karyawan</h1>
                    <p>Kelola data karyawan CV Saka Pratama</p>
                    <p class="small mt-2">
                        <i class="fas fa-info-circle me-1"></i>
                        Sistem penggajian otomatis reset setiap 14 hari kerja
                    </p>
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
    <div class="action-bar d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"
            style="padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>Tambah Karyawan
        </button>

        <!-- Search Form -->
        <form method="GET" class="d-flex search-box">
            <div class="input-group">
                <input type="text" class="form-control" name="search"
                    placeholder="Cari ID, nama, jabatan, atau email..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if (request('search'))
                    <a href="{{ route('karyawan.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-list me-2"></i>Daftar Karyawan</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Gaji Harian</th>
                            <th>Email</th>
                            <th>No. Telp</th>
                            <th>Status</th>
                            <th>Target</th>
                            <th width="250">Total Hadir & Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($karyawan->count() > 0)
                            @foreach ($karyawan as $k)
                                @php
                                    // Hitung total hadir aktif
                                    $totalHadirAktif = DB::table('t_absensi_karyawan')
                                        ->where('id_karyawan', $k->id_karyawan)
                                        ->where('status_absensi', 'hadir')
                                        ->count();

                                    // Hitung total hadir arsip
                                    $totalHadirArsip = DB::table('laporan_penggajian')
                                        ->where('id_karyawan', $k->id_karyawan)
                                        ->sum('jumlah_hari');

                                    $totalHadirDisplay = $totalHadirAktif + $totalHadirArsip;

                                    // Tentukan status periode
                                    if ($totalHadirAktif >= 14) {
                                        $statusClass = 'status-full';
                                        $statusText = 'PERIODE PENUH';
                                    } elseif ($totalHadirAktif >= 12) {
                                        $statusClass = 'status-almost-full';
                                        $statusText = 'HAMPIR PENUH';
                                    } elseif ($totalHadirAktif > 0) {
                                        $statusClass = 'status-ongoing';
                                        $statusText = 'BERLANGSUNG';
                                    } else {
                                        $statusClass = 'status-ongoing';
                                        $statusText = 'BELUM MULAI';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $k->nama_karyawan }}</td>
                                    <td>
                                        <span class="badge badge-{{ $k->jabatan }}">
                                            {{ ucfirst($k->jabatan) }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($k->gaji_harian, 0, ',', '.') }}</td>
                                    <td>{{ $k->email ?: '-' }}</td>
                                    <td>{{ $k->no_telp ?: '-' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $k->status_karyawan }}">
                                            {{ ucfirst($k->status_karyawan) }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($k->jml_target, 0, ',', '.') }} pcs</td>
                                    <td style="min-width: 250px;">
                                        <div class="d-flex flex-column">
                                            <!-- Baris 1: Total Hadir -->
                                            <div class="mb-1">
                                                <span class="badge bg-info">
                                                    <i class="fas fa-calendar-check me-1"></i>
                                                    {{ number_format($totalHadirDisplay, 0, ',', '.') }} hari
                                                </span>
                                            </div>

                                            <!-- Baris 2: Status Periode -->
                                            <div class="mb-1">
                                                <span class="{{ $statusClass }} status-period px-2 py-1"
                                                    style="display: inline-block;">
                                                    <i
                                                        class="fas 
                                                    @if ($statusClass == 'status-full') fa-exclamation-triangle
                                                    @elseif($statusClass == 'status-almost-full')
                                                        fa-clock
                                                    @else
                                                        fa-play-circle @endif 
                                                    me-1">
                                                    </i>
                                                    {{ $statusText }} ({{ $totalHadirAktif }}/14)
                                                </span>
                                            </div>

                                            <!-- Baris 3: Detail -->
                                            <div>
                                                <small class="text-muted d-flex justify-content-between">
                                                    <span>
                                                        <i class="fas fa-sync-alt me-1"></i>
                                                        Aktif: {{ $totalHadirAktif }} hari
                                                    </span>
                                                    <span>
                                                        <i class="fas fa-archive me-1"></i>
                                                        Arsip: {{ $totalHadirArsip }} hari
                                                    </span>
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('karyawan.produk', $k->id_karyawan) }}"
                                                class="btn btn-info btn-sm btn-action" title="Detail Produk">
                                                <i class="fas fa-list"></i>
                                            </a>
                                            <a href="{{ route('karyawan.cetak-slip', $k->id_karyawan) }}"
                                                class="btn btn-success btn-sm btn-action" title="Cetak Slip Gaji"
                                                target="_blank">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <button type="button" class="btn btn-warning btn-sm btn-action edit-btn"
                                                data-id="{{ $k->id_karyawan }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-action hapus-btn"
                                                data-id="{{ $k->id_karyawan }}" data-nama="{{ $k->nama_karyawan }}"
                                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Tidak ada data karyawan</p>
                                        @if (request('search'))
                                            <a href="{{ route('karyawan.index') }}" class="btn btn-primary">Tampilkan
                                                Semua</a>
                                        @else
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#tambahModal">
                                                Tambah Karyawan Pertama
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Karyawan -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">
                        <i class="fas fa-plus me-2"></i>Tambah Karyawan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambah" action="{{ route('karyawan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_karyawan" class="form-label">ID Karyawan <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="id_karyawan" name="id_karyawan" required
                                    pattern="[A-Za-z0-9]+" title="Hanya huruf dan angka diperbolehkan">
                                <small class="text-muted">Contoh: K001, K002, dll. Hanya huruf dan angka.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nama_karyawan" class="form-label">Nama Karyawan <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jabatan" class="form-label">Jabatan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="jabatan" name="jabatan" required>
                                    <option value="">Pilih Jabatan</option>
                                    <option value="operator">Operator</option>
                                    <option value="supervisor">Supervisor</option>
                                    <option value="pemilik">Pemilik</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gaji_harian" class="form-label">Gaji Harian</label>
                                <input type="number" class="form-control" id="gaji_harian" name="gaji_harian"
                                    value="100000" min="0" step="1000">
                                <small class="text-muted">Gaji fix 100.000 per hari untuk operator</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                                <small class="text-muted">Hanya untuk pemilik dan supervisor</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                <small class="text-muted">Hanya untuk pemilik dan supervisor</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="no_telp" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="no_telp" name="no_telp">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status_karyawan" class="form-label">Status <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="status_karyawan" name="status_karyawan" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jml_target" class="form-label">Target Produksi</label>
                                <input type="number" class="form-control" id="jml_target" name="jml_target"
                                    value="500" min="0">
                                <small class="text-muted">Target fix 500 pcs per operator</small>
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

    <!-- Modal Edit Karyawan -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Karyawan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id_karyawan" name="id_karyawan">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ID Karyawan</label>
                                <input type="text" class="form-control" id="edit_id_display" readonly disabled>
                                <small class="text-muted">ID Karyawan tidak dapat diubah</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_nama_karyawan" class="form-label">Nama Karyawan <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama_karyawan" name="nama_karyawan"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_jabatan" class="form-label">Jabatan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="edit_jabatan" name="jabatan" required>
                                    <option value="">Pilih Jabatan</option>
                                    <option value="operator">Operator</option>
                                    <option value="supervisor">Supervisor</option>
                                    <option value="pemilik">Pemilik</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_gaji_harian" class="form-label">Gaji Harian</label>
                                <input type="number" class="form-control" id="edit_gaji_harian" name="gaji_harian"
                                    value="100000" min="0" step="1000">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit_email" name="email">
                                <small class="text-muted">Hanya untuk pemilik dan supervisor</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="edit_password" name="password"
                                    placeholder="Kosongkan jika tidak diubah">
                                <small class="text-muted">Hanya untuk pemilik dan supervisor</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_no_telp" class="form-label">No. Telepon</label>
                                <input type="text" class="form-control" id="edit_no_telp" name="no_telp">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_status_karyawan" class="form-label">Status <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="edit_status_karyawan" name="status_karyawan" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="edit_alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="edit_alamat" name="alamat" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_jml_target" class="form-label">Target Produksi</label>
                                <input type="number" class="form-control" id="edit_jml_target" name="jml_target"
                                    value="500" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Hadir (Kumulatif)</label>
                                <input type="text" class="form-control" id="edit_total_hadir_display" readonly
                                    disabled value="0 hari">
                                <small class="text-muted">Akumulasi kehadiran dari semua periode (tidak pernah
                                    direset)</small>
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
                    <p>Apakah Anda yakin ingin menghapus karyawan <strong id="hapusNama"></strong>?</p>
                    <p class="text-muted">Data karyawan akan dihapus secara permanen dari sistem.</p>
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
@endsection

@push('scripts')
    <script>
        // Form Tambah Karyawan
        document.getElementById('formTambah').addEventListener('submit', function(e) {
            e.preventDefault();
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
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
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

        // Form Edit Karyawan
        document.getElementById('formEdit').addEventListener('submit', function(e) {
            e.preventDefault();
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
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
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

                fetch(`/karyawan/${id}/edit`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const karyawan = data.data;
                            document.getElementById('edit_id_karyawan').value = karyawan.id_karyawan;
                            document.getElementById('edit_id_display').value = karyawan.id_karyawan;
                            document.getElementById('edit_nama_karyawan').value = karyawan
                                .nama_karyawan;
                            document.getElementById('edit_jabatan').value = karyawan.jabatan;
                            document.getElementById('edit_gaji_harian').value = karyawan.gaji_harian;
                            document.getElementById('edit_email').value = karyawan.email || '';
                            document.getElementById('edit_no_telp').value = karyawan.no_telp || '';
                            document.getElementById('edit_alamat').value = karyawan.alamat || '';
                            document.getElementById('edit_status_karyawan').value = karyawan
                                .status_karyawan;
                            document.getElementById('edit_jml_target').value = karyawan.jml_target;
                            document.getElementById('edit_total_hadir_display').value = data
                                .total_hadir + ' hari';

                            // Update form action
                            document.getElementById('formEdit').action =
                                `/karyawan/${karyawan.id_karyawan}`;

                            // Show edit modal
                            new bootstrap.Modal(document.getElementById('editModal')).show();
                        } else {
                            showAlert(data.message, 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error loading employee data:', error);
                        showAlert('Gagal memuat data karyawan: ' + error.message, 'danger');
                    });
            });
        });

        // Hapus button click
        let currentHapusId = null;
        document.querySelectorAll('.hapus-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                currentHapusId = id;
                document.getElementById('hapusNama').textContent = nama;
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

            fetch(`/karyawan/${currentHapusId}`, {
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
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
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

            // Auto hide after 5 seconds
            setTimeout(() => {
                const alert = alertContainer.querySelector('.alert');
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }

        // Reset form when modal is closed
        document.getElementById('tambahModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('formTambah').reset();
        });

        document.getElementById('editModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('formEdit').reset();
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
