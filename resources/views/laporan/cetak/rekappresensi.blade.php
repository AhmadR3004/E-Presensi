<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Rekap E-Presensi Pegawai Bulan {{ $bulan }}-{{ $tahun }}</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A3 landscape;
            margin: 5mm;
            /* Mengurangi margin */
        }

        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .header-line {
            border-top: 3px solid black;
            margin-top: 5px;
        }

        .tabelpresensi {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        .tabelpresensi tr th,
        .tabelpresensi td {
            border: 1px solid black;
            padding: 5px;
            font-size: 10px;
        }

        .sheet {
            padding: 5mm;
            /* Mengurangi padding */
        }

        table {
            page-break-inside: avoid;
            /* Mencegah tabel terpotong */
        }

        /* Hindari halaman kosong */
        html,
        body {
            height: 100%;
            overflow: hidden;
        }
    </style>
</head>

<body class="A3 landscape">

    <section class="sheet">
        <!-- Header Laporan -->
        <table style="width: 100%;">
            <tr>
                <td style="width: 100px;">
                    <img src="{{ public_path('assets/img/login/logo.png') }}" width="85" height="110"
                        alt="">
                </td>
                <td align="center">
                    <p style="margin-bottom: -1em; font-size: 18px">PEMERINTAH KOTA BANJARMASIN</p>
                    <h2>DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL</h2>
                    <p style="margin-top: -1em">Jalan Sultan Adam No. 18 RT. 28 Banjarmasin 70122<br>
                        Telepon 0511-3307293<br>
                        www.disdukcapil.banjarmasinkota.go.id</p>
                </td>
            </tr>
        </table>
        <div class="header-line"></div>
        <div style="text-align: right; margin-top: 10px;">Banjarmasin, {{ date('j F Y') }}</div>
        <div style="text-align: center;">
            <h2>Laporan Rekap E-PRESENSI Pegawai Bulan
                @php
                    $namaBulan = [
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ];
                @endphp
                {{ $namaBulan[$bulan] }} {{ $tahun }}
            </h2>
        </div>

        <table class="tabelpresensi">
            <tr>
                <th rowspan="2">NIP</th>
                <th rowspan="2">Nama Pegawai</th>
                <th colspan="31">Tanggal</th>
                <th rowspan="2">TH</th>
                <th rowspan="2">TT</th>
            </tr>
            <tr>
                <?php
                for($i=1; $i<=31; $i++){
                    ?>
                <th>{{ $i }}</th>
                <?php
                }
                ?>
            </tr>
            @foreach ($rekap as $d)
                <tr>
                    <td>{{ $d->pegawai_id }}</td>
                    <td>{{ $d->nama }}</td>

                    <?php
                    $totalhadir = 0;
                    $totalterlambat = 0;
                    for($i=1; $i<=31; $i++){
                        $tgl = 'tgl_'.$i;
                        if(empty($d->$tgl)){
                            $hadir = ['',''];
                        }else {
                            $hadir = explode("-",$d->$tgl);
                            $totalhadir += 1;
                            if($hadir[0] > "09:00:00"){
                                $totalterlambat += 1;
                            }
                        }
                    ?>
                    <td>
                        <span style="color:{{ $hadir[0] > '09:00:00' ? 'red' : '' }}">{{ $hadir[0] }}</span>
                        <span style="color:{{ $hadir[1] < '16:00:00' ? 'red' : '' }}">{{ $hadir[1] }}</span>
                    </td>
                    <?php
                    }
                    ?>
                    <td>{{ $totalhadir }}</td>
                    <td>{{ $totalterlambat }}</td>
                </tr>
            @endforeach
        </table>

        <div style="text-align: right; margin-top: 20px; font-size: 10px; color: red;">
            <i>*TH = Total Hadir, TT = Total Terlambat</i>
        </div>

        <!-- Tanda tangan di halaman terakhir -->
        <div class="signature-section">
            <table width="100%">
                <tr>
                    <td style="text-align: center; vertical-align: bottom; height: 100px">
                        <p>KEPALA DINAS</p><br>
                        <br>
                        <br>
                        <br>
                        @if ($ttd1)
                            <u><b>{{ $ttd1->nama }}</b></u><br>
                            <b>{{ $ttd1->pangkat }}</b><br>
                            <b>NIP. {{ $ttd1->nip }}</b>
                        @else
                            <b>Data Kepala Dinas Tidak Ditemukan</b>
                        @endif
                    </td>
                    <td style="text-align: center; vertical-align: bottom; height: 100px">
                        <p>PIMPINAN</p><br>
                        <br>
                        <br>
                        <br>
                        @if ($ttd2)
                            <u><b>{{ $ttd2->nama }}</b></u><br>
                            <b>{{ $ttd2->pangkat }}</b><br>
                            <b>NIP. {{ $ttd2->nip }}</b>
                        @else
                            <b>Data Kepala UPT Tidak Ditemukan</b>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

    </section>

</body>

</html>
