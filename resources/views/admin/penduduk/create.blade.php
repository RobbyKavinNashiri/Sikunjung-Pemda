@extends('layouts.app')

@section('title', 'Tambah Penduduk')

@section('content')
    <h3 class="mb-3">Tambah Penduduk</h3>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.penduduk.store') }}">
            @csrf
            @include('admin.penduduk._form')
        </form>
    </div></div>
@endsection