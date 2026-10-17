@csrf

<div>
    <label for="judul" class="mb-1.5 block text-xs font-semibold text-gray-700">Judul (opsional)</label>
    <input id="judul" name="judul" type="text" value="{{ old('judul', $banner->judul ?? '') }}"
        maxlength="255" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
    @error('judul') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="gambar" class="mb-1.5 block text-xs font-semibold text-gray-700">Gambar {{ isset($banner) ? '(opsional)' : '' }}</label>
    @if (isset($banner))
        <img src="{{ Storage::url($banner->gambar) }}" alt="Preview {{ $banner->judul ?? 'banner' }}"
            class="mb-3 aspect-video w-full rounded-xl border border-gray-200 object-cover">
    @endif
    <input id="gambar" name="gambar" type="file" accept="image/jpeg,image/png,image/webp" {{ isset($banner) ? '' : 'required' }}
        class="block w-full rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-700 file:mr-4 file:border-0 file:bg-gray-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-gray-700">
    <p class="mt-1 text-xs text-gray-500">JPG, PNG, atau WebP, maksimal 5 MB.</p>
    @error('gambar') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label for="tautan" class="mb-1.5 block text-xs font-semibold text-gray-700">Tautan tujuan (opsional)</label>
    <input id="tautan" name="tautan" type="text" value="{{ old('tautan', $banner->tautan ?? '') }}"
        maxlength="2048" placeholder="https:// atau /halaman"
        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
    @error('tautan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid gap-5 sm:grid-cols-2">
    <div>
        <label for="urutan" class="mb-1.5 block text-xs font-semibold text-gray-700">Urutan</label>
        <input id="urutan" name="urutan" type="number" min="0" value="{{ old('urutan', $banner->urutan ?? 0) }}"
            class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2.5 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
        @error('urutan') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>
    <div class="flex items-start gap-3 rounded-xl border border-gray-200 bg-gray-50 p-3.5 sm:mt-6">
        <input type="hidden" name="aktif" value="0">
        <input id="aktif" name="aktif" type="checkbox" value="1"
            @checked(old('aktif', $banner->aktif ?? true))
            class="mt-0.5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        <label for="aktif" class="text-xs font-semibold text-gray-700">Tampilkan banner di beranda</label>
    </div>
</div>

<div class="flex justify-end gap-3 border-t border-gray-100 pt-5">
    <a href="{{ route('admin.banner.index') }}" class="rounded-xl bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-200">Batal</a>
    <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
        Simpan Banner
    </button>
</div>