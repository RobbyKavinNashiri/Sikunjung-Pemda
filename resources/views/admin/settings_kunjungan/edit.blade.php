@extends('layouts.app')

@section('title', 'Ubah Jadwal Kunjungan')

@section('content')
    <h3 class="mb-3">Ubah Jadwal Kunjungan</h3>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.settings-kunjungan.update', $item) }}">
            @csrf
            @method('PUT')
            @include('admin.settings_kunjungan._form')
        </form>
    </div></div>
@endsection
