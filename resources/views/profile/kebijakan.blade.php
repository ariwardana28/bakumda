@extends('layouts.app')

@section('title', 'Kebijakan Privasi')

@section('content')
    <div class="max-w-4xl mx-auto py-8 px-4 space-y-6">

        {{-- Kartu Utama Kebijakan Privasi --}}
        <div
            class="bg-slate-50/70 border border-slate-200/80 rounded-3xl shadow-lg backdrop-blur-sm overflow-hidden relative">

            {{-- Header Background Banner (Navy Blue) --}}
            <div class="h-40 relative flex items-center justify-center px-6 text-center"
                style="background: linear-gradient(135deg, #be123c 0%, #881337 100%);">
                {{-- Dot Pattern Overlay --}}
                <div
                    class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:12px_12px] opacity-10">
                </div>

                <div class="relative z-10 text-white space-y-2">
                    <div
                        class="w-12 h-12 mx-auto rounded-2xl flex items-center justify-center text-lg shadow-md mb-2 bg-white text-rose-700">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-black tracking-tight">Kebijakan Privasi BAKUMDA</h1>
                    <p class="text-xs text-rose-100 font-medium">Tanggal Pembuatan: 17 Agustus 2024 &bull; Direktorat
                        Pimpinan Pusat</p>
                </div>
            </div>

            {{-- Konten Utama --}}
            <div class="p-6 sm:p-10 space-y-8 text-slate-700 text-sm leading-relaxed">

                {{-- 1. Pendahuluan --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-800"></span> 1. Pendahuluan
                    </h3>
                    <div class="space-y-3 text-xs sm:text-sm border-l-2 border-blue-200 pl-3 sm:pl-4">
                        <div class="flex flex-col">
                            <strong class="text-slate-800">1.1. Komitmen Privasi Kami:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Selamat datang di bakumda.or.id (“Platform”), sebuah platform terpadu yang dikembangkan dan
                                dikelola secara resmi oleh bakumda.or.id. Kami sangat menghargai kepercayaan Anda dan
                                berkomitmen penuh untuk melindungi kerahasiaan serta keamanan data pribadi pengguna kami.
                                Selain berfokus pada penggalangan dan pengelolaan kegiatan keorganisasian, bakumda.or.id
                                juga berdedikasi dalam menyelenggarakan berbagai program pelatihan non-akademik guna
                                mendukung peningkatan kapasitas dan keterampilan profesional Anda.
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <strong class="text-slate-800">1.2. Cakupan Kebijakan:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Dokumen Kebijakan Privasi ini dirancang untuk memberikan transparansi mengenai prinsip, tata
                                cara pengumpulan, penggunaan, penyimpanan, serta perlindungan informasi pribadi Anda saat
                                mengakses Platform maupun saat berpartisipasi aktif dalam seluruh ekosistem dan layanan
                                pelatihan yang kami sediakan.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 2. Informasi yang Kami Kumpulkan --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-800"></span> 2. Informasi yang Kami Kumpulkan
                    </h3>
                    <div
                        class="p-3 bg-white/60 border border-slate-200/60 rounded-xl mb-3 text-xs sm:text-sm font-medium text-slate-600">
                        Dalam rangka memberikan layanan yang optimal, aman, dan personal, kami mengumpulkan beberapa
                        kategori informasi berikut:
                    </div>
                    <div class="space-y-3 text-xs sm:text-sm border-l-2 border-blue-200 pl-3 sm:pl-4">
                        <div class="flex flex-col">
                            <strong class="text-slate-800">2.1. Informasi Pribadi:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Informasi spesifik yang Anda berikan secara langsung saat mendaftarkan diri sebagai anggota
                                atau memperbarui profil, mencakup namun tidak terbatas pada: nama lengkap, alamat email
                                aktif, nomor telepon/WhatsApp, identitas resmi, serta rincian kontak lainnya yang
                                memungkinkan kami mengidentifikasi Anda secara pribadi.
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <strong class="text-slate-800">2.2. Data Pendaftaran Pelatihan Non-Akademik:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Saat Anda berpartisipasi dalam program pelatihan non-akademik kami, kami dapat mengumpulkan
                                informasi pendukung tambahan. Data ini meliputi riwayat pendidikan, rekam jejak pelatihan,
                                bidang minat/keahlian, nama instansi atau perusahaan tempat Anda bekerja, dokumen verifikasi
                                identitas, hingga bukti konfirmasi pembayaran pelatihan (jika diperlukan).
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <strong class="text-slate-800">2.3. Informasi Non-Pribadi:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Informasi umum yang tidak dapat mengidentifikasi Anda secara individu, seperti data pola
                                penggunaan Platform, preferensi fitur, statistik navigasi, serta analitik perangkat yang
                                berfungsi membantu tim kami dalam mengevaluasi dan meningkatkan performa platform.
                            </p>
                        </div>
                        <div class="flex flex-col">
                            <strong class="text-slate-800">2.4. Data yang Kami Kumpulkan Secara Otomatis:</strong>
                            <p class="mt-1 pl-4 sm:pl-5 font-semibold text-slate-700 text-justify">
                                Setiap kali Anda berinteraksi dengan Layanan kami, sistem akan merekam dan memproses
                                informasi teknis tertentu secara otomatis.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 3. Bagaimana Kami Menggunakan Informasi Anda --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-800"></span> 3. Bagaimana Kami Menggunakan Informasi Anda
                    </h3>
                    <div class="text-xs sm:text-sm border-l-2 border-blue-200 pl-3 sm:pl-4 space-y-2">
                        <p class="pl-4 font-semibold text-slate-600">Seluruh data dan informasi yang terkumpul diproses
                            untuk tujuan spesifik demi kenyamanan dan kelancaran layanan Anda, di antaranya:</p>
                        <ul class="list-decimal pl-9 space-y-1.5 font-semibold text-slate-700 text-justify">
                            <li>Menyediakan, mengoperasikan, memelihara, dan mengoptimalkan fungsi utama Platform
                                bakumda.or.id.</li>
                            <li>Mengelola seluruh administrasi pendaftaran, memverifikasi status keikutsertaan, serta
                                mendukung kelancaran operasional program pelatihan non-akademik.</li>
                            <li>Memproses penerbitan sertifikat resmi, menyalurkan materi pelatihan, dan menyusun laporan
                                evaluasi hasil belajar bagi para peserta pelatihan.</li>
                            <li>Menyesuaikan pengalaman penggunaan Platform dan menyajikan konten, rekomendasi pelatihan,
                                serta informasi yang relevan dengan minat Anda.</li>
                            <li>Mengirimkan pemberitahuan penting, notifikasi sistem, pembaruan jadwal pelatihan, serta
                                informasi strategis lainnya terkait ekosistem Platform.</li>
                            <li>Melakukan analisis statistik dan riset internal guna mengevaluasi efektivitas program
                                pelatihan serta mengembangkan fitur-fitur baru Platform di masa mendatang.</li>
                        </ul>
                    </div>
                </div>

                {{-- 4. Berbagi Informasi dengan Pihak Ketiga --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-800"></span> 4. Berbagi Informasi dengan Pihak Ketiga
                    </h3>
                    <div class="text-xs sm:text-sm border-l-2 border-blue-200 pl-3 sm:pl-4 space-y-2">
                        <p class="pl-4 font-semibold text-slate-700 text-justify">
                            Kami memegang teguh komitmen untuk menjaga kerahasiaan data Anda. Kami tidak akan pernah
                            menjual, menyewakan, meminjamkan, atau mentransfer informasi pribadi Anda kepada pihak ketiga
                            mana pun tanpa persetujuan eksplisit dari Anda. Pengecualian hanya berlaku dalam kondisi
                            berikut:
                        </p>
                        <ul class="list-disc pl-9 space-y-1.5 font-semibold text-slate-700 text-justify">
                            <li>Diwajibkan atau diizinkan oleh peraturan perundang-undangan yang berlaku atau atas perintah
                                resmi dari pihak berwenang.</li>
                            <li>Pembagian data secara terbatas dan terukur kepada instruktur, fasilitator, atau mitra resmi
                                penyelenggara pelatihan, semata-mata khusus untuk kepentingan kelancaran pelaksanaan program
                                pelatihan yang Anda ikuti.</li>
                        </ul>
                    </div>
                </div>

                {{-- 5. Keamanan Informasi --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-800"></span> 5. Keamanan Informasi
                    </h3>
                    <div class="text-xs sm:text-sm border-l-2 border-blue-200 pl-3 sm:pl-4">
                        <p class="font-semibold text-slate-700 text-justify pl-4">
                            Kami menerapkan standar keamanan terbaik melalui perlindungan fisik, teknis, dan manajerial yang
                            teruji untuk menjaga integritas data Anda. Langkah-langkah perlindungan ini dirancang secara
                            ketat untuk mencegah akses tanpa izin, pemalsuan, kebocoran, pengubahan, maupun penghancuran
                            data pribadi yang tidak sah.
                        </p>
                    </div>
                </div>

                {{-- 6. Perubahan Kebijakan Privasi --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-800"></span> 6. Perubahan Kebijakan Privasi
                    </h3>
                    <div class="text-xs sm:text-sm border-l-2 border-blue-200 pl-3 sm:pl-4">
                        <p class="font-semibold text-slate-700 text-justify pl-4">
                            Kebijakan Privasi ini dapat diperbarui atau disesuaikan dari waktu ke waktu seiring dengan
                            perkembangan layanan dan regulasi yang berlaku. Setiap penyesuaian materi akan kami umumkan
                            secara transparan melalui pemberitahuan di Platform atau via kontak terdaftar Anda. Kami
                            menyarankan Anda untuk memeriksa halaman ini secara berkala.
                        </p>
                    </div>
                </div>

                {{-- 7. Hak Anda --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-800"></span> 7. Hak Anda
                    </h3>
                    <div class="text-xs sm:text-sm border-l-2 border-blue-200 pl-3 sm:pl-4">
                        <p class="font-semibold text-slate-700 text-justify pl-4">
                            Sebagai pemilik data, Anda memiliki hak penuh untuk mengakses, mengoreksi, memperbarui, atau
                            mengajukan permohonan penghapusan informasi pribadi Anda dari sistem kami. Apabila Anda memiliki
                            pertanyaan, kendala, atau permintaan khusus terkait privasi data, silakan hubungi tim layanan
                            kami melalui email: <a href="mailto:admin@bakumda.or.id"
                                class="text-blue-800 hover:underline">admin@bakumda.or.id</a>.
                        </p>
                    </div>
                </div>

                {{-- 8. Penerimaan Kebijakan Privasi --}}
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wide flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-800"></span> 8. Penerimaan Kebijakan Privasi
                    </h3>
                    <div class="text-xs sm:text-sm border-l-2 border-blue-200 pl-3 sm:pl-4">
                        <p class="font-semibold text-slate-700 text-justify pl-4">
                            Dengan mengunduh, menginstal, mengakses Platform bakumda.or.id, dan/atau mendaftarkan diri pada
                            program pelatihan non-akademik kami, Anda menyatakan telah membaca, memahami, dan menyetujui
                            seluruh ketentuan yang tercantum dalam Kebijakan Privasi ini. Terima kasih atas kepercayaan Anda
                            kepada bakumda.or.id.
                        </p>
                    </div>
                </div>

                {{-- Footer Info / Direktur --}}
                <div class="pt-4 text-center space-y-1 text-xs text-slate-500 font-semibold border-t border-slate-200/60">
                    <p class="tracking-wider uppercase">DIREKTORAT PIMPINAN PUSAT BAKUMDA</p>
                    <p>Tanggal Pembuatan: 17 Agustus 2024</p>
                </div>

                {{-- Tombol Kembali / Navigasi Bawah --}}
                <div class="pt-4 flex items-center justify-between">
                    <a href="javascript:history.back()"
                        class="py-2.5 px-5 rounded-2xl bg-white hover:bg-slate-100 text-slate-700 font-semibold text-xs uppercase tracking-wider transition flex items-center gap-2 border border-slate-200 shadow-sm">
                        <i class="fa-solid fa-arrow-left text-blue-800"></i> <span>Kembali</span>
                    </a>
                    <span class="text-[11px] text-slate-400 font-medium">BAKUMDA &copy; 2024</span>
                </div>

            </div>
        </div>
    </div>
@endsection
