<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;
    protected $fillable = ['nama_kabupaten'];

     /**
     * Get the data tahunan for the kabupaten.
     */
    public function dataTahunan()
    {
        return $this->hasMany(DataTahunan::class);
    }
    
    public function dataBulanan()
    {
        return $this->hasMany(DataBulanan::class);
    }
    
}
