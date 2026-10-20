<?php

namespace App\Http\Controllers;

use App\Models\Kerjasama;
use App\Models\KerjasamaStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserKerjasamaController extends Controller
{
    /**
     * Menampilkan daftar kerja sama (Index).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kerjasamas = Kerjasama::where('user_id', auth()->id())
            ->with('latestStatus') // Muat status terakhir
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('mitra', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc') // Mengurutkan dari yang terbaru (DESC)
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
            'judul'             => 'required|string|max:255',
            'mitra'             => 'required|string|max:255',
            'deskripsi'         => 'nullable|string',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'required|date|after_or_equal:tanggal_mulai',
            'status'            => 'required|in:pending,aktif,selesai,dibatalkan', // Disesuaikan dengan ENUM migrasi
            'keterangan'        => 'nullable|string', // Ditambahkan validasi keterangan status jika diperlukan
            'file_dokumen'      => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle upload file dokumen jika ada
        if ($request->hasFile('file_dokumen')) {
            $validated['file_dokumen'] = $request->file('file_dokumen')->store('dokumen-kerjasama', 'public');
        }

        // 1. Buat data Kerjasama (tanpa field 'status' dan 'keterangan' jika kolomnya sudah dihapus dari tabel kerjasamas)
        $kerjasama = Kerjasama::create([
            'user_id'           => Auth::id(),
            'judul'             => $validated['judul'],
            'mitra'             => $validated['mitra'],
            'deskripsi'         => $validated['deskripsi'] ?? null,
            'tanggal_mulai'     => $validated['tanggal_mulai'],
            'tanggal_selesai'   => $validated['tanggal_selesai'],
            'file_dokumen'      => $validated['file_dokumen'] ?? null,
        ]);

        // 2. Simpan status ke tabel kerjasama_status
        KerjasamaStatus::create([
            'kerjasama_id' => $kerjasama->id,
            'status'       => $validated['status'],
            'keterangan'   => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('user-kerjasamas.index')
            ->with('success', 'Data kerja sama baru beserta statusnya berhasil ditambahkan.');
    }

    public function show($id)
    {
        $kerjasama = Kerjasama::findOrFail($id);

        return view('user.kerjasama.show', compact('kerjasama'));
    }

    /**
     * Menampilkan form ubah kerja sama (Edit).
     */
    public function edit($id)
    {
        $kerjasama = Kerjasama::findOrFail($id);

        return view('user.kerjasama.form', compact('kerjasama'));
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


    public function cancel(Request $request, $id)
    {
        $kerjasama = Kerjasama::findOrFail($id);

        // Pastikan user yang login adalah pemilik data kerja sama ini
        if ($kerjasama->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Cek status terakhir dari tabel kerjasama_status
        $latestStatus = KerjasamaStatus::where('kerjasama_id', $kerjasama->id)->latest()->first();
        $currentStatus = $latestStatus ? $latestStatus->status : 'pending';

        // Jika status bukan pending (misal sudah aktif atau ditolak), tolak pembatalan
        if ($currentStatus !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses dan tidak dapat dibatalkan.');
        }

        $validated = $request->validate([
            'keterangan' => 'nullable|string|max:1000',
        ]);

        // Simpan status pembatalan baru ke tabel kerjasama_status
        KerjasamaStatus::create([
            'user_id'      => Auth::id(), // ID user yang membatalkan
            'kerjasama_id' => $kerjasama->id,
            'status'       => 'dibatalkan',
            'keterangan'   => $validated['keterangan'] ?? 'Dibatalkan oleh pemohon.',
        ]);

        return redirect()->back()->with('success', 'Kerjasama berhasil dibatalkan.');
    }
}
