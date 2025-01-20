<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Rekap Data Izin Sakit Pegawai Bulan {{ $bulan }}-{{ $tahun }}</title>
    <style>
        @page {
            size: A3 landscape;
            margin: 5mm;
        }

        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
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
        }

        table {
            page-break-inside: avoid;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .izin-approved {
            background-color: green !important;
            color: white !important;
        }

        .izin-rejected {
            background-color: red !important;
            color: white !important;
        }

        .izin-pending {
            background-color: orange !important;
            color: white !important;
        }

        /* Pastikan untuk menampilkan semua elemen dengan benar */
        .sheet,
        .tabelpresensi,
        table {
            page-break-inside: avoid !important;
        }
    </style>
</head>

<body>

    <section class="sheet padding-10mm">

        <table style="width: 100%;">
            <tr>
                <td>
                    <!-- Make sure to use an absolute path for the image -->
                    <img src="{{ public_path('assets/img/login/logo.png') }}" width="85" height="100" alt="">
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
            <h2>Laporan Rekap Data Izin Sakit Pegawai Bulan
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
                <th rowspan="2">TI</th>
                <th rowspan="2">TS</th>
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
                    $totalIzin = 0;
                    $totalSakit = 0;
                    for($i=1; $i<=31; $i++){
                        $tgl = 'tgl_'.$i;
                        if(empty($d->$tgl)){
                            $status = '';
                        } else {
                            $status = $d->$tgl;
                            if($status === 'i'){
                                $totalIzin += 1;
                            } elseif($status === 's'){
                                $totalSakit += 1;
                            }
                        }
                    ?>
                    <td
                        class=" @if ($status === 'i' && $d->{'status_approved_' . $i} == 1) izin-approved
                        @elseif($status === 'i' && $d->{'status_approved_' . $i} == 2) izin-rejected
                        @elseif($status === 'i' && $d->{'status_approved_' . $i} == 0) izin-pending
                        @elseif($status === 's' && $d->{'status_approved_' . $i} == 1) izin-approved
                        @elseif($status === 's' && $d->{'status_approved_' . $i} == 2) izin-rejected
                        @elseif($status === 's' && $d->{'status_approved_' . $i} == 0) izin-pending @endif">
                        @if ($status === 'i')
                            Izin
                        @elseif($status === 's')
                            Sakit
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <?php
                    }
                    ?>
                    <td>{{ $totalIzin }}</td>
                    <td>{{ $totalSakit }}</td>
                </tr>
            @endforeach
        </table>

        <!-- Keterangan status -->
        <div class="status-legend" style="text-align: right; margin-top: 20px; font-size: 10px;">
            <span style="color: green;">• Disetujui (Hijau)</span>
            <span style="color: orange;">• Pending (Oranye)</span>
            <span style="color: red;">• Ditolak (Merah)</span>
        </div>

        <div style="text-align: right; margin-top: 5px; font-size: 10px; color: red;">
            <i>*TI = Total Izin, TS = Total Sakit</i>
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
