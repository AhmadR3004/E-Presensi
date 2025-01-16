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
                                <h1 class="dark:text-white"><b>Laporan Data Pegawai</b></h1>
                                <div id="results-tooltip" role="tooltip"
                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    <div class="tooltip-arrow" data-popper-arrow=""></div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-col md:flex-row items-stretch md:items-center md:space-x-3 space-y-3 md:space-y-0 justify-between mx-4 py-4 border-t dark:border-gray-700">
                            <div class="w-full md:w-1/2">
                                <form action="{{ route('laporan.cetakpegawai') }}" target="_blank"
                                    class="flex flex-col space-y-4" method="POST">
                                    @csrf
                                    <label for="jabatan">Pilih Berdasarkan Jabatan</label>
                                    <select name="jabatan" id="jabatan"
                                        class="form-select block w-full py-2 px-3 text-sm border rounded-md focus:outline-none dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                        <option value="">Semua Jabatan</option>
                                        @foreach ($jabatan as $d)
                                            <option value="{{ $d->id }}">{{ $d->nama_jabatan }}</option>
                                        @endforeach
                                    </select>

                                    <div class="flex space-x-2">
                                        <button type="submit" name="cetak"
                                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none flex items-center space-x-2">
                                            <span class="text-sm">Cetak</span>
                                        </button>
                                        <button type="submit" name="exporttoexcel"
                                            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none flex items-center space-x-2">
                                            <span class="text-sm">Export to Excel</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <script>
        function validateForm() {
            const nip = document.getElementById("nip").value;
            if (!nip) {
                Swal.fire({
                    title: 'Peringatan',
                    text: 'Harap pilih pegawai terlebih dahulu!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return false; // Prevent form submission
            }
            return true;
        }
    </script>
</x-app-layout>
