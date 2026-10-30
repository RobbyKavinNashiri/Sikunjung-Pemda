@extends('layouts.app')

@section('title', 'Ubah Kegiatan')

@section('content')
    <h3 class="mb-3">Ubah Kegiatan</h3>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.settings-kegiatan.update', $item) }}">
            @csrf
            @method('PUT')
            @include('admin.settings_kegiatan._form')
        </form>
    </div></div>
@endsection
