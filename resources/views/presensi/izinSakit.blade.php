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
                            <div class="in">
                                <div>
                                    <b>{{ \Carbon\Carbon::parse($d->tgl_izin)->translatedFormat('d F Y') }}
                                        ({{ $d->status == 's' ? 'Sakit' : 'Izin' }})
                                    </b>
                                    <br>
                                    <small class="text-muted">{{ $d->keterangan }}</small>
                                </div>
                                @if ($d->status_approved == 0)
                                    <span class="badge bg-warning">Waiting</span>
                                @elseif($d->status_approved == 1)
                                    <span class="badge bg-success">Approved</span>
                                @elseif($d->status_approved == 2)
                                    <span class="badge bg-danger">Decline</span>
                                @endif
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
