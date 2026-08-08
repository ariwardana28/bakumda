<?php

namespace App\Http\Controllers;

use App\Models\Pelatihan;
use App\Models\PelatihanPembayaran;
use App\Models\PelatihanAnggota;
use App\Models\PelatihanAnggotaStatus;
use App\Models\Sertifikat;
use App\Models\Notification;
use App\Models\Nilai;
use App\Models\Materi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        // Ambil kata kunci pencarian jika ada
        $search = $request->input('search');

        // Ambil ID user yang sedang login
        $userId = Auth::id();

        // Query data pelatihan dengan filter pencarian dan diurutkan dari terbaru
        $pelatihans = Pelatihan::with(['userPendaftaran' => function ($query) use ($userId) {
            // Eager load pendaftaran milik user yang login, beserta status terakhirnya
            $query->where('users_id', $userId)->with('latestStatus');
        }])->when($search, function ($query, $search) {
            // Mencari di kolom judul DAN deskripsi
            return $query->where('judul', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        })
            ->latest()
            ->get();

        // Mengarahkan ke view daftar pelatihan (misal: resources/views/pelatihan/index.blade.php)
        return view('user.pelatihan.index', compact('pelatihans'));
    }

    public function create(Pelatihan $pelatihan)
    {
        return view('user.pelatihan.create', compact('pelatihan'));
    }

    public function store(Request $request, Pelatihan $pelatihan)
    {
        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            'no_ktp'            => [
                'required',
                'string',
                'digits:16',
                'unique:pelatihan_anggota,no_ktp,NULL,id,pelatihan_id,' . $pelatihan->id
            ],
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'      => 'required|string|max:100',
            'tanggal_lahir'     => 'required|date',
            'agama'             => 'required|string|max:50',
            'status_perkawinan' => 'required|string|max:50',
            'pekerjaan'         => 'required|string|max:100',
            'kewarganegaraan'   => 'required|string|max:50',
            'email'             => 'required|email|max:255',
            'no_hp'             => 'required|string|max:20',
            'alamat'            => 'required|string',
            'provinsi'          => 'required|string',
            'kota'              => 'required|string',
            'kecamatan'         => 'required|string',
            'kelurahan'         => 'required|string',
            'foto'              => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_ktp'          => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'pakta_integritas'  => 'nullable|file|mimes:pdf|max:5120',
            'keterangan'        => 'nullable|string',
        ], [
            'no_ktp.unique' => 'NIK ini sudah terdaftar pada pelatihan ini.',
        ]);

        DB::beginTransaction();
        try {
            // Cek kuota pelatihan
            $jumlahPendaftar = PelatihanAnggota::where('pelatihan_id', $pelatihan->id)->count();
            if ($pelatihan->kuota > 0 && $jumlahPendaftar >= $pelatihan->kuota) {
                return redirect()->route('user-pelatihan.show', $pelatihan->id)
                    ->with('error', 'Mohon maaf, kuota untuk pelatihan ini sudah penuh.');
            }

            // Cek apakah user sudah terdaftar di pelatihan ini
            $isAlreadyRegistered = PelatihanAnggota::where('pelatihan_id', $pelatihan->id)
                ->where('users_id', Auth::id())
                ->exists();

            if ($isAlreadyRegistered) {
                return redirect()->route('user-pelatihan.index')->with('warning', 'Anda sudah terdaftar pada pelatihan ini.');
            }

            // Siapkan data untuk disimpan ke database
            $dataSimpan = $validated;
            $dataSimpan['pelatihan_id'] = $pelatihan->id;
            $dataSimpan['users_id'] = Auth::id();

            // Handle Upload File
            if ($request->hasFile('foto')) {
                $dataSimpan['foto'] = $request->file('foto')->store('pelatihan/peserta', 'public');
            }

            if ($request->hasFile('foto_ktp')) {
                $dataSimpan['foto_ktp'] = $request->file('foto_ktp')->store('pelatihan/ktp', 'public');
            }

            if ($request->hasFile('pakta_integritas')) {
                $dataSimpan['pakta_integritas'] = $request->file('pakta_integritas')->store('pelatihan/pakta', 'public');
            } else {
                unset($dataSimpan['pakta_integritas']);
            }

            // 1. Buat data pendaftar
            $pendaftar = PelatihanAnggota::create($dataSimpan);

            // 2. Buat status awal pendaftaran
            PelatihanAnggotaStatus::create([
                'pelatihan_anggota_id' => $pendaftar->id,
                'status' => 'Menunggu Pembayaran',
            ]);

            // 3. Buat Notifikasi untuk User
            Notification::create([
                'user_id' => Auth::id(),
                'title'   => 'Pendaftaran Pelatihan Berhasil',
                'message' => 'Anda telah berhasil mendaftar pada pelatihan "' . $pelatihan->judul . '". Silakan lakukan pembayaran untuk melanjutkan.',
                'type'    => 'success',
                'route'   => route('user-pelatihan.payment', $pendaftar->id, false),
            ]);

            DB::commit();

            return redirect()->route('user-pelatihan.payment', $pendaftar->id)
                ->with('success', 'Pendaftaran pelatihan berhasil. Silakan lanjutkan ke proses pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Hapus file yang terlanjur di-upload jika terjadi error pada database
            if (isset($dataSimpan['foto']) && Storage::disk('public')->exists($dataSimpan['foto'])) {
                Storage::disk('public')->delete($dataSimpan['foto']);
            }
            if (isset($dataSimpan['foto_ktp']) && Storage::disk('public')->exists($dataSimpan['foto_ktp'])) {
                Storage::disk('public')->delete($dataSimpan['foto_ktp']);
            }
            if (isset($dataSimpan['pakta_integritas']) && Storage::disk('public')->exists($dataSimpan['pakta_integritas'])) {
                Storage::disk('public')->delete($dataSimpan['pakta_integritas']);
            }

            $errorMessage = 'Terjadi kesalahan saat mendaftar pelatihan. Silakan coba lagi.';
            if (config('app.debug')) {
                $errorMessage = 'Gagal mendaftar pelatihan: ' . $e->getMessage() . ' di file ' . $e->getFile() . ' pada baris ' . $e->getLine();
            }
            return back()->withInput()->with('error', $errorMessage);
        }
    }

    /**
     * Menampilkan halaman detail pelatihan berdasarkan ID atau slug.
     */
    public function show(Pelatihan $pelatihan)
    {
        // Mengarahkan ke view detail pelatihan (misal: resources/views/pelatihan/detail.blade.php)
        return view('user.pelatihan.show', compact('pelatihan'));
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

        return redirect()->route('user-pelatihan.index')
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

        // Mengarahkan ke view status dengan data yang diperlukan
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
}
