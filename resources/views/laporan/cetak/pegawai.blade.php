<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Data Pegawai</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <style>
        @page {
            size: A3 landscape;
            margin: 5mm;
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
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .tabeldatapegawai th {
            border: 1px solid black;
            padding: 8px;
            background: #dbdbdb;
            font-size: 10px;
        }

        .tabeldatapegawai td {
            border: 1px solid black;
            padding: 5px;
            font-size: 12px;
        }

        /* Menghilangkan page break di dalam row */
        .tabeldatapegawai tr {
            page-break-inside: avoid;
        }

        .signature-section {
            margin-top: 30px;
        }

        /* Memastikan header tabel muncul di setiap halaman */
        .tabeldatapegawai thead {
            display: table-header-group;
        }

        /* Class untuk konten yang harus dimulai di halaman baru */
        .new-page {
            page-break-before: always;
        }
    </style>
</head>

<body class="A3 lan">
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
            <h2>Laporan Data Pegawai</h2>
        </div>

        <!-- Tabel Data Pegawai -->
        <table class="tabeldatapegawai">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="p-8">Foto</th>
                    <th scope="col" class="p-4">Nama</th>
                    <th scope="col" class="p-4">NIP</th>
                    <th scope="col" class="p-4">Jabatan</th>
                    <th scope="col" class="p-4">Kode Jabatan</th> <!-- Kolom untuk kode jabatan -->
                    <th scope="col" class="p-4">Pangkat</th> <!-- Kolom untuk pangkat jabatan -->
                    <th scope="col" class="p-4">Departemen</th> <!-- Kolom untuk departemen jabatan -->
                    <th scope="col" class="p-4">Tingkat Jabatan</th> <!-- Kolom untuk tingkat jabatan -->
                    <th scope="col" class="p-4">Jenis Kelamin</th>
                    <th scope="col" class="p-4">Email</th>
                    <th scope="col" class="p-4">Alamat</th>
                    <th scope="col" class="p-4">No. Telepon</th>
                    <th scope="col" class="p-4">Tanggal Lahir</th>
                    <th scope="col" class="p-4">Tanggal Masuk</th>
                    <th scope="col" class="p-5">Gaji Pokok</th> <!-- Kolom untuk gaji pokok jabatan -->
                    <th scope="col" class="p-5">Tunjangan</th> <!-- Kolom untuk tunjangan jabatan -->
                    <th scope="col" class="p-5">Total Gaji</th> <!-- Kolom untuk total gaji -->
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawai as $p)
                    <tr>
                        <td class="p-4">
                            <img src="{{ $p->foto ? public_path('storage/uploads/pegawai/' . $p->foto) : public_path('default.jpg') }}"
                                width="60px" height="80">
                        </td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->nip }}</td>
                        <td>{{ $p->jabatan_nama }}</td>
                        <td>{{ $p->kode_jabatan }}</td> <!-- Menampilkan kode jabatan -->
                        <td>{{ $p->pangkat }}</td> <!-- Menampilkan pangkat jabatan -->
                        <td>{{ $p->departemen }}</td> <!-- Menampilkan departemen jabatan -->
                        <td>{{ $p->tingkat_jabatan }}</td> <!-- Menampilkan tingkat jabatan -->
                        <td>{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>{{ $p->no_telp }}</td>
                        <td>{{ $p->tanggal_lahir }}</td>
                        <td>{{ $p->tanggal_masuk }}</td>
                        <td>Rp. {{ number_format($p->gaji_pokok, 0, ',', '.') }}</td> <!-- Menampilkan gaji pokok -->
                        <td>Rp. {{ number_format($p->tunjangan, 0, ',', '.') }}</td> <!-- Menampilkan tunjangan -->
                        <td>Rp. {{ number_format($p->gaji_pokok + $p->tunjangan, 0, ',', '.') }}</td>
                        <!-- Menampilkan total gaji -->
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
