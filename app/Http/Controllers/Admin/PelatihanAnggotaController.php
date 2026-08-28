<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PelatihanPembayaran;
use App\Models\PelatihanAnggotaStatus;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class PelatihanAnggotaController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter status dari URL, default ke 'pending' jika tidak ada
        $statusFilter = $request->get('status', 'pending');

        // Petakan status dari URL ke status di database
        $dbStatus = match ($statusFilter) {
            'diterima' => 'verified',
            'ditolak' => 'rejected',
            default => 'pending',
        };

        // Ambil data pembayaran berdasarkan filter status, beserta relasi terkait
        $pembayaranList = PelatihanPembayaran::with(['pelatihan', 'user', 'pelatihanAnggota'])
            ->where('status_pembayaran', $dbStatus)
            ->latest()
            ->paginate(10);

        return view('admin.pelatihan_anggota.index', compact('pembayaranList'));
    }
    // Method baru untuk menampilkan halaman detail pembayaran
    public function show($id)
    {
        $pembayaran = PelatihanPembayaran::with(['user', 'pelatihan'])->findOrFail($id);

        return view('admin.pelatihan_anggota.show', compact('pembayaran'));
    }

    public function updateVerifikasi(Request $request, $id)
    {
        $request->validate([
            'aksi' => 'required|in:verified,rejected',
            'keterangan_admin' => 'nullable|string|max:500',
        ]);

        $pembayaran = PelatihanPembayaran::with(['pelatihanAnggota', 'pelatihanAnggota.pelatihan'])->findOrFail($id);

        DB::transaction(function () use ($request, $pembayaran) {
            $isVerified = $request->aksi === 'verified';
            $statusPembayaranBaru = $isVerified ? 'verified' : 'rejected';
            $pelatihanId = $pembayaran->pelatihan_anggota_id ? $pembayaran->pelatihanAnggota->pelatihan_id : null;
            $judulPelatihan = optional($pembayaran->pelatihanAnggota->pelatihan)->judul ?? 'Pelatihan';

            // 1. Update status di tabel pelatihan_pembayaran
            $pembayaran->update([
                'status_pembayaran' => $statusPembayaranBaru,
            ]);

            // 2. Buat log status baru untuk anggota
            PelatihanAnggotaStatus::create([
                'pelatihan_anggota_id' => $pembayaran->pelatihan_anggota_id,
                'status'               => $isVerified ? 'Pembayaran Disetujui' : 'Pembayaran Ditolak',
                'keterangan'           => $request->keterangan_admin ?? ($isVerified ? 'Pembayaran telah diverifikasi dan disetujui oleh admin.' : 'Bukti pembayaran ditolak. Silakan unggah ulang bukti yang valid.'),
            ]);

            // 3. Buat Notifikasi untuk User dengan route dinamis
            Notification::create([
                'user_id' => $pembayaran->user_id,
                'title'   => $isVerified ? 'Pembayaran Disetujui' : 'Pembayaran Ditolak',
                'message' => $isVerified
                    ? 'Pembayaran untuk pelatihan "' . $judulPelatihan . '" telah disetujui. Silakan akses materi pelatihan.'
                    : 'Maaf, pembayaran untuk pelatihan "' . $judulPelatihan . '" ditolak. ' . ($request->keterangan_admin ?? 'Silakan periksa kembali dan unggah ulang bukti pembayaran.'),
                'type'    => $isVerified ? 'success' : 'error',
                'route'   => $isVerified
                    ? route('user-materi.index', $pelatihanId, false)
                    : route('user-pelatihan.payment', $pembayaran->pelatihan_anggota_id, false),
            ]);

            // 4. 🌟 TAMBAHAN: Update status referral transaction terkait, sesuai hasil verifikasi pembayaran
            $referralTransaction = ReferralTransaction::where('referred_id', $pembayaran->user_id)
                ->where('pelatihan_id', $pelatihanId)
                ->where('status', 'pending')
                ->first();

            if ($referralTransaction) {
                if ($isVerified) {
                    // Pembayaran disetujui -> referral berhasil
                    $referralTransaction->update([
                        'status' => 'berhasil',
                    ]);

                    Notification::create([
                        'user_id' => $referralTransaction->referrer_id,
                        'title'   => 'Referral Berhasil',
                        'message' => 'Selamat! Kode referral Anda berhasil digunakan untuk pendaftaran pelatihan "' . $judulPelatihan . '" dan pembayaran peserta telah disetujui. Reward sebesar Rp ' . number_format($referralTransaction->reward_amount, 0, ',', '.') . ' akan segera diproses.',
                        'type'    => 'success',
                        'route'   => route('user-referral.index', [], false),
                    ]);
                } else {
                    // Pembayaran ditolak -> referral ikut ditolak
                    $referralTransaction->update([
                        'status' => 'ditolak',
                    ]);

                    Notification::create([
                        'user_id' => $referralTransaction->referrer_id,
                        'title'   => 'Referral Ditolak',
                        'message' => 'Kode referral Anda yang digunakan untuk pendaftaran pelatihan "' . $judulPelatihan . '" tidak jadi berhasil karena pembayaran peserta ditolak oleh admin.',
                        'type'    => 'error',
                        'route'   => route('user-referral.index', [], false),
                    ]);
                }
            }
        });

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
