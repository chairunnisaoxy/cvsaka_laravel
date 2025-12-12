<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $karyawan->nama_karyawan }} - Periode {{ date('F Y', strtotime($periodeStart)) }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .slip-container {
            max-width: 900px;
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

        /* Judul Slip */
        .slip-title {
            text-align: center;
            margin: 20px 0 25px 0;
            padding: 15px;
            background: linear-gradient(135deg, #f5f7ff 0%, #e8eaf6 100%);
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .slip-title h1 {
            color: #1a237e;
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }

        .slip-title h2 {
            color: #d32f2f;
            margin: 8px 0 0 0;
            font-size: 16px;
            font-weight: 500;
        }

        /* MAIN INFO HORIZONTAL LAYOUT */
        .horizontal-info-container {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .info-column {
            flex: 1;
            min-width: 200px;
        }

        .info-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background: #fafafa;
            height: 100%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .info-card h3 {
            font-size: 14px;
            color: #1a237e;
            margin: 0 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #1a237e;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 13px;
            align-items: center;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            color: #555;
            min-width: 140px;
            font-weight: 500;
        }

        .info-value {
            color: #333;
            font-weight: 600;
            text-align: right;
            flex: 1;
        }

        /* Tabel Rincian - OPTIMIZED FOR PRINT */
        .detail-section {
            margin: 20px 0;
        }

        .section-title {
            font-size: 16px;
            color: #1a237e;
            margin: 0 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #1a237e;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .salary-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 10px;
            border: 1px solid #e0e0e0;
            page-break-inside: avoid;
        }

        .salary-table th {
            background: linear-gradient(135deg, #1a237e, #283593);
            color: white;
            font-weight: 500;
            padding: 8px 6px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .salary-table td {
            padding: 6px;
            border: 1px solid #e0e0e0;
            vertical-align: middle;
        }

        .salary-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .salary-table tbody tr:hover {
            background-color: #f0f0f0;
        }

        .salary-table .text-right {
            text-align: right;
        }

        .salary-table .text-center {
            text-align: center;
        }

        /* Total Section - COMPACT FOR PRINT */
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 13px;
            padding: 6px 0;
            border-bottom: 1px dashed #ddd;
        }

        .total-row:last-child {
            border-bottom: none;
        }

        .total-label {
            color: #333;
            font-weight: 500;
        }

        .total-value {
            color: #333;
            font-weight: 600;
        }

        .grand-total {
            margin-top: 10px;
            padding-top: 10px;
        }

        .grand-total .total-label {
            font-size: 16px;
            color: #1a237e;
            font-weight: 600;
        }

        .grand-total .total-value {
            font-size: 18px;
            color: #d32f2f;
            font-weight: 700;
        }

        /* Footer - SIGNATURE KANAN KIRI */
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

        /* Tanda tangan kiri (Perusahaan) */
        .signature-left {
            text-align: left;
        }

        /* Tanda tangan kanan (Karyawan) */
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

        /* Print Styles - OPTIMIZED FOR SINGLE PAGE - FIXED SIGNATURE */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }

            body {
                background: white;
                padding: 0;
                margin: 0;
                font-size: 10pt;
                line-height: 1.3;
            }

            .slip-container {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
                margin: 0;
                page-break-inside: avoid;
                page-break-after: avoid;
            }

            .action-buttons {
                display: none;
            }

            .info-card:hover {
                transform: none;
                box-shadow: none;
            }

            /* Reduce spacing for print */
            .company-header {
                padding-bottom: 10px;
                margin-bottom: 15px;
            }

            .slip-title {
                margin: 15px 0;
                padding: 10px;
            }

            .horizontal-info-container {
                margin-bottom: 15px;
                gap: 10px;
            }

            .info-card {
                padding: 12px;
                border: 1px solid #ccc;
            }

            .detail-section {
                margin: 15px 0;
            }

            .salary-table {
                font-size: 9px;
            }

            .salary-table th,
            .salary-table td {
                padding: 4px;
            }

            /* FIXED: Tanda tangan tetap kanan-kiri saat print */
            .signature-section {
                margin-top: 25px;
                padding-top: 20px;
            }

            .signature-container {
                display: flex !important;
                /* Force flex display */
                justify-content: space-between !important;
                align-items: flex-start !important;
                flex-direction: row !important;
                /* Force horizontal */
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
            .slip-title,
            .horizontal-info-container,
            .grand-total,
            .signature-section,
            .signature-container {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Prevent orphaned rows */
            .salary-table tr {
                page-break-inside: avoid;
            }
        }

        /* Kosong State */
        .empty-state {
            text-align: center;
            padding: 30px 20px;
            background: #fafafa;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px dashed #ddd;
            page-break-inside: avoid;
        }

        .empty-state-icon {
            font-size: 36px;
            color: #e0e0e0;
            margin-bottom: 15px;
        }

        .empty-state h3 {
            color: #757575;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .empty-state p {
            color: #9e9e9e;
            max-width: 400px;
            margin: 0 auto;
            line-height: 1.5;
            font-size: 12px;
        }

        /* Responsive - Hanya untuk browser, bukan print */
        @media (max-width: 768px) and not print {
            .slip-container {
                padding: 15px;
                max-width: 100%;
            }

            .horizontal-info-container {
                flex-direction: column;
                gap: 15px;
            }

            .info-column {
                min-width: 100%;
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

            .salary-table {
                font-size: 10px;
            }

            .salary-table th,
            .salary-table td {
                padding: 6px 4px;
            }
        }

        /* Jika data terlalu banyak, scroll internal */
        .table-container {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            margin-top: 10px;
        }

        @media print {

            /* Hide non-essential elements for print */
            .btn-print:hover,
            .btn-close:hover {
                transform: none;
                box-shadow: none;
            }

            /* Pastikan responsive style tidak mempengaruhi print */
            .signature-container {
                flex-direction: row !important;
                gap: 0 !important;
            }
        }
    </style>
</head>

<body>
    <div class="slip-container">
        <!-- Header Perusahaan -->
        <div class="company-header">
            <h1 class="company-name">CV SAKA PRATAMA</h1>
            <p class="company-address">Jl. Industri Raya No. 123, Kawasan Industri, Jakarta Timur 13930</p>
            <p class="company-address">Telp: (021) 1234-5678 | Email: hr@sakapratama.co.id</p>
        </div>

        <!-- Judul Slip -->
        <div class="slip-title">
            <h1>SLIP GAJI KARYAWAN</h1>
            <h2>Periode {{ date('d F Y', strtotime($periodeStart)) }} - {{ date('d F Y', strtotime($periodeEnd)) }}</h2>
        </div>

        <!-- INFO HORIZONTAL LAYOUT -->
        <div class="horizontal-info-container">
            <!-- Data Karyawan -->
            <div class="info-column">
                <div class="info-card">
                    <div class="info-row">
                        <span class="info-label">Nama</span>
                        <span class="info-value">{{ strtoupper($karyawan->nama_karyawan) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jabatan</span>
                        <span class="info-value">{{ ucfirst($karyawan->jabatan) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Total Hadir</span>
                        <span class="info-value">{{ $totalHadirKeseluruhan }} hari</span>
                    </div>
                </div>
            </div>
        </div>

        @if ($dataAbsensi->isNotEmpty())
            <!-- Rincian Absensi -->
            <div class="detail-section">
                <h3 class="section-title">RINCIAN ABSENSI HARIAN</h3>
                @if (count($dataAbsensi) > 20)
                    <div class="table-container">
                @endif
                <table class="salary-table">
                    <thead>
                        <tr>
                            <th width="15%">Tanggal</th>
                            <th width="15%">Hari</th>
                            <th width="18%" class="text-right">Gaji Pokok</th>
                            <th width="18%" class="text-right">Bonus Lembur</th>
                            <th width="18%" class="text-right">Potongan</th>
                            <th width="16%" class="text-right">Total Harian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $hariIndonesia = [
                                'Monday' => 'Senin',
                                'Tuesday' => 'Selasa',
                                'Wednesday' => 'Rabu',
                                'Thursday' => 'Kamis',
                                'Friday' => 'Jumat',
                                'Saturday' => 'Sabtu',
                                'Sunday' => 'Minggu',
                            ];
                        @endphp
                        @foreach ($dataAbsensi as $absensi)
                            <tr>
                                <td>{{ date('d/m/Y', strtotime($absensi->tanggal)) }}</td>
                                <td class="text-center">
                                    {{ $hariIndonesia[$absensi->nama_hari] ?? $absensi->nama_hari }}
                                </td>
                                <td class="text-right">Rp {{ number_format($absensi->total_gaji, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($absensi->bonus_lembur, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($absensi->potongan, 0, ',', '.') }}</td>
                                <td class="text-right" style="font-weight: 600;">
                                    Rp {{ number_format($absensi->total_bersih, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (count($dataAbsensi) > 20)
            </div>
        @endif
    </div>
    <!-- Total Gaji -->
    <div class="total-row grand-total">
        <span class="total-label">TOTAL DITERIMA</span>
        <span class="total-value">Rp {{ number_format($totalBersih, 0, ',', '.') }}</span>
    </div>
@else
    <!-- Kosong State -->
    <div class="empty-state">
        <div class="empty-state-icon">📋</div>
        <h3>Belum Ada Data Absensi</h3>
        <p>
            Tidak ada catatan absensi untuk periode ini. Slip gaji akan tersedia setelah karyawan memiliki
            catatan kehadiran.
        </p>
    </div>
    @endif

    <!-- Tanda Tangan KANAN KIRI -->
    <div class="signature-section">
        <div class="signature-container">
            <!-- Kiri: Perusahaan -->
            <div class="signature-box signature-left">
                <div class="signature-line"></div>
                <div class="signature-name">Drs. Budi Santoso</div>
                <div class="signature-title">HRD Manager</div>
            </div>

            <!-- Kanan: Karyawan -->
            <div class="signature-box signature-right">
                <div class="signature-line"></div>
                <div class="signature-name">{{ strtoupper($karyawan->nama_karyawan) }}</div>
                <div class="signature-title">Karyawan</div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="btn-print" onclick="optimizedPrint()">🖨️ Cetak Slip Gaji</button>
        <button class="btn-close" onclick="window.close()">✕ Tutup</button>
    </div>
    </div>

    <script>
        // Print dengan optimasi - MEMASTIKAN TANDA TANGAN KANAN-KIRI
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

            // Jalankan print
            window.print();

            // Kembalikan ke state asli setelah print
            setTimeout(() => {
                signatureContainer.style.cssText = originalContainerStyle;
                originalBoxStyles.forEach(item => {
                    item.element.style.cssText = item.style;
                });
            }, 100);
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

            // Juga kurangi font sizes untuk print
            document.querySelectorAll('.info-card, .salary-table, .total-row').forEach(el => {
                el.style.fontSize = '10px';
            });
        });

        window.addEventListener('afterprint', function() {
            // Restore untuk browser view
            const signatureContainer = document.querySelector('.signature-container');
            signatureContainer.style.cssText = '';

            document.querySelectorAll('.signature-box').forEach(box => {
                box.style.cssText = '';
            });

            // Restore font sizes
            document.querySelectorAll('.info-card, .salary-table, .total-row').forEach(el => {
                el.style.fontSize = '';
            });
        });
    </script>
</body>

</html>
