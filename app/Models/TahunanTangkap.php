<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunanTangkap extends Model
{
    use HasFactory;

    protected $fillable = [
        'kabupaten_ikan_id',
        'pelabuhan_id',
        'wppnri_id',
        'jenis_lk',
        'jenis_api_id',
        'kategori_ukuran_kapal_id',
        'tahun',
        'jumlah_rtp',
        'jumlah_kapal',
        'jumlah_api',
        'jumlah_nelayan_buruh',
        'jumlah_nelayan',
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
}
