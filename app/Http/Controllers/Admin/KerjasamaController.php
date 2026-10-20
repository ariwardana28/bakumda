<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kerjasama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KerjasamaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil filter status dari request (default 'pending')
        $statusFilter = $request->get('status', 'pending');
        $search = $request->get('search');

        // 2. Query dasar diurutkan dari yang terbaru (descending)
        $query = Kerjasama::latest(); // atau bisa juga menggunakan ->orderBy('id', 'desc')

        // 3. Filter berdasarkan status jika bukan 'semua'
        if ($statusFilter && $statusFilter !== 'semua') {
            $query->where('status', $statusFilter);
        }

        // 4. Filter berdasarkan kata kunci pencarian (judul / mitra)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('mitra', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // 5. Paginated data
        $kerjasamas = $query->paginate(10)->withQueryString();

        // 6. Hitung jumlah data untuk masing-masing tab status (badge counter)
        $counts = [
            'pending' => Kerjasama::where('status', 'pending')->count(),
            'aktif' => Kerjasama::where('status', 'aktif')->count(),
            'ditolak' => Kerjasama::where('status', 'ditolak')->count(),
        ];

        return view('admin.kerjasama.index', compact('kerjasamas', 'counts'));
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

    public function show(Kerjasama $kerjasama)
    {
        return view('admin.kerjasama.show', compact('kerjasama'));
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

    public function status(Request $request, Kerjasama $kerjasama)
    {
        $validated = $request->validate([
            'status'     => 'required|in:aktif,ditolak',
            'keterangan' => 'required_if:status,ditolak|nullable|string|min:10|max:1000',
        ], [
            'status.in'                => 'Status yang dipilih tidak valid.',
            'keterangan.required_if'   => 'Keterangan penolakan wajib diisi.',
            'keterangan.min'           => 'Keterangan minimal 10 karakter.',
            'keterangan.max'           => 'Keterangan maksimal 1000 karakter.',
        ]);

        // Hanya pengajuan pending yang boleh diproses
        // (mencegah klik ganda atau dua admin memproses data yang sama)
        if ($kerjasama->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses dan tidak dapat diubah lagi.');
        }

        if ($validated['status'] === 'aktif') {
            $kerjasama->update([
                'status'     => 'aktif',
                'keterangan' => null,
                'ditolak_at' => null,
            ]);

            $message = 'Pengajuan kerjasama berhasil aktif.';
        } else {
            $kerjasama->update([
                'status'     => 'ditolak',
                'keterangan' => $validated['keterangan'],
                'ditolak_at' => now(),
            ]);

            $message = 'Pengajuan kerjasama telah ditolak.';
        }

        return redirect()
            ->route('admin.kerjasama.show', $kerjasama->id)
            ->with('success', $message);
    }
}
