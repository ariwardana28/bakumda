<?php

namespace App\Http\Controllers;

use App\Models\AnggotaCard;
use App\Models\Anggota;
use App\Models\User;
use App\Models\AnggotaStatus;
use App\Models\Notification;
use App\Models\Pelatihan;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard beserta data statistik.
     * Mengarahkan pengguna berdasarkan rolenya.
     */
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();

        $pelatihans = Pelatihan::latest()->get();

        // Ambil 2 artikel terbaru yang sudah di-publish
        $artikels = Artikel::where('status', 'published')->latest()->get();

        $user = Auth::user();

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
                $nama_anggota = $anggota->user->name;
                $no_ktpa = $card->card_id; // Sesuai dengan kolom di tabel anggota_card

                // Mengambil status terbaru menggunakan accessor dari model Anda
                $latestStatus = $anggota->latest_status;
                $status_anggota = $latestStatus ? $latestStatus->status : 'Menunggu Verifikasi';
            }
        }

        // Jika user adalah 'Anggota', arahkan ke dashboard anggota.
        if ($user->hasRole('Anggota')) {
            // Ambil data Anggota yang terkait dengan user yang sedang login
            $anggota = Anggota::with(['card.latestStatus', 'card.latestBerlaku'])
                ->where('user_id', $user->id)
                ->first();

            // // Jika user adalah 'Anggota' tapi belum mendaftar sebagai anggota (data Anggota kosong),
            // // arahkan ke halaman welcome agar bisa mendaftar.
            // if (!$anggota) {
            //     return redirect()->route('welcome');
            // }
            return view('dashboard_anggota', compact('anggota', 'pelatihans', 'artikels', 'isRegistered', 'nama_anggota', 'no_ktpa', 'status_anggota')); // Arahkan ke dashboard khusus anggota
        }

        // Ambil data statistik dari database
        $totalAnggota = Anggota::count();
        $pendingVerifikasi = AnggotaStatus::where('status', 'proses')->count();
        $anggotaAktif = AnggotaStatus::where('status', 'aktif')->count(); // Old query

        // Perbaikan: Hitung berdasarkan status terakhir dari setiap AnggotaCard
        $pendingVerifikasi = AnggotaCard::whereHas('latestStatus', function ($query) {
            $query->whereIn('status', ['PROSES', 'Menunggu Pembayaran', 'Pembayaran Diproses']);
        })->count();
        $anggotaAktif = AnggotaCard::whereHas('latestStatus', function ($query) {
            $query->whereIn('status', ['AKTIF', 'APPROVED', 'DISETUJUI']);
        })->count();

        // Ambil data pengajuan hari ini (contoh query)
        $totalPengajuanHariIni = AnggotaStatus::whereDate('created_at', today())->count();

        // Ambil 5 anggota terbaru yang status kartunya 'proses' atau 'aktif' (atau status pending/aktif lainnya)
        $permohonanTerbaru = Anggota::with(['card.latestStatus'])
            ->whereHas('card.latestStatus', function ($query) {
                // Sertakan semua status yang dianggap 'proses' atau 'aktif' untuk ditampilkan di daftar terbaru
                $query->whereIn('status', ['PROSES', 'Menunggu Pembayaran', 'Pembayaran Diproses', 'AKTIF', 'APPROVED', 'DISETUJUI']);
            })
            ->latest()
            ->take(5)
            ->get();

        // Kirim semua data ke view
        return view('dashboard', compact(
            'totalAnggota',
            'pendingVerifikasi',
            'anggotaAktif',
            'totalPengajuanHariIni',
            'permohonanTerbaru'
        ));
    }

    /**
     * Menampilkan detail keanggotaan publik berdasarkan ID Kartu.
     * Metode ini bisa digunakan untuk halaman verifikasi via QR Code.
     *
     * @param string $card_id
     * @return View
     */
    public function anggota(string $card_id): View
    {
        // Cari kartu anggota berdasarkan card_id, lalu eager load relasi utama dan relasi turunan
        $anggotaCard = AnggotaCard::where('card_id', $card_id)
            ->with([
                'anggota.pendingEditRequest.latestStatus',
                'latestBerlaku',
                'berlakuHistory',
                'latestStatus'
            ])
            ->firstOrFail();

        $anggota = $anggotaCard->anggota;

        // Pastikan relasi card terhubung dengan baik ke objek $anggota jika dibutuhkan di view
        if ($anggota && !$anggota->relationLoaded('card')) {
            $anggota->setRelation('card', $anggotaCard);
        }

        return view('dashboard.anggota', compact('anggota', 'anggotaCard'));
    }

    public function markAllNotificationsAsRead()
    {
        if (Auth::check()) {
            Notification::where('user_id', Auth::id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        return back();
    }

    public function readNotification($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($notification) {
            if (is_null($notification->read_at)) {
                $notification->update(['read_at' => now()]);
            }

            // Redirect ke route tujuan notifikasi jika ada, jika tidak kembali ke halaman sebelumnya
            return redirect($notification->route ?? back());
        }

        return back();
    }
}
