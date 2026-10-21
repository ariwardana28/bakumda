<?php

namespace App\Http\Controllers;

use App\Models\Kerjasama;
use App\Models\KerjasamaStatus;
use App\Models\KerjasamaDokumen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class UserKerjasamaController extends Controller
{
    /**
     * Menampilkan daftar kerja sama (Index).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kerjasamas = Kerjasama::where('user_id', auth()->id())
            ->with(['latestStatus', 'dokumens']) // Muat relasi latestStatus dan dokumens
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('mitra', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
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
            'biaya_pelatihan'   => 'required|numeric|min:0',
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
            'biaya_pelatihan'   => $validated['biaya_pelatihan'],
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

    /**
     * Menampilkan (atau mengunduh) dokumen kerja sama milik user yang login.
     *
     * Tampil di browser : /user-kerjasamas/{id}/dokumen
     * Unduh             : /user-kerjasamas/{id}/dokumen?download=1
     */
    public function dokumen(Request $request, $id)
    {
        // Hanya pemilik yang boleh mengakses dokumennya
        $kerjasama = Kerjasama::where('user_id', auth()->id())->findOrFail($id);

        $disk = Storage::disk('public');

        if (!$kerjasama->file_dokumen || !$disk->exists($kerjasama->file_dokumen)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        // Nama file yang rapi untuk ditampilkan / diunduh
        $ext  = pathinfo($kerjasama->file_dokumen, PATHINFO_EXTENSION);
        $nama = \Illuminate\Support\Str::slug($kerjasama->judul) . '.' . $ext;

        if ($request->boolean('download')) {
            return $disk->download($kerjasama->file_dokumen, $nama);
        }

        // inline: PDF tampil langsung di browser (cocok untuk iframe pratinjau)
        return response()->file($disk->path($kerjasama->file_dokumen), [
            'Content-Disposition' => 'inline; filename="' . $nama . '"',
        ]);
    }

    public function pks($id)
    {
        // Hanya pemilik yang boleh melihat dokumennya
        $kerjasama = Kerjasama::where('user_id', auth()->id())->findOrFail($id);

        // Data pihak kedua (pemohon)
        $pemohon = User::find($kerjasama->user_id);

        // Status terkini dari tabel kerjasama_status
        $status = strtolower(
            optional(KerjasamaStatus::where('kerjasama_id', $kerjasama->id)->latest()->first())->status ?? 'pending'
        );

        $romawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        // Tanggal surat = tanggal pengajuan dibuat
        $tglSurat = Carbon::parse($kerjasama->created_at)->locale('id');
        $mulai    = Carbon::parse($kerjasama->tanggal_mulai)->locale('id');
        $selesai  = Carbon::parse($kerjasama->tanggal_selesai)->locale('id');

        // Porsi bagi hasil (ubah di sini jika ketentuan berubah)
        $persenPertama = 30;
        $persenKedua   = 70;

        $biaya = (int) $kerjasama->biaya_pelatihan;

        $pks = [
            'nomor'               => sprintf('%03d/PKS-SEM/BAKUMDA/%s/%s', $kerjasama->id, $romawi[$tglSurat->month], $tglSurat->year),
            'hari'                => $tglSurat->translatedFormat('l'),
            'tanggal_terbilang'   => Str::title($this->terbilang($tglSurat->day)),
            'bulan'               => $tglSurat->translatedFormat('F'),
            'tahun_terbilang'     => Str::title($this->terbilang($tglSurat->year)),
            'tanggal_angka'       => $tglSurat->format('d-m-Y'),
            'tanggal_surat'       => $tglSurat->translatedFormat('d F Y'),
            'mulai'               => $mulai->translatedFormat('d F Y'),
            'selesai'             => $selesai->translatedFormat('d F Y'),
            'biaya'               => number_format($biaya, 0, ',', '.'),
            'biaya_terbilang'     => Str::title($this->terbilang($biaya)) . ' Rupiah',
            'persen_pertama'      => $persenPertama,
            'persen_pertama_terbilang' => $this->terbilang($persenPertama),
            'persen_kedua'        => $persenKedua,
            'persen_kedua_terbilang'   => $this->terbilang($persenKedua),
        ];

        return view('user.kerjasama.pks', compact('kerjasama', 'pemohon', 'pks', 'status'));
    }

    /**
     * Mengubah angka menjadi tulisan bahasa Indonesia.
     * Contoh: 2026 => "dua ribu dua puluh enam"
     */
    private function terbilang(int $angka): string
    {
        if ($angka === 0) {
            return 'nol';
        }

        $huruf = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

        if ($angka < 12) {
            return $huruf[$angka];
        }
        if ($angka < 20) {
            return $this->terbilang($angka - 10) . ' belas';
        }
        if ($angka < 100) {
            $sisa = $angka % 10;
            return $this->terbilang(intdiv($angka, 10)) . ' puluh' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        }
        if ($angka < 200) {
            $sisa = $angka - 100;
            return 'seratus' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        }
        if ($angka < 1000) {
            $sisa = $angka % 100;
            return $this->terbilang(intdiv($angka, 100)) . ' ratus' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        }
        if ($angka < 2000) {
            $sisa = $angka - 1000;
            return 'seribu' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        }
        if ($angka < 1000000) {
            $sisa = $angka % 1000;
            return $this->terbilang(intdiv($angka, 1000)) . ' ribu' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        }
        if ($angka < 1000000000) {
            $sisa = $angka % 1000000;
            return $this->terbilang(intdiv($angka, 1000000)) . ' juta' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
        }

        $sisa = $angka % 1000000000;
        return $this->terbilang(intdiv($angka, 1000000000)) . ' miliar' . ($sisa ? ' ' . $this->terbilang($sisa) : '');
    }

    /**
     * Mengunggah file PKS yang sudah ditandatangani dan dibubuhi meterai.
     */
    public function uploadPks(Request $request, $id)
    {
        $kerjasama = Kerjasama::where('user_id', auth()->id())->findOrFail($id);

        $pksBag = 'pks_' . Str::slug($kerjasama->judul);

        // Gunakan validateWithBag agar error masuk ke error bag spesifik modal (pks_{id})
        $validated = $request->validateWithBag($pksBag, [
            'file_pks' => 'required|file|mimes:pdf|max:5120',
        ], [
            'file_pks.required' => 'Silakan pilih file PKS terlebih dahulu.',
            'file_pks.mimes'    => 'Format file PKS harus berupa PDF.',
            'file_pks.max'      => 'Ukuran file PKS maksimal adalah 5 MB.',
        ]);

        // Simpan file PKS baru ke storage
        $filePath = $request->file('file_pks')->store('dokumen-pks', 'public');

        // Simpan catatan dokumen ke tabel kerjasama_dokumen
        KerjasamaDokumen::create([
            'kerjasama_id' => $kerjasama->id,
            'dokumen'      => $filePath,
        ]);

        // Tambahkan status baru menjadi 'selesai' (atau status lain yang diinginkan)
        KerjasamaStatus::create([
            'kerjasama_id' => $kerjasama->id,
            'status'       => 'selesai', // Ubah ke 'aktif' jika alurnya mengaktifkan kerjasama setelah PKS diunggah
            'keterangan'   => 'Dokumen PKS telah diunggah oleh pengguna.',
            'user_id'      => auth()->id(), // Sesuaikan dengan kolom user_id pada tabel status jika ada
        ]);

        return redirect()->back()
            ->with('success', 'Dokumen PKS bertanda tangan berhasil diunggah dan status kerjasama diperbarui.');
    }

    /**
     * Menampilkan atau mengunduh file PKS yang sudah diunggah.
     */
    public function filePks(Request $request, $id)
    {
        $kerjasama = Kerjasama::where('user_id', auth()->id())->findOrFail($id);

        $disk = Storage::disk('public');

        if (!$kerjasama->file_pks || !$disk->exists($kerjasama->file_pks)) {
            abort(404, 'File PKS belum diunggah atau tidak ditemukan.');
        }

        $nama = 'PKS-' . Str::slug($kerjasama->judul) . '.pdf';

        if ($request->boolean('download')) {
            return $disk->download($kerjasama->file_pks, $nama);
        }

        return response()->file($disk->path($kerjasama->file_pks), [
            'Content-Disposition' => 'inline; filename="' . $nama . '"',
        ]);
    }
}
