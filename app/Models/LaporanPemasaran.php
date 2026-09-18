<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPemasaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_operasional_id',
        'kategori',
        'jenis_ikan',
        'quantyti_kg',
        'tujuan',
        'urutan',
    ];

    public function laporanOperasional()
    {
        return $this->belongsTo(laporanOperasional::class);
    }
}
