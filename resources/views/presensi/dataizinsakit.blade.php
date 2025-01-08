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
                                <h1 class="dark:text-white"><b>Data Izin/Sakit</b></h1>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="p-4">No</th>
                                        <th scope="col" class="p-4">Tanggal</th>
                                        <th scope="col" class="p-4">NIP</th>
                                        <th scope="col" class="p-4">Nama Pegawai</th>
                                        <th scope="col" class="p-4">Jabatan</th>
                                        <th scope="col" class="p-4">Status</th>
                                        <th scope="col" class="p-4">Keterangan</th>
                                        <th scope="col" class="p-4">Status Approved</th>
                                        <th scope="col" class="p-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataizinsakit as $d)
                                        <tr
                                            class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-3">
                                                {{ Carbon\Carbon::parse($d->tgl_izin)->format('d F Y') }}</td>
                                            <td class="px-4 py-3">{{ $d->pegawai_id }}</td>
                                            <td class="px-4 py-3">{{ $d->nama }}</td>
                                            <td class="px-4 py-3">{{ $d->nama_jabatan }}</td>
                                            <td class="px-4 py-3">{{ $d->status == 'i' ? 'Izin' : 'Sakit' }}</td>
                                            <td class="px-4 py-3">{{ $d->keterangan }}</td>
                                            <td class="px-4 py-3">
                                                @if ($d->status_approved == 1)
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-green-600 px-3 py-1 text-sm font-semibold text-white">
                                                        Disetujui
                                                    </span>
                                                @elseif($d->status_approved == 2)
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-red-700 px-3 py-1 text-sm font-semibold text-white">
                                                        Ditolak
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-orange-500 px-3 py-1 text-sm font-semibold text-white">
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->status_approved == 0)
                                                    <a href="#"
                                                        class="approveButton inline-flex items-center justify-center p-2 bg-blue-600 text-white text-sm font-medium rounded-full hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                                        data-id="{{ $d->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </a>
                                                @else
                                                    <a href="/presensi/{{ $d->id }}/batalkanizinsakit"
                                                        class="inline-flex items-center justify-center p-2 bg-red-600 text-white text-sm font-medium rounded-full hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
            </section>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal-izinsakit" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-lg w-full max-w-lg">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Izin/Sakit</h3>
                <button id="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-white">
                    &times;
                </button>
            </div>
            <!-- Isi Modal -->
            <form action="/presensi/approveizinsakit" method="POST" class="mt-4" id="approveForm">
                @csrf
                <input type="hidden" id="id_izinsakit_form" name="id_izinsakit_form">
                <label for="status_approved" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status
                    Approval</label>
                <select name="status_approved" id="status_approved" class="w-full p-2 border rounded">
                    <option value="1">Disetujui</option>
                    <option value="2">Ditolak</option>
                </select>

                <!-- Tombol Submit dengan Heroicons -->
                <button type="submit"
                    class="inline-flex items-center mt-4 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l12 9-12 9V3z" />
                    </svg>
                    Simpan
                </button>
            </form>
        </div>
    </div>

</x-app-layout>

<script>
    // Menggunakan data-id untuk mengambil ID yang sesuai
    document.querySelectorAll('.approveButton').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var id_izinsakit = this.getAttribute('data-id'); // Mendapatkan id_izinsakit
            document.getElementById('id_izinsakit_form').value = id_izinsakit;
            document.getElementById('modal-izinsakit').classList.remove('hidden');
        });
    });

    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('modal-izinsakit').classList.add('hidden');
    });
</script>
