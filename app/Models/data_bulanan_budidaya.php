<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_bulanan_budidaya extends Model
{
    use HasFactory;
    protected $fillable = [
        'kabupaten_ikan_id',
        'komoditas_budidaya_id',
        'bulan',
        'tahun',
        'hasil_produksi',
        'jumlah_pembudidaya',
        'keterangan',
    ];
}   
