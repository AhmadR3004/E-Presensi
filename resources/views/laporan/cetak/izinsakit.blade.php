<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Data Izin Sakit {{ $pegawai->nama }} Bulan {{ $bulan }}-{{ $tahun }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.js"></script>

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

        .tabelizin {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .tabelizin th {
            border: 1px solid black;
            padding: 8px;
            background: #dbdbdb;
            font-size: 12px;
        }

        .tabelizin td {
            border: 1px solid black;
            padding: 5px;
            font-size: 12px;
        }

        /* Menghilangkan page break di dalam row */
        .tabelizin tr {
            page-break-inside: avoid;
        }

        .signature-section {
            margin-top: 30px;
        }

        /* Memastikan header tabel muncul di setiap halaman */
        .tabelizin thead {
            display: table-header-group;
        }

        /* Class untuk konten yang harus dimulai di halaman baru */
        .new-page {
            page-break-before: always;
        }

        /* Status approved di kolom Status */
        .status-approved-1 {
            background-color: green !important;
            /* Disetujui: hijau */
            color: white !important;
            padding: 3px;
            text-align: center;
            /* Agar teks di tengah */
        }

        .status-approved-2 {
            background-color: red !important;
            /* Ditolak: merah */
            color: white !important;
            padding: 3px;
            text-align: center;
            /* Agar teks di tengah */
        }

        .status-approved-pending {
            background-color: orange !important;
            /* Pending: oranye */
            color: white !important;
            padding: 3px;
            text-align: center;
            /* Agar teks di tengah */
        }

        /* Pastikan warna latar belakang tetap ada saat pencetakan */
        @media print {
            .status-approved-2 {
                background-color: red !important;
                /* Ditolak: merah */
                color: white !important;
                padding: 3px;
                text-align: center;
                /* Agar teks di tengah */
            }

            .status-approved-pending {
                background-color: orange !important;
                /* Pending: oranye */
                color: white !important;
                padding: 3px;
                text-align: center;
                /* Agar teks di tengah */
            }
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
            <h2>Laporan Izin Sakit Pegawai Bulan
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

        <!-- Tabel Izin Sakit -->
        <table class="tabelizin">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Izin</th>
                    <th>Status Izin</th>
                    <th>Keterangan</th>
                    <th>Status Approved</th> <!-- Kolom baru untuk status approved -->
                </tr>
            </thead>
            <tbody>
                @foreach ($izinSakit as $key => $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_izin)) }}</td>
                        <td>{{ $d->status == 'S' ? 'Sakit' : 'Izin' }}</td>
                        <td>{{ $d->keterangan }}</td>
                        <td class="px-4 py-3">
                            @if ($d->status_approved == 1)
                                <span class="status-approved-1">Disetujui</span>
                            @elseif($d->status_approved == 2)
                                <span class="status-approved-2">Ditolak</span>
                            @else
                                <span class="status-approved-pending">Pending</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Jika data kurang dari sepuluh, langsung ke tanda tangan -->
        @if (count($izinSakit) < 10)
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
        @else
            <!-- Jika data lebih dari sepuluh, lanjutkan ke halaman kedua -->
            <div class="new-page"></div>
        @endif
    </section>

    <!-- Halaman Kedua (jika ada lebih dari sepuluh data) -->
    @if (count($izinSakit) >= 10)
        <section class="sheet">
            <table class="tabelizin">
                <tbody>
                    @foreach ($izinSakit as $key => $d)
                        @if ($key >= 10)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d-m-Y', strtotime($d->tgl_izin)) }}</td>
                                <td>{{ $d->status == 'S' ? 'Sakit' : 'Izin' }}</td>
                                <td>{{ $d->keterangan }}</td>
                                <td class="px-4 py-3">
                                    @if ($d->status_approved == 1)
                                        <span class="status-approved-1">Disetujui</span>
                                    @elseif($d->status_approved == 2)
                                        <span class="status-approved-2">Ditolak</span>
                                    @else
                                        <span class="status-approved-pending">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            <!-- Tanda tangan di halaman kedua -->
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
    @endif
</body>

</html>
