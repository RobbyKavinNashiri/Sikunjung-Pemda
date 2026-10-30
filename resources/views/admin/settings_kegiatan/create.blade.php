@extends('layouts.app')

@section('title', 'Tambah Kegiatan')

@section('content')
    <h3 class="mb-3">Tambah Kegiatan</h3>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.settings-kegiatan.store') }}">
            @csrf
            @include('admin.settings_kegiatan._form')
        </form>
    </div></div>
@endsection
