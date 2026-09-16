<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriUkuranKapal extends Model
{
    use HasFactory;

    protected $fillable = ['label'];

    public function produksiTangkap()
    {
        return $this->hasMany(ProduksiTangkap::class);
    }
}