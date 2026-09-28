<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanArmadaTangkap extends Model
{
    use HasFactory;

    protected $fillable =[
        'laporan_operasional-id',
        'nama_armada',
        'jenis_alat_tangkap',
        'ukuran_kapal',
        'jumlah_kapal',
        'jumlah_abk',
        'status_dokumen',
        'urutan',
    ];

    public function laporanOperasional()
    {
        return $this->belongsTo(LaporanOperasional::class);
    }
}
