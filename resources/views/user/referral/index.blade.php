@extends('layouts.app')

@section('title', 'Inspirator')

@section('content')
    <div class="px-3 md:px-8 py-4 md:py-6 space-y-6 md:space-y-8 max-w-7xl mx-auto">
        <!-- Kartu Identitas Pengguna -->
        <div class="flex items-center gap-4 p-4 bg-white border border-amber-300 rounded-2xl shadow-sm mb-4">
            <div
                class="w-12 h-12 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white font-bold text-lg shadow-md">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="flex-1">
                <p class="text-[10px] uppercase font-bold text-orange-600 tracking-widest">Pemilik Akun</p>
                <h2 class="text-lg font-extrabold text-stone-900">{{ Auth::user()->name }}</h2>
            </div>
            <div class="hidden sm:block text-right">
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1 bg-sky-100 text-sky-800 text-[10px] font-bold rounded-full border border-sky-300">
                    <i class="fa-solid fa-circle-check"></i> Aktif
                </span>
            </div>
        </div>

        <!-- Hero Section / Banner Utama -->
        <div x-data="{ openGuideModal: false }"
            class="relative overflow-hidden rounded-2xl md:rounded-3xl bg-gradient-to-br from-amber-400 via-orange-500 to-amber-500 p-6 sm:p-8 md:p-10 text-white shadow-2xl border border-amber-300/40 group">
            <!-- Dekorasi Background -->
            <div
                class="absolute -right-20 -top-20 w-64 md:w-96 h-64 md:h-96 bg-white/20 rounded-full blur-3xl pointer-events-none">
            </div>
            <div
                class="absolute -left-20 -bottom-20 w-60 md:w-80 h-60 md:h-80 bg-yellow-200/30 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 space-y-6">
                <!-- Header dengan Badge & Tombol Panduan -->
                <div class="flex items-center justify-between gap-4">
                    <span
                        class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/90 border border-white text-stone-900 text-[10px] md:text-xs font-black tracking-wide uppercase shadow-md backdrop-blur-md">
                        <i class="fa-solid fa-gift text-orange-600"></i> Program Referral BAKUMDA
                    </span>
                    <button @click="openGuideModal = true" title="Panduan Program"
                        class="px-5 py-2.5 rounded-2xl bg-white hover:bg-stone-50 text-orange-600 shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center gap-2.5 border border-white/80 backdrop-blur-md text-sm sm:text-base font-extrabold cursor-pointer">
                        <i class="fa-solid fa-book-open-reader text-base sm:text-lg"></i>
                        <span>Panduan</span>
                    </button>
                </div>

                <div class="space-y-2 max-w-xl">
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-white drop-shadow-sm">
                        Ajak Teman Bergabung Pada Program Pelatihan Pendidikan BAKUMDA & Dapatkan Reward
                    </h1>
                    <p class="text-xs sm:text-sm text-amber-50 font-medium leading-relaxed">
                        Bagikan kode referral Anda. Pilih target 5x penggunaan atau 10x penggunaan untuk melakukan klaim
                        reward setelah target tercapai.
                    </p>
                </div>

                <!-- Grid 2 Kartu Kode Referral -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($referralCodes as $ref)
                        @php
                            $target = $ref->tier_type == 'tier_10' ? 10 : 5;
                            // Hitung hanya transaksi sukses yang BELUM diklaim (is_claimed = 0)
                            $unclaimedTransactionsCount = $ref
                                ->transactions()
                                ->whereIn('status', ['berhasil', 'success'])
                                ->where('is_claimed', 0)
                                ->count();
                            // Jumlah klaim yang bisa dilakukan adalah hasil pembagian dari transaksi yang belum diklaim dengan target
                            $unclaimedCount = floor($unclaimedTransactionsCount / $target);
                            // Progress bar menunjukkan sisa transaksi yang dibutuhkan untuk klaim berikutnya
                            $percent = ($unclaimedTransactionsCount % $target) / $target * 100;
                            $isCompleted = $unclaimedCount > 0;

                            // Cek pengajuan klaim pending milik user yang sedang login
                            $pendingClaim = DB::table('referral_payments')
                                ->where('user_id', Auth::id())
                                ->where('status', 'pending')
                                ->first();
                        @endphp

                        <div
                            class="relative bg-white backdrop-blur-md border {{ $isCompleted ? 'border-green-500 shadow-green-500/10' : 'border-stone-200' }} p-5 rounded-2xl space-y-4 shadow-xl hover:shadow-2xl transition-all group overflow-hidden text-stone-900">

                            @if ($isCompleted)
                                <div class="absolute inset-0 bg-amber-500/5 pointer-events-none"></div>
                            @endif

                            <div class="flex justify-between items-start">
                                <div class="space-y-0.5">
                                    <span class="text-xs font-bold text-stone-500 uppercase tracking-widest">
                                        {{ $ref->tier_type == 'tier_10' ? 'Tier 10 Penggunaan' : 'Tier 5 Penggunaan' }}
                                    </span>
                                    <h3 class="text-2xl font-black text-stone-900">
                                        {{ $ref->tier_type == 'tier_10' ? 'Rp200.000' : 'Rp250.000' }}
                                    </h3>
                                </div>

                                @if ($pendingClaim)
                                    {{-- Jika Status Pending, Tombol Berubah Menjadi 'Proses Claim' --}}
                                    <button type="button"
                                        @click="$dispatch('open-pending-modal', { 
                                            bankName: '{{ $pendingClaim->bank_name }}', 
                                            accountNumber: '{{ $pendingClaim->account_number }}', 
                                            accountName: '{{ $pendingClaim->account_name }}', 
                                            amount: '{{ number_format($pendingClaim->amount, 0, ',', '.') }}',
                                            createdAt: '{{ date('d M Y, H:i', strtotime($pendingClaim->created_at)) }}' 
                                        })"
                                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-[10px] font-black rounded-lg shadow-md transition-all cursor-pointer flex items-center gap-1.5">
                                        <i class="fa-solid fa-clock-rotate-left"></i> Proses Claim
                                    </button>
                                @elseif ($unclaimedCount > 0)
                                    <button type="button"
                                        @click="$dispatch('open-claim-modal', { codeId: {{ $ref->id }}, unclaimedCount: {{ $unclaimedCount }}, rewardAmount: '{{ $ref->tier_type == 'tier_10' ? '200.000' : '250.000' }}' })"
                                        class="px-4 py-2 bg-gradient-to-r from-green-400 to-emerald-600 text-white text-[10px] font-black rounded-lg shadow-lg hover:scale-105 transition-transform animate-pulse cursor-pointer">
                                        KLAIM SEKARANG ({{ $unclaimedCount }})
                                    </button>
                                @elseif ($ref->status === 'claimed' && $unclaimedCount == 0)
                                    <span
                                        class="px-4 py-2 bg-slate-200 text-slate-500 text-[10px] font-black rounded-lg shadow-inner cursor-not-allowed">
                                        <i class="fa-solid fa-check-double"></i> DIKLAIM
                                    </span>
                                @else
                                    <div
                                        class="text-[10px] font-bold text-orange-600 bg-orange-50 px-2.5 py-1 rounded-md border border-orange-200 shadow-inner">
                                        {{ $unclaimedTransactionsCount % $target }} / {{ $target }}
                                    </div>
                                @endif
                            </div>

                            <!-- Progress Bar -->
                            <div class="w-full bg-stone-100 rounded-full h-2 overflow-hidden border border-stone-200/50">
                                <div class="h-full bg-gradient-to-r from-yellow-400 to-orange-500 transition-all duration-1000 ease-out"
                                    style="width: {{ $percent }}%">
                                </div>
                            </div>

                            <div class="flex items-center gap-2 pt-2">
                                <div class="flex-1 px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl font-mono text-sm font-bold text-stone-900 tracking-widest select-all shadow-inner"
                                    id="code-{{ $ref->id }}">
                                    {{ $ref->code }}
                                </div>

                                <button
                                    onclick="navigator.clipboard.writeText(document.getElementById('code-{{ $ref->id }}').innerText); alert('Kode referral berhasil disalin!');"
                                    class="h-12 px-4 rounded-xl bg-stone-100 hover:bg-orange-500 hover:text-white text-stone-700 font-bold transition-all flex items-center gap-2 shrink-0 border border-stone-200 text-xs cursor-pointer">
                                    <i class="fa-solid fa-copy"></i>
                                    <span>Salin Kode</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- MODAL KLAIM REWARD -->
            <div x-data="{ openClaimModal: false, codeId: null, maxUnclaimed: 0, claimQty: 1, rewardAmount: '' }" x-show="openClaimModal"
                @open-claim-modal.window="
                    openClaimModal = true; 
                    codeId = $event.detail.codeId; 
                    maxUnclaimed = $event.detail.unclaimedCount; 
                    claimQty = $event.detail.unclaimedCount; 
                    rewardAmount = $event.detail.rewardAmount;
                "
                @keydown.escape.window="openClaimModal = false" style="display: none;"
                class="fixed inset-0 z-50 overflow-y-auto bg-stone-900/60 backdrop-blur-sm flex items-center justify-center p-4">

                <div @click.away="openClaimModal = false"
                    class="bg-white rounded-2xl max-w-sm w-full p-5 shadow-2xl border border-stone-100 space-y-4 relative text-stone-900"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                    <!-- Header Modal -->
                    <div class="flex items-center justify-between border-b border-stone-100 pb-3">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 rounded-lg bg-green-100 text-green-700 flex items-center justify-center text-sm font-bold">
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-black text-stone-900">Klaim Reward</h3>
                                <p class="text-[11px] text-stone-500">Maksimal <strong x-text="maxUnclaimed"></strong>
                                    klaim.</p>
                            </div>
                        </div>
                        <button @click="openClaimModal = false"
                            class="w-7 h-7 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-500 flex items-center justify-center transition-colors cursor-pointer">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    </div>

                    <!-- Form Pemilihan Jumlah Klaim & Rekening Bank -->
                    <form action="{{ route('user-referral.claimAll') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="hidden" name="referral_code_id" :value="codeId">

                        <!-- Input Jumlah Klaim -->
                        <div class="space-y-1.5">
                            <label class="text-[11px] font-bold text-stone-700 uppercase tracking-wide">Jumlah Klaim</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="claim_qty" x-model.number="claimQty"
                                    @input="if(claimQty > maxUnclaimed) claimQty = maxUnclaimed; if(claimQty < 1) claimQty = 1;"
                                    min="1" :max="maxUnclaimed"
                                    class="w-24 px-3 py-1.5 rounded-lg border border-stone-200 text-sm font-bold text-stone-900 focus:ring-2 focus:ring-green-500 focus:outline-none text-center">

                                <div class="flex gap-1.5 flex-1">
                                    <button type="button" @click="claimQty = 1"
                                        class="flex-1 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-[11px] font-bold rounded-lg transition-all cursor-pointer">
                                        1x
                                    </button>
                                    <template x-if="maxUnclaimed >= 2">
                                        <button type="button" @click="claimQty = 2"
                                            class="flex-1 py-1.5 bg-stone-100 hover:bg-stone-200 text-stone-700 text-[11px] font-bold rounded-lg transition-all cursor-pointer">
                                            2x
                                        </button>
                                    </template>
                                    <button type="button" @click="claimQty = maxUnclaimed"
                                        class="flex-1 py-1.5 bg-green-50 hover:bg-green-100 text-green-700 text-[11px] font-bold rounded-lg transition-all cursor-pointer">
                                        Semua
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Input Informasi Rekening Bank -->
                        <div class="space-y-2.5 pt-1 border-t border-stone-100">
                            <label class="text-[11px] font-bold text-stone-700 uppercase tracking-wide">Rekening
                                Tujuan</label>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-[10px] font-semibold text-stone-500 mb-0.5">Bank</label>
                                    <input type="text" name="bank_name" required placeholder="Contoh: BCA"
                                        class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-xs font-medium text-stone-900 focus:ring-2 focus:ring-green-500 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-semibold text-stone-500 mb-0.5">No.
                                        Rekening</label>
                                    <input type="text" name="account_number" required placeholder="No Rekening"
                                        class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-xs font-medium text-stone-900 focus:ring-2 focus:ring-green-500 focus:outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-semibold text-stone-500 mb-0.5">Atas Nama (Sesuai
                                    Rekening)</label>
                                <input type="text" name="account_name" required placeholder="Nama Pemilik Rekening"
                                    class="w-full px-3 py-1.5 rounded-lg border border-stone-200 text-xs font-medium text-stone-900 focus:ring-2 focus:ring-green-500 focus:outline-none">
                            </div>
                        </div>

                        <!-- Info Total Reward -->
                        <div class="text-center space-y-0.5 bg-stone-50 p-3 rounded-xl border border-stone-100">
                            <p class="text-[11px] text-stone-500">Total nominal:</p>
                            <p class="text-xl font-extrabold text-green-600"
                                x-text="'Rp' + (claimQty * parseFloat(rewardAmount.replace(/\./g, ''))).toLocaleString('id-ID')">
                            </p>
                        </div>

                        <!-- Tombol Submit Aksi -->
                        <div class="pt-1">
                            <button type="submit"
                                class="w-full py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold text-xs rounded-xl transition-all shadow-md shadow-green-200 cursor-pointer flex items-center justify-center gap-2">
                                <i class="fa-solid fa-check-circle"></i>
                                <span>Proses Klaim (<span x-text="claimQty"></span>)</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MODAL INFORMASI STATUS PENDING / PROSES CLAIM -->
            <div x-data="{ openPendingModal: false, bankName: '', accountNumber: '', accountName: '', amount: '', createdAt: '' }" x-show="openPendingModal"
                @open-pending-modal.window="
                    openPendingModal = true;
                    bankName = $event.detail.bankName;
                    accountNumber = $event.detail.accountNumber;
                    accountName = $event.detail.accountName;
                    amount = $event.detail.amount;
                    createdAt = $event.detail.createdAt;
                "
                @keydown.escape.window="openPendingModal = false" style="display: none;"
                class="fixed inset-0 z-50 overflow-y-auto bg-stone-900/60 backdrop-blur-sm flex items-center justify-center p-4">

                <div @click.away="openPendingModal = false"
                    class="bg-white rounded-2xl max-w-sm w-full p-5 shadow-2xl border border-stone-100 space-y-4 relative text-stone-900"
                    x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0">

                    <!-- Header Modal -->
                    <div class="flex items-center justify-between border-b border-stone-100 pb-3">
                        <div class="flex items-center gap-2.5">
                            <div
                                class="w-8 h-8 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-bold">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-black text-stone-900">Claim Dalam Proses</h3>
                                <p class="text-[11px] text-stone-500">Status pencairan sedang ditinjau.</p>
                            </div>
                        </div>
                        <button @click="openPendingModal = false"
                            class="w-7 h-7 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-500 flex items-center justify-center transition-colors cursor-pointer">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    </div>

                    <!-- Detail Informasi Klaim Pending -->
                    <div class="space-y-3 text-xs">
                        <div class="bg-amber-50 border border-amber-200 p-3 rounded-xl space-y-2">
                            <div class="flex justify-between">
                                <span class="text-stone-500">Jumlah Klaim:</span>
                                <span class="font-extrabold text-amber-700" x-text="'Rp ' + amount"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-stone-500">Tanggal Pengajuan:</span>
                                <span class="font-semibold text-stone-700" x-text="createdAt"></span>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <p class="font-bold text-stone-700 uppercase tracking-wide text-[10px]">Tujuan Rekening</p>
                            <div class="p-3 bg-stone-50 rounded-xl border border-stone-200 space-y-1 font-medium">
                                <div class="flex justify-between">
                                    <span class="text-stone-500">Bank:</span>
                                    <span class="font-bold text-stone-900 uppercase" x-text="bankName"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-stone-500">No. Rekening:</span>
                                    <span class="font-mono font-bold text-stone-900" x-text="accountNumber"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-stone-500">Atas Nama:</span>
                                    <span class="font-bold text-stone-900" x-text="accountName"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Tutup -->
                    <div class="pt-1">
                        <button type="button" @click="openPendingModal = false"
                            class="w-full py-2.5 bg-stone-900 hover:bg-stone-800 text-white font-bold text-xs rounded-xl transition-all shadow-md cursor-pointer">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

            <!-- MODAL PANDUAN SINGKAT -->
            <div x-show="openGuideModal" style="display: none;"
                class="fixed inset-0 z-50 overflow-y-auto bg-stone-900/60 backdrop-blur-sm flex items-center justify-center p-4">

                <div @click.away="openGuideModal = false"
                    class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-stone-100 space-y-6 relative text-stone-900">

                    <div class="flex items-center justify-between border-b border-stone-100 pb-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <h3 class="text-lg font-black text-stone-900">Tata Cara Program Referral</h3>
                        </div>
                        <button @click="openGuideModal = false"
                            class="w-8 h-8 rounded-full bg-stone-100 hover:bg-stone-200 text-stone-500 flex items-center justify-center transition-colors cursor-pointer">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <div class="space-y-4 text-stone-600 text-xs sm:text-sm text-left">
                        <div class="flex gap-3 items-start">
                            <span
                                class="w-6 h-6 rounded-full bg-amber-500 text-white font-bold flex items-center justify-center text-xs shrink-0 mt-0.5">1</span>
                            <p><strong class="text-stone-800">Bagikan Kode:</strong> Salin kode referral unik Anda lalu
                                bagikan kepada rekan yang ingin bergabung ke program BAKUMDA.</p>
                        </div>
                        <div class="flex gap-3 items-start">
                            <span
                                class="w-6 h-6 rounded-full bg-amber-500 text-white font-bold flex items-center justify-center text-xs shrink-0 mt-0.5">2</span>
                            <p><strong class="text-stone-800">Capai Target Penggunaan:</strong> Pantau progress
                                penggunaan
                                kode Anda hingga mencapai kelipatan target (Tier 5 atau Tier 10).</p>
                        </div>
                        <div class="flex gap-3 items-start">
                            <span
                                class="w-6 h-6 rounded-full bg-amber-500 text-white font-bold flex items-center justify-center text-xs shrink-0 mt-0.5">3</span>
                            <p><strong class="text-stone-800">Klaim Reward:</strong> Tombol <span
                                    class="text-orange-600 font-bold">KLAIM SEKARANG</span> akan aktif secara otomatis
                                jika
                                target kelipatan tercapai.</p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button @click="openGuideModal = false"
                            class="w-full py-3 bg-stone-900 hover:bg-stone-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition-all shadow-md cursor-pointer">
                            Mengerti & Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Ringkas -->
        <div class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                <div class="p-5 md:p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500">Total Referral Sukses</p>
                        <h3 class="text-xl font-extrabold text-slate-900 mt-0.5">{{ $totalSuccess }} Orang</h3>
                    </div>
                </div>

                <div class="p-5 md:p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500">Total Reward Diperoleh</p>
                        <h3 class="text-xl font-extrabold text-slate-900 mt-0.5">Rp
                            {{ number_format($totalReward, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="p-5 md:p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg font-bold shrink-0">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-slate-500">Jumlah Kode Aktif</p>
                        <h3 class="text-xl font-extrabold text-slate-900 mt-0.5">{{ $referralCodes->count() }} Kode
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Transaksi Referral -->
        <div class="p-5 sm:p-6 md:p-8 rounded-2xl md:rounded-3xl bg-white border border-slate-200/80 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-3 border-b border-slate-100">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Riwayat Transaksi Referral</h2>
                    <p class="text-xs text-slate-500">Daftar pengguna yang mendaftar menggunakan kode Anda.</p>
                </div>

                <form method="GET" action="" class="flex items-center gap-2">
                    <label class="text-xs font-semibold text-slate-500">Tampilkan:</label>
                    <select name="per_page" onchange="this.form.submit()"
                        class="text-xs border-slate-200 rounded-lg py-1.5 focus:ring-red-500 focus:border-red-500">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5 data</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 data</option>
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs sm:text-sm">
                    <thead>
                        <tr
                            class="border-b border-slate-200 text-slate-400 font-semibold uppercase text-[11px] tracking-wider">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Kode Digunakan</th>
                            <th class="py-3 px-4">Pengguna Baru (Referred)</th>
                            <th class="py-3 px-4">Jumlah Reward</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Status Klaim</th>
                            <th class="py-3 px-4">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                        @forelse($transactions as $index => $trx)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3.5 px-4 font-mono text-slate-400">
                                    {{ $transactions->firstItem() + $index }}
                                </td>
                                <td class="py-3.5 px-4 font-mono font-bold text-slate-800">
                                    {{ $trx->referralCode->code ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-slate-900">
                                    {{ $trx->referred->name ?? 'Pengguna' }}
                                </td>
                                <td class="py-3.5 px-4 font-mono font-bold text-emerald-600">
                                    + Rp {{ number_format($trx->reward_amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if (strtolower($trx->status) == 'berhasil' || strtolower($trx->status) == 'success')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200 uppercase">
                                            {{ $trx->status }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-200 uppercase">
                                            {{ $trx->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4">
                                    @if ($trx->is_claimed == 1)
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600 border border-green-200 uppercase">
                                            Sudah Diklaim
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-200 uppercase">
                                            Belum Diklaim
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-slate-400 text-xs">
                                    {{ $trx->created_at->format('d M Y, H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400 text-xs italic">
                                    Belum ada transaksi referral yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($transactions->hasPages())
                <div class="pt-4">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
