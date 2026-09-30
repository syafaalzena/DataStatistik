<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanArmadaDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_armada_tangkap_id',
        'nama_dokumen',
        'urutan',
    ];

    public function armadaTangkap()
    {
        return $this->belongsTo(LaporanArmadaTangkap::class, 'laporan_armada_tangkap_id');
    }
}