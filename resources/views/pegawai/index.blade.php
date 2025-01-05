<x-app-layout>
    {{-- Cek jika ada variabel data dan tampilkan alert --}}
    @if (isset($data))
        @if ($data['status'] == 'success')
            <div class="alert alert-success">
                {{ $data['message'] }}
            </div>
        @elseif ($data['status'] == 'error')
            <div class="alert alert-danger">
                {{ $data['message'] }}
            </div>
        @endif
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
                                <h1 class="dark:text-white"><b>Data Pegawai</b></h1>
                                <div id="results-tooltip" role="tooltip"
                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    <div class="tooltip-arrow" data-popper-arrow=""></div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-col md:flex-row items-stretch md:items-center md:space-x-3 space-y-3 md:space-y-0 justify-between mx-4 py-4 border-t dark:border-gray-700">
                            <div class="w-full md:w-1/2">
                                <form class="flex items-center" method="GET" action="{{ route('pegawai.index') }}">
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
                                            placeholder="Cari Pegawai"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    </div>

                                    <!-- Dropdown untuk memilih jabatan dengan ikon koper -->
                                    <div class="relative w-full ml-1">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor"
                                                class="w-5 h-5 text-gray-500 dark:text-gray-400">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                                            </svg>
                                        </div>
                                        <select name="jabatan_id" id="jabatan_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option value="">Pilih Jabatan</option>
                                            @foreach ($jabatans as $jabatan)
                                                <option value="{{ $jabatan->id }}"
                                                    {{ request('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                                    {{ $jabatan->nama_jabatan }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Tombol submit -->
                                    <button type="submit"
                                        class="ml-1 flex items-center justify-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">Cari</button>
                                </form>
                            </div>
                            <div
                                class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                <button type="button" id="createPegawaiButton" data-modal-toggle="createPegawaiModal"
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
                            <!-- Tabel Pegawai -->
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="p-8">Foto</th>
                                        <th scope="col" class="p-4">Nama</th>
                                        <th scope="col" class="p-4">NIP</th>
                                        <th scope="col" class="p-4">Jabatan</th>
                                        <th scope="col" class="p-4">Jenis Kelamin</th>
                                        <th scope="col" class="p-4">Email</th>
                                        <th scope="col" class="p-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pegawais as $pegawai)
                                        <tr
                                            class="border-b dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex items-center">
                                                    <img src="{{ $pegawai->foto ? asset('storage/uploads/pegawai/' . $pegawai->foto) : asset('default.jpg') }}"
                                                        alt="Foto Pegawai" class="w-14 h-14 rounded-full">
                                                </div>
                                            </th>
                                            <td class="px-4 py-3">{{ $pegawai->nama }}</td>
                                            <td class="px-4 py-3">{{ $pegawai->nip }}</td>
                                            <td class="px-4 py-3">{{ $pegawai->jabatan->nama_jabatan }}</td>
                                            <td class="px-4 py-3">
                                                @if ($pegawai->jenis_kelamin == 'L')
                                                    Laki-laki
                                                @elseif ($pegawai->jenis_kelamin == 'P')
                                                    Perempuan
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">{{ $pegawai->email }}</td>
                                            <td
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="flex items-center space-x-4">
                                                    <button type="button"
                                                        class="py-2 px-3 flex items-center text-sm font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                                        data-modal-toggle="editPegawaiModal"
                                                        onclick="openEditModal({{ $pegawai->nip }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4 mr-2 -ml-0.5" viewbox="0 0 20 20"
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
                                                        data-modal-toggle="showPegawaiModal"
                                                        onclick="openShowModal({{ $pegawai }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24"
                                                            fill="currentColor" class="w-4 h-4 mr-2 -ml-0.5">
                                                            <path d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 010-1.113zM17.25 12a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" />
                                                        </svg>
                                                        Preview
                                                    </button>
                                                    <button type="button"
                                                        class="flex items-center text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900"
                                                        data-modal-toggle="deletePegawaiModal"
                                                        onclick="openDeleteModal({{ $pegawai->nip }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4 mr-2 -ml-0.5" viewbox="0 0 20 20"
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
                                    class="font-semibold text-gray-900 dark:text-white">{{ $pegawais->firstItem() }}</span>
                                -
                                <span
                                    class="font-semibold text-gray-900 dark:text-white">{{ $pegawais->lastItem() }}</span>
                                of
                                <span
                                    class="font-semibold text-gray-900 dark:text-white">{{ $pegawais->total() }}</span>
                            </span>
                            {{ $pegawais->links() }}
                        </nav>
                    </div>
                </div>
            </section>
            <!-- Include form create pegawai -->
            @include('pegawai.create', ['jabatans' => $jabatans])
            <!-- Include modal edit pegawai -->
            @include('pegawai.edit', ['jabatans' => $jabatans])
            <!-- Include modal show pegawai -->
            @include('pegawai.show')
            <!-- Include modal delete pegawai -->
            @include('pegawai.delete')

        </div>
    </div>

    <script>
        document.querySelectorAll('[data-modal-toggle]').forEach(function(button) {
            button.addEventListener('click', function() {
                const modal = document.getElementById(button.getAttribute('data-modal-toggle'));
                modal.classList.toggle('hidden');
            });
        });
    </script>
    <script>
        function openEditModal(nip) {
            fetch(`/pegawai/${nip}/edit`) // Gantilah id dengan nip
                .then(response => response.json())
                .then(data => {
                    const pegawai = data.pegawai;
                    const jabatans = data.jabatans;

                    // Isi data pegawai ke form edit
                    document.getElementById('edit_nama').value = pegawai.nama;
                    document.getElementById('edit_nip').value = pegawai.nip; // NIP tetap
                    document.getElementById('edit_alamat').value = pegawai.alamat;
                    document.getElementById('edit_no_telp').value = pegawai.no_telp;
                    document.getElementById('edit_tanggal_lahir').value = pegawai.tanggal_lahir;
                    document.getElementById('edit_jenis_kelamin').value = pegawai.jenis_kelamin;
                    document.getElementById('edit_tanggal_masuk').value = pegawai.tanggal_masuk;
                    document.getElementById('edit_email').value = pegawai.email;
                    document.getElementById('edit_password').value = ''; // Biarkan kosong
                    document.getElementById('edit_foto').value = ''; // Biarkan kosong
                    document.getElementById('editPegawaiForm').action = `/pegawai/${nip}`; // Ganti dengan nip

                    // Populasi dropdown jabatan
                    const jabatanSelect = document.getElementById('edit_jabatan_id');
                    jabatanSelect.innerHTML = ''; // Bersihkan opsi sebelumnya
                    jabatans.forEach(jabatan => {
                        const option = document.createElement('option');
                        option.value = jabatan.id;
                        option.text = jabatan.nama_jabatan;
                        if (jabatan.id === pegawai.jabatan_id) {
                            option.selected = true; // Pilih jabatan yang sesuai
                        }
                        jabatanSelect.appendChild(option);
                    });
                });
        }
    </script>
    <script>
        function openShowModal(pegawai) {
            document.getElementById('show_nama').innerText = pegawai.nama;
            document.getElementById('show_nip').innerText = pegawai.nip;
            document.getElementById('show_jabatan').innerText = pegawai.jabatan.nama_jabatan;
            document.getElementById('show_alamat').innerText = pegawai.alamat;
            document.getElementById('show_no_telp').innerText = pegawai.no_telp;
            document.getElementById('show_tanggal_lahir').innerText = pegawai.tanggal_lahir;
            document.getElementById('show_jenis_kelamin').innerText = pegawai.jenis_kelamin === 'L' ? 'Laki-laki' :
                'Perempuan';
            document.getElementById('show_tanggal_masuk').innerText = pegawai.tanggal_masuk;
            document.getElementById('show_email').innerText = pegawai.email;
            document.getElementById('show_foto').src = pegawai.foto ? `/storage/uploads/pegawai/${pegawai.foto}` :
                `default.jpg`;
        }
    </script>
    <script>
        function openDeleteModal(nip) {
            document.getElementById('deletePegawaiForm').action = `/pegawai/${nip}`;
        }
    </script>

</x-app-layout>
