<x-app-layout>
    <div class="py-4">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <!-- Start block -->
            <section class="bg-white-50 dark:bg-gray-900 p-3 sm:p-5 antialiased">
                <div class="mx-auto max-w-screen-2xl px-4 lg:px-12">
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div
                            class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                            <div class="flex-1 flex items-center space-x-2">
                                <h1 class="dark:text-white"><b>Monitoring Presensi</b></h1>
                                <div id="results-tooltip" role="tooltip"
                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    <div class="tooltip-arrow" data-popper-arrow=""></div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-col md:flex-row items-stretch md:items-center md:space-x-3 space-y-3 md:space-y-0 justify-between mx-4 py-4 border-t dark:border-gray-700">
                            <div class="w-full md:w-1/2">
                                <form class="flex items-center" method="GET"
                                    action="{{ route('presensi.monitoring') }}">
                                    <label for="date" class="sr-only">Select Date</label>
                                    <div class="relative w-full">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                fill="currentColor" viewbox="0 0 20 20"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
                                            </svg>
                                        </div>
                                        <input type="date" name="date" id="date"
                                            value="{{ old('date', $date) }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    </div>
                                    <button type="submit"
                                        class="ml-4 bg-primary-700 text-white py-2 px-4 rounded-lg">Filter</button>
                                </form>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="p-4">No</th>
                                        <th scope="col" class="p-4">NIP</th>
                                        <th scope="col" class="p-4">Nama Pegawai</th>
                                        <th scope="col" class="p-4">Jabatan</th>
                                        <th scope="col" class="p-4">Jam Masuk</th>
                                        <th scope="col" class="p-4">Foto Masuk</th>
                                        <th scope="col" class="p-4">Jam Pulang</th>
                                        <th scope="col" class="p-4">Foto Pulang</th>
                                        <th scope="col" class="p-4">Keterangan</th>
                                        <th scope="col" class="p-4">Lokasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($presensi as $index => $p)
                                        <tr
                                            class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3">{{ $index + 1 }}</td>
                                            <td class="px-4 py-3">{{ $p->pegawai->nip }}</td>
                                            <td class="px-4 py-3">{{ $p->pegawai->nama }}</td>
                                            <td class="px-4 py-3">{{ $p->pegawai->jabatan->nama_jabatan }}</td>
                                            <td class="px-4 py-3">{{ $p->jam_in }}</td>
                                            <td class="px-4 py-3">
                                                @if (!empty($p->foto_in))
                                                    <img src="{{ Storage::url('uploads/absensi/' . $p->foto_in) }}"
                                                        alt="Foto Masuk" class="w-16 h-16 object-cover rounded">
                                                @else
                                                    <ion-icon name="hourglass-outline"
                                                        class="text-gray-500 text-xl"></ion-icon>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if ($p->jam_out)
                                                    {{ $p->jam_out }}
                                                @else
                                                    <span
                                                        class="bg-red-500 text-white text-sm font-semibold px-2.5 py-0.5 rounded-full">
                                                        Belum Absen
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @if (!empty($p->foto_out))
                                                    <img src="{{ Storage::url('uploads/absensi/' . $p->foto_out) }}"
                                                        alt="Foto Pulang" class="w-16 h-16 object-cover rounded">
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-10 ml-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                                                    </svg>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                @php
                                                    $cutOffTime = '09:00:00';
                                                    $jamMasuk = strtotime($p->jam_in);
                                                    $batasAbsen = strtotime($cutOffTime);
                                                    $terlambat = $jamMasuk > $batasAbsen;
                                                    $selisihTerlambat = $terlambat
                                                        ? gmdate('H:i:s', $jamMasuk - $batasAbsen)
                                                        : '';
                                                    $keterangan = $terlambat
                                                        ? "Telat $selisihTerlambat"
                                                        : 'Tepat Waktu';
                                                    $badgeClass = $terlambat ? 'bg-red-500' : 'bg-green-500';
                                                @endphp
                                                <span
                                                    class="inline-block px-3 py-1 text-sm font-semibold text-white rounded-full {{ $badgeClass }}">
                                                    {{ $keterangan }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <a href="#"
                                                    class="showMap bg-blue-700 text-white px-2 py-2 rounded-lg hover:bg-blue-400 inline-flex items-center justify-center"
                                                    data-modal-toggle="showMap" data-lokasi-in="{{ $p->lokasi_in }}"
                                                    data-pegawai-nama="{{ $p->pegawai->nama }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    @include('presensi.showmap')

    <script>
        let mapInstance; // Peta global
        let marker; // Marker global
        let circle; // Circle global

        document.querySelectorAll('[data-modal-toggle]').forEach(function(button) {
            button.addEventListener('click', function() {
                const modal = document.getElementById(button.getAttribute('data-modal-toggle'));
                const lokasiIn = button.getAttribute('data-lokasi-in');
                const pegawaiNama = button.getAttribute('data-pegawai-nama');

                const [latitude, longitude] = lokasiIn.split(',').map(coord => parseFloat(coord.trim()));

                // Lokasi kantor (gunakan nilai lokasi kantor dari backend atau data yang tersedia)
                const lokasiKantor = "{{ $lokasiKantor->lokasi_kantor }}"; // Pastikan ini ada dan valid
                const radiusKantor = "{{ $lokasiKantor->radius }}"; // Pastikan ini ada dan valid

                const [latitudeKan, longitudeKan] = lokasiKantor.split(',').map(coord => parseFloat(coord
                    .trim()));

                // Menampilkan nama pegawai
                document.getElementById('pegawaiNameHeader').textContent = pegawaiNama;

                // Tampilkan modal
                modal.classList.remove('hidden');

                // Cek apakah peta sudah diinisialisasi sebelumnya
                if (!mapInstance) {
                    mapInstance = L.map('map').setView([latitude, longitude], 20);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(mapInstance);

                    // Tambahkan marker pertama kali
                    marker = L.marker([latitude, longitude]).addTo(mapInstance)
                        .bindPopup(`<b>${pegawaiNama}</b>`)
                        .openPopup();

                    // Pastikan radiusKantor adalah angka dan valid
                    const radius = isNaN(radiusKantor) ? 100 : parseInt(radiusKantor);
                    console.log('Radius Kantor:', radius);

                    // Tambahkan circle pertama kali jika radius valid
                    circle = L.circle([latitudeKan, longitudeKan], {
                        color: 'red',
                        fillColor: '#f03',
                        fillOpacity: 0.3,
                        radius: radius
                    }).addTo(mapInstance);
                } else {
                    // Update posisi marker dan view peta
                    mapInstance.setView([latitude, longitude], 20);
                    marker.setLatLng([latitude, longitude]);
                    marker.bindPopup(`<b>${pegawaiNama}</b>`).openPopup();

                    // Update circle jika sudah ada
                    circle.setLatLng([latitudeKan, longitudeKan]);
                    const radius = isNaN(radiusKantor) ? 100 : parseInt(radiusKantor);
                    circle.setRadius(radius);
                }

                // Tambahkan close handler untuk mereset modal
                modal.querySelector('[data-modal-toggle]').addEventListener('click', function() {
                    modal.classList.add('hidden');
                });
            });
        });
    </script>

    <script>
        // Memastikan variabel $lokasi_kantor tersedia dan dapat diakses di dalam JavaScript
        const lokasiKantor = "{{ $lokasiKantor->lokasi_kantor }}";
        const radiusKantor = "{{ $lokasiKantor->radius }}";

        document.querySelectorAll('.showMap').forEach(function(button) {
            button.addEventListener('click', function() {
                // Ambil data dari tombol
                const lokasiIn = button.getAttribute('data-lokasi-in'); // Format: "latitude,longitude"
                const pegawaiNama = button.getAttribute('data-pegawai-nama');

                // Pisahkan latitude dan longitude untuk lokasi pegawai
                const [latitude, longitude] = lokasiIn.split(',').map(coord => parseFloat(coord.trim()));
                // Pisahkan latitude dan longitude untuk lokasi kantor
                const [latitudeKan, longitudeKan] = lokasiKantor.split(',').map(coord => parseFloat(coord
                    .trim()));

                // Mengirimkan data ke modal
                document.getElementById('pegawaiName').textContent = 'Lokasi Pegawai: ' + pegawaiNama;
                document.getElementById('pegawaiNameHeader').textContent = pegawaiNama;

                // Menampilkan modal
                const modal = document.getElementById('showMap');
                modal.classList.remove('hidden');

                // Inisialisasi peta menggunakan Leaflet.js
                const map = L.map('map').setView([latitude, longitude], 22);

                // Tambahkan tile layer (misalnya OpenStreetMap)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                // Tambahkan marker di lokasi pegawai
                L.marker([latitude, longitude]).addTo(map)
                    .bindPopup(`<b>${pegawaiNama}</b>`)
                    .openPopup();

                // Tambahkan circle radius di sekitar lokasi kantor
                const circle = L.circle([latitudeKan, longitudeKan], {
                    color: 'red',
                    fillColor: 'red',
                    fillOpacity: 0.2,
                    radius: parseInt(radiusKantor)
                }).addTo(map);
            });
        });
    </script>

</x-app-layout>
