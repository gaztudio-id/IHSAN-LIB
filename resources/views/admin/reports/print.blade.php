<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bulanan {{ $monthName }} {{ $year }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #22543d; padding-bottom: 15px; }
        .logo { width: 80px; height: auto; position: absolute; left: 0; top: 0; }
        .title-wrapper { margin-left: 0; } /* Centered because logo is absolute */
        .title { font-size: 18px; font-weight: bold; text-transform: uppercase; color: #22543d; margin: 0; }
        .subtitle { font-size: 14px; margin: 5px 0; }
        .meta { font-size: 11px; color: #666; margin-top: 5px; }
        
        .section-title { font-size: 14px; font-weight: bold; background-color: #f0fdf4; padding: 5px 10px; border-left: 4px solid #22543d; margin-top: 20px; margin-bottom: 10px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px 12px; text-align: left; }
        th { background-color: #f9f9f9; width: 60%; font-weight: normal; }
        td { font-weight: bold; color: #000; }
        
        .footer { position: fixed; bottom: 30px; right: 0; text-align: right; width: 250px; }
        .signature-line { margin-top: 60px; border-top: 1px solid #333; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title" style="text-align: center; font-size: 20px; font-weight: bold; text-transform: uppercase; color: #166534; margin-bottom: 5px;">Laporan Aktivitas & Statistik Bulanan</h1>
        <h2 class="subtitle" style="text-align: center; font-size: 16px; margin: 0; color: #14532d;">Perpustakaan Ihsan Lib</h2>
        <p class="meta" style="text-align: center; margin-top: 10px; font-weight: bold; color: #064e3b; font-size: 14px; background-color: #f0fdf4; padding: 5px; display: inline-block;">Periode: {{ $monthName }} {{ $year }}</p>
    </div>

    <div class="content">
        <div class="section-title">Ringkasan Statistik</div>
        <table>
            <tr>
                <th>Anggota Baru Terdaftar</th>
                <td>{{ $newMembers }}</td>
            </tr>
            <tr>
                <th>Koleksi Buku Baru</th>
                <td>{{ $newBooks }}</td>
            </tr>
            <tr>
                <th>Total Kunjungan (Absensi)</th>
                <td>{{ $visitsCount }}</td>
            </tr>
            <tr>
                <th>Total Peminjaman Buku</th>
                <td>{{ $loansCount }}</td>
            </tr>
            <tr>
                <th>Total Pengembalian</th>
                <td>{{ $returnsCount }}</td>
            </tr>
            <tr>
                <th>Surat Bebas Pustaka (SBP) Terbit</th>
                <td>{{ $sbpIssued }}</td>
            </tr>
        </table>

        <div class="section-title">Keterangan</div>
        <p style="text-align: justify; line-height: 1.5;">
            Pada bulan {{ $monthName }} {{ $year }}, Perpustakaan Ihsan Lib mencatat aktivitas pelayanan dan pengelolaan yang aktif. 
            Tercatat sebanyak <strong>{{ $visitsCount }} kunjungan</strong> anggota ke perpustakaan, dengan penambahan koleksi bahan pustaka sebanyak <strong>{{ $newBooks }} buku baru</strong>. 
            Selain itu, terdapat pertumbuhan anggota dengan bergabungnya <strong>{{ $newMembers }} anggota baru</strong>. 
            Sirkulasi peminjaman buku berjalan lancar dengan total <strong>{{ $loansCount }} transaksi peminjaman</strong> dan <strong>{{ $returnsCount }} pengembalian</strong>.
            Laporan ini dibuat secara otomatis oleh sistem pada tanggal {{ now()->translatedFormat('d F Y') }}.
        </p>
    </div>

    <div class="footer">
        <p>Pekanbaru, {{ now()->translatedFormat('d F Y') }}</p>
        <p style="margin-bottom: 60px;">Mengetahui,<br>Kepala Perpustakaan</p>
        <div class="signature-line"></div>
        <p style="font-weight: bold;">( .......................................... )</p>
    </div>
</body>
</html>
