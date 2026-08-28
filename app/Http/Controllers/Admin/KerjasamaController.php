<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kerjasama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KerjasamaController extends Controller
{
    public function index()
    {
        $kerjasamas = Kerjasama::latest()->paginate(10);
        return view('admin.kerjasama.index', compact('kerjasamas'));
    }

    public function create()
    {
        return view('admin.kerjasama.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mitra' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,selesai,dibatalkan',
            'file_dokumen' => 'nullable|mimes:pdf|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_dokumen')) {
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen-kerjasama', 'public');
        }

        Kerjasama::create($data);

        return redirect()->route('admin.kerjasama.index')->with('success', 'Data kerjasama berhasil ditambahkan.');
    }

    public function edit(Kerjasama $kerjasama)
    {
        return view('admin.kerjasama.edit', compact('kerjasama'));
    }

    public function update(Request $request, Kerjasama $kerjasama)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'mitra' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:aktif,selesai,dibatalkan',
            'file_dokumen' => 'nullable|mimes:pdf|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_dokumen')) {
            if ($kerjasama->file_dokumen && Storage::disk('public')->exists($kerjasama->file_dokumen)) {
                Storage::disk('public')->delete($kerjasama->file_dokumen);
            }
            $data['file_dokumen'] = $request->file('file_dokumen')->store('dokumen-kerjasama', 'public');
        }

        $kerjasama->update($data);

        return redirect()->route('admin.kerjasama.index')->with('success', 'Data kerjasama berhasil diperbarui.');
    }

    public function destroy(Kerjasama $kerjasama)
    {
        if ($kerjasama->file_dokumen && Storage::disk('public')->exists($kerjasama->file_dokumen)) {
            Storage::disk('public')->delete($kerjasama->file_dokumen);
        }

        $kerjasama->delete();

        return redirect()->route('admin.kerjasama.index')->with('success', 'Data kerjasama berhasil dihapus.');
    }
}