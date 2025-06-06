<div id="createJabatanModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 justify-center items-center flex w-full h-full bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-3xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-900 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Jabatan</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="createJabatanModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('jabatan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="kode_jabatan" class="block mb-2 text-sm font-medium text-gray-900">Kode
                            Jabatan</label>
                        <input type="text" name="kode_jabatan" id="kode_jabatan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Kode Jabatan" required>
                    </div>

                    <div>
                        <label for="nama_jabatan" class="block mb-2 text-sm font-medium text-gray-900">Nama
                            Jabatan</label>
                        <input type="text" name="nama_jabatan" id="nama_jabatan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Nama Jabatan" required>
                    </div>

                    <div>
                        <label for="pangkat" class="block mb-2 text-sm font-medium text-gray-900">Pangkat</label>
                        <input type="text" name="pangkat" id="pangkat"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Pangkat" required>
                    </div>

                    <div>
                        <label for="departemen" class="block mb-2 text-sm font-medium text-gray-900">Departemen</label>
                        <input type="text" name="departemen" id="departemen"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Departemen" required>
                    </div>

                    <div>
                        <label for="tingkat_jabatan" class="block mb-2 text-sm font-medium text-gray-900">Tingkat
                            Jabatan</label>
                        <input type="text" name="tingkat_jabatan" id="tingkat_jabatan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Tingkat Jabatan" required>
                    </div>

                    <div>
                        <label for="gaji_pokok" class="block mb-2 text-sm font-medium text-gray-900">Gaji Pokok</label>
                        <input type="number" name="gaji_pokok" id="gaji_pokok"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Gaji Pokok" step="0.01" required>
                    </div>

                    <div>
                        <label for="tunjangan" class="block mb-2 text-sm font-medium text-gray-900">Tunjangan</label>
                        <input type="number" name="tunjangan" id="tunjangan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Tunjangan" step="0.01">
                    </div>
                </div>
                <div class="items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    <button type="submit"
                        class="w-full sm:w-auto justify-center text-white inline-flex bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Add
                        Jabatan</button>
                    <button data-modal-toggle="createJabatanModal" type="button"
                        class="w-full justify-center sm:w-auto text-gray-500 inline-flex items-center bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                        <svg class="mr-1 -ml-1 w-5 h-5" fill="currentColor" viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Discard
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('nama_jabatan').addEventListener('blur', function() {
        let namaJabatan = this.value; // Ambil nilai input nama_jabatan
        let alertText = document.getElementById('jabatan-alert'); // Ambil elemen alert

        // Reset pesan peringatan
        alertText.classList.add('hidden');

        // Lakukan pengecekan hanya jika nama_jabatan tidak kosong
        if (namaJabatan.length > 0) {
            fetch('/check-jabatan/' + namaJabatan) // Ganti URL sesuai endpoint pengecekan nama_jabatan
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        // Jika nama_jabatan sudah ada, tampilkan pesan peringatan
                        alertText.classList.remove('hidden');
                    } else {
                        // Jika nama_jabatan tidak ada, sembunyikan pesan peringatan
                        alertText.classList.add('hidden');
                    }
                })
                .catch(error => console.error('Error checking nama_jabatan:', error));
        }
    });
</script>
