<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanOperasional extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelabuhan_id',
        'bulan',
        'tahun',
        'nama_pengelola',
        'nip_pengelola',
    ];

    public function pelabuhan()
    {
        return $this->belongsTo(Pelabuhan::class);
    }

    public function armadaTangkap()
    {
        return $this->hasMany(LaporanArmadaTangkap::class)->orderBy('urutan');
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

    public function getTotalKapalAttribute()
    {
        return $this->armadaTangkap->sum('jumlah_kapal');
    }

    public function getTotalAbkAttribute()
    {
        return $this->armadaTangkap->sum('jumlah_abk');
    }

    public function getTotalProduksiKgAttribute()
    {
        return $this->produksiIkan->sum('produksi_kg');
    }

    public function getTotalNilaiProduksiAttribute()
    {
        return $this->produksiIkan->sum('nilai_rp');
    }

    public function getTotalLogistikAttribute()
    {
        return $this->logistik->sum('total_rp');
    }

    public function getNamaBulanAttribute(): string
    {
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        return $bulanIndo[$this->bulan] ?? '-';
    }
}