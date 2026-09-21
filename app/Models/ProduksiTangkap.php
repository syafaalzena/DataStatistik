<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduksiTangkap extends Model
{
    use HasFactory;

   protected $fillable = [
    'kabupaten_ikan_id',
    'pelabuhan_id',
    'wppnri_id',
    'jenis_lk',
    'jenis_api_id',
    'kategori_ukuran_kapal_id',
    'komoditas_ikan_id',
    'bulan',
    'tahun',
    'volume_produksi_kg',
    'harga_rp',
    'nilai_rp',
];


    public function kabupatenIkan()
    {
        return $this->belongsTo(KabupatenIkan::class, 'kabupaten_ikan_id');
    }

    public function pelabuhan()
    {
        return $this->belongsTo(Pelabuhan::class);
    }

    public function wppnri()
    {
        return $this->belongsTo(Wppnri::class);
    }

    public function jenisApi()
    {
        return $this->belongsTo(JenisApi::class);
    }

    public function kategoriUkuranKapal()
    {
        return $this->belongsTo(KategoriUkuranKapal::class);
    }

    public function komoditasIkan()
    {
        return $this->belongsTo(KomoditasIkan::class);
    }

    public function getTriwulanAttribute(): int
    {
        return (int) ceil($this->bulan / 3);
    }

    public function getSemesterAttribute(): int
    {
        return $this->bulan <= 6 ? 1 : 2;
    }
}