@extends('layouts.app')

@section('title', 'Ubah Kegiatan')

@section('content')
    <h3 class="mb-3">Ubah Kegiatan</h3>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('penduduk.kegiatan.update', $item->id_settings_kegiatan) }}">
            @csrf
            @method('PUT')
            @include('penduduk.kegiatan._form')
        </form>
    </div></div>
@endsection
