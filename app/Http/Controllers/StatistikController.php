<?php

namespace App\Http\Controllers;

use App\Models\Statistik;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Statistik::all();
        return view('statistik.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('statistik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_statistik' => 'required|string|max:255',
        ]);

        Statistik::create($request->all());

        return redirect()->route('statistik.index')
            ->with('success', 'Statistik created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Statistik $statistik)
    {
        return view('statistik.show', compact('statistik'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statistik $statistik)
    {
        return view('statistik.edit', compact('statistik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Statistik $statistik)
    {
        $request->validate([
            'nama_statistik' => 'required|string|max:255',
        ]);

        $statistik->update($request->all());

        return redirect()->route('statistik.index')
            ->with('success', 'Statistik updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Statistik $statistik)
    {
        $statistik->delete();

        return redirect()->route('statistik.index')
            ->with('success', 'Statistik deleted successfully.');
    }
    
    public function statistikKab()
    {
        $data = Statistik::all();
        return view('statistik.StatistikKab', compact('data'));
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
