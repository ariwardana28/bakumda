<?php

namespace App\Http\Controllers;
 
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
 
class ArtikelController extends Controller
{
    /**
     * Menampilkan daftar semua artikel.
     */
    public function index()
    {
        $artikels = Artikel::latest()->paginate(10);
        return view('user.artikel.index', compact('artikels'));
    }
 
    /**
     * Menampilkan form untuk membuat artikel baru.
     */
    public function create()
    {
        return view('user.artikel.create');
    }
 
    /**
     * Menyimpan artikel baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ]);
 
        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['judul']);
 
        // Pastikan slug unik
        $slugCount = Artikel::where('slug', 'like', $validated['slug'].'%')->count();
        if ($slugCount > 0) {
            $validated['slug'] = $validated['slug'] . '-' . ($slugCount + 1);
        }
 
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('artikel/gambar', 'public');
        }
 
        Artikel::create($validated);
 
        return redirect()->route('user.artikel.index')->with('success', 'Artikel berhasil dibuat.');
    }
 
    /**
     * Menampilkan detail satu artikel.
     */
    public function show(Artikel $artikel)
    {
        // Untuk halaman publik/pengguna
        return view('user.artikel.show', compact('artikel'));
    }
 
    /**
     * Menampilkan form untuk mengedit artikel.
     */
    public function edit(Artikel $artikel)
    {
        return view('user.artikel.edit', compact('artikel'));
    }
 
    /**
     * Memperbarui artikel di database.
     */
    public function update(Request $request, Artikel $artikel)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ]);
 
        // Jika judul berubah, buat slug baru
        if ($artikel->judul !== $validated['judul']) {
            $validated['slug'] = Str::slug($validated['judul']);
            $slugCount = Artikel::where('slug', 'like', $validated['slug'].'%')->where('id', '!=', $artikel->id)->count();
            if ($slugCount > 0) {
                $validated['slug'] = $validated['slug'] . '-' . ($slugCount + 1);
            }
        }
 
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('artikel/gambar', 'public');
        }
 
        $artikel->update($validated);
 
        return redirect()->route('user.artikel.index')->with('success', 'Artikel berhasil diperbarui.');
    }
 
    /**
     * Menghapus artikel dari database.
     */
    public function destroy(Artikel $artikel)
    {
        // Hapus gambar terkait jika ada
        if ($artikel->gambar) {
            Storage::disk('public')->delete($artikel->gambar);
        }
 
        $artikel->delete();
 
        return redirect()->route('user.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
