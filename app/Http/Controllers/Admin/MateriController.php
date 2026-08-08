<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public static function middleware(): array
    {
        return [
            'permission:materi-view'   => ['only' => ['index', 'show']],
            'permission:materi-create' => ['only' => ['create', 'store']],
            'permission:materi-edit'   => ['only' => ['edit', 'update']],
            'permission:materi-delete' => ['only' => ['destroy']],
        ];
    }

    public function index(Request $request, Pelatihan $pelatihan = null)
    {
        $query = Materi::with('pelatihan')->latest();

        // Jika diakses melalui route /pelatihan/{id}/materi
        if ($pelatihan) {
            $query->where('pelatihan_id', $pelatihan->id);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $materis = $query->paginate(10)->withQueryString();
        return view('admin.materi.index', compact('materis', 'pelatihan'));
    }

    public function create(Pelatihan $pelatihan)
    {
        return view('admin.materi.create', compact('pelatihan'));
    }

   public function store(Request $request, Pelatihan $pelatihan)
    {
        $validated = $request->validate([
            'pelatihan_id' => 'required|exists:pelatihan,id',
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Tambahkan mimetypes yang spesifik untuk video agar lebih aman
            'file'      => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,mp4,mov,webm|mimetypes:video/mp4,video/quicktime,video/webm,application/pdf,application/msword...|max:102400', 
            'status'    => 'required|in:draft,published',
        ]);

        // Pastikan materi yang ditambahkan sesuai dengan pelatihan dari URL
        if ((int) $validated['pelatihan_id'] !== $pelatihan->id) {
            return back()->with('error', 'Terjadi kesalahan, pelatihan tidak cocok.');
        }

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('materi/gambar', 'public');
        }

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('materi/file', 'public');
        }

        $materi = Materi::create($validated);

        return redirect()->route('admin.pelatihan.materi.index', $materi->pelatihan_id)
            ->with('success', 'Data materi berhasil ditambahkan.');
    }

    public function show(Pelatihan $pelatihan, Materi $materi)
    {
        // Memastikan materi yang diakses adalah milik pelatihan yang benar
        abort_if($materi->pelatihan_id !== $pelatihan->id, 404);
        return view('admin.materi.show', compact('materi'));
    }

    public function edit(Pelatihan $pelatihan, Materi $materi)
    {
        return view('admin.materi.edit', compact('materi'));
    }

    public function update(Request $request, Pelatihan $pelatihan, Materi $materi)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file'      => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,mp4,mov,webm|max:102400', // Max 100MB
            'status'    => 'required|in:draft,published',
        ]);

        if ($request->hasFile('gambar')) {
            if ($materi->gambar) {
                Storage::disk('public')->delete($materi->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('materi/gambar', 'public');
        }

        if ($request->hasFile('file')) {
            if ($materi->file) {
                Storage::disk('public')->delete($materi->file);
            }
            $validated['file'] = $request->file('file')->store('materi/file', 'public');
        }

        $materi->update($validated);

        return redirect()->route('admin.pelatihan.materi.index', $materi->pelatihan_id)
            ->with('success', 'Data materi berhasil diperbarui.');
    }

    public function destroy(Pelatihan $pelatihan, Materi $materi)
    {
        $pelatihanId = $materi->pelatihan_id; // Simpan ID sebelum dihapus
        if ($materi->gambar) Storage::disk('public')->delete($materi->gambar);
        if ($materi->file) Storage::disk('public')->delete($materi->file);

        $materi->delete();

        return redirect()->route('admin.pelatihan.materi.index', $pelatihanId)
            ->with('success', 'Data materi berhasil dihapus.');
    }
}
