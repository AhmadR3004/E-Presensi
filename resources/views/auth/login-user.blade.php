<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Login E-Presensi Pegawai</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    <!-- App Capsule -->
    <div id="appCapsule" class="pt-8">
        <div class="login-form mt-5">
            <div class="section">
                <img src="assets/img/login/logo.png" alt="image" class="form-image">
            </div>
            <div class="section mt-1">
                <h1>E-Presensi</h1>
                <h4>Harap login terlebih dahulu!</h4>
            </div>
            <div class="section mt-1 mb-5">
                <form action="/prosesLogin" method="POST">
                    @csrf
                    @if ($errors->has('login'))
                        <div class="alert alert-danger text-center mt-3">
                            {{ $errors->first('login') }}
                        </div>
                    @endif
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" name="nip" class="form-control" id="nomorinduk" placeholder="NIP"
                                inputmode="numeric" pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Password" required>
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-links mt-2">
                        <div><a href="{{ route('forgot-password-user') }}" class="text-muted">Lupa Password?</a></div>
                    </div>

                    <div class="form-button-group">
                        <button type="submit" class="btn btn-primary btn-block btn-lg">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // SweetAlert untuk menampilkan pesan status dari session
        @if (session('status') && session('message'))
            Swal.fire({
                icon: '{{ session('status') }}', // success atau error
                title: '{{ session('status') == 'success' ? 'Berhasil!' : 'Gagal!' }}',
                text: '{{ session('message') }}',
                confirmButtonText: 'OK'
            });
        @endif
    </script>

    <!-- ///////////// Js Files ////////////////////  -->
    <script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('assets/js/base.js') }}"></script>

</body>

</html>
