<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelatihan;
use App\Models\Materi;
use App\Models\Nilai;
use App\Models\PelatihanAnggota;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Auth;

class UserMateriController extends Controller
{
    /**
     * Menetapkan middleware permission untuk setiap metode.
     */
    public static function middleware(): array
    {
        return [
            'permission:user-materi-view' => ['only' => ['index', 'show']],
            'permission:sertifikat-view' => ['only' => ['sertifikat', 'daftarSertifikat']],
        ];
    }

    public function index($pelatihanId)
    {
        // Ambil data pelatihan beserta relasi materinya
        $pelatihan = Pelatihan::with('materi')->findOrFail($pelatihanId);

        // Ambil data anggota pelatihan berdasarkan user yang sedang login
        $pelatihanAnggota = PelatihanAnggota::where('pelatihan_id', $pelatihanId)
            ->where('users_id', Auth::id())
            ->first();

        // Petakan nilai untuk setiap materi jika user sudah mengerjakannya
        $nilaiMateri = [];
        if ($pelatihanAnggota) {
            $dataNilai = Nilai::where('pelatihan_anggota_id', $pelatihanAnggota->id)->get();
            foreach ($dataNilai as $item) {
                $nilaiMateri[$item->materi_id] = $item;
            }
        }

        // ==========================================
        // LOGIKA PENGECEKAN KELULUSAN SEMUA MATERI
        // ==========================================
        $totalMateri = $pelatihan->materi->count();
        $jumlahLulus = 0;

        if ($pelatihanAnggota && $totalMateri > 0) {
            foreach ($pelatihan->materi as $materi) {
                $nilaiUser = $nilaiMateri[$materi->id] ?? null;
                // Ganti 'nilai_total_soal' dan batas standar '>= 75' sesuai dengan kolom dan standar kelulusan database Anda
                if ($nilaiUser && $nilaiUser->nilai_total_soal >= 75) {
                    $jumlahLulus++;
                }
            }
        }

        // Bernilai true jika total materi ada dan jumlah materi yang lulus sama dengan total materi
        $semuaMateriLulus = ($totalMateri > 0 && $jumlahLulus === $totalMateri);
        // ==========================================

        return view('user.materi.index', compact('pelatihan', 'nilaiMateri', 'semuaMateriLulus'));
    }

    public function show($pelatihanId, $materiId)
    {
        $pelatihan = Pelatihan::findOrFail($pelatihanId);

        $materi = Materi::where('pelatihan_id', $pelatihanId)
            ->where('id', $materiId)
            ->firstOrFail();

        // Ambil data anggota pelatihan berdasarkan user yang sedang login
        $pelatihanAnggota = PelatihanAnggota::where('pelatihan_id', $pelatihanId)
            ->where('users_id', Auth::id())
            ->first();

        // Ambil data nilai kuis jika anggota tersebut sudah pernah mengerjakan
        $nilai = null;
        if ($pelatihanAnggota) {
            $nilai = Nilai::where('pelatihan_anggota_id', $pelatihanAnggota->id)
                ->where('materi_id', $materiId)
                ->first();
        }

        return view('user.materi.show', compact('pelatihan', 'materi', 'nilai'));
    }

    public function sertifikat($pelatihanId)
    {
        // 1. Ambil data pelatihan
        $pelatihan = Pelatihan::with('materi')->findOrFail($pelatihanId);

        // 2. Ambil data anggota pelatihan user yang sedang login
        $pelatihanAnggota = PelatihanAnggota::where('pelatihan_id', $pelatihanId)
            ->where('users_id', Auth::id())
            ->first();

        // Jika user belum terdaftar di pelatihan ini, blokir akses
        if (! $pelatihanAnggota) {
            abort(403, 'Anda tidak terdaftar dalam pelatihan ini.');
        }

        // 3. Ambil data nilai user untuk setiap materi
        $dataNilai = Nilai::where('pelatihan_anggota_id', $pelatihanAnggota->id)->get();
        $nilaiMateri = [];
        foreach ($dataNilai as $item) {
            $nilaiMateri[$item->materi_id] = $item;
        }

        // 4. Validasi ulang kelulusan di sisi backend untuk keamanan (mencegah akses via URL langsung)
        $totalMateri = $pelatihan->materi->count();
        $jumlahLulus = 0;

        if ($totalMateri > 0) {
            foreach ($pelatihan->materi as $materi) {
                $nilaiUser = $nilaiMateri[$materi->id] ?? null;
                // Sesuaikan batas nilai lulus (misal >= 75) dengan aturan sistem Anda
                if ($nilaiUser && $nilaiUser->nilai_total_soal >= 75) {
                    $jumlahLulus++;
                }
            }
        }

        $semuaMateriLulus = ($totalMateri > 0 && $jumlahLulus === $totalMateri);

        // Jika belum lulus semua, tolak akses ke sertifikat
        if (! $semuaMateriLulus) {
            return redirect()->route('user.materi.index', $pelatihanId)
                ->with('error', 'Anda harus menyelesaikan dan lulus semua materi terlebih dahulu untuk mencetak sertifikat.');
        }

        // 5. Jika sudah lulus, tampilkan view sertifikat (atau generate PDF menggunakan DomPDF/Snappy)
        return view('user.sertifikat.sertifikat', compact('pelatihan', 'pelatihanAnggota'));
    }

    public function daftarSertifikat()
    {
        $userId = auth()->id();

        // Ambil sertifikat dengan relasi ke nilai -> pelatihanAnggota -> pelatihan,
        // serta filter khusus milik user yang sedang login jika ada kolom user_id/users_id di tabel sertifikat.
        $daftarSertifikat = Sertifikat::with(['nilai.pelatihanAnggota.pelatihan'])
            ->get();

        return view('user.sertifikat.index', compact('daftarSertifikat'));
    }
}
