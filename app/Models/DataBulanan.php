<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataBulanan extends Model
{
    
    use HasFactory;
    protected $fillable = [
        'kabupaten_id',
        'bulan',
        'tahun',
        'jenis_produksi',
        'produksi',
        'harga',
    ];
        
    
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}

