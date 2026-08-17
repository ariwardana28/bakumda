{{-- 
    DESKTOP SIDEBAR 
    - Muncul otomatis pada layar 'xl' (1280px) ke atas.
--}}
<aside class="hidden xl:flex w-72 bg-slate-950 border-r border-slate-800 flex-col justify-between p-6 shrink-0">
    <div>
        <!-- Brand Logo -->
        <div class="flex items-center space-x-3 mb-8">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-blue-700 to-amber-500 flex items-center justify-center text-white font-black text-lg shadow-lg">
                <i class="fa-solid fa-scale-balanced"></i>
            </div>
            <div>
                <span class="font-extrabold text-white text-sm tracking-wide block">BAKUMDA</span>
                <span class="text-[10px] text-amber-400 font-bold uppercase tracking-widest">Portal Advokasi</span>
            </div>
        </div>

        <!-- Sidebar Navigation Links -->
        <nav class="space-y-1.5 text-sm font-semibold">
            <a href="javascript:void(0)" onclick="showAlert('Nav: Beranda')" class="flex items-center space-x-3 px-3.5 py-3 rounded-xl bg-blue-600 text-white shadow-md shadow-blue-600/30">
                <i class="fa-solid fa-house w-5 text-center"></i>
                <span>Beranda Utama</span>
            </a>
            <a href="javascript:void(0)" onclick="showAlert('Nav: Konsultasi')" class="flex items-center space-x-3 px-3.5 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900 transition">
                <i class="fa-solid fa-comments w-5 text-center"></i>
                <span>Konsultasi & Pengaduan</span>
            </a>
            <a href="javascript:void(0)" onclick="showAlert('Nav: Perundangan')" class="flex items-center space-x-3 px-3.5 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900 transition">
                <i class="fa-solid fa-book-bookmark w-5 text-center"></i>
                <span>Database UU & Perda</span>
            </a>
            <a href="javascript:void(0)" onclick="showAlert('Nav: Keanggotaan')" class="flex items-center space-x-3 px-3.5 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900 transition">
                <i class="fa-solid fa-id-card w-5 text-center"></i>
                <span>Keanggotaan Advokat</span>
            </a>
            <a href="javascript:void(0)" onclick="showAlert('Nav: Berita')" class="flex items-center space-x-3 px-3.5 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900 transition">
                <i class="fa-solid fa-newspaper w-5 text-center"></i>
                <span>Artikel & Putusan</span>
            </a>
            <a href="javascript:void(0)" onclick="showAlert('Nav: Posbakum')" class="flex items-center space-x-3 px-3.5 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900 transition">
                <i class="fa-solid fa-building-columns w-5 text-center"></i>
                <span>Posbakum Daerah</span>
            </a>
            <a href="javascript:void(0)" onclick="showAlert('Nav: Pengaturan')" class="flex items-center space-x-3 px-3.5 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-slate-900 transition">
                <i class="fa-solid fa-gear w-5 text-center"></i>
                <span>Pengaturan Akun</span>
            </a>
        </nav>
    </div>

    <!-- Sidebar User Profile Footer -->
    <div class="pt-4 border-t border-slate-800 flex items-center space-x-3">
        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-700 to-amber-500 flex items-center justify-center text-white font-black text-xs">A</div>
        <div class="min-w-0 flex-1">
            <h4 class="text-xs font-bold text-white truncate">DR. ARIS MUNANDAR</h4>
            <p class="text-[10px] text-slate-400 truncate">KTA: 8821 5094</p>
        </div>
        <button onclick="showAlert('Logout')" class="text-slate-400 hover:text-red-500 transition"><i class="fa-solid fa-right-from-bracket text-sm"></i></button>
    </div>
</aside>