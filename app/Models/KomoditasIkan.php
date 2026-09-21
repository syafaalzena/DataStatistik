<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomoditasIkan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_ikan', 'nama_latin', 'kode_fao', 'kelompok_sdi'];

    public function produksiTangkap()
    {
        return $this->hasMany(ProduksiTangkap::class);
    }
}