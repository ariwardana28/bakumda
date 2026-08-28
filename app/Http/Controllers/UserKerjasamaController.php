<?php

namespace App\Http\Controllers;

use App\Models\Kerjasama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserKerjasamaController extends Controller
{
    /**
     * Menampilkan daftar kerja sama (Index).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kerjasamas = Kerjasama::when($search, function ($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                             ->orWhere('mitra', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('user.kerjasama.index', compact('kerjasamas'));
    }

    /**
     * Menampilkan form tambah kerja sama (Create).
     */
    public function create()
    {
        return view('user.kerjasama.form');
    }

    /**
     * Menyimpan data kerja sama baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'           => 'required|string|max:255',
            'mitra'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status'          => 'required|in:aktif,pending,selesai,terminasi',
            'file_dokumen'    => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle upload file dokumen jika ada
        if ($request->hasFile('file_dokumen')) {
            $validated['file_dokumen'] = $request->file('file_dokumen')->store('dokumen-kerjasama', 'public');
        }

        Kerjasama::create($validated);

        return redirect()->route('user-kerjasamas.index')
            ->with('success', 'Data kerja sama baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form ubah kerja sama (Edit).
     */
    public function edit($id)
    {
        $kerjasama = Kerjasama::findOrFail($id);

        return view('user.kerjasamas.form', compact('kerjasama'));
    }

    /**
     * Memperbarui data kerja sama di database.
     */
    public function update(Request $request, $id)
    {
        $kerjasama = Kerjasama::findOrFail($id);

        $validated = $request->validate([
            'judul'           => 'required|string|max:255',
            'mitra'           => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status'          => 'required|in:aktif,pending,selesai,terminasi',
            'file_dokumen'    => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle update file dokumen baru
        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama jika ada
            if ($kerjasama->file_dokumen && Storage::disk('public')->exists($kerjasama->file_dokumen)) {
                Storage::disk('public')->delete($kerjasama->file_dokumen);
            }

            $validated['file_dokumen'] = $request->file('file_dokumen')->store('dokumen-kerjasama', 'public');
        }

        $kerjasama->update($validated);

        return redirect()->route('user-kerjasamas.index')
            ->with('success', 'Data kerja sama berhasil diperbarui.');
    }

    /**
     * Menghapus data kerja sama dari database.
     */
    public function destroy($id)
    {
        $kerjasama = Kerjasama::findOrFail($id);

        // Hapus file dokumen fisik jika ada
        if ($kerjasama->file_dokumen && Storage::disk('public')->exists($kerjasama->file_dokumen)) {
            Storage::disk('public')->delete($kerjasama->file_dokumen);
        }

        $kerjasama->delete();

        return redirect()->route('user.kerjasama.index')
            ->with('success', 'Data kerja sama berhasil dihapus.');
    }
}