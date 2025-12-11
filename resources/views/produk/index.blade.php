@extends('layouts.app')

@section('title', 'Data Produk')

@push('styles')
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
            border: 1px solid var(--border);
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
            border: 1px solid var(--border);
            border-right: none;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }

        .search-box .btn {
            border: 1px solid var(--border);
            border-left: none;
            padding: 0.75rem 1rem;
        }

        /* Card */
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary), #34495e);
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
            background-color: var(--primary);
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
            border-color: var(--border);
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
        .badge-aktif {
            background-color: #198754 !important;
            color: white;
        }

        .badge-nonaktif {
            background-color: #6c757d !important;
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

        .btn-group .btn-action {
            margin-right: 0.25rem;
        }

        .btn-group .btn-action:last-child {
            margin-right: 0;
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

        /* Modal Header */
        .modal-header {
            background: linear-gradient(135deg, var(--primary), #34495e);
            color: white;
            border-bottom: none;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-content {
                padding: 1.5rem;
            }

            .welcome-content h1 {
                font-size: 1.5rem;
            }

            .welcome-section {
                padding: 1.5rem;
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
                    <h1>Data Produk</h1>
                    <p>Kelola data produk CV Saka Pratama</p>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <i class="fas fa-boxes welcome-icon"></i>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <div id="alertContainer"></div>

    <!-- Action Bar -->
    <div class="action-bar d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal"
            style="padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>Tambah Produk
        </button>

        <!-- Search Form -->
        <form method="GET" class="d-flex search-box">
            <div class="input-group">
                <input type="text" class="form-control" name="search"
                    placeholder="Cari ID Produk, nama produk, atau satuan..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i>
                </button>
                @if (request('search'))
                    <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-list me-2"></i>Daftar Produk</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID Produk</th>
                            <th>Nama Produk</th>
                            <th>Satuan</th>
                            <th>Status</th>
                            <th width="140">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($produk->count() > 0)
                            @foreach ($produk as $item)
                                <tr>
                                    <td><strong>{{ $item->id_produk }}</strong></td>
                                    <td>{{ $item->nama_produk }}</td>
                                    <td>{{ $item->satuan }}</td>
                                    <td>
                                        <span class="badge badge-{{ $item->status_produk }}">
                                            {{ ucfirst($item->status_produk) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-warning btn-sm btn-action edit-btn"
                                                data-id="{{ $item->id_produk }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-action hapus-btn"
                                                data-id="{{ $item->id_produk }}" data-nama="{{ $item->nama_produk }}"
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
                                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Tidak ada data produk</p>
                                        @if (request('search'))
                                            <a href="{{ route('produk.index') }}" class="btn btn-primary">Tampilkan
                                                Semua</a>
                                        @else
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#tambahModal">
                                                Tambah Produk Pertama
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

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">
                        <i class="fas fa-plus me-2"></i>Tambah Produk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambah" action="{{ route('produk.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_produk" class="form-label">ID Produk <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="id_produk" name="id_produk" required>
                                <small class="text-muted">Contoh: PRD001, PRD002, dll.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nama_produk" class="form-label">Nama Produk <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_produk" name="nama_produk" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="satuan" class="form-label">Satuan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="satuan" name="satuan" required>
                                    <option value="">Pilih Satuan</option>
                                    <option value="pcs">Pcs</option>
                                    <option value="unit">Unit</option>
                                    <option value="set">Set</option>
                                    <option value="pasang">Pasang</option>
                                    <option value="lusin">Lusin</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status_produk" class="form-label">Status Produk</label>
                                <select class="form-select" id="status_produk" name="status_produk">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
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

    <!-- Modal Edit Produk -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Produk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id_produk" name="id_produk">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">ID Produk</label>
                                <input type="text" class="form-control" id="edit_id_display" readonly disabled>
                                <small class="text-muted">ID Produk tidak dapat diubah</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_nama_produk" class="form-label">Nama Produk <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_nama_produk" name="nama_produk"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_satuan" class="form-label">Satuan <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="edit_satuan" name="satuan" required>
                                    <option value="">Pilih Satuan</option>
                                    <option value="pcs">Pcs</option>
                                    <option value="unit">Unit</option>
                                    <option value="set">Set</option>
                                    <option value="pasang">Pasang</option>
                                    <option value="lusin">Lusin</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_status_produk" class="form-label">Status Produk</label>
                                <select class="form-select" id="edit_status_produk" name="status_produk">
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
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

    <!-- Modal Konfirmasi Nonaktifkan -->
    <div class="modal fade" id="nonaktifModal" tabindex="-1" aria-labelledby="nonaktifModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-warning" id="nonaktifModalLabel">
                        <i class="fas fa-pause me-2"></i>Konfirmasi Penonaktifan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menonaktifkan produk <strong id="nonaktifNamaProduk"></strong>?</p>
                    <p class="text-muted">Produk yang dinonaktifkan tidak akan muncul di daftar produksi.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-warning" id="confirmNonaktif">
                        <i class="fas fa-pause me-2"></i>Ya, Nonaktifkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Aktifkan -->
    <div class="modal fade" id="aktifModal" tabindex="-1" aria-labelledby="aktifModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-success" id="aktifModalLabel">
                        <i class="fas fa-play me-2"></i>Konfirmasi Aktivasi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mengaktifkan produk <strong id="aktifNamaProduk"></strong>?</p>
                    <p class="text-muted">Produk yang diaktifkan akan muncul di daftar produksi.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="confirmAktif">
                        <i class="fas fa-play me-2"></i>Ya, Aktifkan
                    </button>
                </div>
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
                    <p>Apakah Anda yakin ingin menghapus produk <strong id="hapusNamaProduk"></strong>?</p>
                    <p class="text-muted">Produk akan dihapus secara permanen dari sistem.</p>
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
                if (alert) {
                    alert.remove();
                }
            }, 5000);
        }

        // Form Tambah Produk
        document.getElementById('formTambah').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
            submitBtn.disabled = true;

            try {
                const formData = new FormData(this);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                // Cek status response
                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('Sesi telah habis. Silakan refresh halaman dan coba lagi.');
                    }
                    if (response.status === 422) {
                        // Validation error
                        const data = await response.json();
                        throw new Error(data.errors ? Object.values(data.errors).join(' ') : data.message);
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    showAlert(data.message, 'success');
                    document.getElementById('tambahModal').querySelector('.btn-close').click();
                    this.reset();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(data.message || 'Gagal menambahkan produk', 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error: ' + error.message, 'danger');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        // Form Edit Produk
        document.getElementById('formEdit').addEventListener('submit', async function(e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengupdate...';
            submitBtn.disabled = true;

            try {
                const formData = new FormData(this);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('Sesi telah habis. Silakan refresh halaman dan coba lagi.');
                    }
                    if (response.status === 422) {
                        const data = await response.json();
                        throw new Error(data.errors ? Object.values(data.errors).join(' ') : data.message);
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    showAlert(data.message, 'success');
                    document.getElementById('editModal').querySelector('.btn-close').click();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(data.message || 'Gagal mengupdate produk', 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error: ' + error.message, 'danger');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });

        // Edit button click
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', async function() {
                const id = this.getAttribute('data-id');

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                    const response = await fetch(`/produk/${id}/edit`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.success) {
                        const produk = data.data;
                        document.getElementById('edit_id_produk').value = produk.id_produk;
                        document.getElementById('edit_id_display').value = produk.id_produk;
                        document.getElementById('edit_nama_produk').value = produk.nama_produk;
                        document.getElementById('edit_satuan').value = produk.satuan;
                        document.getElementById('edit_status_produk').value = produk.status_produk;

                        document.getElementById('formEdit').action = `/produk/${produk.id_produk}`;
                        new bootstrap.Modal(document.getElementById('editModal')).show();
                    } else {
                        showAlert(data.message, 'danger');
                    }
                } catch (error) {
                    console.error('Error loading product data:', error);
                    showAlert('Gagal memuat data produk: ' + error.message, 'danger');
                }
            });
        });

        // Nonaktif button click
        let currentNonaktifId = null;
        document.querySelectorAll('.nonaktif-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                currentNonaktifId = id;
                document.getElementById('nonaktifNamaProduk').textContent = nama;
                new bootstrap.Modal(document.getElementById('nonaktifModal')).show();
            });
        });

        // Confirm nonaktif
        document.getElementById('confirmNonaktif').addEventListener('click', async function() {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menonaktifkan...';
            btn.disabled = true;

            try {
                const formData = new FormData();
                formData.append('_method', 'PUT');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                const response = await fetch(`/produk/${currentNonaktifId}/nonaktifkan`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('Sesi telah habis. Silakan refresh halaman dan coba lagi.');
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    showAlert(data.message, 'success');
                    document.getElementById('nonaktifModal').querySelector('.btn-close').click();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(data.message, 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error: ' + error.message, 'danger');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
                currentNonaktifId = null;
            }
        });

        // Aktif button click
        let currentAktifId = null;
        document.querySelectorAll('.aktif-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                currentAktifId = id;
                document.getElementById('aktifNamaProduk').textContent = nama;
                new bootstrap.Modal(document.getElementById('aktifModal')).show();
            });
        });

        // Confirm aktif
        document.getElementById('confirmAktif').addEventListener('click', async function() {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Mengaktifkan...';
            btn.disabled = true;

            try {
                const formData = new FormData();
                formData.append('_method', 'PUT');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                const response = await fetch(`/produk/${currentAktifId}/aktifkan`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('Sesi telah habis. Silakan refresh halaman dan coba lagi.');
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    showAlert(data.message, 'success');
                    document.getElementById('aktifModal').querySelector('.btn-close').click();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(data.message, 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error: ' + error.message, 'danger');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
                currentAktifId = null;
            }
        });

        // Hapus button click
        let currentHapusId = null;
        document.querySelectorAll('.hapus-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                currentHapusId = id;
                document.getElementById('hapusNamaProduk').textContent = nama;
                new bootstrap.Modal(document.getElementById('hapusModal')).show();
            });
        });

        // Confirm hapus
        document.getElementById('confirmHapus').addEventListener('click', async function() {
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menghapus...';
            btn.disabled = true;

            try {
                const formData = new FormData();
                formData.append('_method', 'DELETE');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                const response = await fetch(`/produk/${currentHapusId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) {
                    if (response.status === 419) {
                        throw new Error('Sesi telah habis. Silakan refresh halaman dan coba lagi.');
                    }
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const data = await response.json();

                if (data.success) {
                    showAlert(data.message, 'success');
                    document.getElementById('hapusModal').querySelector('.btn-close').click();
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(data.message, 'danger');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error: ' + error.message, 'danger');
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
                currentHapusId = null;
            }
        });

        // Reset form when modal is closed
        document.getElementById('tambahModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('formTambah').reset();
        });

        document.getElementById('editModal').addEventListener('hidden.bs.modal', function() {
            document.getElementById('formEdit').reset();
        });
    </script>
@endpush
