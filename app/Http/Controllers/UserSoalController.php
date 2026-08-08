<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelatihan;
use App\Models\Materi;
use App\Models\Soal;
use App\Models\PelatihanAnggota;
use App\Models\Nilai;
use App\Models\NilaiSoal;
use App\Models\SoalJawaban;
use App\Models\Sertifikat;
use App\Models\SertifikatNilai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserSoalController extends Controller
{
    /**
     * Menampilkan halaman soal/kuis berdasarkan pelatihan dan materi.
     */
    public function index(Pelatihan $pelatihan, Materi $materi)
    {
        // Eager load relasi 'soal' dan juga relasi 'jawaban' di dalam setiap soal.
        $materi->load('soal.jawaban');

        // Lakukan pengacakan (shuffle) di sisi controller, bukan di view.
        // Ini memastikan konsistensi data yang dikirim ke view.
        $materi->soal = $materi->soal->shuffle();
        foreach ($materi->soal as $soal) {
            // Acak juga pilihan jawaban untuk setiap soal
            $soal->jawaban = $soal->jawaban->shuffle();
        }

        return view('user.soal.index', compact('pelatihan', 'materi'));
    }

    /**
     * Menyimpan hasil jawaban kuis yang dikirimkan oleh user.
     */
    public function store(Request $request, Pelatihan $pelatihan, Materi $materi)
    {
        DB::beginTransaction();

        // Cari data pendaftaran user di pelatihan ini
        $pelatihanAnggota = PelatihanAnggota::where('pelatihan_id', $pelatihan->id)
            ->where('users_id', Auth::id())
            ->first();

        if (!$pelatihanAnggota) {
            return redirect()->route('user-materi.show', [$pelatihan->id, $materi->id])
                ->with('error', 'Anda tidak terdaftar pada pelatihan ini.');
        }

        // Eager load soal beserta jawaban yang benar
        $materi->load('soal.jawaban');
        $jawabanUser = $request->input('jawaban', []); // Array [soal_id => jawaban_id]

        $jumlahSoal = $materi->soal->count();
        if ($jumlahSoal === 0) {
            return redirect()->route('user-materi.show', [$pelatihan->id, $materi->id])
                ->with('warning', 'Tidak ada soal untuk dinilai.');
        }

        // 1. Hitung nilai per soal
        $nilaiPerSoal = $jumlahSoal > 0 ? 100 / $jumlahSoal : 0;
        $jawabanBenar = 0;
        $detailNilaiSoal = [];

        foreach ($materi->soal as $soal) {
            $jawabanIdPilihanUser = $jawabanUser[$soal->id] ?? null;
            $jawabanYangBenar = $soal->jawaban->firstWhere('status', 1);

            $isBenar = ($jawabanYangBenar && $jawabanYangBenar->id == $jawabanIdPilihanUser);

            if ($isBenar) {
                $jawabanBenar++;
            }

            $detailNilaiSoal[] = [
                'soal_id' => $soal->id,
                'jawaban_id' => $jawabanIdPilihanUser,
                'nilai' => $isBenar ? $nilaiPerSoal : 0,
            ];
        }

        // 2. Hitung skor total kuis (skala 0 - 100)
        $nilaiTotalSoal = $jawabanBenar * $nilaiPerSoal;

        // Hitung nilai akhir berbobot berdasarkan jumlah modul/materi dalam pelatihan
        $jumlahMateriDiPelatihan = $pelatihan->materi()->count();
        $bobotPerMateri = $jumlahMateriDiPelatihan > 0 ? (100 / $jumlahMateriDiPelatihan) : 0;
        $nilaiAkhir = ($nilaiTotalSoal / 100) * $bobotPerMateri;

        // 3. Simpan rekapitulasi nilai ke tabel `nilai`
        $nilai = Nilai::updateOrCreate(
            [
                'pelatihan_anggota_id' => $pelatihanAnggota->id,
                'materi_id' => $materi->id,
            ],
            [
                'nilai_total_soal' => $nilaiTotalSoal,
                'nilai' => $nilaiAkhir,
                'status' => $nilaiTotalSoal >= 75 ? 'lulus' : 'tidak_lulus',
                'keterangan' => 'Kuis dikerjakan pada ' . now()->format('d-m-Y H:i'),
            ]
        );

        // 4. Hapus detail lama & simpan detail jawaban baru
        $nilai->nilaiSoal()->delete();
        $nilai->nilaiSoal()->createMany($detailNilaiSoal);

        // 5. Cek dan buat sertifikat otomatis jika seluruh materi sudah lulus
        $this->checkAndGenerateSertifikat($pelatihanAnggota, $pelatihan);

        DB::commit();

        return redirect()->route('user-materi.show', [$pelatihan->id, $materi->id])
            ->with('success', "Kuis berhasil dikumpulkan! Skor Anda: " . number_format($nilaiTotalSoal, 2));
    }



    /**
     * Menampilkan halaman soal/kuis untuk remidi.
     */
    public function remedi(Pelatihan $pelatihan, Materi $materi)
    {
        // 1. Cari data pendaftaran user di pelatihan ini
        $pelatihanAnggota = PelatihanAnggota::where('pelatihan_id', $pelatihan->id)
            ->where('users_id', Auth::id())
            ->first();

        if (!$pelatihanAnggota) {
            return redirect()->route('user-materi.show', [$pelatihan->id, $materi->id])->with('error', 'Anda tidak terdaftar pada pelatihan ini.');
        }

        // 2. Cari nilai terakhir user untuk materi ini
        $nilai = Nilai::where('pelatihan_anggota_id', $pelatihanAnggota->id)
            ->where('materi_id', $materi->id)
            ->first();

        // 3. Validasi kondisi untuk remidi
        // Jika tidak ada nilai, arahkan ke kuis reguler
        if (!$nilai) {
            return redirect()->route('user-soal.index', [$pelatihan->id, $materi->id]);
        }

        // Jika sudah lulus, tidak perlu remidi
        if ($nilai->nilai_total_soal >= 75) {
            return redirect()->route('user-materi.show', [$pelatihan->id, $materi->id])->with('info', 'Anda sudah lulus untuk materi ini dan tidak memerlukan remidi.');
        }

        // Cek apakah sudah lewat 1 menit
        $waktuTunggu = now()->subMinutes(1);
        if ($nilai->updated_at > $waktuTunggu) {
            $waktuTersedia = $nilai->updated_at->addMinutes(1)->diffForHumans();
            return redirect()->route('user-materi.show', [$pelatihan->id, $materi->id])->with('error', "Anda baru bisa mengambil remidi lagi {$waktuTersedia}.");
        }

        // 4. Eager load soal dan jawaban (diacak jika diperlukan, sama seperti logic di index)
        $materi->load(['soal' => function ($query) {
            $query->inRandomOrder()->with(['jawaban' => function ($q) {
                $q->inRandomOrder();
            }]);
        }]);

        // 5. Arahkan langsung ke view khusus remedi: resources/views/user/soal/remedi.blade.php
        return view('user.soal.remedi', compact('pelatihan', 'materi', 'nilai'));
    }

    /**
     * Menyimpan hasil jawaban kuis remedi yang dikirimkan oleh user.
     */
    public function storeRemedi(Request $request, $pelatihanId, $materiId)
    {
        DB::beginTransaction();
        try {
            $user = auth()->user();

            $pelatihanAnggota = PelatihanAnggota::where('pelatihan_id', $pelatihanId)
                ->where('users_id', $user->id)
                ->first();

            if (!$pelatihanAnggota) {
                return redirect()->route('user-materi.show', [$pelatihanId, $materiId])
                    ->with('error', 'Anda tidak terdaftar pada pelatihan ini.');
            }

            $nilaiLama = Nilai::where('pelatihan_anggota_id', $pelatihanAnggota->id)
                ->where('materi_id', $materiId)
                ->first();

            $skorLama = $nilaiLama ? ($nilaiLama->nilai_total_soal ?? 0) : 0;

            $soals = Soal::where('materi_id', $materiId)->get();
            $benar = 0;
            $totalSoal = $soals->count();

            // Array untuk menampung detail jawaban per soal
            $detailJawabanData = [];

            foreach ($soals as $soal) {
                $jawabanUser = $request->input("jawaban.{$soal->id}");

                $kunciJawaban = SoalJawaban::select('soal_jawaban.*')
                    ->join('jawaban', 'jawaban.id', '=', 'soal_jawaban.jawaban_id')
                    ->where('soal_jawaban.soal_id', $soal->id)
                    ->where('jawaban.status', 1)
                    ->first();

                $isBenar = ($jawabanUser && $kunciJawaban && $jawabanUser == $kunciJawaban->jawaban_id);
                if ($isBenar) {
                    $benar++;
                }

                // Simpan skor per soal (misal: benar 25 / salah 0)
                $detailJawabanData[$soal->id] = [
                    'jawaban_id' => $jawabanUser,
                    'nilai' => $isBenar ? 25 : 0, // Sesuaikan bobot nilai per soal jika ada aturan lain
                ];
            }

            $skorBaru = $totalSoal > 0 ? ($benar / $totalSoal) * 100 : 0;

            $pelatihan = Pelatihan::with('materi')->findOrFail($pelatihanId);

            // Pengecekan jika skor baru lebih kecil dari skor lama
            if ($skorBaru < $skorLama) {
                DB::commit();

                session(['cooldown_remedi_' . $materiId => now()->addMinutes(1)]);

                return view('user.quiz.gagal-remedi', [
                    'skorLama' => $skorLama,
                    'skorBaru' => $skorBaru,
                    'materi' => Materi::findOrFail($materiId),
                    'pelatihan' => $pelatihan,
                ]);
            }

            $jumlahMateriDiPelatihan = $pelatihan->materi->count();
            $bobotPerMateri = $jumlahMateriDiPelatihan > 0 ? (100 / $jumlahMateriDiPelatihan) : 0;
            $nilaiAkhirBaru = ($skorBaru / 100) * $bobotPerMateri;

            // 1. Simpan / Perbarui tabel utama 'nilai'
            $nilaiRecord = Nilai::updateOrCreate(
                [
                    'pelatihan_anggota_id' => $pelatihanAnggota->id,
                    'materi_id' => $materiId
                ],
                [
                    'nilai_total_soal' => $skorBaru,
                    'nilai' => $nilaiAkhirBaru,
                    'status' => $skorBaru >= 75 ? 'lulus' : 'tidak_lulus',
                    'keterangan' => 'Remidi'
                ]
            );

            // 2. Simpan / Perbarui detail ke tabel 'nilai_soal'
            foreach ($detailJawabanData as $soalId => $dataDetail) {
                // Asumsi model untuk tabel 'nilai_soal' adalah NilaiSoal
                \App\Models\NilaiSoal::updateOrCreate(
                    [
                        'nilai_id' => $nilaiRecord->id,
                        'soal_id' => $soalId,
                    ],
                    [
                        'jawaban_id' => $dataDetail['jawaban_id'],
                        'nilai' => $dataDetail['nilai'],
                    ]
                );
            }

            if (method_exists($this, 'checkAndGenerateSertifikat')) {
                $this->checkAndGenerateSertifikat($pelatihanAnggota, $pelatihan);
            }

            DB::commit();

            return redirect()->route('user-materi.show', [$pelatihanId, $materiId])
                ->with('success', 'Selamat! Nilai remedi Anda berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('user-materi.show', [$pelatihanId, $materiId])
                ->with('error', 'Terjadi kesalahan saat menyimpan remedi: ' . $e->getMessage());
        }
    }
    /**
     * Helper privat untuk mengecek kelulusan dan mengenerate sertifikat secara otomatis.
     */
    private function checkAndGenerateSertifikat($pelatihanAnggota, $pelatihan)
    {
        $materiIds = $pelatihan->materi->pluck('id');
        $totalMateri = $materiIds->count();

        if ($totalMateri === 0) return;

        // Ambil nilai user yang statusnya lulus untuk pelatihan ini
        $nilaiLulusCollection = Nilai::where('pelatihan_anggota_id', $pelatihanAnggota->id)
            ->whereIn('materi_id', $materiIds)
            ->where('status', 'lulus')
            ->get();

        // Jika jumlah materi yang lulus sama dengan total materi keseluruhan
        if ($nilaiLulusCollection->count() === $totalMateri) {
            // Cek apakah sudah ada sertifikat yang terhubung ke salah satu nilai materi ini
            $sudahPunyaSertifikat = SertifikatNilai::whereIn('nilai_id', $nilaiLulusCollection->pluck('id'))->exists();

            if (!$sudahPunyaSertifikat) {
                $noSertifikat = 'CERT-' . strtoupper(uniqid()) . '-' . date('Y');

                $sertifikat = Sertifikat::create([
                    'no_sertifikat' => $noSertifikat,
                ]);

                // Kaitkan ke tabel pivot sertifikat_nilai
                $sertifikat->nilai()->attach($nilaiLulusCollection->pluck('id'));
            }
        }
    }
}
