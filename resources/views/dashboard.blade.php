<x-app-layout>
    <div class="mt-10 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-gray-900 dark:text-gray-100">
                <a class="text-sm font-bold">Selamat Datang, {{ $userName }}</a>
                <a class="text-sm font-semibold">Berikut adalah Data Pegawai Hari ini!</a>
            </div>
        </div>
    </div>

    <div class="mt-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- Pegawai Hadir -->
                    <div
                        class="p-3 rounded-md shadow text-center flex items-center space-x-3 bg-white transform transition-transform duration-300">
                        <div class="bg-green-100 p-3 rounded-md text-3xl text-green-600 mb-3">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="flex-1 text-center">
                            <p class="text-base font-semibold text-gray-800">Pegawai Hadir</p>
                            <p class="text-lg text-green-700">{{ $hadir }}</p>
                        </div>
                    </div>

                    <!-- Pegawai Izin -->
                    <div
                        class="p-3 rounded-md shadow text-center flex items-center space-x-3 bg-white transform transition-transform duration-300">
                        <div class="bg-yellow-100 p-3 rounded-md text-3xl text-yellow-600 mb-3">
                            <i class="fas fa-user-times"></i>
                        </div>
                        <div class="flex-1 text-center">
                            <p class="text-base font-semibold text-gray-800">Pegawai Izin</p>
                            <p class="text-lg text-yellow-700">{{ $izin }}</p>
                        </div>
                    </div>

                    <!-- Pegawai Sakit -->
                    <div
                        class="p-3 rounded-md shadow text-center flex items-center space-x-3 bg-white transform transition-transform duration-300">
                        <div class="bg-red-100 p-3 rounded-md text-3xl text-red-600 mb-3">
                            <i class="fas fa-procedures"></i>
                        </div>
                        <div class="flex-1 text-center">
                            <p class="text-base font-semibold text-gray-800">Pegawai Sakit</p>
                            <p class="text-lg text-red-700">{{ $sakit }}</p>
                        </div>
                    </div>

                    <!-- Pegawai Terlambat -->
                    <div
                        class="p-3 rounded-md shadow text-center flex items-center space-x-3 bg-white transform transition-transform duration-300">
                        <div class="bg-blue-100 p-3 rounded-md text-3xl text-blue-600 mb-3">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="flex-1 text-center">
                            <p class="text-base font-semibold text-gray-800">Pegawai Terlambat</p>
                            <p class="text-lg text-blue-700">{{ $terlambat }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
