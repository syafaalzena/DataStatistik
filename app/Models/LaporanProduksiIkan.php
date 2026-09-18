<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanProduksiIkan extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_operasional_id',
        'jenis_ikan',
        'produksi_kg',
        'harga_rp',
        'urutan',
    ];

    public function laporanOperasional()
    {
        return $this->belongsTo(laporanOperasional::class);
    }
}
