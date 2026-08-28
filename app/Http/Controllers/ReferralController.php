<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReferralCode;
use App\Models\ReferralTransaction;
use App\Models\ReferralPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->query('per_page', 5);

        // Otomatis buat 2 kode referral (tier_5 dan tier_10) jika belum ada
        $tiers = [
            ['tier_type' => 'tier_5', 'target_count' => 5],
            ['tier_type' => 'tier_10', 'target_count' => 10],
        ];

        foreach ($tiers as $tier) {
            ReferralCode::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'tier_type' => $tier['tier_type']
                ],
                [
                    'code' => strtoupper(substr(md5($user->id . $tier['tier_type'] . time()), 0, 8)),
                    'target_count' => $tier['target_count'],
                    'current_uses' => 0,
                ]
            );
        }

        // Ambil kedua kode referral milik user
        $referralCodes = ReferralCode::where('user_id', $user->id)->get();

        // 1. Ambil riwayat pencairan dana (Referral Payments) alih-alih transaksi
        $payments = ReferralPayment::where('user_id', $user->id)
            ->latest()
            ->paginate($perPage);

        // dd($payments);

        // 2. Hitung total pencairan yang sukses/dibayar (opsional, sesuaikan statusnya)
        $totalSuccessPayment = ReferralPayment::where('user_id', $user->id)
            ->where('status', 'paid') // atau 'approved'
            ->count();

        // 3. Hitung total nominal keseluruhan amount yang dicairkan
        $totalReward = ReferralPayment::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved', 'paid'])
            ->sum('amount');

        // Hitung total referral yang sukses (berstatus 'berhasil')
        $totalSuccess = ReferralTransaction::where('referrer_id', $user->id)
            ->where('status', 'berhasil')
            ->count();

        return view('user.referral.index', compact('referralCodes', 'payments', 'totalSuccessPayment', 'totalReward', 'perPage', 'totalSuccess'));
    }
}
