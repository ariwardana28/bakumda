<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratJenis;
use Illuminate\Http\Request;

class SuratJenisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suratJenis = SuratJenis::latest()->paginate(10);
        return view('admin.surat_jenis.index', compact('suratJenis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.surat_jenis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:surat_jenis,nama',
            'deskripsi' => 'required|string',
        ]);

        SuratJenis::create($validated);

        return redirect()->route('admin.surat-jenis.index')->with('success', 'Jenis Surat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratJenis $suratJeni)
    {
        return view('admin.surat_jenis.show', compact('suratJeni'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratJenis $suratJeni)
    {
        return view('admin.surat_jenis.edit', compact('suratJeni'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratJenis $suratJeni)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:surat_jenis,nama,' . $suratJeni->id,
            'deskripsi' => 'required|string',
        ]);

        $suratJeni->update($validated);

        return redirect()->route('admin.surat-jenis.index')->with('success', 'Jenis Surat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratJenis $suratJeni)
    {
        $suratJeni->delete();

        return redirect()->route('admin.surat-jenis.index')->with('success', 'Jenis Surat berhasil dihapus.');
    }
}
