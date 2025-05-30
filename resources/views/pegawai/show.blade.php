<div id="showPegawaiModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 justify-center items-center flex w-full h-full bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-3xl h-full md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-900 sm:p-5">
            <!-- Modal header -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Pegawai</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-toggle="showPegawaiModal">
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
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto</label>
                    <img id="show_foto" src="" alt="Foto Pegawai" class="h-24 w-24 rounded-full">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"></label>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                    <p id="show_nama" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                    <p id="show_nip" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
                    <p id="show_jabatan" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Jabatan</label>
                    <p id="show_kode_jabatan" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pangkat</label>
                    <p id="show_pangkat" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Departemen</label>
                    <p id="show_departemen" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tingkat Jabatan</label>
                    <p id="show_tingkat_jabatan" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gaji Pokok</label>
                    <p id="show_gaji_pokok" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tunjangan</label>
                    <p id="show_tunjangan" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Gaji</label>
                    <p id="show_total_gaji" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                    <p id="show_alamat" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No Telp</label>
                    <p id="show_no_telp" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Lahir</label>
                    <p id="show_tanggal_lahir" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jenis Kelamin</label>
                    <p id="show_jenis_kelamin" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Masuk</label>
                    <p id="show_tanggal_masuk" class="text-gray-900 dark:text-white"></p>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <p id="show_email" class="text-gray-900 dark:text-white"></p>
                </div>
            </div>
        </div>
    </div>
</div>
