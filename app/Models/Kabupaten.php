<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;
}

public function dataTahunan()
{
    return $this->hasMany(DataTahunanGaram::class);
}

public function dataBulanan()
{
    return $this->hasMany(DataBulananGaram::class);
}