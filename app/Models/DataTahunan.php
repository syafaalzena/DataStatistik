<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTahunan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kabupaten_id', 
        'statistik_id', 
        'jumlah_petani', 
        'luas_lahan_rebus', 
        'luas_lahan_jemur', 
        'jumlah_lahan_unit', 
        'tahun', 
        'lokasi'];
    

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
}

