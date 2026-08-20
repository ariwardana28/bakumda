<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\ReferralCode;
use App\Models\ReferralTransaction;
use App\Models\ReferralPayment;
use App\Models\ReferralPaymentDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserReferralController extends Controller
{
    /**
     * Menetapkan middleware permission untuk setiap metode.
     */
    public static function middleware(): array
    {
        return [
            'permission:user-referral-view' => ['only' => ['index', 'claim']],
        ];
    }

    /**
     * Menampilkan halaman utama program referral untuk pengguna.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $perPage = $request->input('per_page', 5);
        $claimStatusFilter = $request->input('claim_status', 'all'); // 'all', 'claimed', 'unclaimed'

        // Ambil semua kode referral milik user
        $referralCodes = ReferralCode::where('user_id', $user->id)
            ->withCount(['claims' => function ($query) {
                $query->whereIn('status', ['requested', 'approved']);
            }])
            ->get()
            ->map(function ($code) {
                if ($code->target_count > 0) {
                    // Hitung berapa kali bisa diklaim berdasarkan total penggunaan
                    $total_claimable = floor($code->current_uses / $code->target_count);
                    // Hitung sisa klaim yang belum diambil
                    $code->unclaimed_count = $total_claimable - $code->claims_count;
                } else {
                    $code->unclaimed_count = 0;
                }
                return $code;
            });


        // Ambil transaksi di mana user ini adalah pemilik kode (referrer)
        $transactionsQuery = ReferralTransaction::where('referrer_id', $user->id)
            ->with(['referred', 'referralCode']);

        // Terapkan filter status klaim
        if ($claimStatusFilter === 'claimed') {
            $transactionsQuery->where('is_claimed', 1);
        } elseif ($claimStatusFilter === 'unclaimed') {
            $transactionsQuery->where('is_claimed', 0);
        }

        $transactions = $transactionsQuery->latest()->paginate($perPage)->withQueryString();

        // Hitung jumlah untuk setiap tab status klaim
        $claimStatusCounts = [
            'claimed' => ReferralTransaction::where('referrer_id', $user->id)->where('is_claimed', 1)->count(),
            'unclaimed' => ReferralTransaction::where('referrer_id', $user->id)->where('is_claimed', 0)->count(),
        ];
        $claimStatusCounts['all'] = $claimStatusCounts['claimed'] + $claimStatusCounts['unclaimed'];

        // Hitung statistik
        $totalSuccess = ReferralTransaction::where('referrer_id', $user->id)->where('status', 'berhasil')->count();
        $totalReward = ReferralTransaction::where('referrer_id', $user->id)->where('status', 'berhasil')->sum('reward_amount');

        return view('user.referral.index', compact(
            'referralCodes',
            'transactions',
            'totalSuccess',
            'totalReward',
            'perPage',
            'claimStatusFilter',
            'claimStatusCounts'
        ));
    }

    /**
     * Memproses permintaan klaim reward dari pengguna.
     */
    public function claim(Request $request)
    {
        $request->validate([
            'referral_code_id' => 'required|exists:referral_codes,id',
        ]);

        DB::beginTransaction();
        try {
            $user = Auth::user();
            $referralCode = ReferralCode::findOrFail($request->referral_code_id);

            // 1. Otorisasi
            if ($referralCode->user_id !== $user->id) {
                return back()->with('error', 'Anda tidak memiliki izin untuk mengklaim kode ini.');
            }

            // 2. Validasi: Hitung sisa klaim yang tersedia
            $claimedCount = $referralCode->claims()->whereIn('status', ['requested', 'approved'])->count();
            $totalClaimable = $referralCode->target_count > 0 ? floor($referralCode->current_uses / $referralCode->target_count) : 0; // Pastikan menggunakan floor
            $unclaimedCount = $totalClaimable - $claimedCount;

            if ($unclaimedCount <= 0) {
                return back()->with('error', 'Tidak ada reward yang tersedia untuk diklaim pada kode ini.');
            }

            // 3. Update status kode menjadi 'claim_requested'
            $referralCode->status = 'claim_requested';
            $referralCode->save();

            // 4. Kirim notifikasi ke semua admin
            $admins = User::role('Admin')->get(); // Sesuaikan dengan nama role admin Anda

            // Buat record klaim baru
            $referralCode->claims()->create([
                'user_id' => $user->id,
                'reward_amount' => $referralCode->tier_type == 'tier_10' ? 200000 : 250000,
                'status' => 'requested',
                'claimed_at' => now(),
            ]);

            $rewardAmount = $referralCode->tier_type == 'tier_10' ? '200.000' : '250.000';

            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'title'   => 'Permintaan Klaim Reward',
                    'message' => "Pengguna {$user->name} mengajukan klaim reward sebesar Rp{$rewardAmount} untuk kode referral {$referralCode->code}.",
                    'type'    => 'info',
                    // 'route'   => route('admin.referral.claims'), // Arahkan ke halaman manajemen klaim admin
                ]);
            }

            DB::commit();
            return redirect()->route('user-referral.index')->with('success', 'Permintaan klaim reward berhasil diajukan dan akan segera diproses oleh admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses klaim: ' . $e->getMessage());
        }
    }

    /**
     * Memproses permintaan klaim semua reward yang tersedia.
     */
    public function claimAll(Request $request)
    {
        $request->validate([
            'referral_code_id' => 'required|exists:referral_codes,id',
            'claim_qty' => 'required|integer|min:1',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
        ]);

        $referralCode = ReferralCode::where('id', $request->referral_code_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $target = $referralCode->tier_type == 'tier_10' ? 10 : 5;
        $rewardPerClaim = $referralCode->tier_type == 'tier_10' ? 200000 : 250000;

        // Ambil transaksi berhasil yang belum diklaim
        $successfulTransactions = $referralCode->transactions()
            ->whereIn('status', ['berhasil', 'success'])
            ->where('is_claimed', 0)
            ->get();

        $totalEarnedClaim = floor($successfulTransactions->count() / $target);
        $alreadyClaimed = $referralCode->claimed_count ?? 0;
        $maxUnclaimed = max(0, $totalEarnedClaim - $alreadyClaimed);

        $qtyToClaim = (int) $request->claim_qty;
        if ($qtyToClaim > $maxUnclaimed || $maxUnclaimed <= 0) {
            return back()->with('error', 'Jumlah klaim melebihi batas transaksi yang tersedia.');
        }

        // 1. Simpan ke tabel referral_payments
        $payment = \App\Models\ReferralPayment::create([
            'user_id' => auth()->id(),
            'amount' => $qtyToClaim * $rewardPerClaim,
            'status' => 'pending',
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
        ]);

        // 2. Ambil sejumlah transaksi yang akan diklaim ($qtyToClaim * $target)
        $transactionsToClaim = $successfulTransactions->take($qtyToClaim * $target);

        foreach ($transactionsToClaim as $trx) {
            // Tandai transaksi sudah diklaim
            $trx->update(['is_claimed' => 1]);

            // Simpan detail ke tabel referral_payment_details
            \App\Models\ReferralPaymentDetail::create([
                'referral_payment_id' => $payment->id,
                'referral_transaction_id' => $trx->id,
                'reward_amount' => $rewardPerClaim / $target,
            ]);
        }

        // 3. Update status claimed_count di referral_codes
        $referralCode->claimed_count = $alreadyClaimed + $qtyToClaim;

        if ($referralCode->claimed_count >= $totalEarnedClaim) {
            $referralCode->status = 'claimed';
        }

        $referralCode->save();

        return back()->with('success', "Berhasil mengajukan klaim sebanyak {$qtyToClaim}x reward!");
    }
}
