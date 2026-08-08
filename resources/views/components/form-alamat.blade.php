@props(['anggota' => null])

<!-- Provinsi -->
<div>
    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
        Provinsi <span class="text-rose-500">*</span>
    </label>
    <select name="provinsi" id="provinsi" required class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('provinsi') border-rose-500 @enderror">
        <option value="">-- Pilih Provinsi --</option>
    </select>
    @error('provinsi') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
</div>

<!-- Kota / Kabupaten -->
<div>
    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
        Kota / Kabupaten <span class="text-rose-500">*</span>
    </label>
    <select name="kota" id="kota" required class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('kota') border-rose-500 @enderror">
      <option value="">-- Pilih Kota/Kabupaten --</option>
    </select>
    @error('kota') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
</div>

<!-- Kecamatan -->
<div>
    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
        Kecamatan <span class="text-rose-500">*</span>
    </label>
    <select name="kecamatan" id="kecamatan" required class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('kecamatan') border-rose-500 @enderror">
      <option value="">-- Pilih Kecamatan --</option>
    </select>
    @error('kecamatan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
</div>

<!-- Kelurahan / Desa -->
<div>
    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
        Kelurahan / Desa <span class="text-rose-500">*</span>
    </label>
    <select name="kelurahan" id="kelurahan" required class="w-full px-4 py-2.5 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/60 text-slate-800 dark:text-slate-100 border border-slate-200 dark:border-slate-800 focus:border-brand-500/50 focus:ring-2 focus:ring-brand-500/10 outline-none transition-all @error('kelurahan') border-rose-500 @enderror">
      <option value="">-- Pilih Kelurahan/Desa --</option>
    </select>
    @error('kelurahan') <span class="text-[10px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
</div>