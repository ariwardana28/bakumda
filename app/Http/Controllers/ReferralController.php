<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReferralCode;
use App\Models\ReferralTransaction;
use Illuminate\Support\Facades\Auth;

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

        // Ambil riwayat transaksi
        $transactions = ReferralTransaction::with(['referred', 'referralCode'])
            ->where('referrer_id', $user->id)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $totalSuccess = ReferralTransaction::where('referrer_id', $user->id)
            ->where('status', 'berhasil')
            ->count();

        $totalReward = ReferralTransaction::where('referrer_id', $user->id)
            ->where('status', 'berhasil')
            ->sum('reward_amount');

        return view('user.referral.index', compact('referralCodes', 'transactions', 'totalSuccess', 'totalReward', 'perPage'));
    }
}
