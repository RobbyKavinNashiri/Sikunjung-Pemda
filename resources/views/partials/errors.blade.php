@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $pesan)
                <li>{{ $pesan }}</li>
            @endforeach
        </ul>
    </div>
@endif