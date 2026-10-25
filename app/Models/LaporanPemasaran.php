<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPemasaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_operasional_id',
        'laporan_armada_tangkap_id',
        'kategori',
        'jenis_ikan',
        'quantity_kg',
        'tujuan',
        'nama_pt',
        'urutan',
    ];

    public function laporanOperasional()
    {
        return $this->belongsTo(LaporanOperasional::class);
    }

    public function armada()
    {
        return $this->belongsTo(LaporanArmadaTangkap::class, 'laporan_armada_tangkap_id');
    }
}