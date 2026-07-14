<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataTahunanSarana extends Model
{
    protected $table = 'data_tahunan_saranas';

    protected $fillable = [
        'kabupaten_ikan_id',
        'jenis_budidaya_id',
        'tahun',
        'jumlah_rtp',
        'jumlah_pembudidaya',
        'luas_lahan',
    ];

    public function kabupaten()
    {
        return $this->belongsTo(KabupatenIkan::class, 'kabupaten_ikan_id');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisBudidaya::class, 'jenis_budidaya_id');
    }
}