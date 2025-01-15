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
            margin: 20mm;
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
    </style>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</head>

<body class="A4">
    <!-- Halaman Pertama -->
    <section class="sheet">
        <!-- Header Laporan -->
        <table style="width: 100%;">
            <tr>
                <td style="width: 100px;">
                    <img src="{{ asset('assets/img/login/logo.png') }}" width="85" height="100" alt="">
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
                <td rowspan="5">
                    @php
                        $path = Storage::url('uploads/pegawai/' . $pegawai->foto);
                    @endphp
                    <img src="{{ url($path) }}" width="120px" height="150" alt="">
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

        <!-- Awal tabel presensi - hanya menampilkan 10 baris pertama -->
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
                @foreach ($presensi as $key => $d)
                    @if ($key < 10)
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
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                            <td>{{ $d->jam_in }}</td>
                            <td><img src="{{ url($path_in) }}" width="40" height="30" alt=""></td>
                            <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</td>
                            <td>
                                @if ($d->jam_out != null)
                                    <img src="{{ url($path_out) }}" width="40" height="30" alt="">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $keterangan }}</td>
                            <td>{{ $jamKerja }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </section>

    <!-- Halaman Kedua -->
    <section class="sheet">
        <!-- Lanjutan tabel presensi -->
        <table class="tabelpresensi">
            <tbody>
                @foreach ($presensi as $key => $d)
                    @if ($key >= 10)
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
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                            <td>{{ $d->jam_in }}</td>
                            <td><img src="{{ url($path_in) }}" width="40" height="30" alt=""></td>
                            <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Absen' }}</td>
                            <td>
                                @if ($d->jam_out != null)
                                    <img src="{{ url($path_out) }}" width="40" height="30" alt="">
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $keterangan }}</td>
                            <td>{{ $jamKerja }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
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
                        <u><b>YUSNA IRAWAN, SE, M.Eng</b></u><br>
                        <b>Pembina Utama Muda (IV/c)</b><br>
                        <b>NIP. 19721222 200003 1 004</b>
                    </td>
                    <td style="text-align: center; vertical-align: bottom; height: 100px">
                        <p>Pimpinan</p><br>
                        <br>
                        <br>
                        <br>
                        <u><b>YUSNA IRAWAN, SE, M.Eng</b></u><br>
                        <b>Pembina Utama Muda (IV/c)</b><br>
                        <b>NIP. 19721222 200003 1 004</b>
                    </td>
                </tr>
            </table>
        </div>
    </section>
</body>

</html>
