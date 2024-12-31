@if ($histori->isEmpty())
    <div class="alert alert-warning mt-1">
        <p>Data tidak ada!</p>
    </div>
@endif
@foreach ($histori as $d)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                @php
                    $path = Storage::url('uploads/absensi/' . $d->foto_in);
                @endphp
                <img src="{{ url($path) }}" alt="image" class="image">
                <div class="in">
                    <div>
                        <b>{{ \Carbon\Carbon::parse($d->tgl_presensi)->translatedFormat('d F Y') }}</b>
                        <br>
                        {{-- <small class="text-muted">{{ $d->nama_jabatan }}</small> --}}
                    </div>
                    <span class="badge {{ $d->jam_in < '09:00' ? 'badge-success' : 'badge-danger' }}">
                        {{ $d->jam_in }}
                    </span>
                    <span class="badge badge-danger">{{ $d->jam_out }}</span>
                </div>
            </div>
        </li>
    </ul>
@endforeach
