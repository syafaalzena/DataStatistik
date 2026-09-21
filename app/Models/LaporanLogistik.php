<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanLogistik extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_operasional_id',
        'nama_item',
        'jumlah',
        'satuan',
        'harga_rp',
        'total_rp',
        'urutan',
    ];

    public function laporanOperasional()
    {
        return $this->belongsTo(LaporanOperasional::class);
    }
}
