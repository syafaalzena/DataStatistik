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
        'quantity_kg',
        'tujuan',
        'nama_pt',
        'urutan',
    ];

    public function laporanOperasional()
    {
        return $this->belongsTo(laporanOperasional::class);
    }
}
