@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin / Sakit</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
    <div class="row" style="margin-top: 4rem; margin-bottom: 5px;">
        <div class="col">
            @php
                $messagesuccess = Session::get('success');
                $messageerror = Session::get('error');
            @endphp
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ $messagesuccess }}
                </div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ $messageerror }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col">
            @if ($dataizin->isEmpty())
                <div class="alert alert-warning mt-1">
                    <p>Data tidak ada!</p>
                </div>
            @endif
            @foreach ($dataizin as $d)
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="in d-flex justify-content-between">
                                <div>
                                    <b>{{ \Carbon\Carbon::parse($d->tgl_izin)->translatedFormat('d F Y') }}
                                        ({{ $d->status == 's' ? 'Sakit' : 'Izin' }})
                                    </b>
                                    <br>
                                    <small class="text-muted">{{ $d->keterangan }}</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    @if ($d->status_approved == 0)
                                        <span class="badge bg-warning me-2">Waiting</span>
                                        <!-- Tombol Hapus dengan logo Ionicons -->
                                        <form action="{{ route('dataizin.destroy', $d->id) }}" method="POST"
                                            style="display: inline-block;" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0">
                                                <ion-icon name="trash-outline"></ion-icon> <!-- Ikon Ionicons -->
                                            </button>
                                        </form>
                                    @elseif($d->status_approved == 1)
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($d->status_approved == 2)
                                        <span class="badge bg-danger">Decline</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            @endforeach
        </div>
    </div>

    <div class="fab-button bottom-right" style="margin-bottom: 70px">
        <a href="/presensi/createIzin" class="fab">
            <ion-icon name="add-outline"></ion-icon>
        </a>
    </div>
@endsection

@push('myscript')
    <script>
        // Tambahkan event listener untuk setiap form penghapusan
        document.querySelectorAll('.delete-form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah form langsung submit

                // Menampilkan SweetAlert konfirmasi
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data izin ini akan dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Batal',
                    confirmButtonText: 'Ya, Hapus!',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika konfirmasi, kirim form untuk menghapus data
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
