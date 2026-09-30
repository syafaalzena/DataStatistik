<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripTangkap extends Model
{
    use HasFactory;

    protected $fillable = [
        'kabupaten_ikan_id', 'pelabuhan_id', 'wppnri_id', 'jenis_lk',
        'jenis_api_id', 'kategori_ukuran_kapal_id', 'tanggal', 'jumlah_trip',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kabupatenIkan() { return $this->belongsTo(KabupatenIkan::class, 'kabupaten_ikan_id'); }
    public function pelabuhan() { return $this->belongsTo(Pelabuhan::class); }
    public function wppnri() { return $this->belongsTo(Wppnri::class); }
    public function jenisApi() { return $this->belongsTo(JenisApi::class); }
    public function kategoriUkuranKapal() { return $this->belongsTo(KategoriUkuranKapal::class); }

    public function getBulanAttribute(): int { return (int) $this->tanggal->format('n'); }
    public function getTahunAttribute(): int { return (int) $this->tanggal->format('Y'); }
    public function getTriwulanAttribute(): int { return (int) ceil($this->bulan / 3); }
    public function getSemesterAttribute(): int { return $this->bulan <= 6 ? 1 : 2; }
}