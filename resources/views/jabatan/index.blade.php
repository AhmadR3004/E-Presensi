<x-app-layout>
    @if (session('status') && session('message'))
        <script>
            Swal.fire({
                icon: '{{ session('status') }}',
                title: '{{ session('status') == 'success' ? 'Success!' : 'Error!' }}',
                text: '{{ session('message') }}',
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
                                <h1 class="dark:text-white"><b>Data Jabatan</b></h1>
                                <div id="results-tooltip" role="tooltip"
                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    <div class="tooltip-arrow" data-popper-arrow=""></div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-col md:flex-row items-stretch md:items-center md:space-x-3 space-y-3 md:space-y-0 justify-between mx-4 py-4 border-t dark:border-gray-700">
                            <div class="w-full md:w-1/2">
                                <form class="flex items-center" method="GET" action="{{ route('jabatan.index') }}">
                                    <label for="simple-search" class="sr-only">Search</label>
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
                                        <input type="text" name="search" id="simple-search"
                                            placeholder="Cari Jabatan"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    </div>
                                </form>
                            </div>
                            <div
                                class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                <button type="button" id="createJabatanButton" data-modal-toggle="createJabatanModal"
                                    class="flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                                    <svg class="h-3.5 w-3.5 mr-1.5 -ml-1" fill="currentColor" viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path clip-rule="evenodd" fill-rule="evenodd"
                                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                    </svg>
                                    Add Data
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <!-- Tabel Jabatan -->
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="p-4">Kode Jabatan</th>
                                        <th scope="col" class="p-4">Nama Jabatan</th>
                                        <th scope="col" class="p-4">Pangkat</th>
                                        <th scope="col" class="p-4">Departemen</th>
                                        <th scope="col" class="p-4">Tingkat Jabatan</th>
                                        <th scope="col" class="p-4">Gaji Pokok</th>
                                        <th scope="col" class="p-4">Tunjangan</th>
                                        <th scope="col" class="p-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jabatans as $jabatan)
                                        <tr
                                            class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="px-4 py-3">{{ $jabatan->kode_jabatan }}</td>
                                            <td class="px-4 py-3">{{ $jabatan->nama_jabatan }}</td>
                                            <td class="px-4 py-3">{{ $jabatan->pangkat }}</td>
                                            <td class="px-4 py-3">{{ $jabatan->departemen }}</td>
                                            <td class="px-4 py-3">{{ $jabatan->tingkat_jabatan }}</td>
                                            <td class="px-4 py-3">{{ number_format($jabatan->gaji_pokok, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3">{{ number_format($jabatan->tunjangan, 0, ',', '.') }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <div class="flex items-center space-x-4">
                                                    <button type="button"
                                                        class="py-2 px-3 flex items-center text-sm font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                                        data-modal-toggle="editJabatanModal"
                                                        onclick="openEditModal({{ $jabatan->id }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4 mr-2 -ml-0.5" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                            <path fill-rule="evenodd"
                                                                d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Edit
                                                    </button>
                                                    <button type="button"
                                                        class="py-2 px-3 flex items-center text-sm font-medium text-center text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                                        data-modal-toggle="showJabatanModal"
                                                        onclick="openShowModal({{ $jabatan }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="currentColor" class="w-4 h-4 mr-2 -ml-0.5">
                                                            <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" />
                                                        </svg>
                                                        Preview
                                                    </button>
                                                    <button type="button"
                                                        class="flex items-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
                                                        data-modal-toggle="deleteJabatanModal"
                                                        onclick="openDeleteModal({{ $jabatan->id }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4 mr-2 -ml-0.5" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                            aria-label="Table navigation">
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                Showing
                                <span
                                    class="font-semibold text-gray-900 dark:text-white">{{ $jabatans->firstItem() }}</span>
                                -
                                <span
                                    class="font-semibold text-gray-900 dark:text-white">{{ $jabatans->lastItem() }}</span>
                                of
                                <span
                                    class="font-semibold text-gray-900 dark:text-white">{{ $jabatans->total() }}</span>
                            </span>
                            {{ $jabatans->links() }}
                        </nav>
                    </div>
                </div>
            </section>
            <!-- Include form create jabatan -->
            @include('jabatan.create')
            <!-- Include modal edit jabatan -->
            @include('jabatan.edit')
            <!-- Include modal show jabatan -->
            @include('jabatan.show')
            <!-- Include modal delete jabatan -->
            @include('jabatan.delete')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>

    <script>
        document.querySelectorAll('[data-modal-toggle]').forEach(function(button) {
            button.addEventListener('click', function() {
                const modal = document.getElementById(button.getAttribute('data-modal-toggle'));
                modal.classList.toggle('hidden');
            });
        });
    </script>
    <script>
        function openEditModal(id) {
            fetch(`/jabatan/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_kode_jabatan').value = data.kode_jabatan;
                    document.getElementById('edit_nama_jabatan').value = data.nama_jabatan;
                    document.getElementById('edit_pangkat').value = data.pangkat;
                    document.getElementById('edit_departemen').value = data.departemen;
                    document.getElementById('edit_tingkat_jabatan').value = data.tingkat_jabatan;
                    document.getElementById('edit_gaji_pokok').value = data.gaji_pokok;
                    document.getElementById('edit_tunjangan').value = data.tunjangan || ''; // Handle null tunjangan

                    // Set the form action for updating the jabatan
                    document.getElementById('edit_form').action = `/jabatan/${id}`;
                });
        }
    </script>
    <script>
        function openShowModal(jabatan) {
            document.getElementById('show_kode_jabatan').textContent = jabatan.kode_jabatan;
            document.getElementById('show_nama_jabatan').textContent = jabatan.nama_jabatan;
            document.getElementById('show_pangkat').textContent = jabatan.pangkat;
            document.getElementById('show_departemen').textContent = jabatan.departemen;
            document.getElementById('show_tingkat_jabatan').textContent = jabatan.tingkat_jabatan;
            document.getElementById('show_gaji_pokok').textContent = formatCurrency(jabatan.gaji_pokok);
            document.getElementById('show_tunjangan').textContent = formatCurrency(jabatan.tunjangan);
        }

        // Fungsi untuk format mata uang IDR
        function formatCurrency(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }
    </script>
    <script>
        function openDeleteModal(id) {
            document.getElementById('deleteJabatanForm').action = `/jabatan/${id}`;
        }
    </script>
</x-app-layout>
