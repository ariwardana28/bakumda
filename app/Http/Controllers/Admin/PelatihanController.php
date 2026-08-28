<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\PelatihanJenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelatihanController extends Controller
{
    public static function middleware(): array
    {
        return [
            'permission:pelatihan-view'   => ['only' => ['index', 'show']],
            'permission:pelatihan-create' => ['only' => ['create', 'store']],
            'permission:pelatihan-edit'   => ['only' => ['edit', 'update']],
            'permission:pelatihan-delete' => ['only' => ['destroy']],
        ];
    }

    public function index(Request $request)
    {
        $query = Pelatihan::latest();

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $pelatihans = $query->paginate(10)->withQueryString();
        return view('admin.pelatihan.index', compact('pelatihans'));
    }

    public function create()
    {
        // Ambil data jenis pelatihan untuk ditampilkan pada dropdown/select di form
        $jenisPelatihans = PelatihanJenis::all(); // Sesuaikan nama model jenis pelatihan Anda

        return view('admin.pelatihan.create', compact('jenisPelatihans'));
    }

    public function store(Request $request)
    {
        // Bersihkan format titik pada harga sebelum divalidasi (Contoh: "100.000" menjadi "100000")
        if ($request->has('harga')) {
            $request->merge([
                'harga' => str_replace('.', '', $request->harga)
            ]);
        }

        $validated = $request->validate([
            'judul'              => 'required|string|max:255',
            'pelatihan_jenis_id' => 'required|exists:pelatihan_jenis,id', // Validasi jenis pelatihan wajib diisi dan ada di database
            'deskripsi'          => 'required|string',
            'tanggal_mulai'      => 'required|date',
            'tanggal_selesai'    => 'required|date|after_or_equal:tanggal_mulai',
            'harga'              => 'required|numeric|min:0',
            'kuota'              => 'nullable|integer|min:0',
            'gambar'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'             => 'required|in:akan datang,berlangsung,selesai,dibatalkan',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('pelatihan/gambar', 'public');
        }

        Pelatihan::create($validated);

        return redirect()->route('admin.pelatihan.index')->with('success', 'Data pelatihan berhasil ditambahkan.');
    }

    public function show(Pelatihan $pelatihan)
    {
        return view('admin.pelatihan.show', compact('pelatihan'));
    }

    public function edit(Pelatihan $pelatihan)
    {
        // Ambil data jenis pelatihan untuk dropdown pilihan di form edit
        $jenisPelatihans = PelatihanJenis::all(); // Sesuaikan nama model jenis pelatihan Anda

        return view('admin.pelatihan.edit', compact('pelatihan', 'jenisPelatihans'));
    }

    public function update(Request $request, Pelatihan $pelatihan)
    {
        // Bersihkan format titik pada harga sebelum divalidasi
        if ($request->has('harga')) {
            $request->merge([
                'harga' => str_replace('.', '', $request->harga)
            ]);
        }

        $validated = $request->validate([
            'judul'              => 'required|string|max:255',
            'pelatihan_jenis_id' => 'required|exists:pelatihan_jenis,id', // Validasi jenis pelatihan
            'deskripsi'          => 'required|string',
            'tanggal_mulai'      => 'required|date',
            'tanggal_selesai'    => 'required|date|after_or_equal:tanggal_mulai',
            'harga'              => 'required|numeric|min:0',
            'kuota'              => 'nullable|integer|min:0',
            'gambar'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'             => 'required|in:akan datang,berlangsung,selesai,dibatalkan',
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($pelatihan->gambar) {
                Storage::disk('public')->delete($pelatihan->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('pelatihan/gambar', 'public');
        }

        $pelatihan->update($validated);

        return redirect()->route('admin.pelatihan.index')->with('success', 'Data pelatihan berhasil diperbarui.');
    }

    public function destroy(Pelatihan $pelatihan)
    {
        // Hapus gambar jika ada
        if ($pelatihan->gambar) {
            Storage::disk('public')->delete($pelatihan->gambar);
        }

        $pelatihan->delete();

        return redirect()->route('admin.pelatihan.index')->with('success', 'Data pelatihan berhasil dihapus.');
    }
}