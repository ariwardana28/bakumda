<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\ProdukGambar;
use App\Models\ProdukUkuran;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public static function middleware(): array
    {
        return [
            'permission:produk-view'   => ['only' => ['index', 'show']],
            'permission:produk-create' => ['only' => ['create', 'store']],
            'permission:produk-edit'   => ['only' => ['edit', 'update']],
            'permission:produk-delete' => ['only' => ['destroy']],
        ];
    }
    /**
     * Menampilkan daftar semua produk.
     */
    public function index()
    {
        $produks = Produk::latest()->paginate(10);
        return view('admin.produk.index', compact('produks'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        return view('admin.produk.create');
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'status'      => 'required|string|max:255',
            'kategori'    => 'required|string|max:255',

            // Validasi gambar
            'gambar_produk'   => 'nullable|array',
            'gambar_produk.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

            // Validasi varian ukuran (harus sesuai dengan nama input di Blade: ukurans)
            'ukurans'              => 'nullable|array',
            'ukurans.*.ukuran'     => 'required_with:ukurans|string|max:50',
            'ukurans.*.harga'      => 'required_with:ukurans|numeric|min:0',
            'ukurans.*.stok'       => 'required_with:ukurans|integer|min:0',
            'ukurans.*.status'     => 'required_with:ukurans|string|max:255',
            'ukurans.*.keterangan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        $uploadedImages = [];

        try {
            // 2. Buat Slug
            $validated['slug'] = Str::slug($validated['nama_produk']);

            // 3. Simpan Produk Utama
            $produk = Produk::create([
                'nama_produk' => $validated['nama_produk'],
                'slug'        => $validated['slug'],
                'deskripsi'   => $validated['deskripsi'],
                'status'      => $validated['status'],
                'kategori'    => $validated['kategori'],
            ]);

            // 4. Simpan Gambar-gambar (jika ada)
            if ($request->hasFile('gambar_produk')) {
                foreach ($request->file('gambar_produk') as $file) {
                    $path = $file->store('produk/gambar', 'public');
                    $uploadedImages[] = $path;

                    $produk->gambars()->create([
                        'gambar' => $path
                    ]);
                }
            }

            // 5. Simpan Ukuran-ukuran Produk (hanya jika kategori Baju)
            if ($request->kategori === 'Baju' && $request->has('ukurans')) {
                // Pastikan data yang dikirim adalah array
                $dataUkuran = $request->input('ukurans');

                // Simpan melalui relasi (Eloquent akan otomatis mengisi produk_id)
                $produk->ukurans()->createMany($dataUkuran);
            }

            DB::commit();

            return redirect()->route('admin.produk.index')
                ->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file yang sempat terupload jika gagal
            foreach ($uploadedImages as $path) {
                Storage::disk('public')->delete($path);
            }

            return back()->withInput()
                ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail satu produk (opsional, seringkali form edit sudah cukup).
     */
    public function show(Produk $produk)
    {
        return view('admin.produk.show', compact('produk'));
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit(Produk $produk)
    {
        // Muat relasi gambar dan ukuran agar tersedia di view
        $produk->load(['gambars', 'ukurans']);

        return view('admin.produk.edit', compact('produk'));
    }

    /**
     * Memperbarui produk di database.
     */
    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'status'      => 'required|string|max:255',
            'kategori'    => 'required|string|max:255',

            // Validasi untuk gambar tambahan baru
            'gambar_produk'   => 'nullable|array',
            'gambar_produk.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

            // Validasi untuk ukuran
            'ukurans'              => 'nullable|array',
            'ukurans.*.id'         => 'nullable|integer|exists:produk_ukuran,id',
            'ukurans.*.ukuran'     => 'required|string|max:50',
            'ukurans.*.harga'      => 'required|numeric|min:0',
            'ukurans.*.stok'       => 'required|integer|min:0',
            'ukurans.*.status'     => 'required|string|max:255',
            'ukurans.*.keterangan' => 'nullable|string',

            // Validasi untuk item yang akan dihapus
            'delete_gambars'   => 'nullable|array',
            'delete_gambars.*' => 'integer|exists:produk_gambar,id',
            'delete_ukurans'   => 'nullable|array',
            'delete_ukurans.*' => 'integer|exists:produk_ukuran,id',
        ]);

        DB::beginTransaction();
        $uploadedImages = [];

        try {
            // Update slug jika nama produk berubah
            if ($produk->nama_produk !== $validated['nama_produk']) {
                $validated['slug'] = Str::slug($validated['nama_produk']);
            }

            // Update informasi dasar produk
            $produk->update([
                'nama_produk' => $validated['nama_produk'],
                'slug'        => $validated['slug'] ?? $produk->slug,
                'deskripsi'   => $validated['deskripsi'],
                'status'      => $validated['status'],
                'kategori'    => $validated['kategori'],
            ]);

            // 1. Proses Hapus Gambar yang dipilih untuk dihapus
            if ($request->has('delete_gambars')) {
                $gambarList = ProdukGambar::whereIn('id', $request->delete_gambars)->get();
                foreach ($gambarList as $img) {
                    Storage::disk('public')->delete($img->gambar);
                    $img->delete();
                }
            }

            // 2. Proses Gambar Tambahan Baru
            if ($request->hasFile('gambar_produk')) {
                foreach ($request->file('gambar_produk') as $file) {
                    $path = $file->store('produk/gambar', 'public');
                    $uploadedImages[] = $path;

                    $produk->gambars()->create([
                        'gambar' => $path
                    ]);
                }
            }

            // 3. Proses Hapus Varian Ukuran yang dipilih untuk dihapus
            if ($request->has('delete_ukurans')) {
                $produk->ukurans()->whereIn('id', $request->delete_ukurans)->delete();
            }

            // 4. Proses Ukuran (Update existing atau Create baru, hanya jika kategori Baju)
            if ($request->kategori === 'Baju' && $request->has('ukurans')) {
                // Kumpulkan ID ukuran yang dikirim dari form untuk mendeteksi yang dihapus/di-manage secara dinamis
                $submittedIds = collect($request->ukurans)->pluck('id')->filter()->toArray();

                // Hapus ukuran lama milik produk ini yang tidak ada lagi di dalam list form
                $produk->ukurans()->whereNotIn('id', $submittedIds)->delete();

                // Lakukan update atau create untuk setiap baris ukuran
                foreach ($request->ukurans as $ukuranData) {
                    $produk->ukurans()->updateOrCreate(
                        ['id' => $ukuranData['id'] ?? null], // Kondisi pencarian berdasarkan ID
                        [
                            'ukuran'     => $ukuranData['ukuran'],
                            'harga'      => $ukuranData['harga'],
                            'stok'       => $ukuranData['stok'],
                            'status'     => $ukuranData['status'],
                            'keterangan' => $ukuranData['keterangan'] ?? null,
                        ]
                    );
                }
            } else {
                // Jika kategori diubah dari Baju ke non-Baju, hapus semua varian ukurannya
                $produk->ukurans()->delete();
            }

            DB::commit();

            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file baru yang sempat ter-upload jika terjadi error sistem
            foreach ($uploadedImages as $path) {
                Storage::disk('public')->delete($path);
            }

            return back()->withInput()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy(Produk $produk)
    {
        // Hapus gambar terkait jika ada
        if ($produk->gambar) {
            Storage::disk('public')->delete($produk->gambar);
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}

