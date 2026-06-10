<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

@section('content')
<div class="container">

    <h3>Statistik Garam Aceh</h3>

    <a href="{{ route('garam.rekapTahunan') }}"
       class="btn btn-success">
       Rekap Tahunan
    </a>

    <a href="{{ route('garam.rekapBulanan') }}"
       class="btn btn-info">
       Rekap Bulanan
    </a>

    <hr>

    <div class="row">

        @foreach($data as $kabupaten)

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">

                    <h5>
                        {{ $kabupaten->nama_kabupaten }}
                    </h5>

                    <a href="{{ route('garam.show',$kabupaten->id) }}"
                       class="btn btn-primary">
                       Kelola Data
                    </a>

                </div>
            </div>
        </div>

        @endforeach

    </div>

</div>

</body>
</html>