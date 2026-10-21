<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kerjasama;
use App\Models\KerjasamaStatus;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class KerjasamaController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->get('status', 'pending');
        $search = $request->get('search');

        $query = Kerjasama::with('latestStatus');

        // Filter berdasarkan status terakhir di tabel kerjasama_status
        if ($statusFilter && $statusFilter !== 'semua') {
            if ($statusFilter === 'pending') {
                // Menampilkan yang status terakhirnya 'pending' ATAU belum memiliki status sama sekali
                $query->where(function ($q) {
                    $q->whereHas('latestStatus', fn($sub) => $sub->where('status', 'pending'))
                        ->orWhereDoesntHave('latestStatus');
                });
            } else {
                $query->whereHas('latestStatus', function ($q) use ($statusFilter) {
                    $q->where('status', $statusFilter);
                });
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('mitra', 'like', "%{$search}%");
            });
        }

        $kerjasamas = $query->latest()->paginate(10)->withQueryString();

        // Hitung jumlah data per status untuk badge tab
        $counts = [
            'pending' => Kerjasama::where(function ($q) {
                $q->whereHas('latestStatus', fn($sub) => $sub->where('status', 'pending'))
                    ->orWhereDoesntHave('latestStatus');
            })->count(),
            'aktif'   => Kerjasama::whereHas('latestStatus', fn($q) => $q->where('status', 'aktif'))->count(),
            'selesai'   => Kerjasama::whereHas('latestStatus', fn($q) => $q->where('status', 'selesai'))->count(),
            'ditolak' => Kerjasama::whereHas('latestStatus', fn($q) => $q->where('status', 'dibatalkan'))->count(),
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
        // Memuat relasi status terakhir dan user pembuat status
        $kerjasama->load(['latestStatus.user']);

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
            'status'     => 'required|in:aktif,dibatalkan',
            'keterangan' => 'required_if:status,dibatalkan|nullable|string|min:10|max:1000',
        ], [
            'status.in'                => 'Status yang dipilih tidak valid.',
            'keterangan.required_if'   => 'Keterangan pembatalan/penolakan wajib diisi.',
            'keterangan.min'           => 'Keterangan minimal 10 karakter.',
            'keterangan.max'           => 'Keterangan maksimal 1000 karakter.',
        ]);

        // Cek status terakhir dari tabel kerjasama_status
        $latestStatus = KerjasamaStatus::where('kerjasama_id', $kerjasama->id)->latest()->first();

        if ($latestStatus && $latestStatus->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses dan tidak dapat diubah lagi.');
        }

        if ($validated['status'] === 'aktif') {
            // Simpan status baru ke tabel kerjasama_status
            KerjasamaStatus::create([
                'user_id'      => Auth::id(),
                'kerjasama_id' => $kerjasama->id,
                'status'       => 'aktif',
                'keterangan'   => null,
            ]);

            $message = 'Pengajuan kerjasama berhasil diaktifkan.';

            // Kirim Notifikasi ke User pembuat pengajuan (jika user_id ada)
            Notification::create([
                'user_id'      => $kerjasama->user_id,
                'title'        => 'Kerjasama Disetujui',
                'message'      => 'Pengajuan kerjasama "' . $kerjasama->judul . '" telah disetujui dan berstatus aktif.',
                'type'         => 'kerjasama',
                'route'        => '/user-kerjasamas/' . $kerjasama->id,
                'route_params' => json_encode([$kerjasama->id]),
            ]);
        } else {
            // Simpan status dibatalkan/ditolak ke tabel kerjasama_status
            KerjasamaStatus::create([
                'user_id'      => Auth::id(),
                'kerjasama_id' => $kerjasama->id,
                'status'       => 'dibatalkan',
                'keterangan'   => $validated['keterangan'],
            ]);

            $message = 'Pengajuan kerjasama telah ditolak/dibatalkan.';

            // Kirim Notifikasi Penolakan ke User pembuat pengajuan
            Notification::create([
                'user_id'      => $kerjasama->user_id,
                'title'        => 'Kerjasama Ditolak',
                'message'      => 'Pengajuan kerjasama "' . $kerjasama->judul . '" ditolak. Keterangan: ' . $validated['keterangan'],
                'type'         => 'kerjasama',
                'route'        => '/user-kerjasamas/' . $kerjasama->id,
                'route_params' => json_encode([$kerjasama->id]),
            ]);
        }

        return redirect()
            ->route('admin.kerjasama.show', $kerjasama->id)
            ->with('success', $message);
    }
}
