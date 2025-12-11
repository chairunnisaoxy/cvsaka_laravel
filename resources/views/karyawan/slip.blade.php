<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $karyawan->nama_karyawan }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .slip-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border: 2px solid #2c3e50;
        }

        .header {
            text-align: center;
            border-bottom: 3px double #2c3e50;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2c3e50;
            margin: 0;
            font-size: 24px;
        }

        .header h2 {
            color: #e74c3c;
            margin: 5px 0;
            font-size: 18px;
        }

        .info-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #3498db;
        }

        .info-box h3 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 14px;
        }

        .info-box p {
            margin: 5px 0;
            font-size: 13px;
        }

        .table-container {
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .total-section {
            background: #2c3e50;
            color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .total-amount {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }

        .period-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #27ae60;
        }

        .period-info h4 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 14px;
        }

        .period-info p {
            margin: 5px 0;
            font-size: 13px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #666;
        }

        .print-btn {
            text-align: center;
            margin-top: 20px;
        }

        .print-btn button {
            background: #27ae60;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .slip-container {
                box-shadow: none;
                border: none;
                padding: 0;
            }

            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="slip-container">
        <div class="header">
            <h1>CV SAKA PRATAMA</h1>
            <h2>SLIP GAJI KARYAWAN</h2>
            <p>Periode: {{ date('d/m/Y', strtotime($periodeStart)) }} - {{ date('d/m/Y', strtotime($periodeEnd)) }}</p>
        </div>

        <div class="info-section">
            <div class="info-box">
                <h3>DATA KARYAWAN</h3>
                <p><strong>Nama:</strong> {{ $karyawan->nama_karyawan }}</p>
                <p><strong>ID Karyawan:</strong> {{ $karyawan->id_karyawan }}</p>
                <p><strong>Jabatan:</strong> {{ ucfirst($karyawan->jabatan) }}</p>
            </div>
            <div class="info-box">
                <h3>INFORMASI PERIODE</h3>
                <p><strong>Periode:</strong> {{ date('d/m/Y', strtotime($periodeStart)) }} -
                    {{ date('d/m/Y', strtotime($periodeEnd)) }}</p>
                <p><strong>Jumlah Hari Kerja:</strong> {{ $jumlahHari }} hari</p>
                <p><strong>Total Hadir (Kumulatif):</strong> {{ $totalHadirKeseluruhan }} hari</p>
                <p><strong>Tanggal Cetak:</strong> {{ date('d/m/Y H:i') }}</p>
            </div>
        </div>

        @if ($dataAbsensi->isNotEmpty())
            <div class="period-info">
                <h4>STATUS PERIODE</h4>
                <p>
                    <strong>Hari Hadir Periode Ini:</strong> {{ $jumlahHari }} hari dari maksimal 14 hari
                    @if ($totalHadirAktif >= 14)
                        <span style="color: #e74c3c; font-weight: bold;"> (PERIODE SUDAH PENUH)</span>
                    @elseif($totalHadirAktif >= 12)
                        <span style="color: #f39c12; font-weight: bold;"> (HAMPIR PENUH)</span>
                    @else
                        <span style="color: #27ae60; font-weight: bold;"> (MASIH BERLANJUT)</span>
                    @endif
                </p>
                <p><strong>Catatan:</strong> Sistem akan otomatis mengarsipkan periode ini setelah mencapai 14 hari
                    hadir.</p>
            </div>

            <div class="table-container">
                <h3>RINCIAN ABSENSI PERIODE INI</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Gaji Pokok</th>
                            <th>Bonus Lembur</th>
                            <th>Potongan</th>
                            <th>Total</th>
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
                                <td>{{ $hariIndonesia[$absensi->nama_hari] ?? $absensi->nama_hari }}</td>
                                <td>Rp {{ number_format($absensi->total_gaji, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($absensi->bonus_lembur, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($absensi->potongan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($absensi->total_bersih, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="total-section">
                <h3>TOTAL PENERIMAAN PERIODE INI</h3>
                <div class="total-amount">
                    Rp {{ number_format($totalBersih, 0, ',', '.') }}
                </div>
                <p>
                    Gaji Pokok: Rp {{ number_format($totalGaji, 0, ',', '.') }} |
                    Bonus: Rp {{ number_format($totalBonus, 0, ',', '.') }} |
                    Potongan: Rp {{ number_format($totalPotongan, 0, ',', '.') }}
                </p>
            </div>
        @else
            <div style="text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 5px;">
                <h3 style="color: #6c757d;">Belum ada data absensi untuk periode ini</h3>
                <p style="color: #6c757d;">Karyawan ini belum memiliki catatan absensi dengan status hadir.</p>
                <p style="color: #6c757d;">Periode akan dimulai saat karyawan pertama kali hadir.</p>
            </div>
        @endif

        <div class="footer">
            <p><strong>SISTEM PENGGAJIAN 14 HARI:</strong> Setiap 14 hari kerja, periode akan direset dan diarsipkan
                otomatis.</p>
            <p>Slip gaji ini dicetak secara otomatis oleh sistem penggajian CV Saka Pratama</p>
            <p>Jl. Contoh No. 123, Kota Contoh - Telp: (021) 123-4567</p>
        </div>

        <div class="print-btn">
            <button onclick="window.print()">🖨️ Cetak Slip Gaji</button>
            <button onclick="window.close()" style="background: #95a5a6; margin-left: 10px;">Tutup</button>
        </div>
    </div>
</body>

</html>
