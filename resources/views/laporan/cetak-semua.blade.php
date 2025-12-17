<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penggajian Keseluruhan - CV Saka Pratama</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .report-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        /* Header Perusahaan */
        .company-header {
            border-bottom: 2px solid #1a237e;
            padding-bottom: 15px;
            margin-bottom: 25px;
            position: relative;
        }

        .company-header:after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, #1a237e 0%, #283593 50%, #3949ab 100%);
        }

        .company-name {
            font-size: 24px;
            font-weight: 700;
            color: #1a237e;
            margin: 0;
            letter-spacing: 0.5px;
            text-align: center;
        }

        .company-address {
            font-size: 12px;
            color: #666;
            margin: 5px 0;
            text-align: center;
        }

        /* Judul Laporan */
        .report-title {
            text-align: center;
            margin: 20px 0 25px 0;
            padding: 15px;
            background: linear-gradient(135deg, #f5f7ff 0%, #e8eaf6 100%);
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .report-title h1 {
            color: #1a237e;
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }

        .report-title h2 {
            color: #d32f2f;
            margin: 8px 0 0 0;
            font-size: 16px;
            font-weight: 500;
        }

        /* Filter Info */
        .filter-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .filter-info h3 {
            font-size: 14px;
            color: #1a237e;
            margin: 0 0 10px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid #ddd;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
        }

        .filter-label {
            color: #555;
            min-width: 120px;
            font-weight: 500;
        }

        .filter-value {
            color: #333;
            font-weight: 600;
            text-align: right;
            flex: 1;
        }

        /* Summary Section */
        .summary-section {
            margin: 25px 0;
            border: 2px solid #1a237e;
            border-radius: 8px;
            padding: 25px;
            background: linear-gradient(135deg, #f5f7ff 0%, #e8eaf6 100%);
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .summary-item {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        .summary-value {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
            color: #1a237e;
        }

        .summary-label {
            font-size: 13px;
            color: #666;
            font-weight: 500;
        }

        .summary-total {
            background: #27ae60;
            color: white;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            margin-top: 20px;
            box-shadow: 0 4px 12px rgba(39, 174, 96, 0.2);
        }

        .summary-total .summary-value {
            font-size: 28px;
            color: white;
            margin: 10px 0;
        }

        .summary-total .summary-label {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Employee Section */
        .employee-section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }

        .employee-header {
            background: #f8f9fa;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #27ae60;
            border: 1px solid #e0e0e0;
        }

        .employee-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .employee-info h3 {
            margin: 0;
            color: #1a237e;
            font-size: 16px;
            font-weight: 600;
        }

        .employee-info small {
            color: #666;
            font-size: 12px;
        }

        .employee-total {
            background: linear-gradient(135deg, #27ae60, #219653);
            color: white;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            box-shadow: 0 2px 6px rgba(39, 174, 96, 0.3);
        }

        /* Table Styling - OPTIMIZED FOR PRINT */
        .laporan-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 10px;
            border: 1px solid #e0e0e0;
            page-break-inside: avoid;
        }

        .laporan-table th {
            background: linear-gradient(135deg, #1a237e, #283593);
            color: white;
            font-weight: 500;
            padding: 10px 8px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .laporan-table td {
            padding: 8px;
            border: 1px solid #e0e0e0;
            vertical-align: middle;
        }

        .laporan-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .laporan-table tbody tr:hover {
            background-color: #f0f0f0;
        }

        .laporan-table .text-right {
            text-align: right;
        }

        .laporan-table .text-center {
            text-align: center;
        }

        /* Badge */
        .badge {
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
        }

        .badge-info {
            background: #0dcaf0;
            color: white;
        }

        .badge-success {
            background: #198754;
            color: white;
        }

        /* Total Row */
        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .total-row td {
            border-top: 2px solid #ddd;
            font-size: 12px;
        }

        /* Footer */
        .report-footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 25px;
            border-top: 2px dashed #1a237e;
            font-size: 11px;
            color: #666;
        }

        /* Tanda Tangan */
        .signature-section {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 2px solid #1a237e;
        }

        .signature-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 60px;
        }

        .signature-box {
            text-align: center;
            width: 45%;
        }

        .signature-left {
            text-align: left;
        }

        .signature-right {
            text-align: right;
        }

        .signature-line {
            width: 200px;
            height: 1px;
            background: #333;
            margin-top: 60px;
            margin-bottom: 10px;
        }

        .signature-left .signature-line {
            margin-left: 0;
        }

        .signature-right .signature-line {
            margin-left: auto;
            margin-right: 0;
        }

        .signature-name {
            font-weight: 600;
            color: #1a237e;
            margin-top: 5px;
            font-size: 14px;
        }

        .signature-title {
            font-size: 12px;
            color: #666;
            font-style: italic;
            margin-top: 2px;
        }

        /* Tombol Aksi */
        .action-buttons {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #eee;
        }

        .action-buttons button {
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 0 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-print {
            background: linear-gradient(135deg, #1a237e, #283593);
            color: white;
        }

        .btn-print:hover {
            background: linear-gradient(135deg, #283593, #3949ab);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(41, 53, 147, 0.3);
        }

        .btn-close {
            background: linear-gradient(135deg, #757575, #616161);
            color: white;
        }

        .btn-close:hover {
            background: linear-gradient(135deg, #616161, #424242);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(97, 97, 97, 0.3);
        }

        /* Print Styles - OPTIMIZED */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
                /* Menghilangkan header dan footer browser */
                margin-header: 0;
                margin-footer: 0;
            }

            /* Menghilangkan header/footer dari browser */
            @page :left {
                margin-left: 0;
                margin-right: 0;
                margin-top: 0;
                margin-bottom: 0;
            }

            @page :right {
                margin-left: 0;
                margin-right: 0;
                margin-top: 0;
                margin-bottom: 0;
            }

            @page :first {
                margin-left: 0;
                margin-right: 0;
                margin-top: 0;
                margin-bottom: 0;
            }

            /* Menghilangkan URL dan nomor halaman */
            @page {
                @top-left {
                    content: '';
                }

                @top-center {
                    content: '';
                }

                @top-right {
                    content: '';
                }

                @bottom-left {
                    content: '';
                }

                @bottom-center {
                    content: '';
                }

                @bottom-right {
                    content: '';
                }
            }

            body {
                background: white;
                padding: 0;
                margin: 0;
                font-size: 10pt;
                line-height: 1.3;
                /* Menghilangkan margin di body saat print */
                margin-top: 0 !important;
                margin-bottom: 0 !important;
            }

            .report-container {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
                margin: 0;
                /* Pastikan tidak ada margin tambahan */
                margin-top: 0 !important;
                margin-bottom: 0 !important;
            }

            .action-buttons {
                display: none;
            }

            /* Reduce spacing for print */
            .company-header {
                padding-bottom: 10px;
                margin-bottom: 15px;
            }

            .report-title {
                margin: 15px 0;
                padding: 10px;
            }

            .filter-info {
                padding: 12px;
                margin-bottom: 15px;
            }

            .summary-section {
                margin: 15px 0;
                padding: 15px;
            }

            .summary-item {
                padding: 15px;
            }

            .summary-value {
                font-size: 20px;
            }

            .employee-header {
                padding: 12px 15px;
                margin-bottom: 15px;
            }

            .laporan-table {
                font-size: 9px;
            }

            .laporan-table th,
            .laporan-table td {
                padding: 6px;
            }

            /* FIXED: Tanda tangan tetap kanan-kiri saat print */
            .signature-section {
                margin-top: 25px;
                padding-top: 20px;
            }

            .signature-container {
                display: flex !important;
                justify-content: space-between !important;
                align-items: flex-start !important;
                flex-direction: row !important;
                margin-top: 40px !important;
            }

            .signature-box {
                width: 45% !important;
                text-align: center !important;
            }

            .signature-left {
                text-align: left !important;
            }

            .signature-right {
                text-align: right !important;
            }

            .signature-line {
                width: 180px !important;
                margin-top: 50px !important;
                margin-bottom: 8px !important;
                display: block !important;
            }

            .signature-left .signature-line {
                margin-left: 0 !important;
                margin-right: auto !important;
            }

            .signature-right .signature-line {
                margin-left: auto !important;
                margin-right: 0 !important;
            }

            .signature-name {
                font-size: 13px !important;
            }

            .signature-title {
                font-size: 11px !important;
            }

            /* Ensure no page breaks inside important elements */
            .company-header,
            .report-title,
            .summary-section,
            .summary-grid,
            .employee-section,
            .signature-section {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Prevent orphaned rows */
            .laporan-table tr {
                page-break-inside: avoid;
            }
        }

        /* Kosong State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background: #fafafa;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px dashed #ddd;
        }

        .empty-state-icon {
            font-size: 48px;
            color: #e0e0e0;
            margin-bottom: 15px;
        }

        .empty-state h3 {
            color: #757575;
            margin-bottom: 10px;
            font-size: 18px;
        }

        .empty-state p {
            color: #9e9e9e;
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.5;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) and not print {
            .report-container {
                padding: 15px;
                max-width: 100%;
            }

            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }

            .employee-header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .signature-container {
                flex-direction: column;
                align-items: center;
                gap: 40px;
                margin-top: 40px;
            }

            .signature-box {
                width: 100%;
                margin-bottom: 30px;
            }

            .signature-left,
            .signature-right {
                text-align: center;
                padding: 0;
            }

            .signature-line {
                margin: 40px auto 10px;
                width: 250px;
            }

            .action-buttons {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .action-buttons button {
                width: 100%;
                margin: 0;
            }
        }

        /* Jika data terlalu banyak, scroll internal */
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            margin-top: 10px;
        }

        @media print {

            /* Pastikan responsive style tidak mempengaruhi print */
            .signature-container {
                flex-direction: row !important;
                gap: 0 !important;
            }

            .summary-grid {
                grid-template-columns: repeat(4, 1fr) !important;
            }
        }
    </style>
</head>

<body>
    <div class="report-container">
        <!-- Header Perusahaan -->
        <div class="company-header">
            <h1 class="company-name">CV SAKA PRATAMA</h1>
            <p class="company-address">Jl. Industri Raya No. 123, Kawasan Industri, Jakarta Timur 13930</p>
            <p class="company-address">Telp: (021) 1234-5678 | Email: hr@sakapratama.co.id</p>
        </div>

        <!-- Judul Laporan -->
        <div class="report-title">
            <h1>LAPORAN PENGGAJIAN KESELURUHAN</h1>
            <h2>
                @if (!empty($start_date) && !empty($end_date))
                    Periode {{ date('d F Y', strtotime($start_date)) }} - {{ date('d F Y', strtotime($end_date)) }}
                @else
                    Semua Periode
                @endif
            </h2>
        </div>

        <!-- Filter Info -->
        <div class="filter-info">
            <h3>FILTER YANG DIGUNAKAN</h3>
            <div class="filter-row">
                <span class="filter-label">Periode:</span>
                <span class="filter-value">
                    {{ !empty($start_date) ? date('d/m/Y', strtotime($start_date)) : 'Semua' }}
                    -
                    {{ !empty($end_date) ? date('d/m/Y', strtotime($end_date)) : 'Semua' }}
                </span>
            </div>
            @if (!empty($id_karyawan))
                <div class="filter-row">
                    <span class="filter-label">Karyawan:</span>
                    <span class="filter-value">
                        {{ $laporan->first()->nama_karyawan ?? 'Semua Karyawan' }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Summary Section -->
        <div class="summary-section">
            <h3 style="text-align: center; color: #1a237e; margin-bottom: 20px;">RINGKASAN KESELURUHAN</h3>

            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-value">{{ $jumlah_karyawan }}</div>
                    <div class="summary-label">Jumlah Karyawan</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">Rp {{ number_format($total_gaji_keseluruhan, 0, ',', '.') }}</div>
                    <div class="summary-label">Total Gaji Pokok</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">Rp {{ number_format($total_bonus_keseluruhan, 0, ',', '.') }}</div>
                    <div class="summary-label">Total Bonus</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">Rp {{ number_format($total_potongan_keseluruhan, 0, ',', '.') }}</div>
                    <div class="summary-label">Total Potongan</div>
                </div>
            </div>

            <div class="summary-total">
                <div class="summary-value">Rp {{ number_format($total_bersih_keseluruhan, 0, ',', '.') }}</div>
                <div class="summary-label">TOTAL DIBERIKAN</div>
            </div>
        </div>

        @if (!empty($karyawan_data))
            <h3 style="color: #1a237e; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #1a237e;">
                RINCIAN PER KARYAWAN
            </h3>

            @foreach ($karyawan_data as $id_karyawan => $data)
                <div class="employee-section">
                    <div class="employee-header">
                        <div class="employee-header-content">
                            <div class="employee-info">
                                <h3>{{ $data['nama'] }}</h3>
                                <small>{{ ucfirst($data['jabatan']) }} | {{ $data['total_laporan'] }} Laporan</small>
                            </div>
                            <div class="employee-total">
                                Rp {{ number_format($data['total_bersih'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    <table class="laporan-table">
                        <thead>
                            <tr>
                                <th width="25%">Periode</th>
                                <th width="10%">Jumlah Hari</th>
                                <th width="15%" class="text-right">Gaji Pokok</th>
                                <th width="15%" class="text-right">Bonus</th>
                                <th width="15%" class="text-right">Potongan</th>
                                <th width="20%" class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['laporan_detail'] as $detail)
                                <tr>
                                    <td>
                                        {{ date('d/m/Y', strtotime($detail->periode_start)) }} -
                                        {{ date('d/m/Y', strtotime($detail->periode_end)) }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info">{{ $detail->jumlah_hari }} hari</span>
                                    </td>
                                    <td class="text-right">Rp {{ number_format($detail->total_gaji, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">Rp {{ number_format($detail->total_bonus, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">Rp {{ number_format($detail->total_potongan, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        <strong>Rp {{ number_format($detail->total_bersih, 0, ',', '.') }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                            <!-- Total per karyawan -->
                            <tr class="total-row">
                                <td colspan="2">
                                    <strong>TOTAL {{ strtoupper($data['nama']) }}</strong><br>
                                    <small style="font-size: 9px;">{{ $data['total_laporan'] }} periode |
                                        {{ $data['total_hari'] }} hari</small>
                                </td>
                                <td class="text-right">
                                    <strong>Rp {{ number_format($data['total_gaji'], 0, ',', '.') }}</strong>
                                </td>
                                <td class="text-right">
                                    <strong>Rp {{ number_format($data['total_bonus'], 0, ',', '.') }}</strong>
                                </td>
                                <td class="text-right">
                                    <strong style="color: #d32f2f;">
                                        - Rp {{ number_format($data['total_potongan'], 0, ',', '.') }}
                                    </strong>
                                </td>
                                <td class="text-right">
                                    <span class="badge badge-success">
                                        Rp {{ number_format($data['total_bersih'], 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endforeach

            <!-- Grand Total -->
            <div class="summary-section">
                <h3 style="text-align: center; color: #1a237e; margin-bottom: 20px;">GRAND TOTAL KESELURUHAN</h3>

                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="summary-value">{{ $jumlah_karyawan }}</div>
                        <div class="summary-label">Jumlah Karyawan</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-value">Rp {{ number_format($total_gaji_keseluruhan, 0, ',', '.') }}</div>
                        <div class="summary-label">Total Gaji Pokok</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-value">Rp {{ number_format($total_bonus_keseluruhan, 0, ',', '.') }}</div>
                        <div class="summary-label">Total Bonus</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-value">Rp {{ number_format($total_potongan_keseluruhan, 0, ',', '.') }}
                        </div>
                        <div class="summary-label">Total Potongan</div>
                    </div>
                </div>

                <div class="summary-total">
                    <div class="summary-value">Rp {{ number_format($total_bersih_keseluruhan, 0, ',', '.') }}</div>
                    <div class="summary-label">TOTAL DIBERIKAN KESELURUHAN</div>
                </div>
            </div>
        @else
            <!-- Kosong State -->
            <div class="empty-state">
                <div class="empty-state-icon">📋</div>
                <h3>Tidak Ada Data Laporan</h3>
                <p>Tidak ditemukan laporan penggajian dengan filter yang dipilih.</p>
            </div>
        @endif

        <!-- Tanda Tangan -->
        <div class="signature-section">
            <div class="signature-container">
                <!-- Kiri: Perusahaan -->
                <div class="signature-box signature-left">
                    <div class="signature-line"></div>
                    <div class="signature-name">Drs. Budi Santoso</div>
                    <div class="signature-title">HRD Manager</div>
                    <div class="signature-title">CV Saka Pratama</div>
                </div>

                <!-- Kanan: Supervisor -->
                <div class="signature-box signature-right">
                    <div class="signature-line"></div>
                    <div class="signature-name">Siti Rahayu</div>
                    <div class="signature-title">Supervisor</div>
                    <div class="signature-title">Sistem Penggajian</div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="report-footer">
            <p>
                <strong>Catatan:</strong> Laporan ini dicetak secara otomatis oleh sistem penggajian CV Saka
                Pratama.<br>
                Dokumen ini valid dan dapat dipertanggungjawabkan sebagai arsip perusahaan.
            </p>
            <p style="margin-top: 10px; font-size: 10px;">
                Dicetak pada: {{ date('d/m/Y H:i:s') }} |
                Sistem Penggajian CV Saka Pratama
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn-print" onclick="optimizedPrint()">🖨️ Cetak Laporan</button>
        </div>
    </div>

    <script>
        // Print dengan optimasi
        function optimizedPrint() {
            // Simpan state asli
            const originalContainerStyle = document.querySelector('.signature-container').style.cssText;
            const originalBoxStyles = [];

            document.querySelectorAll('.signature-box').forEach((box, index) => {
                originalBoxStyles.push({
                    element: box,
                    style: box.style.cssText
                });
            });

            // Pastikan tanda tangan tetap horizontal untuk print preview
            const signatureContainer = document.querySelector('.signature-container');
            signatureContainer.style.flexDirection = 'row';
            signatureContainer.style.justifyContent = 'space-between';
            signatureContainer.style.alignItems = 'flex-start';
            signatureContainer.style.display = 'flex';

            document.querySelectorAll('.signature-box').forEach(box => {
                box.style.width = '45%';
                box.style.marginBottom = '0';
            });

            document.querySelector('.signature-left').style.textAlign = 'left';
            document.querySelector('.signature-right').style.textAlign = 'right';

            // Jalankan print dengan delay untuk memastikan style diterapkan
            setTimeout(() => {
                window.print();
            }, 100);

            // Kembalikan ke state asli setelah print
            setTimeout(() => {
                signatureContainer.style.cssText = originalContainerStyle;
                originalBoxStyles.forEach(item => {
                    item.element.style.cssText = item.style;
                });
            }, 500);
        }

        // Handle beforeprint event untuk memastikan layout benar
        window.addEventListener('beforeprint', function() {
            // Force horizontal layout untuk tanda tangan
            const signatureContainer = document.querySelector('.signature-container');
            signatureContainer.style.flexDirection = 'row';
            signatureContainer.style.justifyContent = 'space-between';
            signatureContainer.style.alignItems = 'flex-start';
            signatureContainer.style.display = 'flex';

            document.querySelectorAll('.signature-box').forEach(box => {
                box.style.width = '45%';
                box.style.marginBottom = '0';
                box.style.float = 'none';
            });

            document.querySelector('.signature-left').style.textAlign = 'left';
            document.querySelector('.signature-right').style.textAlign = 'right';

            // Kurangi font sizes untuk print
            document.querySelectorAll('.laporan-table').forEach(el => {
                el.style.fontSize = '9px';
            });

            // Tambahkan style untuk menghilangkan header/footer browser
            const style = document.createElement('style');
            style.innerHTML = `
                @page {
                    margin: 15mm !important;
                    margin-header: 0 !important;
                    margin-footer: 0 !important;
                }
                @page :left, @page :right, @page :first {
                    margin: 15mm !important;
                }
            `;
            document.head.appendChild(style);
        });

        window.addEventListener('afterprint', function() {
            // Restore untuk browser view
            const signatureContainer = document.querySelector('.signature-container');
            signatureContainer.style.cssText = '';

            document.querySelectorAll('.signature-box').forEach(box => {
                box.style.cssText = '';
            });

            // Restore font sizes
            document.querySelectorAll('.laporan-table').forEach(el => {
                el.style.fontSize = '';
            });

            // Hapus style yang ditambahkan
            const styles = document.querySelectorAll('style[data-print-style]');
            styles.forEach(style => style.remove());
        });
    </script>
</body>

</html>
