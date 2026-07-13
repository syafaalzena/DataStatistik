<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KabupatenIkan extends Model
{
    use HasFactory;
    protected $fillable = ['nama_kabupaten'];

    public function komoditas()
{
    return $this->hasMany(KomoditasBudidaya::class, 'kabupaten_ikan_id');
}

public function jenisBudidaya()
{
    return $this->hasMany(JenisBudidaya::class, 'kabupaten_ikan_id');
}

public function dataBulananBudidaya()
{
    return $this->hasMany(DataBulananBudidaya::class, 'kabupaten_ikan_id');
}

public function dataTahunanSarana()
{
    return $this->hasMany(DataTahunanSarana::class, 'kabupaten_ikan_id');
}
}
