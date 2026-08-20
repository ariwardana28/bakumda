<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\ReferralPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereHas('referralCodes') // Hanya ambil user yang punya kode referral
            ->with(['referralCodes', 'referralPayments'])
            ->withCount('referralPayments as referrals_count');

        // Fungsionalitas Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('referralCodes', function ($q_code) use ($search) {
                        $q_code->where('code', 'like', "%{$search}%");
                    });
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        // Data untuk kartu statistik
        $stats = [
            'total_users_with_referral' => User::whereHas('referralCodes')->count(),
            'total_commission' => ReferralPayment::where('status', 'approved')->sum('amount'),
            'pending_claims' => ReferralPayment::where('status', 'pending')->count(),
            // Asumsi referral rate adalah statis, atau bisa diambil dari settings
            'referral_rate' => '10%',
        ];

        // Mengubah data user untuk view
        $users->getCollection()->transform(function ($user) {
            // Ambil hanya satu kode referral untuk ditampilkan (misalnya yang pertama)
            $user->referral_code_display = $user->referralCodes->first()->code ?? 'N/A';
            // Hitung total komisi yang sudah disetujui untuk user ini
            $user->total_commission_earned = $user->referralPayments()->where('status', 'approved')->sum('amount');
            return $user;
        });

        return view('admin.referral.index', compact('users', 'stats'));
    }

    public function claims(Request $request)
    {
        // Ambil status dari request, default ke 'pending'
        $statusFilter = $request->get('status', 'pending');

        $query = ReferralPayment::with('user')->latest();

        if ($statusFilter !== 'all') {
            $query->where('status', $statusFilter);
        }

        $claims = $query->paginate(10)->withQueryString();

        // Hitung jumlah untuk setiap tab status
        $statusCounts = ReferralPayment::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.referral.claims', compact('claims', 'statusFilter', 'statusCounts'));
    }

    public function updateClaim(Request $request, ReferralPayment $claim)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'rejection_reason' => 'nullable|string|required_if:status,rejected|max:500',
        ]);

        DB::transaction(function () use ($claim, $validated) {
            $claim->status = $validated['status'];
            $claim->rejection_reason = $validated['status'] === 'rejected' ? $validated['rejection_reason'] : null;
            $claim->processed_by = auth()->id();
            $claim->processed_at = now();
            $claim->save();

            // Ambil semua ID transaksi referral yang terkait dengan pembayaran ini
            $transactionIds = $claim->details()->pluck('referral_transaction_id');

            if ($transactionIds->isNotEmpty()) {
                // Jika klaim disetujui, set is_claimed = 1.
                // Jika klaim ditolak, kembalikan is_claimed = 0 agar bisa diklaim lagi.
                $isClaimedStatus = ($validated['status'] === 'approved') ? 1 : 0;
                DB::table('referral_transactions')->whereIn('id', $transactionIds)->update(['is_claimed' => $isClaimedStatus]);
            }

            // Kirim notifikasi ke pengguna
            Notification::create([
                'user_id' => $claim->user_id,
                'title'   => 'Status Klaim Reward Diperbarui',
                'message' => 'Klaim reward Anda sebesar Rp' . number_format($claim->amount, 0, ',', '.') . ' telah ' . ($claim->status === 'approved' ? 'disetujui' : 'ditolak') . '.',
                'type'    => $claim->status === 'approved' ? 'success' : 'error',
                'route'   => route('user-referral.index', [], false),
            ]);
        });

        return back()->with('success', 'Status klaim berhasil diperbarui.');
    }
}
