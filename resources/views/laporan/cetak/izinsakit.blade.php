<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Data Izin Sakit {{ $pegawai->nama }} Bulan {{ $bulan }}-{{ $tahun }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .sheet {
            padding: 10mm;
        }

        .header-line {
            border-top: 3px solid black;
            margin-top: 5px;
        }

        .tabeldatapegawai {
            margin-top: 5px;
            margin-bottom: 20px;
        }

        .tabeldatapegawai td {
            padding: 5px;
        }

        .tabelizin {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .tabelizin th,
        .tabelizin td {
            border: 1px solid black;
            padding: 8px;
            font-size: 12px;
        }

        .status-approved-1 {
            background-color: green;
            color: white;
            padding: 3px;
            text-align: center;
        }

        .status-approved-2 {
            background-color: red;
            color: white;
            padding: 3px;
            text-align: center;
        }

        .status-approved-pending {
            background-color: orange;
            color: white;
            padding: 3px;
            text-align: center;
        }

        .signature-section {
            margin-top: 30px;
        }

        .new-page {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <section class="sheet">
        <!-- Header Laporan -->
        <table style="width: 100%;">
            <tr>
                <td style="width: 100px;">
                    <img src="{{ public_path('assets/img/login/logo.png') }}" width="85" height="110" alt="">
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
            <h3>Laporan Izin Sakit Pegawai Bulan
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
            </h3>
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

        <!-- Tabel Izin Sakit -->
        <table class="tabelizin">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal Izin</th>
                    <th>Status Izin</th>
                    <th>Keterangan</th>
                    <th>Status Approved</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($izinSakit as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tgl_izin)) }}</td>
                        <td>{{ $d->status == 'S' ? 'Sakit' : 'Izin' }}</td>
                        <td>{{ $d->keterangan }}</td>
                        <td>
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
