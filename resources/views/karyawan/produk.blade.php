@extends('layouts.app')

@section('title', 'Detail Produk - ' . $karyawan->nama_karyawan)

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

        .action-bar {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border);
            margin-bottom: 1.5rem;
        }

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

        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
        }

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

        .modal-header {
            background: linear-gradient(135deg, var(--primary), #34495e);
            color: white;
            border-bottom: none;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }

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

            .table-responsive {
                font-size: 0.8rem;
            }

            .btn-action {
                padding: 0.3rem 0.5rem;
                font-size: 0.75rem;
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
                    <h1>Detail Produk Karyawan</h1>
                    <p>Karyawan: <strong>{{ $karyawan->nama_karyawan }}</strong></p>
                    <p>Jabatan: <strong>{{ ucfirst($karyawan->jabatan) }}</strong> | ID:
                        <strong>{{ $karyawan->id_karyawan }}</strong></p>
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
    <div class="action-bar">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
            <i class="fas fa-plus me-2"></i>Tambah Produk untuk Karyawan
        </button>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-list me-2"></i>Daftar Produk yang Dikerjakan</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Satuan</th>
                            <th>Jumlah Aktual (Pcs)</th>
                            <th>Jumlah Keranjang</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($produkKaryawan->count() > 0)
                            @foreach ($produkKaryawan as $pk)
                                <tr>
                                    <td>
                                        <strong>{{ $pk->nama_produk }}</strong><br>
                                        <small class="text-muted">{{ $pk->id_produk }}</small>
                                    </td>
                                    <td>{{ ucfirst($pk->satuan) }}</td>
                                    <td class="fw-bold">
                                        {{ number_format($pk->jml_aktual, 0, ',', '.') }} pcs
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ number_format($pk->jml_keranjang, 0, ',', '.') }} keranjang
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-warning btn-sm btn-action edit-btn"
                                                data-id-produk="{{ $pk->id_produk }}"
                                                data-id-karyawan="{{ $pk->id_karyawan }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm btn-action hapus-btn"
                                                data-id-produk="{{ $pk->id_produk }}"
                                                data-id-karyawan="{{ $pk->id_karyawan }}"
                                                data-nama="{{ $pk->nama_produk }}" title="Hapus">
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
                                        <i class="fas fa-boxes fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada produk yang ditambahkan untuk karyawan ini</p>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#tambahModal">
                                            Tambah Produk Pertama
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

    <!-- Modal Tambah Produk untuk Karyawan -->
    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahModalLabel">
                        <i class="fas fa-plus me-2"></i>Tambah Produk untuk Karyawan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambah">
                    @csrf
                    <input type="hidden" name="id_karyawan" value="{{ $karyawan->id_karyawan }}">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Menambahkan produk untuk karyawan: <strong>{{ $karyawan->nama_karyawan }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_produk" class="form-label">Produk <span class="text-danger">*</span></label>
                                <select class="form-select" id="id_produk" name="id_produk" required>
                                    <option value="">Pilih Produk</option>
                                    @foreach ($produkBelumDimiliki as $produk)
                                        <option value="{{ $produk->id_produk }}">
                                            {{ $produk->nama_produk }} - {{ ucfirst($produk->satuan) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jml_aktual" class="form-label">Jumlah Aktual (Pcs) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="jml_aktual" name="jml_aktual" value="0"
                                    min="1" step="1" required>
                                <small class="text-muted">Masukkan jumlah produksi dalam pcs</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah Keranjang (Otomatis)</label>
                                <input type="text" class="form-control" id="jml_keranjang_display" value="0"
                                    readonly style="background-color: #f8f9fa;">
                                <small class="text-muted">1 keranjang = 500 pcs</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="fas fa-calculator me-2"></i>
                                    <strong>Perhitungan Otomatis:</strong><br>
                                    • Jumlah Keranjang = Jumlah Aktual ÷ 500 pcs (dibulatkan ke atas)<br>
                                </div>
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

    <!-- Modal Edit Produk Karyawan -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Data Produk
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEdit">
                    @csrf
                    <input type="hidden" id="edit_id_produk" name="id_produk">
                    <input type="hidden" name="id_karyawan" value="{{ $karyawan->id_karyawan }}">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Mengedit data produk untuk karyawan: <strong>{{ $karyawan->nama_karyawan }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Produk</label>
                                <input type="text" class="form-control" id="edit_nama_produk" readonly disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_jml_aktual" class="form-label">Jumlah Aktual (Pcs) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="edit_jml_aktual" name="jml_aktual"
                                    value="0" min="1" step="1" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jumlah Keranjang (Otomatis)</label>
                                <input type="text" class="form-control" id="edit_jml_keranjang_display"
                                    value="0" readonly style="background-color: #f8f9fa;">
                                <small class="text-muted">1 keranjang = 500 pcs</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    <i class="fas fa-calculator me-2"></i>
                                    <strong>Perhitungan Otomatis:</strong><br>
                                    • Jumlah Keranjang = Jumlah Aktual ÷ 500 pcs (dibulatkan ke atas)<br>
                                </div>
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
                    <p>Apakah Anda yakin ingin menghapus produk <strong id="hapusNama"></strong> dari karyawan ini?</p>
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
@endsection

@push('scripts')
    <script>
        // URLs
        const storeUrl = "{{ route('produk-karyawan.store') }}";
        const updateUrl = "{{ route('produk-karyawan.update') }}";
        const destroyUrl = "{{ route('produk-karyawan.destroy') }}";
        const getDataUrl = "{{ route('produk-karyawan.get-data') }}";

        // Auto calculate untuk form tambah
        function calculateTambah() {
            const jmlAktual = parseInt(document.getElementById('jml_aktual').value) || 0;
            const jmlKeranjang = Math.ceil(jmlAktual / 500);

            document.getElementById('jml_keranjang_display').value = jmlKeranjang + ' keranjang';
        }

        // Auto calculate untuk form edit
        function calculateEdit() {
            const jmlAktual = parseInt(document.getElementById('edit_jml_aktual').value) || 0;
            const jmlKeranjang = Math.ceil(jmlAktual / 500);

            document.getElementById('edit_jml_keranjang_display').value = jmlKeranjang + ' keranjang';
        }

        // Attach event listeners for auto-calculation
        document.getElementById('jml_aktual').addEventListener('input', calculateTambah);
        document.getElementById('edit_jml_aktual').addEventListener('input', calculateEdit);

        // Form Tambah
        document.getElementById('formTambah').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validasi client-side
            const idProduk = document.getElementById('id_produk').value;
            const jmlAktual = document.getElementById('jml_aktual').value;

            if (!idProduk) {
                showAlert('Pilih produk terlebih dahulu', 'danger');
                return;
            }

            if (jmlAktual < 1) {
                showAlert('Jumlah aktual harus lebih dari 0', 'danger');
                return;
            }

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
                        document.getElementById('jml_keranjang_display').value = '0';
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        if (data.errors) {
                            let errorMessages = Object.values(data.errors).flat().join('<br>');
                            showAlert(errorMessages, 'danger');
                        } else {
                            showAlert(data.message, 'danger');
                        }
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
                const id_produk = this.getAttribute('data-id-produk');
                const id_karyawan = this.getAttribute('data-id-karyawan');

                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                this.disabled = true;

                fetch(`${getDataUrl}?id_produk=${encodeURIComponent(id_produk)}&id_karyawan=${encodeURIComponent(id_karyawan)}`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.success) {
                            document.getElementById('edit_id_produk').value = data.data.id_produk;
                            document.getElementById('edit_nama_produk').value = data.data.nama_produk;
                            document.getElementById('edit_jml_aktual').value = data.data.jml_aktual;
                            calculateEdit();

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
                        if (data.errors) {
                            let errorMessages = Object.values(data.errors).flat().join('<br>');
                            showAlert(errorMessages, 'danger');
                        } else {
                            showAlert(data.message, 'danger');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Terjadi kesalahan', 'danger');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        });

        // Hapus button click
        let currentHapusProdukId = null;
        let currentHapusKaryawanId = null;
        document.querySelectorAll('.hapus-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id_produk = this.getAttribute('data-id-produk');
                const id_karyawan = this.getAttribute('data-id-karyawan');
                const nama = this.getAttribute('data-nama');
                currentHapusProdukId = id_produk;
                currentHapusKaryawanId = id_karyawan;
                document.getElementById('hapusNama').textContent = nama;
                new bootstrap.Modal(document.getElementById('hapusModal')).show();
            });
        });

        // Confirm hapus
        document.getElementById('confirmHapus').addEventListener('click', function() {
            const formData = new FormData();
            formData.append('id_produk', currentHapusProdukId);
            formData.append('id_karyawan', currentHapusKaryawanId);

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
                    showAlert('Terjadi kesalahan', 'danger');
                })
                .finally(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    currentHapusProdukId = null;
                    currentHapusKaryawanId = null;
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
            document.getElementById('jml_keranjang_display').value = '0';
        });
    </script>
@endpush
