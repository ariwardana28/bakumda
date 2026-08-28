<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use App\Models\PelatihanJenis;
use App\Models\PelatihanPembayaran;
use App\Models\PelatihanAnggota;
use App\Models\PelatihanAnggotaStatus;
use App\Models\Sertifikat;
use App\Models\Notification;
use App\Models\Nilai;
use App\Models\Materi;
use App\Models\ReferralTransaction; // Tambahkan ini
use App\Models\ReferralCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserPelatihanController extends Controller
{
    /**
     * Menetapkan middleware permission untuk setiap metode.
     */
    public static function middleware(): array
    {
        return [
            'permission:user-pelatihan-view'   => ['only' => ['index']],
            'permission:user-pelatihan-create' => ['only' => ['create', 'store']],
            'permission:user-pelatihan-show'   => ['only' => ['show', 'status']],
            // Izin untuk melihat halaman pembayaran dan memprosesnya
            'permission:user-pelatihan-payment' => ['only' => ['payment', 'processPayment']],
        ];
    }

    /**
     * Menampilkan daftar semua pelatihan (dengan fitur pencarian opsional).
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jenisId = $request->input('pelatihan_jenis_id');
        $userId = Auth::id();

        // 1. Ambil data jenis pelatihan beserta relasi pelatihannya
        $jenisPelatihans = PelatihanJenis::with(['pelatihans' => function ($query) use ($userId, $search) {
            $query->with(['userPendaftaran' => function ($q) use ($userId) {
                $q->where('users_id', $userId)->with('latestStatus');
            }]);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            }

            $query->latest();
        }])
            ->when($jenisId, function ($query) use ($jenisId) {
                $query->where('id', $jenisId);
            })
            ->get();

        // 2. Query cadangan (jika $pelatihans dibutuhkan di view)
        $pelatihans = Pelatihan::with(['userPendaftaran' => function ($query) use ($userId) {
            $query->where('users_id', $userId)->with('latestStatus');
        }])->when($search, function ($query, $search) {
            return $query->where('judul', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        })
            ->when($jenisId, function ($query, $jenisId) {
                return $query->where('pelatihan_jenis_id', $jenisId);
            })
            ->latest()
            ->get();

        return view('user.pelatihan.index', compact('pelatihans', 'jenisPelatihans'));
    }

    public function create(Pelatihan $pelatihan)
    {
        return view('user.pelatihan.create', compact('pelatihan'));
    }

    public function store(Request $request, Pelatihan $pelatihan)
    {
        // Validasi referral_code (opsional), sekaligus tolak jika kode adalah milik user yang sedang login
        $request->validate([
            'referral_code' => [
                'nullable',
                'string',
                'exists:referral_codes,code',
                function ($attribute, $value, $fail) {
                    $referralCode = \App\Models\ReferralCode::where('code', $value)->first();

                    if ($referralCode && $referralCode->user_id === Auth::id()) {
                        $fail('Anda memasukkan kode referral akun Anda sendiri. Hal ini tidak diperbolehkan.');
                    }
                },
            ],
        ]);

        DB::beginTransaction();
        try {
            // Cek kuota
            $jumlahPendaftar = PelatihanAnggota::where('pelatihan_id', $pelatihan->id)->count();
            if ($pelatihan->kuota > 0 && $jumlahPendaftar >= $pelatihan->kuota) {
                return redirect()->route('user-pelatihan.show', $pelatihan->id)->with('error', 'Mohon maaf, kuota untuk pelatihan ini sudah penuh.');
            }

            // Cek apakah user sudah terdaftar
            $isAlreadyRegistered = PelatihanAnggota::where('pelatihan_id', $pelatihan->id)
                ->where('users_id', Auth::id())
                ->exists();

            if ($isAlreadyRegistered) {
                return redirect()->route('user-pelatihan.show', $pelatihan->id)->with('info', 'Anda sudah terdaftar pada pelatihan ini.');
            }

            // Buat pendaftaran baru hanya dengan pelatihan_id dan user_id
            $pendaftar = PelatihanAnggota::create([
                'pelatihan_id' => $pelatihan->id,
                'users_id' => Auth::id(),
            ]);

            // Proses kode referral jika ada dan valid
            if ($request->filled('referral_code')) {
                // Cari kode referral yang digunakan
                $referralCode = ReferralCode::where('code', $request->referral_code)->first();

                // Validasi kepemilikan sudah dijamin lolos oleh rule di atas,
                // pengecekan ini tetap dipertahankan sebagai lapisan keamanan tambahan (defense in depth)
                if ($referralCode && $referralCode->user_id !== Auth::id()) {
                    ReferralTransaction::create([
                        'referral_code_id' => $referralCode->id,
                        'referrer_id'      => $referralCode->user_id, // Pemilik kode referral
                        'referred_id'      => Auth::id(),             // User yang mendaftar menggunakan kode
                        'pelatihan_id'     => $pelatihan->id,
                        'reward_amount'    => 50000,                  // Reward awal, dihitung/diperbarui nanti
                        'status'           => 'pending',              // Status awal pending
                    ]);
                }
            }

            PelatihanAnggotaStatus::create([
                'pelatihan_anggota_id' => $pendaftar->id,
                'status' => 'Menunggu Pembayaran',
            ]);

            // Buat notifikasi untuk user
            Notification::create([
                'user_id' => Auth::id(),
                'title'   => 'Pendaftaran Berhasil',
                'message' => 'Silakan lakukan pembayaran untuk pelatihan ' . $pelatihan->judul,
                'type'    => 'success',
                'route'   => route('user-pelatihan.payment', $pendaftar->id, false),
            ]);

            DB::commit();
            return redirect()->route('user-pelatihan.payment', $pendaftar->id)
                ->with('success', 'Pendaftaran berhasil! Silakan lanjutkan ke proses pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal memproses pendaftaran: ' . $e->getMessage());
        }
    }


    /**
     * Menampilkan halaman detail pelatihan berdasarkan ID atau slug.
     */
    public function show(Pelatihan $pelatihan)
    {
        // Eager load relasi materi dan pendaftaran user yang login
        $pelatihan->load(['materi', 'userPendaftaran' => function ($query) {
            $query->where('users_id', Auth::id())->with('latestStatus');
        }]);

        // AMBIL DATA INI: Ambil pelatihan lain (selain pelatihan yang sedang dibuka), misal 4 buah
        $pelatihanLainnya = Pelatihan::where('id', '!=', $pelatihan->id)->take(4)->get();

        // Kirim $pelatihanLainnya ke view menggunakan compact
        return view('user.pelatihan.show', compact('pelatihan', 'pelatihanLainnya'));
    }


    /**
     * Menampilkan halaman pembayaran (payment).
     */
    public function payment($id)
    {
        // Cari data pendaftaran berdasarkan ID, dan eager load relasi pelatihan
        $pendaftaran = PelatihanAnggota::with('pelatihan')->findOrFail($id);

        // Otorisasi: Pastikan user yang login adalah pemilik pendaftaran
        if (Auth::id() !== $pendaftaran->users_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Ambil data pelatihan dari relasi
        $pelatihan = $pendaftaran->pelatihan;

        // Cek jika pendaftaran tidak ditemukan atau tidak ada relasi pelatihan
        if (!$pelatihan) {
            return redirect()->route('user-pelatihan.index')->with('error', 'Data pelatihan tidak ditemukan.');
        }

        // Mengarahkan ke view pembayaran dengan data yang diperlukan
        return view('user.pelatihan.payment', compact('pelatihan', 'pendaftaran'));
    }

    /**
     * Memproses unggahan bukti pembayaran.
     */
    public function processPayment(Request $request, $id)
    {
        // Ambil data pendaftaran secara manual berdasarkan ID
        $pendaftaran = PelatihanAnggota::findOrFail($id);

        // Otorisasi: Pastikan user yang login adalah pemilik pendaftaran
        if (Auth::id() !== $pendaftaran->users_id) {
            abort(403, 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $validated = $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'catatan'          => 'nullable|string|max:1000',
        ]);

        // 1. Simpan file bukti pembayaran ke storage public/pelatihan/pembayaran
        $path = $request->file('bukti_pembayaran')->store('pelatihan/pembayaran', 'public');

        // 2. Simpan ke tabel pelatihan_pembayaran
        PelatihanPembayaran::updateOrCreate(
            [
                'pelatihan_id'         => $pendaftaran->pelatihan_id,
                'user_id'              => Auth::id(),
                'pelatihan_anggota_id' => $pendaftaran->id,
            ],
            [
                'jumlah_pembayaran'  => $pendaftaran->pelatihan->harga,
                'status_pembayaran'  => 'pending',
                'tanggal_pembayaran' => now(),
                'bukti_pembayaran'   => $path,
                'catatan'            => $validated['catatan'] ?? null,
            ]
        );

        // 3. Buat status baru untuk pendaftaran anggota
        PelatihanAnggotaStatus::create([
            'pelatihan_anggota_id' => $pendaftaran->id,
            'status'               => 'Pembayaran Diproses',
            'keterangan'           => 'Bukti pembayaran telah diunggah dan sedang menunggu verifikasi oleh admin.',
        ]);

        // 4. Buat Notifikasi untuk User
        Notification::create([
            'user_id' => Auth::id(),
            'title'   => 'Bukti Pembayaran Diunggah',
            'message' => 'Bukti pembayaran untuk pelatihan "' . $pendaftaran->pelatihan->judul . '" berhasil dikirim dan sedang menunggu verifikasi admin.',
            'type'    => 'info',
            'route'   => route('user-pelatihan.status', $pendaftaran->id, false),
        ]);

        
        return redirect()->route('user-pelatihan.status', $pendaftaran->id)
            ->with('success', 'Konfirmasi pembayaran berhasil dikirim. Pendaftaran Anda akan segera diverifikasi.');
    }

    /**
     * Menampilkan halaman status pendaftaran.
     *
     * @param int $id ID dari PelatihanAnggota
     * @return \Illuminate\View\View
     */
    public function status($id)
    {
        // Cari data pendaftaran berdasarkan ID, dan eager load relasi status terakhir
        $pendaftaran = PelatihanAnggota::with('latestStatus', 'pelatihan')->findOrFail($id);

        // Otorisasi: Pastikan user yang login adalah pemilik pendaftaran
        if (Auth::id() !== $pendaftaran->users_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        // Ambil status terakhir
        $statusTerakhir = $pendaftaran->latestStatus->status ?? '';

        // Cek jika status sudah disetujui / aktif / pembayaran diverifikasi
        // Sesuaikan string 'Aktif' atau status sukses Anda di database
        if (in_array($statusTerakhir, ['Aktif', 'Disetujui', 'Selesai', 'Pembayaran Disetujui'])) {
            return redirect()->route('user-materi.index', $pendaftaran->pelatihan_id);
        }

        // Jika belum diverifikasi, arahkan ke view status seperti biasa
        return view('user.pelatihan.status', compact('pendaftaran'));
    }

    public function cetakSertifikat($pelatihanId)
    {
        // Pastikan user terdaftar di pelatihan ini dan ambil data pendaftarannya
        $pelatihanAnggota = PelatihanAnggota::where('pelatihan_id', $pelatihanId)
            ->where('users_id', \Illuminate\Support\Facades\Auth::id())
            ->firstOrFail();

        // Ambil data pelatihan
        $pelatihan = Pelatihan::with('materi')->findOrFail($pelatihanId);

        // Ambil ID semua materi pada pelatihan ini
        $materiIds = $pelatihan->materi->pluck('id');

        // Ambil ID nilai user yang statusnya 'lulus' pada pelatihan ini
        $nilaiLulusIds = Nilai::where('pelatihan_anggota_id', $pelatihanAnggota->id)
            ->whereIn('materi_id', $materiIds)
            ->where('status', 'lulus')
            ->pluck('id');

        // Cari sertifikat yang terhubung ke nilai-nilai lulus tersebut melalui tabel pivot sertifikat_nilai
        $sertifikat = Sertifikat::whereHas('nilai', function ($query) use ($nilaiLulusIds) {
            $query->whereIn('nilai.id', $nilaiLulusIds);
        })->first();

        // Jika sertifikat belum ada / belum lulus semua
        if (!$sertifikat) {
            return redirect()->back()->with('error', 'Sertifikat belum tersedia. Pastikan Anda telah menyelesaikan dan lulus semua kuis pada pelatihan ini.');
        }

        // Ambil nama lengkap user yang sedang login
        $namaPeserta = \Illuminate\Support\Facades\Auth::user()->name;

        return view('user.sertifikat.sertifikat', compact('sertifikat', 'pelatihan', 'namaPeserta'));
    }

    public function downloadSertifikat($pelatihanId)
    {
        $pelatihanAnggota = PelatihanAnggota::where('pelatihan_id', $pelatihanId)
            ->where('users_id', Auth::id())
            ->firstOrFail();

        $pelatihan = Pelatihan::with('materi')->findOrFail($pelatihanId);

        $materiIds = $pelatihan->materi->pluck('id');

        $nilaiLulusIds = Nilai::where('pelatihan_anggota_id', $pelatihanAnggota->id)
            ->whereIn('materi_id', $materiIds)
            ->where('status', 'lulus')
            ->pluck('id');

        $sertifikat = Sertifikat::whereHas('nilai', function ($query) use ($nilaiLulusIds) {
            $query->whereIn('nilai.id', $nilaiLulusIds);
        })->firstOrFail();

        $namaPeserta = Auth::user()->name;

        $pelatihanAnggotaId = optional($sertifikat->nilai->first())->pelatihan_anggota_id;
        $daftarNilai = $pelatihanAnggotaId
            ? Nilai::where('pelatihan_anggota_id', $pelatihanAnggotaId)->get()
            : $sertifikat->nilai ?? collect();
        $totalNilaiAkumulatif = $daftarNilai->sum('nilai');
        $predikat = '';
        if ($totalNilaiAkumulatif >= 85) {
            $predikat = 'Sangat Baik';
        } elseif ($totalNilaiAkumulatif >= 70) {
            $predikat = 'Baik';
        } elseif ($totalNilaiAkumulatif >= 55) {
            $predikat = 'Cukup Baik';
        } elseif ($totalNilaiAkumulatif >= 40) {
            $predikat = 'Kurang Baik';
        } else {
            $predikat = 'Buruk';
        }

        return view('user.sertifikat.download', compact('sertifikat', 'pelatihan', 'namaPeserta', 'daftarNilai', 'predikat', 'totalNilaiAkumulatif'));
    }

    public function downloadSertifikatPdf($pelatihanId)
    {
        $pelatihanAnggota = PelatihanAnggota::where('pelatihan_id', $pelatihanId)
            ->where('users_id', Auth::id())
            ->firstOrFail();

        $pelatihan = Pelatihan::with('materi')->findOrFail($pelatihanId);

        $materiIds = $pelatihan->materi->pluck('id');

        $nilaiLulusIds = Nilai::where('pelatihan_anggota_id', $pelatihanAnggota->id)
            ->whereIn('materi_id', $materiIds)
            ->where('status', 'lulus')
            ->pluck('id');

        $sertifikat = Sertifikat::whereHas('nilai', function ($query) use ($nilaiLulusIds) {
            $query->whereIn('nilai.id', $nilaiLulusIds);
        })->firstOrFail();

        $namaPeserta = Auth::user()->name;

        $pelatihanAnggotaId = optional($sertifikat->nilai->first())->pelatihan_anggota_id;
        $daftarNilai = $pelatihanAnggotaId
            ? Nilai::where('pelatihan_anggota_id', $pelatihanAnggotaId)->get()
            : $sertifikat->nilai ?? collect();
        $totalNilaiAkumulatif = $daftarNilai->sum('nilai');
        $predikat = '';
        if ($totalNilaiAkumulatif >= 85) {
            $predikat = 'Sangat Baik';
        } elseif ($totalNilaiAkumulatif >= 70) {
            $predikat = 'Baik';
        } elseif ($totalNilaiAkumulatif >= 55) {
            $predikat = 'Cukup Baik';
        } elseif ($totalNilaiAkumulatif >= 40) {
            $predikat = 'Kurang Baik';
        } else {
            $predikat = 'Buruk';
        }

        $pdf = Pdf::loadView('user.sertifikat.download-pdf', compact('sertifikat', 'pelatihan', 'namaPeserta', 'daftarNilai', 'predikat', 'totalNilaiAkumulatif'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('sertifikat-' . Str::slug($pelatihan->judul ?? 'pelatihan') . '.pdf');
    }
}
