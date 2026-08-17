@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 space-y-6">

        {{-- Kartu Utama Aturan Penggunaan --}}
        <div
            class="bg-slate-50/70 border border-slate-200/80 rounded-3xl shadow-lg backdrop-blur-sm overflow-hidden relative">

            {{-- Header Background Banner (Biru Gelap Elegan) --}}
            <div class="h-40 relative flex items-center justify-center px-6 text-center"
                style="background: linear-gradient(135deg, #be123c 0%, #881337 100%);">
                <div
                    class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:12px_12px] opacity-10">
                </div>
                <div class="relative z-10 text-white space-y-2">
                    <div
                        class="w-12 h-12 mx-auto rounded-2xl flex items-center justify-center text-lg shadow-md mb-2 text-rose-700 bg-white">
                        <i class="fa-solid fa-gavel"></i>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black tracking-tight">Aturan Penggunaan Platform BAKUMDA</h1>
                    <p class="text-xs text-rose-100 font-medium">Tanggal Berlaku: 17 Agustus 2024 &bull; Penerbit:
                        Direktorat Pimpinan Pusat BAKUMDA</p>
                </div>
            </div>

            {{-- Konten Utama --}}
            <div class="p-6 sm:p-10 space-y-6 text-slate-700 text-sm leading-relaxed">

                {{-- Pengantar --}}
                <div class="p-4 rounded-2xl bg-white/80 border border-slate-200/70 shadow-sm text-slate-600 text-justify">
                    Selamat datang di <strong class="text-slate-800">bakumda.or.id</strong> (“Platform”). Aturan Penggunaan
                    ini mengatur akses dan penggunaan Anda atas Platform, layanan keorganisasian, serta program pelatihan
                    non-akademik yang disediakan oleh BAKUMDA.
                </div>

                {{-- 1. Ketentuan Umum --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-600"></span> 1. Ketentuan Umum & Penerimaan Syarat
                    </h3>
                    <div class="space-y-3 text-xs sm:text-sm border-l-2 border-slate-200 pl-3 sm:pl-4">
                        <div class="flex flex-col">
                            <strong class="text-slate-800">1.1. Persetujuan Bindis:</strong>
                            <p
                                class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify border-l-2 border-transparent">
                                Dengan mengunduh, mendaftar, mengakses, atau menggunakan Platform, Anda menyatakan telah
                                membaca, memahami, dan menyetujui untuk terikat oleh seluruh ketentuan dalam Aturan
                                Penggunaan ini serta Kebijakan Privasi kami.
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <strong class="text-slate-800">1.2. Perubahan Ketentuan:</strong>
                            <p
                                class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify border-l-2 border-transparent">
                                BAKUMDA berhak mengubah atau memperbarui Aturan Penggunaan ini sewaktu-waktu. Perubahan akan
                                diumumkan melalui Platform atau email terdaftar.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 2. Pendaftaran Akun --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-600"></span> 2. Pendaftaran Akun & Kelayakan
                    </h3>
                    <div class="space-y-3 text-xs sm:text-sm border-l-2 border-slate-200 pl-3 sm:pl-4">
                        <div class="flex flex-col">
                            <strong class="text-slate-800">2.1. Akurasi Data:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Anda wajib memberikan data pribadi dan dokumen pendukung yang akurat, benar, dan terbaru
                                saat mendaftar sebagai anggota maupun peserta pelatihan.
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <strong class="text-slate-800">2.2. Keamanan Akun:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Anda bertanggung jawab penuh untuk menjaga kerahasiaan informasi akun dan kredensial login.
                                Seluruh aktivitas yang terjadi di bawah akun Anda menjadi tanggung jawab Anda sepenuhnya.
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <strong class="text-slate-800">2.3. Verifikasi Identitas:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                BAKUMDA berhak melakukan verifikasi identitas atau menolak pendaftaran jika ditemukan data
                                yang tidak sah atau memalsukan identitas.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 3. Keikutsertaan Pelatihan --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-600"></span> 3. Keikutsertaan Pelatihan Non-Akademik
                    </h3>
                    <div class="space-y-3 text-xs sm:text-sm border-l-2 border-slate-200 pl-3 sm:pl-4">
                        <div class="flex flex-col">
                            <strong class="text-slate-800">3.1. Pembayaran & Konfirmasi:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Pelatihan yang memerlukan biaya wajib diselesaikan proses pembayarannya sesuai dengan
                                ketentuan dan bukti konfirmasi resmi sebelum masa pendaftaran ditutup.
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <strong class="text-slate-800">3.2. Penerbitan Sertifikat:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Sertifikat resmi hanya akan diterbitkan bagi peserta yang memenuhi kriteria kelulusan,
                                kehadiran, serta evaluasi hasil belajar yang ditetapkan oleh instruktur/fasilitator.
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <strong class="text-slate-800">3.3. Tata Tertib Pelatihan:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Peserta wajib menjaga etika, kesopanan, dan profesionalisme selama mengikuti seluruh sesi
                                pelatihan, baik secara daring maupun luring.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 4. Hak Kekayaan Intelektual --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-600"></span> 4. Hak Kekayaan Intelektual (HKI)
                    </h3>
                    <div class="space-y-3 text-xs sm:text-sm border-l-2 border-slate-200 pl-3 sm:pl-4">
                        <div class="flex flex-col">
                            <strong class="text-slate-800">4.1. Kepemilikan Materi:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Seluruh konten, materi pelatihan, modul, logo, desain, dan infrastruktur perangkat lunak
                                pada Platform adalah milik sah BAKUMDA atau lisensor resminya.
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <strong class="text-slate-800">4.2. Pembatasan Penggunaan:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Pengguna dilarang keras menggandakan, mendistribusikan ulang, menjual, mengubah, atau
                                mempublikasikan kembali materi pelatihan tanpa izin tertulis dari Pimpinan Pusat BAKUMDA.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 5. Larangan Penggunaan --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-600"></span> 5. Larangan Penggunaan Platform
                    </h3>
                    <div class="text-xs sm:text-sm border-l-2 border-slate-200 pl-3 sm:pl-4">
                        <p class="mb-2 text-slate-600 font-semibold pl-4">Pengguna dilarang untuk:</p>
                        <ul class="list-disc pl-9 space-y-1.5 text-slate-700 font-semibold text-justify">
                            <li>Menggunakan Platform untuk tindakan ilegal, penipuan, atau melanggar hukum yang berlaku di
                                Republik Indonesia.</li>
                            <li>Mengunggah konten yang mengandung unsur SARA, ujaran kebencian, pornografi, atau merusak
                                nama baik BAKUMDA.</li>
                            <li>Meretas, merusak, atau mengganggu stabilitas teknis dan sistem keamanan Platform.</li>
                        </ul>
                    </div>
                </div>

                {{-- 6. Pembatasan Tanggung Jawab --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-600"></span> 6. Pembatasan Tanggung Jawab
                    </h3>
                    <div class="space-y-3 text-xs sm:text-sm border-l-2 border-slate-200 pl-3 sm:pl-4">
                        <div class="flex flex-col">
                            <strong class="text-slate-800">6.1. Ketersediaan Layanan:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                BAKUMDA berupaya menjaga kelancaran operasional Platform, namun tidak menjamin Platform akan
                                senantiasa bebas dari gangguan teknis atau perawatan berkala.
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <strong class="text-slate-800">6.2. Penggunaan Informasi:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Risiko yang timbul akibat penyalahgunaan akun akibat kelalaian pengguna dalam menjaga
                                kerahasiaan data pribadi berada di luar tanggung jawab BAKUMDA.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 7. Penangguhan & Pemutusan Akun --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-600"></span> 7. Penangguhan & Pemutusan Akun
                    </h3>
                    <div class="text-xs sm:text-sm border-l-2 border-slate-200 pl-3 sm:pl-4">
                        <p class="font-semibold text-slate-700 text-justify pl-4">
                            BAKUMDA berhak membatasi, menangguhkan, atau menghentikan akses akun Anda secara sepihak jika
                            ditemukan pelanggaran terhadap Aturan Penggunaan ini atau Kebijakan Privasi yang berlaku.
                        </p>
                    </div>
                </div>

                {{-- 8. Hukum yang Mengatur & Kontak --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-rose-600"></span> 8. Hukum yang Mengatur & Kontak
                    </h3>
                    <div class="space-y-3 text-xs sm:text-sm border-l-2 border-slate-200 pl-3 sm:pl-4">
                        <div class="flex flex-col">
                            <strong class="text-slate-800">8.1. Hukum:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Aturan Penggunaan ini diatur dan ditafsirkan berdasarkan hukum yang berlaku di Republik
                                Indonesia.
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <strong class="text-slate-800">8.2. Kontak:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Apabila Anda memiliki pertanyaan terkait Aturan Penggunaan ini, silakan hubungi kami melalui
                                email: <a href="mailto:admin@bakumda.or.id"
                                    class="text-rose-600 hover:underline">admin@bakumda.or.id</a>.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Tombol Kembali / Navigasi Bawah --}}
                <div class="pt-6 border-t border-slate-200/60 flex items-center justify-between">
                    <a href="javascript:history.back()"
                        class="py-2.5 px-5 rounded-2xl bg-white hover:bg-slate-100 text-slate-700 font-semibold text-xs uppercase tracking-wider transition flex items-center gap-2 border border-slate-200 shadow-sm">
                        <i class="fa-solid fa-arrow-left text-rose-600"></i> <span>Kembali</span>
                    </a>
                    <span class="text-[11px] text-slate-400 font-medium">BAKUMDA &copy; 2024</span>
                </div>

            </div>
        </div>
    </div>
@endsection
