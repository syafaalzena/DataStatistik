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
        'tanggal_pulang',
        'jenis_alat_tangkap',
        'latitude',
        'longitude',
        'ukuran_kapal',
        'jumlah_abk',
        'urutan',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'tanggal_pulang' => 'date',
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

    public function foto()
    {
        return $this->hasOne(LaporanArmadaFoto::class);
    }

    public function produksiIkan()
    {
        return $this->hasMany(LaporanProduksiIkan::class)->orderBy('urutan');
    }

    public function logistik()
    {
        return $this->hasMany(LaporanLogistik::class)->orderBy('urutan');
    }

    public function pemasaran()
    {
        return $this->hasMany(LaporanPemasaran::class)->orderBy('urutan');
    }
}
