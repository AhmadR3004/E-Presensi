<x-app-layout>
    @if (session('status') && session('message'))
        <script>
            Swal.fire({
                icon: '{{ session('status') }}', // Menggunakan status 'success' atau 'warning'
                title: '{{ session('status') == 'success' ? 'Success!' : 'Oops!' }}', // Menampilkan judul berbeda berdasarkan status
                text: '{{ session('message') }}', // Menampilkan pesan
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <div class="py-4">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <!-- Start block -->
            <section class="bg-white-50 dark:bg-gray-900 p-3 sm:p-5 antialiased">
                <div class="mx-auto max-w-screen-2xl px-4 lg:px-12">
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div
                            class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                            <div class="flex-1 flex items-center space-x-2">
                                <h1 class="dark:text-white"><b>Konfigurasi Lokasi Kantor</b></h1>
                            </div>
                        </div>
                        <div
                            class="flex flex-col md:flex-row items-stretch md:items-center md:space-x-3 space-y-3 md:space-y-0 justify-between mx-4 py-4 border-t dark:border-gray-700">
                            <div class="w-full md:w-2/3"> <!-- Perpendek input -->
                                <form action="{{ route('konfigurasi.updatelokasikantor') }}" method="POST">
                                    @csrf
                                    <div class="grid gap-4 mb-4 sm:grid-cols-1">
                                        <div>
                                            <div class="space-y-4">
                                                <div class="relative flex items-center">
                                                    <div class="absolute left-3 flex items-center pointer-events-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-5 h-5 text-gray-400">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 2.25c-4.97 0-9 4.03-9 9 0 6.28 9 10.5 9 10.5s9-4.22 9-10.5c0-4.97-4.03-9-9-9zM12 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
                                                        </svg>
                                                    </div>
                                                    <input value="{{ $lok_kantor->lokasi_kantor }}" type="text"
                                                        name="lokasi_kantor" id="lokasi_kantor"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full pl-10 pr-3 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                        placeholder="Lokasi Kantor" required autocomplete="off">
                                                </div>
                                                <div class="relative flex items-center">
                                                    <div class="absolute left-3 flex items-center pointer-events-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-5 h-5 text-gray-400">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 3v18m9-9H3" />
                                                        </svg>
                                                    </div>
                                                    <input value="{{ $lok_kantor->radius }}" type="text"
                                                        name="radius" id="radius"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full pl-10 pr-3 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                                        placeholder="Radius (m)" required autocomplete="off"
                                                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                                        <button type="submit"
                                            class="w-full sm:w-auto justify-center text-white inline-flex bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-3 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Peta lebih lebar -->
                            <div class="w-full md:w-3/4 h-[200px]"> <!-- Perlebar map -->
                                <div id="map" style="height: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        // Mengambil posisi geolokasi pengguna
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                // Jika input lokasi_kantor masih kosong, update dengan lokasi pengguna
                if (document.getElementById('lokasi_kantor').value === '') {
                    document.getElementById('lokasi_kantor').value = position.coords.latitude + ',' + position
                        .coords.longitude;
                }

                // Inisialisasi peta dengan posisi kantor (menggunakan lokasi kantor dari database)
                var lokasi_kantor = '{{ $lok_kantor->lokasi_kantor }}';
                var lok = lokasi_kantor.split(',');
                var lat_kantor = parseFloat(lok[0]);
                var long_kantor = parseFloat(lok[1]);
                var radius = {{ $lok_kantor->radius }}; // Radius kantor

                var map = L.map('map').setView([lat_kantor, long_kantor], 18);

                // Menambahkan layer peta
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 20,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                // Marker untuk lokasi kantor
                var marker = L.marker([lat_kantor, long_kantor]).addTo(map);

                // Menambahkan circle untuk lokasi kantor
                var circle = L.circle([lat_kantor, long_kantor], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: radius
                }).addTo(map);
            });
        }
    </script>


</x-app-layout>
