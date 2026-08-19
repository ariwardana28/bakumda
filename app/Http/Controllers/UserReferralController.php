<?php

namespace App\Http\Controllers;

use App\Models\ReferralCode;
use App\Models\ReferralTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserReferralController extends Controller
{
    /**
     * Menampilkan halaman utama program referral untuk pengguna.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil semua kode referral milik user
        $referralCodes = ReferralCode::where('user_id', $user->id)->get();

        // Ambil transaksi yang terkait dengan user ini sebagai referrer
        $transactionsQuery = ReferralTransaction::where('referrer_id', $user->id)
            ->with(['referralCode', 'referred']);

        // Statistik
        $totalSuccess = (clone $transactionsQuery)->where('status', 'berhasil')->count();
        $totalReward = (clone $transactionsQuery)->where('status', 'berhasil')->sum('reward_amount');

        // Paginasi untuk riwayat transaksi
        $perPage = $request->input('per_page', 5);
        $transactions = $transactionsQuery->latest()->paginate($perPage)->withQueryString();

        return view('user.referral.index', compact(
            'referralCodes',
            'transactions',
            'totalSuccess',
            'totalReward',
            'perPage'
        ));
    }

    /**
     * Memproses permintaan klaim reward dari pengguna.
     */
    public function claim(Request $request)
    {
        $validated = $request->validate([
            'referral_code_id' => 'required|exists:referral_codes,id',
        ]);

        DB::beginTransaction();
        try {
            $referralCode = ReferralCode::findOrFail($validated['referral_code_id']);

            // Otorisasi: Pastikan kode referral ini milik user yang sedang login
            if ($referralCode->user_id !== Auth::id()) {
                abort(403, 'Anda tidak berhak mengklaim kode ini.');
            }

            // Validasi: Pastikan target sudah tercapai dan belum pernah diklaim
            if ($referralCode->current_uses < $referralCode->target_count) {
                return back()->with('error', 'Target penggunaan kode referral belum tercapai.');
            }

            if ($referralCode->status === 'claimed') {
                return back()->with('info', 'Reward untuk kode ini sudah pernah Anda klaim.');
            }

            // Update status kode referral menjadi 'claimed'
            $referralCode->status = 'claimed';
            $referralCode->save();

            DB::commit();

            return back()->with('success', 'Selamat! Permintaan klaim reward untuk kode ' . $referralCode->code . ' berhasil dikirim dan akan segera diproses oleh admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses klaim: ' . $e->getMessage());
        }
    }
}