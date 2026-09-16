<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wppnri extends Model
{
    use HasFactory;

    protected $fillable = ['kode'];

    public function produksiTangkap()
    {
        return $this->hasMany(ProduksiTangkap::class);
    }
}