@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
    <style>
        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            height: auto !important;
            margin: auto;
            border-radius: 10px;
        }

        #map {
            height: 250px;
        }
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection
@section('content')
    <div class="row" style="margin-top: 65px;">
        <div class="col">
            <div id="map"></div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col">
            <input type="hidden" id="lokasi">
            <div class="webcam-capture"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @if ($cek == 0)
                <!-- Absen Masuk -->
                <button id="takeabsen" class="btn btn-primary btn-block">
                    <ion-icon name="camera-outline"></ion-icon> Absen Masuk
                </button>
            @elseif ($cek == 1)
                <!-- Absen Pulang -->
                <button id="takeabsen" class="btn btn-danger btn-block">
                    <ion-icon name="camera-outline"></ion-icon> Absen Pulang
                </button>
            @elseif ($cek == 2)
                <!-- Sudah Absen Masuk dan Pulang -->
                <button id="takeabsen" class="btn btn-secondary btn-block" disabled>
                    <ion-icon name="camera-outline"></ion-icon> Sudah Absen Hari Ini
                </button>
            @endif
        </div>
    </div>
    <audio id="notifikasi_in">
        <source src="{{ asset('assets/sound/notifikasi_in.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="notifikasi_out">
        <source src="{{ asset('assets/sound/notifikasi_out.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="radius">
        <source src="{{ asset('assets/sound/radius.mp3') }}" type="audio/mpeg">
    </audio>
@endsection

@push('myscript')
    <script>
        var notifikasi_in = document.getElementById('notifikasi_in');
        var notifikasi_out = document.getElementById('notifikasi_out');
        var radius = document.getElementById('radius');
        Webcam.set({
            width: 640,
            height: 480,
            image_format: 'jpeg',
            jpeg_quality: 80
        });
        Webcam.attach('.webcam-capture');

        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + ',' + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 19);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 20,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            var circle = L.circle([-3.334345495834711, 114.59274160520408], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 10
            }).addTo(map);
        }

        function errorCallback(error) {

        }

        $('#takeabsen').click(function(e) {
            Webcam.snap(function(uri) {
                image = uri;
            });
            var lokasi = $('#lokasi').val();
            $.ajax({
                type: 'POST',
                url: '/presensi/store',
                data: {
                    _token: '{{ csrf_token() }}',
                    image: image,
                    lokasi: lokasi
                },
                cache: false,
                success: function(respond) {
                    var status = respond.split('|');
                    if (status[0] == "success") {
                        if (status[2] == "in") {
                            notifikasi_in.play();
                        } else {
                            notifikasi_out.play();
                        }
                        Swal.fire({
                            title: 'Absen berhasil',
                            text: status[1],
                            icon: 'success',
                        })
                        setTimeout("location.href = '/user'", 3000);
                    } else {
                        if (status[2] == "radius") {
                            radius.play();
                        }
                        Swal.fire({
                            title: 'Error !',
                            text: status[1],
                            icon: 'error',
                        })
                        setTimeout("location.href = '/user'", 3000);
                    }
                }
            });
        });
    </script>
@endpush
