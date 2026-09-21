<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisApi extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    public function produksiTangkap()
    {
        return $this->hasMany(ProduksiTangkap::class);
    }
}