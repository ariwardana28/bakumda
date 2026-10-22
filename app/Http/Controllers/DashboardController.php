<?php

namespace App\Http\Controllers;

use App\Models\AnggotaCard;
use App\Models\Anggota;
use App\Models\AnggotaStatus;
use App\Models\Notification;
use App\Models\Pelatihan;
use App\Models\Artikel;
use App\Services\HomepageBannerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard beserta data statistik.
     * Mengarahkan pengguna berdasarkan rolenya.
     */
    public function index(HomepageBannerService $homepageBannerService): View|RedirectResponse
    {
        $user = Auth::user();

        $pelatihans = Pelatihan::latest()->get();
        $banners = $homepageBannerService->activeSlides();

        // Artikel yang sudah dipublikasikan
        $artikels = Artikel::where('status', 'published')->latest()->get();

        $isRegistered = false;
        $isActiveMember = false;
        $nama_anggota = '';
        $no_ktpa = '';
        $status_anggota = '';

        // Cari anggota berdasarkan user yang sedang login (tamu: tidak ada hasil)
        $anggota = $user
            ? Anggota::with(['user', 'card.latestStatus', 'card.latestBerlaku'])
                ->where('user_id', $user->id)
                ->first()
            : null;

        if ($anggota && $anggota->card) {
            $card = $anggota->card;

            $isRegistered = true;
            $nama_anggota = $anggota->user->name;
            $no_ktpa = $card->card_id;

            $latestStatus = $card->latestStatus;
            $status_anggota = $latestStatus ? $latestStatus->status : 'Menunggu Verifikasi';

            // Anggota terdaftar DAN berstatus aktif -> semua fitur terbuka
            $isActiveMember = $anggota->isActive();
        }

        // Tamu atau user ber-role 'Anggota' -> tampilan beranda anggota
        if (! $user || $user->hasRole('Anggota')) {
            return view('dashboard_anggota', compact(
                'anggota',
                'pelatihans',
                'banners',
                'artikels',
                'isRegistered',
                'isActiveMember',
                'nama_anggota',
                'no_ktpa',
                'status_anggota'
            ));
        }

        // ---- Dashboard admin ----

        $totalAnggota = Anggota::count();

        // Hitung berdasarkan status terakhir dari setiap AnggotaCard
        $pendingVerifikasi = AnggotaCard::whereHas('latestStatus', function ($query) {
            $query->whereIn('status', ['PROSES', 'Menunggu Pembayaran', 'Pembayaran Diproses']);
        })->count();

        $anggotaAktif = AnggotaCard::whereHas('latestStatus', function ($query) {
            $query->whereIn('status', ['AKTIF', 'APPROVED', 'DISETUJUI']);
        })->count();

        $totalPengajuanHariIni = AnggotaStatus::whereDate('created_at', today())->count();

        // 5 anggota terbaru dengan status proses atau aktif
        $permohonanTerbaru = Anggota::with(['card.latestStatus'])
            ->whereHas('card.latestStatus', function ($query) {
                $query->whereIn('status', ['PROSES', 'Menunggu Pembayaran', 'Pembayaran Diproses', 'AKTIF', 'APPROVED', 'DISETUJUI']);
            })
            ->latest()
            ->take(5)
            ->get();

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
     * Dipakai untuk halaman verifikasi via QR Code.
     */
    public function anggota(string $card_id): View
    {
        $anggotaCard = AnggotaCard::where('card_id', $card_id)
            ->with([
                'anggota.pendingEditRequest.latestStatus',
                'latestBerlaku',
                'berlakuHistory',
                'latestStatus',
            ])
            ->firstOrFail();

        $anggota = $anggotaCard->anggota;

        if ($anggota && ! $anggota->relationLoaded('card')) {
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
            return $notification->route ? redirect($notification->route) : back();
        }

        return back();
    }
}