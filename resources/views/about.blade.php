@extends('layouts.app')

@section('title', 'Tentang Kami, Visi & Misi')
@section('page-subtitle', 'Informasi profil perusahaan, landasan visi, serta misi strategis organisasi.')

@section('content')
    <div class="space-y-6 max-w-7xl mx-auto pb-10" x-data="companyProfileApp()">

        <!-- Navigasi Tab / List Pilihan -->
        <div
            class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-3 shadow-sm no-print">
            <nav class="flex flex-wrap items-center gap-2">
                <button @click="activeTab = 'about'"
                    :class="activeTab === 'about' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/20' :
                        'bg-gray-50 dark:bg-gray-900/50 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900'"
                    class="flex items-center gap-2 px-5 py-3 rounded-2xl text-xs font-extrabold uppercase tracking-wider transition-all duration-200">
                    <i class="fa-solid fa-building text-sm"></i> Tentang Kami
                </button>

                <!-- Tombol Visi & Misi Digabung Menjadi Satu -->
                <button @click="activeTab = 'vision-mission'"
                    :class="activeTab === 'vision-mission' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/20' :
                        'bg-gray-50 dark:bg-gray-900/50 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900'"
                    class="flex items-center gap-2 px-5 py-3 rounded-2xl text-xs font-extrabold uppercase tracking-wider transition-all duration-200">
                    <i class="fa-solid fa-bullseye text-sm"></i> Visi & Misi
                </button>

                <button @click="activeTab = 'values'"
                    :class="activeTab === 'values' ? 'bg-orange-500 text-white shadow-md shadow-orange-500/20' :
                        'bg-gray-50 dark:bg-gray-900/50 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900'"
                    class="flex items-center gap-2 px-5 py-3 rounded-2xl text-xs font-extrabold uppercase tracking-wider transition-all duration-200">
                    <i class="fa-solid fa-award text-sm"></i> Nilai-Nilai Inti
                </button>
            </nav>
        </div>

        <!-- Konten Dinamis Berdasarkan Tab yang Dipilih -->
        <div class="transition-all duration-300">

            <!-- 1. KONTEN: TENTANG KAMI -->
            <div x-show="activeTab === 'about'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                class="space-y-6" style="display: none;">

                <div
                    class="relative overflow-hidden bg-gradient-to-br from-blue-950 via-slate-900 to-indigo-950 rounded-3xl p-8 sm:p-12 text-white shadow-2xl border border-blue-800/50">
                    <div
                        class="absolute -right-10 -bottom-10 w-72 h-72 bg-blue-500/15 rounded-full blur-3xl pointer-events-none">
                    </div>
                    <div
                        class="absolute -left-10 -top-10 w-72 h-72 bg-cyan-500/15 rounded-full blur-3xl pointer-events-none">
                    </div>

                    <div class="relative z-10 max-w-3xl space-y-4">
                        <span
                            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/20 text-blue-300 border border-blue-500/30 text-[11px] font-extrabold uppercase tracking-wider shadow-sm">
                            <i class="fa-solid fa-building text-xs"></i> Profil Korporat & Keunggulan
                        </span>
                        <h1
                            class="text-2xl sm:text-4xl font-black tracking-tight leading-tight bg-gradient-to-r from-white via-blue-100 to-cyan-200 bg-clip-text text-transparent">
                            Membangun Solusi Digital & Layanan Profesional Terpercaya
                        </h1>
                        <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                            Kami adalah entitas profesional yang bergerak di bidang penyediaan solusi teknologi informasi,
                            pengadaan strategis, konstruksi, serta pendampingan administratif dan hukum dengan standar
                            kualitas tertinggi.
                        </p>
                        <p
                            class="text-blue-200/80 text-xs sm:text-sm leading-relaxed border-l-2 border-cyan-400 pl-4 py-1 italic">
                            "Berkomitmen untuk terus menghadirkan inovasi berkelanjutan, efisiensi operasional maksimal,
                            serta kemitraan jangka panjang yang bernilai tambah bagi setiap klien korporat maupun instansi."
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    <div
                        class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 hover:border-blue-500/40 hover:shadow-2xl transition-all space-y-3">
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg shadow-inner">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="font-extrabold text-gray-900 text-base">Integritas & Legalitas</h3>
                        <p class="text-gray-500 text-xs sm:text-sm leading-relaxed">
                            Menjamin kepatuhan penuh terhadap standar operasional prosedur serta regulasi hukum yang berlaku
                            demi keamanan proyek.
                        </p>
                    </div>

                    <div
                        class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 hover:border-cyan-500/40 hover:shadow-2xl transition-all space-y-3">
                        <div
                            class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center font-bold text-lg shadow-inner">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <h3 class="font-extrabold text-gray-900 text-base">Inovasi Berbasis Teknologi</h3>
                        <p class="text-gray-500 text-xs sm:text-sm leading-relaxed">
                            Penerapan teknologi modern untuk mempercepat transformasi digital serta otomatisasi alur kerja
                            bisnis secara optimal.
                        </p>
                    </div>

                    <div
                        class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 hover:border-indigo-500/40 hover:shadow-2xl transition-all space-y-3">
                        <div
                            class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg shadow-inner">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                        <h3 class="font-extrabold text-gray-900 text-base">Mitra Solutif</h3>
                        <p class="text-gray-500 text-xs sm:text-sm leading-relaxed">
                            Siap mendampingi dan memberikan solusi strategis terbaik guna mendukung kesuksesan jangka
                            panjang instansi Anda.
                        </p>
                    </div>
                </div>
            </div>

            <!-- 2. KONTEN: VISI & MISI  -->
            <div x-show="activeTab === 'vision-mission'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                class="space-y-6" style="display: none;">

                <!-- CARD 1: VISI UTAMA ORGANISASI -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm space-y-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-orange-100 dark:bg-orange-950/50 text-orange-600 dark:text-orange-400 flex items-center justify-center text-lg font-bold shadow-inner">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <div>
                            <span
                                class="text-xs font-extrabold text-orange-600 dark:text-orange-400 uppercase tracking-wider">Arah
                                Masa Depan</span>
                            <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white tracking-tight">Visi
                                Utama Organisasi</h2>
                        </div>
                    </div>
                    <div
                        class="p-6 sm:p-8 rounded-2xl bg-orange-50/50 dark:bg-orange-950/20 border border-orange-100 dark:border-orange-900/30">
                        <p
                            class="text-gray-700 dark:text-gray-200 text-base sm:text-lg font-serif italic leading-relaxed text-center">
                            "Menjadi perusahaan terdepan, terpercaya, dan inovatif dalam memberikan solusi layanan
                            profesional, teknologi terpadu, serta keunggulan operasional di tingkat nasional."
                        </p>
                    </div>
                </div>
                <!-- CARD 2: MISI PERUSAHAAN -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm space-y-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-lg font-bold shadow-inner">
                            <i class="fa-solid fa-rocket"></i>
                        </div>
                        <div>
                            <span
                                class="text-xs font-extrabold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">Langkah
                                Strategis</span>
                            <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white tracking-tight">Misi
                                Perusahaan</h2>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 pt-2">
                        <template x-for="(misi, index) in listMisi" :key="index">
                            <div
                                class="flex items-start gap-4 p-4 sm:p-5 rounded-2xl bg-gray-50/80 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/60">
                                <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-sm mt-0.5"
                                    x-text="index + 1"></div>
                                <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 leading-relaxed"
                                    x-text="misi"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- 3. KONTEN: NILAI-NILAI INTI -->
            <div x-show="activeTab === 'values'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                class="space-y-6" style="display: none;">

                <div
                    class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700/80 p-6 sm:p-8 shadow-sm space-y-6">
                    <div class="text-center max-w-2xl mx-auto space-y-2">
                        <span
                            class="text-xs font-extrabold text-orange-600 dark:text-orange-400 uppercase tracking-wider">Prinsip
                            Kerja Kami</span>
                        <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white">Nilai-Nilai Inti (Core
                            Values)</h2>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Fondasi etika dan profesionalisme
                            yang dijunjung tinggi oleh seluruh anggota tim.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                        <div
                            class="p-6 rounded-2xl bg-gray-50/60 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/70 space-y-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-base">Integritas Tinggi</h3>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                Menjunjung kejujuran, transparansi, serta kepatuhan hukum yang ketat dalam setiap aspek
                                layanan dan operasional bisnis.
                            </p>
                        </div>

                        <div
                            class="p-6 rounded-2xl bg-gray-50/60 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/70 space-y-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-sky-100 dark:bg-sky-950/50 text-sky-600 dark:text-sky-400 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-base">Inovatif & Responsif</h3>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                Selalu beradaptasi dengan perkembangan teknologi modern serta tanggap terhadap kebutuhan
                                solusi klien secara cepat dan tepat.
                            </p>
                        </div>

                        <div
                            class="p-6 rounded-2xl bg-gray-50/60 dark:bg-gray-900/40 border border-gray-100 dark:border-gray-700/70 space-y-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-award"></i>
                            </div>
                            <h3 class="font-bold text-gray-900 dark:text-white text-base">Kualitas Profesional</h3>
                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                Berkomitmen memberikan hasil kerja berstandar tinggi yang berorientasi pada kepuasan penuh
                                dan nilai tambah bagi mitra.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('companyProfileApp', () => ({
                activeTab: 'about', // Tab default saat halaman dibuka
                listMisi: [
                    'Menyediakan layanan pengembangan sistem teknologi informasi dan platform digital yang andal serta berdaya saing tinggi.',
                    'Menjalankan tata kelola pengadaan barang/jasa serta konstruksi dengan prinsip efisiensi, akuntabilitas, dan ketepatan waktu.',
                    'Memberikan pendampingan hukum dan penyusunan instrumen administratif yang profesional serta berlandaskan kepastian hukum.',
                    'Membangun kemitraan strategis yang berkelanjutan dan saling menguntungkan dengan seluruh pemangku kepentingan.'
                ]
            }));
        });
    </script>
@endsection
