<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBulanan extends Model
{
    
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'kabupaten_id',
        'bulan',
        'tahun',
        'jenis_produksi',
        'produksi',
        'lokasi',
        'jumlah_petani',
        'nama_kelompok',
        'nama_pemilik',
        'harga',
    ];
        
    
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}

