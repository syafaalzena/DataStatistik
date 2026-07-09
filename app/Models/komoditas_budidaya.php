<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class komoditas_budidaya extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_komoditas',
    ];


public function komoditas()
{
    return $this->hasMany(KomoditasBudidaya::class);
}

}
