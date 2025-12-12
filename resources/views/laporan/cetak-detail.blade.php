<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Laporan Penggajian - {{ $laporan->nama_karyawan }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .laporan-container {
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

        /* Judul Laporan */
        .laporan-title {
            text-align: center;
            margin: 20px 0 25px 0;
            padding: 15px;
            background: linear-gradient(135deg, #f5f7ff 0%, #e8eaf6 100%);
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .laporan-title h1 {
            color: #1a237e;
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }

        .laporan-title h2 {
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

        /* Ringkasan Penggajian */
        .summary-section {
            margin: 25px 0;
            border: 2px solid #1a237e;
            border-radius: 8px;
            padding: 25px;
            background: linear-gradient(135deg, #f5f7ff 0%, #e8eaf6 100%);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 15px;
            padding: 8px 0;
            border-bottom: 1px dashed #ddd;
        }

        .summary-row:last-child {
            border-bottom: none;
        }

        .summary-label {
            color: #333;
            font-weight: 500;
        }

        .summary-value {
            color: #333;
            font-weight: 600;
        }

        .grand-total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #1a237e;
        }

        .grand-total .summary-label {
            font-size: 18px;
            color: #1a237e;
            font-weight: 600;
        }

        .grand-total .summary-value {
            font-size: 20px;
            color: #d32f2f;
            font-weight: 700;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 10px;
        }

        .status-completed {
            background: #e8f5e8;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
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

            .laporan-container {
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

            .laporan-title {
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

            .summary-section {
                margin: 15px 0;
                padding: 15px;
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
            .laporan-title,
            .horizontal-info-container,
            .summary-section,
            .grand-total,
            .signature-section,
            .signature-container {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }

            /* Font size adjustments for print */
            .info-row {
                font-size: 11px;
            }

            .summary-row {
                font-size: 13px;
            }

            .grand-total .summary-label {
                font-size: 16px;
            }

            .grand-total .summary-value {
                font-size: 18px;
            }
        }

        /* Footer Laporan */
        .laporan-footer {
            font-size: 11px;
            color: #666;
            text-align: center;
            margin-top: 20px;
            line-height: 1.5;
            padding: 15px;
            background: #f5f5f5;
            border-radius: 6px;
        }

        /* ID Laporan Styling */
        .laporan-id {
            text-align: center;
            margin: 15px 0;
            padding: 10px;
            background: #f0f0f0;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            letter-spacing: 1px;
        }

        /* Responsive - Hanya untuk browser, bukan print */
        @media (max-width: 768px) and not print {
            .laporan-container {
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

        /* Terbilang Section */
        .terbilang-section {
            text-align: center;
            margin: 15px 0;
            font-style: italic;
            color: #666;
            font-size: 13px;
            padding: 12px;
            background: #f9f9f9;
            border-radius: 6px;
            border: 1px dashed #ddd;
        }

        /* Progress Bar Styling */
        .progress-container {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #ddd;
        }

        .progress-bar {
            height: 10px;
            background: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #4caf50, #8bc34a);
            border-radius: 5px;
        }

        .progress-text {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="laporan-container">
        <!-- Header Perusahaan -->
        <div class="company-header">
            <h1 class="company-name">CV SAKA PRATAMA</h1>
            <p class="company-address">Jl. Industri Raya No. 123, Kawasan Industri, Jakarta Timur 13930</p>
            <p class="company-address">Telp: (021) 1234-5678 | Email: hr@sakapratama.co.id</p>
        </div>

        <!-- Judul Laporan -->
        <div class="laporan-title">
            <h1>LAPORAN PENGGAJIAN</h1>
            <h2>Periode {{ date('d F Y', strtotime($laporan->periode_start)) }} -
                {{ date('d F Y', strtotime($laporan->periode_end)) }}</h2>
        </div>

        <!-- ID Laporan -->
        <div class="laporan-id">
            <strong>ID LAPORAN:</strong> {{ $laporan->id_laporan }}
        </div>

        <!-- INFO HORIZONTAL LAYOUT -->
        <div class="horizontal-info-container">
            <!-- Data Karyawan -->
            <div class="info-column">
                <div class="info-card">
                    <h3>DATA KARYAWAN</h3>
                    <div class="info-row">
                        <span class="info-label">Nama</span>
                        <span class="info-value">{{ strtoupper($laporan->nama_karyawan) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jabatan</span>
                        <span class="info-value">{{ ucfirst($laporan->jabatan) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Jumlah Hari</span>
                        <span class="info-value">
                            {{ $laporan->jumlah_hari }} hari
                            <span class="status-badge status-completed">DIARSIPKAN</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>



        <!-- Ringkasan Penggajian -->
        <div class="summary-section">
            <h3 style="text-align: center; color: #1a237e; margin-bottom: 20px;">RINGKASAN PENGGAJIAN</h3>

            <div class="summary-row">
                <span class="summary-label">Total Gaji Pokok</span>
                <span class="summary-value">Rp {{ number_format($laporan->total_gaji, 0, ',', '.') }}</span>
            </div>

            <div class="summary-row">
                <span class="summary-label">Total Bonus Lembur</span>
                <span class="summary-value">Rp {{ number_format($laporan->total_bonus, 0, ',', '.') }}</span>
            </div>

            <div class="summary-row">
                <span class="summary-label">Total Potongan</span>
                <span class="summary-value" style="color: #d32f2f;">
                    - Rp {{ number_format($laporan->total_potongan, 0, ',', '.') }}
                </span>
            </div>

            <div class="summary-row grand-total">
                <span class="summary-label">TOTAL DITERIMA</span>
                <span class="summary-value">Rp {{ number_format($laporan->total_bersih, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Tanda Tangan KANAN KIRI -->
        <div class="signature-section">
            <div class="signature-container">
                <!-- Kiri: Perusahaan -->
                <div class="signature-box signature-left">
                    <div class="signature-line"></div>
                    <div class="signature-name">Drs. Budi Santoso</div>
                    <div class="signature-title">HRD Manager</div>
                    <div class="signature-title">CV Saka Pratama</div>
                </div>

                <!-- Kanan: Karyawan -->
                <div class="signature-box signature-right">
                    <div class="signature-line"></div>
                    <div class="signature-name">{{ strtoupper($laporan->nama_karyawan) }}</div>
                    <div class="signature-title">Karyawan</div>
                    <div class="signature-title">{{ ucfirst($laporan->jabatan) }}</div>
                </div>
            </div>
        </div>

        <!-- Catatan Kaki -->
        <div class="laporan-footer">
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
            document.querySelectorAll('.info-card, .summary-row').forEach(el => {
                el.style.fontSize = '11px';
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
            document.querySelectorAll('.info-card, .summary-row').forEach(el => {
                el.style.fontSize = '';
            });
        });

        // Progress bar animation
        document.addEventListener('DOMContentLoaded', function() {
            const progressFill = document.querySelector('.progress-fill');
            if (progressFill) {
                const width = progressFill.style.width;
                progressFill.style.width = '0%';

                setTimeout(() => {
                    progressFill.style.transition = 'width 1s ease-in-out';
                    progressFill.style.width = width;
                }, 300);
            }
        });
    </script>
</body>

</html>
