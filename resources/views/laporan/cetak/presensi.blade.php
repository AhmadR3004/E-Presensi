<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan E-Presensi {{ $pegawai->nama }} Bulan {{ $bulan }}-{{ $tahun }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .sheet {
            padding: 20mm;
        }

        .header-line {
            border-top: 3px solid black;
            margin-top: 5px;
        }

        .tabeldatapegawai {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .tabeldatapegawai td {
            padding: 5px;
        }

        .tabelpresensi {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .tabelpresensi th {
            border: 1px solid black;
            padding: 8px;
            background: #dbdbdb;
            font-size: 12px;
        }

        .tabelpresensi td {
            border: 1px solid black;
            padding: 5px;
            font-size: 12px;
        }

        /* Menghilangkan page break di dalam row */
        .tabelpresensi tr {
            page-break-inside: avoid;
        }

        .signature-section {
            margin-top: 30px;
        }

        /* Memastikan header tabel muncul di setiap halaman */
        .tabelpresensi thead {
            display: table-header-group;
        }

        /* Class untuk konten yang harus dimulai di halaman baru */
        .new-page {
            page-break-before: always;
        }

        .tabeltotal {
            width: 100%;
            margin-top: 20px;
            font-size: 12px;
        }

        .tabeltotal td {
            padding: 5px;
            text-align: left;
        }

        .footer-note {
            font-size: 10px;
            text-align: center;
            margin-top: 5px;
        }
    </style>
</head>

<body class="A4">
    <!-- Halaman Pertama -->
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
            <h2>Laporan E-PRESENSI Pegawai Bulan
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

        <!-- Data Pegawai -->
        <table class="tabeldatapegawai">
            <tr>
                <td rowspan="6">
                    @php
                        $path = public_path('storage/uploads/pegawai/' . $pegawai->foto);
                        if (!$pegawai->foto || !file_exists($path)) {
                            // Foto tidak ada, gunakan foto default
                            $path = public_path('default.jpg');
                        }
                    @endphp
                    <img src="{{ $path }}" width="120px" height="150" alt="">
                </td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td>{{ $nip }}</td>
            </tr>
            <tr>
                <td>Nama Pegawai</td>
                <td>:</td>
                <td>{{ $pegawai->nama }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $jabatan->nama_jabatan }}</td>
            </tr>
            <tr>
                <td>No. WhatsApp</td>
                <td>:</td>
                <td>{{ $pegawai->no_telp }}</td>
            </tr>
        </table>

        <!-- tabel presensi -->
        <table class="tabelpresensi">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Foto</th>
                    <th>Jam Pulang</th>
                    <th>Foto</th>
                    <th>Keterangan</th>
                    <th>Jam Kerja</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalTerlambat = 0;
                    $totalTepatWaktu = 0;
                @endphp
                @foreach ($presensi as $d)
                    @php
                        $path_in = Storage::url('uploads/absensi/' . $d->foto_in);
                        $path_out = Storage::url('uploads/absensi/' . $d->foto_out);
                        $cutOffTime = '09:00:00';
                        $jamMasuk = strtotime($d->jam_in);
                        $jamPulang = $d->jam_out != null ? strtotime($d->jam_out) : null;
                        $batasAbsen = strtotime($cutOffTime);
                        $terlambat = $jamMasuk > $batasAbsen;
                        $selisihTerlambat = $terlambat ? gmdate('H:i:s', $jamMasuk - $batasAbsen) : '';
                        $keterangan = $terlambat ? "Terlambat $selisihTerlambat" : 'Tepat Waktu';
                        $jamKerja = $jamPulang ? gmdate('H:i:s', $jamPulang - $jamMasuk) : '-';

                        // Hitung total terlambat dan tepat waktu
                        if ($terlambat) {
                            $totalTerlambat++;
                        } else {
                            $totalTepatWaktu++;
                        }
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                        <td>{{ $d->jam_in }}</td>
                        <td>
                            @if ($d->foto_in && file_exists(public_path('storage/uploads/absensi/' . $d->foto_in)))
                                <img src="{{ url($path_in) }}" width="40" height="30" alt="Foto Masuk">
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</td>
                        <td>
                            @if ($d->foto_out && file_exists(public_path('storage/uploads/absensi/' . $d->foto_out)))
                                <img src="{{ url($path_out) }}" width="40" height="30" alt="Foto Pulang">
                            @else
                                <span>-</span>
                            @endif
                        </td>
                        <td>{{ $keterangan }}</td>
                        <td>{{ $jamKerja }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tabel Total Terlambat dan Tepat Waktu -->
        <table class="tabeltotal">
            <tr>
                <td style="vertical-align: top;"><strong>Terlambat:</strong> {{ $totalTerlambat }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;"><strong>Tepat Waktu:</strong> {{ $totalTepatWaktu }}</td>
            </tr>
        </table>

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
