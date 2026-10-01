<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LaporanArmadaFoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'laporan_armada_tangkap_id',
        'foto',
        'lokasi',
    ];

    public function armadaTangkap()
    {
        return $this->belongsTo(LaporanArmadaTangkap::class, 'laporan_armada_tangkap_id');
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->foto);
    }

    public function getJamUploadAttribute(): string
    {
        return $this->created_at->translatedFormat('H:i, d M Y');
    }
}