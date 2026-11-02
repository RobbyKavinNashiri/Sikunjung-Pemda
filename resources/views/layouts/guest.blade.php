<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-5">
            <h4 class="text-center mb-3">{{ config('app.name') }}</h4>
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    @include('partials.flash')
                    @include('partials.errors')
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>