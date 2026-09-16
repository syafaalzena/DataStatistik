<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelabuhan extends Model
{
    use HasFactory;

    protected $fillable = ['kabupaten_ikan_id', 'nama'];

    public function kabupatenIkan()
    {
        return $this->belongsTo(KabupatenIkan::class, 'kabupaten_ikan_id');
    }

    public function produksiTangkap()
    {
        return $this->hasMany(ProduksiTangkap::class);
    }
}