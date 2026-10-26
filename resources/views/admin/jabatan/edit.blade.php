@extends('layouts.app')

@section('title', 'Ubah Jabatan')

@section('content')
    <h3 class="mb-3">Ubah Jabatan</h3>

    <div class="card"><div class="card-body">
        <form method="POST" action="{{ route('admin.jabatan.update', $jabatan) }}">
            @csrf
            @method('PUT')
            @include('admin.jabatan._form')
        </form>
    </div></div>
@endsection