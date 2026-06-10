<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>

    @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard</h2>

    <div class="card">
        <div class="card-body">
            <h4>Data Statistik Garam Aceh</h4>

            <a href="{{ route('kabupaten.index') }}"
               class="btn btn-primary">
                Lihat Data
            </a>
        </div>
    </div>
</div>
@endsection

</body>
</html>