<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomoditasBudidaya extends Model
{
    protected $fillable = [
        'kabupaten_ikan_id',
        'nama_komoditas',
    ];

    public function kabupaten()
    {
        return $this->belongsTo(KabupatenIkan::class, 'kabupaten_ikan_id');
    }

    public function dataBulanan()
    {
        return $this->hasMany(DataBulananBudidaya::class);
    }
}