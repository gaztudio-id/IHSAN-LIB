<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Bebas Pustaka - {{ $sbp->member->name }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; margin: 0; padding: 20px; color: #000; line-height: 1.4; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 22px; text-transform: uppercase; font-weight: bold; }
        .header h2 { margin: 2px 0; font-size: 16px; font-weight: normal; }
        .header p { margin: 2px 0; font-size: 13px; }
        .title { text-align: center; font-size: 18px; font-weight: bold; text-decoration: underline; margin-bottom: 20px; }
        .content { margin-bottom: 20px; line-height: 1.5; font-size: 16px; }
        .signature-section { float: right; width: 250px; text-align: center; margin-top: 30px; }
        .signature-name { font-weight: bold; text-decoration: underline; margin-top: 70px; }
        
        @media print {
            @page { margin: 15mm; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h1>Perpustakaan Al-Ihsan Boarding School</h1>
        <h2>Jl. Pesantren No. 1, Desa Kubang Jaya, Kec. Siak Hulu, Kampar, Riau</h2>
        <p>Telp: (0761) 1234567 | Email: perpus@al-ihsan.sch.id</p>
    </div>

    <div class="title">
        SURAT KETERANGAN BEBAS PUSTAKA<br>
        <span style="font-size: 14px; font-weight: normal;">Nomor: {{ $sbp->letter_number ?? '.../SBP/IHSAN-LIB/.../...' }}</span>
    </div>

    <div class="content">
        <p style="margin-bottom: 20px;"><strong><em>Assalamu’alaikum Warahmatullahi Wabarakatuh</em></strong></p>

        <p>Yang bertanda tangan di bawah ini, Kepala Perpustakaan Al-Ihsan Boarding School Riau, menerangkan bahwa:</p>
        
        <table style="width: 100%; margin: 20px 0;">
            <tr><td style="width: 150px;">Nama</td><td>: <strong>{{ $sbp->member->name }}</strong></td></tr>
            <tr><td>NIS</td><td>: {{ $sbp->member->nis }}</td></tr>
            <tr><td>Kelas</td><td>: {{ $sbp->member->class ?? 'XII' }}</td></tr>
        </table>

        <p>Setelah dilakukan pemeriksaan administrasi perpustakaan, santri tersebut dinyatakan <strong>tidak memiliki tanggungan peminjaman buku</strong> maupun denda administrasi di Perpustakaan Al-Ihsan Boarding School.</p>
        
        <p>Surat keterangan ini diberikan untuk dipergunakan sebagai syarat pengambilan ijazah / rapor.</p>
        
        <p>Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
        
        <p style="margin-top: 20px;"><strong><em>Wassalamu’alaikum Warahmatullahi Wabarakatuh</em></strong></p>
    </div>

    <div class="signature-section">
        <p>Kubang Jaya, {{ \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
        <p>Kepala Perpustakaan,</p>
        <div class="signature-name">Ust. Abdullah, S.Pd.I</div>
        <div>NIP. 19800101 201001 1 001</div>
    </div>

</body>
</html>
