@extends('layouts.app')

@section('title', 'Tambah Jabatan')

@section('content')
    <h3 class="mb-3">Tambah Jabatan</h3>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.jabatan.store') }}">
            @csrf
            @include('admin.jabatan._form')
        </form>
    </div></div>
@endsection