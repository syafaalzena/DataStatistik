<?php

namespace App\Http\Controllers;

use App\Models\KabupatenIkan;
use App\Models\LaporanOperasional;

class TangkapMenuController extends Controller
{
    public function index()
    {
        $totalProduksiKabupaten = KabupatenIkan::count();
        $totalLaporanOperasional = LaporanOperasional::count();

        return view('tangkap.menu', compact('totalProduksiKabupaten', 'totalLaporanOperasional'));
    }
}