<div id="showJabatanModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 justify-center items-center flex w-full h-full bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-3xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-900 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Jabatan</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="showJabatanModal">
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
            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                <!-- Kode Jabatan -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><b>Kode
                            Jabatan</b></label>
                    <p id="show_kode_jabatan" class="text-gray-900 dark:text-white"></p>
                </div>
                <!-- Nama Jabatan -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><b>Nama
                            Jabatan</b></label>
                    <p id="show_nama_jabatan" class="text-gray-900 dark:text-white"></p>
                </div>
                <!-- Pangkat -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><b>Pangkat</b></label>
                    <p id="show_pangkat" class="text-gray-900 dark:text-white"></p>
                </div>
                <!-- Departemen -->
                <div>
                    <label
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><b>Departemen</b></label>
                    <p id="show_departemen" class="text-gray-900 dark:text-white"></p>
                </div>
                <!-- Tingkat Jabatan -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><b>Tingkat
                            Jabatan</b></label>
                    <p id="show_tingkat_jabatan" class="text-gray-900 dark:text-white"></p>
                </div>
                <!-- Gaji Pokok -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><b>Gaji
                            Pokok</b></label>
                    <p id="show_gaji_pokok" class="text-gray-900 dark:text-white"></p>
                </div>
                <!-- Tunjangan -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><b>Tunjangan</b></label>
                    <p id="show_tunjangan" class="text-gray-900 dark:text-white"></p>
                </div>
            </div>
        </div>
    </div>
</div>
