@extends('layouts.admin')

@section('content')
<div class="container mx-auto max-w-4xl px-4 ">
    {{-- Tombol Kembali --}}
    <div class="mb-6">
        <a href="{{ route('user-pelatihan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Pelatihan
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        {{-- Header Status Pembayaran --}}
        <div class="bg-gradient-to-br from-slate-950 via-gray-900 to-blue-950 p-6 md:p-8 text-white relative">
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#60a5fa_1px,transparent_1px)] [background-size:20px_20px] pointer-events-none"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-500/20 border border-amber-400/30 rounded-full text-amber-300 text-xs font-semibold uppercase tracking-wider mb-2">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        Menunggu Pembayaran
                    </span>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Selesaikan Pembayaran Anda</h1>
                    <p class="text-gray-300 text-xs md:text-sm mt-1">Silakan lakukan transfer sesuai nominal di bawah untuk mengaktifkan pendaftaran.</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl text-left md:text-right min-w-[220px]">
                    <span class="text-xs text-gray-300 block uppercase tracking-wider mb-1">Total Tagihan</span>
                    <span class="text-xl md:text-2xl font-extrabold text-blue-400">Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8 space-y-8">
            {{-- Informasi Rekening Tujuan --}}
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">Pilih Rekening Tujuan Transfer</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Bank BCA --}}
                    <div onclick="selectBank(this)" class="bank-card p-5 rounded-2xl border-2 border-blue-600 bg-blue-50/40 flex items-start justify-between gap-4 relative cursor-pointer transition-all shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center font-bold text-xs shadow-md shrink-0">
                                BCA
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Bank Central Asia (BCA)</span>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="font-bold text-gray-900 text-base font-mono tracking-wide">123-456-7890</span>
                                    <button type="button" onclick="copyToClipboard('123-456-7890', event)" class="text-gray-400 hover:text-blue-600 transition-colors" title="Salin Nomor Rekening">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </div>
                                <span class="text-xs text-gray-500 block mt-1">a.n. Pusat Pelatihan Kompetensi</span>
                            </div>
                        </div>
                        <div class="check-icon text-blue-600 shrink-0 mt-1">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>

                    {{-- Bank Mandiri --}}
                    <div onclick="selectBank(this)" class="bank-card p-5 rounded-2xl border-2 border-gray-200 bg-white hover:border-gray-300 flex items-start justify-between gap-4 relative cursor-pointer transition-all">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-amber-500 text-white rounded-xl flex items-center justify-center font-bold text-xs shadow-md shrink-0">
                                MANDIRI
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Bank Mandiri</span>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="font-bold text-gray-900 text-base font-mono tracking-wide">098-765-4321</span>
                                    <button type="button" onclick="copyToClipboard('098-765-4321', event)" class="text-gray-400 hover:text-blue-600 transition-colors" title="Salin Nomor Rekening">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                </div>
                                <span class="text-xs text-gray-500 block mt-1">a.n. Pusat Pelatihan Kompetensi</span>
                            </div>
                        </div>
                        <div class="check-icon text-blue-600 shrink-0 mt-1 hidden">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Peserta & Program --}}
            <div class="p-5 rounded-2xl bg-gray-50/80 border border-gray-200/80 grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-gray-400 block uppercase tracking-wider mb-0.5">Program Pelatihan</span>
                    <strong class="text-gray-900 text-sm block">{{ $pelatihan->judul }}</strong>
                </div>
                <div>
                    <span class="text-gray-400 block uppercase tracking-wider mb-0.5">Nama Pendaftar</span>
                    <strong class="text-gray-900 text-sm block">{{ $pendaftaran->nama ?? 'Peserta' }}</strong>
                </div>
            </div>

            {{-- Form Upload Bukti Transfer --}}
            <form action="{{ route('user-pelatihan.payment.store', $pendaftaran->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 pt-4 border-t border-gray-100">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Unggah Bukti Pembayaran / Struk Transfer</label>
                    <p class="text-xs text-gray-500 mb-3">Format yang didukung: JPG, JPEG, PNG, atau PDF. Ukuran maksimum 2MB.</p>
                    
                    {{-- Custom Upload Box --}}
                    <div class="relative border-2 border-dashed border-gray-300 rounded-2xl p-6 hover:border-blue-500 transition-colors bg-gray-50/50 text-center cursor-pointer" onclick="document.getElementById('file-upload').click()">
                        <input type="file" name="bukti_pembayaran" id="file-upload" accept=".jpg,.jpeg,.png,.pdf" required class="hidden" onchange="updateFileName(this)">
                        <div id="upload-placeholder" class="space-y-2">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                            </div>
                            <div class="text-xs text-gray-600">
                                <span class="font-semibold text-blue-600 hover:underline">Klik untuk memilih file</span> atau seret file ke sini
                            </div>
                            <p class="text-[11px] text-gray-400">SVG, PNG, JPG, or PDF (maks. 2MB)</p>
                        </div>
                        <div id="file-preview-container" class="hidden items-center justify-center gap-3 text-left">
                            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div class="overflow-hidden">
                                <p id="file-name" class="text-xs font-semibold text-gray-900 truncate"></p>
                                <p class="text-[11px] text-gray-500">File siap diunggah</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-2">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" rows="3" placeholder="Contoh: Transfer dari rekening BCA a.n. Nama Pengirim..."
                        class="w-full px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-gray-50/30"></textarea>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                    <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-semibold text-sm px-8 py-3.5 rounded-xl transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2">
                        <span>Konfirmasi Pembayaran</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function selectBank(element) {
        document.querySelectorAll('.bank-card').forEach(card => {
            card.classList.remove('border-blue-600', 'bg-blue-50/40');
            card.classList.add('border-gray-200', 'bg-white');
            const check = card.querySelector('.check-icon');
            if(check) check.classList.add('hidden');
        });
        
        element.classList.remove('border-gray-200', 'bg-white');
        element.classList.add('border-blue-600', 'bg-blue-50/40');
        const activeCheck = element.querySelector('.check-icon');
        if(activeCheck) activeCheck.classList.remove('hidden');
    }

    function updateFileName(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            document.getElementById('file-name').textContent = fileName;
            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('file-preview-container').classList.remove('hidden');
            document.getElementById('file-preview-container').classList.add('flex');
        }
    }

    function copyToClipboard(text, event) {
        event.stopPropagation();
        navigator.clipboard.writeText(text).then(() => {
            // Optional: Tambahkan feedback kecil misal tooltip/alert ringan
            alert('Nomor rekening berhasil disalin: ' + text);
        });
    }
</script>
@endsection