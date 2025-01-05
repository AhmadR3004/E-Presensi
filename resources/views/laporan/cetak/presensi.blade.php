<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan E-Presensi Pegawai</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        .header-line {
            border-top: 3px solid black;
            margin-top: 5px;
        }

        .tabeldatapegawai {
            margin-top: 20px;
        }

        .tabeldatapegawai td {
            padding: 5px;
        }

        .tabelpresensi {
            border-collapse: collapse;
            width: 100%;
            margin top: 20px;
        }

        .tabelpresensi tr th {
            border: 1px solid black;
            padding: 8px;
            background: #dbdbdb;
        }

        .tabelpresensi td {
            border: 1px solid black;
            padding: 5px;
            font-size: 12px;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width: 100%;">
            <tr>
                <td>
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

        <table class="tabelpresensi">
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

                    // Perhitungan jam kerja
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
                    <td>
                        <span class="inline-block px-3 py-1 text-sm font-semibold text-white rounded-full">
                            {{ $keterangan }}
                        </span>
                    </td>
                    <td>{{ $jamKerja }}</td>
                </tr>
            @endforeach
        </table>

        <table width="100%" style="margin-top: 100px">
            <tr>
                <td style="text-align: center; vertical-align: bottom; height: 100px">
                    <p>KEPALA DINAS</p><br>
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
                    <u><b>YUSNA IRAWAN, SE, M.Eng</b></u><br>
                    <b>Pembina Utama Muda (IV/c)</b><br>
                    <b>NIP. 19721222 200003 1 004</b>
                </td>
            </tr>
        </table>

    </section>

</body>

</html>
