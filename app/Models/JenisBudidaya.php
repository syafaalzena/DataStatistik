<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBudidaya extends Model
{
    protected $fillable = ['kabupaten_ikan_id',
    'nama_jenis',
    ];

    public function kabupaten()
    {
        return $this->belongsTo(KabupatenIkan::class, 'kabupaten_ikan_id');
    }

    public function dataBulanan()
    {
        return $this->hasMany(DataBulananBudidaya::class);
    }

    public function dataTahunan()
    {
        return $this->hasMany(DataTahunanSarana::class);
    }
}