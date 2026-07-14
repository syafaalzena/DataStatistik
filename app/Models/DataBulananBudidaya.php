<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBulananBudidaya extends Model
{
    protected $fillable = [
        'kabupaten_ikan_id',
        'komoditas_budidaya_id',
        'jenis_budidaya_id',
        'bulan',
        'tahun',
        'hasil_produksi',
        'keterangan',
    ];

    public function kabupaten()
    {
        return $this->belongsTo(KabupatenIkan::class, 'kabupaten_ikan_id');
    }

    public function komoditas()
    {
        return $this->belongsTo(KomoditasBudidaya::class, 'komoditas_budidaya_id');
    }

    public function jenis()
    {
        return $this->belongsTo(JenisBudidaya::class, 'jenis_budidaya_id');
    }
}