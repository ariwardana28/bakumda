<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelatihan;
use App\Models\Anggota;
use App\Models\Sertifikat;
use App\Models\AnggotaBerlaku;
use App\Models\AnggotaCard;
use App\Models\Artikel;
use Illuminate\Support\Facades\Auth; // Tambahkan ini

class HalamanUtamaController extends Controller
{
    public function index()
    {
        // Jika pengguna sudah login, langsung arahkan ke dashboard.
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $pelatihans = Pelatihan::latest()->get();
        $user = Auth::user();
        $artikels = Artikel::where('status', 'published')->latest()->get();
        $isRegistered = false;
        $nama_anggota = '';
        $no_ktpa = '';
        $status_anggota = '';

        // Cari anggota berdasarkan user_id yang sedang login
        $anggota = Anggota::where('user_id', $user->id ?? null)->first();

        if ($anggota) {
            $card = $anggota->card; // Mengambil relasi card dari model
            if ($card) {
                $isRegistered = true;
                $nama_anggota = $anggota->nama;
                $no_ktpa = $card->card_id; // Sesuai dengan kolom di tabel anggota_card

                // Mengambil status terbaru menggunakan accessor dari model Anda
                $latestStatus = $anggota->latest_status;
                $status_anggota = $latestStatus ? $latestStatus->status : 'Menunggu Verifikasi';
            }
        }

        return view('welcome', compact('pelatihans', 'isRegistered', 'nama_anggota', 'no_ktpa', 'status_anggota', 'artikels'));
    }

    /**
     * Menampilkan halaman formulir untuk pengecekan sertifikat.
     */
    public function showCekSertifikatForm()
    {
        return view('user.sertifikat.cek-sertifikat');
    }

    /**
     * Memproses pengecekan nomor sertifikat dan menampilkan hasilnya.
     */
    public function CekSertifikat(Request $request)
    {
        $request->validate([
            'no_sertifikat' => 'required|string|min:5',
        ], [
            'no_sertifikat.required' => 'Nomor sertifikat wajib diisi.',
        ]);

        $nomorSertifikat = $request->input('no_sertifikat');

        // Cari sertifikat berdasarkan nomor, dan eager load relasi yang dibutuhkan
        $sertifikat = Sertifikat::where('no_sertifikat', $nomorSertifikat)
            ->with([
                'nilai.pelatihanAnggota.user', // User (Peserta)
                'nilai.pelatihanAnggota.pelatihan' // Pelatihan
            ])
            ->first();

        if (!$sertifikat) {
            return back()->withInput()->with('error', 'Sertifikat dengan nomor tersebut tidak ditemukan.');
        }

        return view('user.sertifikat.sertifikat-publik', compact('sertifikat'));
    }

    /**
     * Menampilkan halaman formulir untuk pengecekan kartu anggota.
     */
    public function showCekKartuAnggotaForm()
    {
        // Anda perlu membuat file view ini: resources/views/user/keanggotaan/cek-kartu-anggota.blade.php
        return view('admin.keanggotaan.cek-kartu-anggota');
    }

    /**
     * Memproses pengecekan nomor kartu anggota dan menampilkan hasilnya.
     */
    public function CekKartuAnggota(Request $request)
    {
        $request->validate([
            'no_kartu' => 'required|string|min:5',
        ], [
            'no_kartu.required' => 'Nomor kartu anggota wajib diisi.',
        ]);

        $nomorKartu = $request->input('no_kartu');

        // Cari kartu anggota berdasarkan nomor, dan eager load relasi yang dibutuhkan
        $anggotaCard = AnggotaCard::where('card_id', $nomorKartu)
            ->with(['anggota', 'latestStatus', 'latestBerlaku'])
            ->first();

        if (!$anggotaCard) {
            return back()->withInput()->with('error', 'Kartu anggota dengan nomor tersebut tidak ditemukan.');
        }

        // Ambil variabel pendukung yang dibutuhkan view
        $latestBerlaku = $anggotaCard->latestBerlaku;

        return view('admin.keanggotaan.kartu-anggota-publik', compact('anggotaCard', 'latestBerlaku'));
    }

    public function show(Artikel $artikel)
    {
        // Pastikan hanya artikel yang berstatus 'published' yang bisa diakses publik.
        // Route model binding sudah menangani 404 jika tidak ditemukan.
        // Kita tambahkan pengecekan status.
        if ($artikel->status !== 'published') {
            abort(404);
        }

        // Arahkan ke view untuk menampilkan detail artikel.
        return view('user.artikel.show', compact('artikel'));
    }

    public function Korwil()
    {
        // Menampilkan halaman daftar provinsi.
        // Daftar provinsi sudah di-hardcode di view, jadi tidak perlu passing data.
        return view('user.korwil.index');
    }

    /**
     * Menampilkan detail Korwil untuk provinsi tertentu.
     *
     * @param string $province
     * @return \Illuminate\View\View
     */
    public function showKorwilByProvince($province)
    {
        $korwils = AnggotaBerlaku::with(['anggotaCard', 'anggotaCard.anggota'])
            ->where('jabatan', 'LIKE', '%KORWIL%' . strtoupper($province) . '%')
            ->latest()
            ->get();

        return view('user.korwil.show', compact('korwils', 'province'));
    }

    /**
     * Menampilkan halaman Surat Penunjukan untuk Korwil tertentu.
     *
     * @param  \App\Models\AnggotaCard $anggotaCard
     * @return \Illuminate\View\View
     */
    public function showKorwilSurat(AnggotaCard $anggotaCard)
    {
        // Eager load relasi yang dibutuhkan untuk view
        $anggotaCard->load(['anggota', 'latestBerlaku']);

        $anggota = $anggotaCard->anggota;
        $latestBerlaku = $anggotaCard->latestBerlaku;

        // Ekstrak nama provinsi dari jabatan
        $province = 'TIDAK DIKETAHUI';
        if ($latestBerlaku && !empty($latestBerlaku->jabatan)) {
            // Mencari teks setelah "KORWIL PROVINSI "
            $jabatanUpper = strtoupper($latestBerlaku->jabatan);
            $prefix = 'KORWIL PROVINSI ';
            if (str_starts_with($jabatanUpper, $prefix)) {
                $province = substr($latestBerlaku->jabatan, strlen($prefix));
            }
        }

        // Mengirim data ke view 'user.korwil.surat'
        // Pastikan file view ini ada: resources/views/user/korwil/surat.blade.php
        return view('user.korwil.surat', compact('anggotaCard', 'anggota', 'province'));
    }
}
