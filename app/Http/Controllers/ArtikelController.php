<?php

namespace App\Http\Controllers;
 
use App\Models\Kategori;
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
        $artikels = Artikel::where('users_id', Auth::id())->latest()->paginate(10);
        return view('user.artikel.index', compact('artikels'));
    }
 
    /**
     * Menampilkan form untuk membuat artikel baru.
     */
    public function create()
    {
        $kategoris = Kategori::orderBy('nama')->get();
        return view('user.artikel.create', compact('kategoris'));
    }
 
    /**
     * Menyimpan artikel baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'kategori_id' => 'required|exists:kategori,id',
            'tanggal' => 'required|date',
        ]);
 
        $validated['users_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['judul']);
 
        // Pastikan slug unik
        $slugCount = Artikel::where('slug', 'like', $validated['slug'].'%')->count();
        if ($slugCount > 0) {
            $validated['slug'] = $validated['slug'] . '-' . ($slugCount + 1);
        }
 
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('artikel/gambar', 'public');
        }
 
        // dd($validated);
        Artikel::create($validated);
 
        return redirect()->route('user.artikel.index')->with('success', 'Artikel berhasil dibuat.');
    }
 
    /**
     * Menampilkan detail satu artikel.
     */
    public function show(Artikel $artikel)
    {
        // Pastikan user hanya bisa melihat artikel miliknya sendiri
        if ($artikel->users_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK MEMILIKI IZIN UNTUK MENGAKSES HALAMAN INI.');
        }

        // Untuk halaman publik/pengguna
        return view('user.artikel.show', compact('artikel'));
    }
 
    /**
     * Menampilkan form untuk mengedit artikel.
     */
    public function edit(Artikel $artikel)
    {
        $kategoris = Kategori::orderBy('nama')->get();
        
        // Pastikan user hanya bisa mengedit artikel miliknya sendiri
        if ($artikel->users_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK MEMILIKI IZIN UNTUK MENGAKSES HALAMAN INI.');
        }

        return view('user.artikel.edit', compact('artikel', 'kategoris'));
    }
 
    /**
     * Memperbarui artikel di database.
     */
    public function update(Request $request, Artikel $artikel)
    {
        // Pastikan user hanya bisa memperbarui artikel miliknya sendiri
        if ($artikel->users_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK MEMILIKI IZIN UNTUK MELAKUKAN TINDAKAN INI.');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
            'kategori_id' => 'required|exists:kategori,id',
            'tanggal' => 'required|date',
        ]);
 
        // Jika judul berubah, buat slug baru
        // Cek apakah judul yang di-request berbeda dengan judul yang ada di database
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
        // Pastikan user hanya bisa menghapus artikel miliknya sendiri
        if ($artikel->users_id !== Auth::id()) {
            abort(403, 'ANDA TIDAK MEMILIKI IZIN UNTUK MELAKUKAN TINDAKAN INI.');
        }

        // Hapus gambar terkait jika ada
        if ($artikel->gambar) {
            Storage::disk('public')->delete($artikel->gambar);
        }
 
        $artikel->delete();
 
        return redirect()->route('user.artikel.index')->with('success', 'Artikel berhasil dihapus.');
    }
}
