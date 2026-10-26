@extends('layouts.app')

@section('title', 'Ubah Penduduk')

@section('content')
    <h3 class="mb-3">Ubah Penduduk</h3>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.penduduk.update', $penduduk) }}">
            @csrf
            @method('PUT')
            @include('admin.penduduk._form')
        </form>
    </div></div>
@endsection