@extends('layouts.presensi')
@section('content')
    <div class="section" id="user-section">
        <div id="user-detail" style="display: flex !important; align-items: center !important; gap: 8px !important;">
            <div class="avatar">
                @if (Auth::guard('pegawai')->user()->foto)
                    @php
                        $path = Storage::url('uploads/pegawai/' . Auth::guard('pegawai')->user()->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="avatar" class="imaged w64 rounded">
                @else
                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
                @endif
            </div>
            <div id="user-info" style="margin-left: 8px !important;">
                <h2 id="user-name" style="font-size: 1.25rem !important; font-weight: bold !important;">
                    {{ Auth::guard('pegawai')->user()->nama }}</h2>
                <span id="user-role"
                    style="font-size: 0.875rem !important; color: #d1d5db !important;">{{ Auth::guard('pegawai')->user()->jabatan->nama_jabatan }}</span>
            </div>
        </div>

        <!-- Tombol Logout di ujung atas kanan dengan style dan !important -->
        <div class="fab-button"
            style="position: absolute !important; right: 20px !important; top: 45px !important; z-index: 9999 !important;">
            <a href="javascript:void(0);" class="fab" id="logout-button"
                style="background-color: transparent !important; color: white !important; border-radius: 9999px !important; padding: 0.5rem !important; box-shadow: 3px 4px 6px rgb(0, 0, 0, 0.6) !important;">
                <ion-icon name="exit" class="text-xl"></ion-icon>
            </a>
        </div>

    </div>

    <!-- Tambahkan SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('logout-button').addEventListener('click', function() {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan logout dari akun ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect ke halaman logout jika dikonfirmasi
                    window.location.href = '/prosesLogout';
                }
            });
        });
    </script>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/editProfile" class="green" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/izinSakit" class="danger" style="font-size: 40px;">
                                <ion-icon name="calendar-number"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Cuti</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/histori" class="warning" style="font-size: 40px;">
                                <ion-icon name="document-text"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Histori</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="" class="orange" style="font-size: 40px;">
                                <ion-icon name="location"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Lokasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensihariini != null)
                                        @php
                                            $path = Storage::url('uploads/absensi/' . $presensihariini->foto_in);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w48">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $presensihariini != null ? \Carbon\Carbon::parse($presensihariini->jam_in)->format('H:i') : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensihariini != null && $presensihariini->jam_out != null)
                                        @php
                                            $path = Storage::url('uploads/absensi/' . $presensihariini->foto_out);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w48">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $presensihariini != null && $presensihariini->jam_out != null ? \Carbon\Carbon::parse($presensihariini->jam_out)->format('H:i') : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rekapPresensi">
            <h3 style="margin: 0.1px !important; ">Rekap Presensi</h3>
            <h4>Bulan {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }}</h4>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                            <span class="badge bg-danger"
                                style="position: absolute; top: 2px; right: 2px; z-index: 999">{{ $rekapPresensi->jmlhadir }}</span>
                            <ion-icon name="accessibility" style="font-size: 1.6rem" class="text-primary mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight: 500;">Hadir</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                            <span class="badge bg-danger"
                                style="position: absolute; top: 2px; right: 2px; z-index: 999">{{ $rekapizin->jmlizin }}</span>
                            <ion-icon name="newspaper" style="font-size: 1.6rem" class="text-success mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight: 500;">Izin</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                            <span class="badge bg-danger"
                                style="position: absolute; top: 2px; right: 2px; z-index: 999">{{ $rekapizin->jmlsakit }}</span>
                            <ion-icon name="medkit" style="font-size: 1.6rem" class="text-warning mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight: 500;">Sakit</span>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem;">
                            <span class="badge bg-danger"
                                style="position: absolute; top: 2px; right: 2px; z-index: 999">{{ $rekapPresensi->jmlterlambat }}</span>
                            <ion-icon name="alarm" style="font-size: 1.6rem" class="text-danger mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight: 500;">Telat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Rank hari ini
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($historibulanini as $d)
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="finger-print"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</div>
                                        <span class="badge badge-success">{{ $d->jam_in }}</span>
                                        <span class="badge badge-danger">
                                            {{ !empty($d->jam_out) ? $d->jam_out : 'Belum Absen' }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderboard as $d)
                            <li>
                                <div class="item">
                                    @php
                                        $path = Storage::url('uploads/absensi/' . $d->foto_in);
                                    @endphp
                                    <img src="{{ url($path) }}" alt="image" class="image">
                                    <div class="in">
                                        <div>
                                            <b>{{ $d->nama }}</b>
                                            <br>
                                            <small class="text-muted">{{ $d->nama_jabatan }}</small>
                                        </div>
                                        <span class="badge {{ $d->jam_in < '09:00' ? 'badge-success' : 'badge-danger' }}">
                                            {{ $d->jam_in }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
