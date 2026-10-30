@extends('layouts.app')

@section('title', 'Tambah Jadwal Kunjungan')

@section('content')
    <h3 class="mb-3">Tambah Jadwal Kunjungan</h3>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.settings-kunjungan.store') }}">
            @csrf
            @include('admin.settings_kunjungan._form')
        </form>
    </div></div>
@endsection
