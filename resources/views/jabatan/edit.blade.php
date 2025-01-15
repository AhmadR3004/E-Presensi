<div id="editJabatanModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 justify-center items-center flex w-full h-full bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-3xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-900 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Jabatan</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="editJabatanModal">
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
            <form id="edit_form" action="{{ route('jabatan.update', ':id') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="edit_kode_jabatan" class="block mb-2 text-sm font-medium text-gray-900">Kode
                            Jabatan</label>
                        <input type="text" name="kode_jabatan" id="edit_kode_jabatan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            required>
                    </div>

                    <div>
                        <label for="edit_nama_jabatan" class="block mb-2 text-sm font-medium text-gray-900">Nama
                            Jabatan</label>
                        <input type="text" name="nama_jabatan" id="edit_nama_jabatan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            required>
                    </div>

                    <div>
                        <label for="edit_pangkat" class="block mb-2 text-sm font-medium text-gray-900">Pangkat</label>
                        <input type="text" name="pangkat" id="edit_pangkat"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            required>
                    </div>

                    <div>
                        <label for="edit_departemen"
                            class="block mb-2 text-sm font-medium text-gray-900">Departemen</label>
                        <input type="text" name="departemen" id="edit_departemen"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            required>
                    </div>

                    <div>
                        <label for="edit_tingkat_jabatan" class="block mb-2 text-sm font-medium text-gray-900">Tingkat
                            Jabatan</label>
                        <input type="text" name="tingkat_jabatan" id="edit_tingkat_jabatan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            required>
                    </div>

                    <div>
                        <label for="edit_gaji_pokok" class="block mb-2 text-sm font-medium text-gray-900">Gaji
                            Pokok</label>
                        <input type="number" name="gaji_pokok" id="edit_gaji_pokok"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            required step="0.01">
                    </div>

                    <div>
                        <label for="edit_tunjangan"
                            class="block mb-2 text-sm font-medium text-gray-900">Tunjangan</label>
                        <input type="number" name="tunjangan" id="edit_tunjangan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            step="0.01">
                    </div>
                </div>

                <button type="submit"
                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    Update Jabatan
                </button>
            </form>
        </div>
    </div>
</div>
