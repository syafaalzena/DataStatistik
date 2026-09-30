<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanArmadaTangkap extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_operasional_id',
        'nama_armada',
        'tanggal_berangkat',
        'jenis_alat_tangkap',
        'latitude',
        'longitude',
        'ukuran_kapal',
        'jumlah_abk',
        'urutan',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function laporanOperasional()
    {
        return $this->belongsTo(LaporanOperasional::class);
    }

    public function dokumens()
    {
        return $this->hasMany(LaporanArmadaDokumen::class)->orderBy('urutan');
    }
}