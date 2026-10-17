@extends('layouts.admin')

@section('content')
    <div class="container mx-auto space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Banner Beranda</h1>
                <p class="mt-1 text-sm text-gray-500">Atur gambar yang tampil pada slider beranda.</p>
            </div>
            @can('pelatihan-create')
                <a href="{{ route('admin.banner.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                    <i class="fa-solid fa-plus"></i>
                    Tambah Banner
                </a>
            @endcan
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-gray-100 p-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-sm font-semibold text-gray-700">{{ $banners->total() }} banner</p>
                <form action="{{ route('admin.banner.index') }}" method="GET" class="w-full sm:w-72">
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Cari judul banner"
                        class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-2 text-sm text-gray-800 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Gambar</th>
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Urutan</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse ($banners as $banner)
                            <tr>
                                <td class="w-40 px-4 py-3">
                                    <img src="{{ Storage::url($banner->gambar) }}" alt="{{ $banner->judul ?? 'Banner' }}"
                                        class="h-16 w-28 rounded-lg border border-gray-200 object-cover">
                                </td>
                                <td class="px-4 py-3 font-medium">{{ $banner->judul ?: 'Tanpa judul' }}</td>
                                <td class="px-4 py-3">{{ $banner->urutan }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $banner->aktif ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $banner->aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        @can('pelatihan-edit')
                                            <a href="{{ route('admin.banner.edit', $banner) }}"
                                                class="rounded-lg bg-amber-50 px-3 py-2 text-xs font-semibold text-amber-700 hover:bg-amber-100">
                                                Edit
                                            </a>
                                        @endcan
                                        @can('pelatihan-delete')
                                            <form action="{{ route('admin.banner.destroy', $banner) }}" method="POST"
                                                onsubmit="return confirm('Hapus banner ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-12 text-center text-sm text-gray-500">Belum ada banner.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($banners->hasPages())
                <div class="border-t border-gray-100 p-4">{{ $banners->links() }}</div>
            @endif
        </div>
    </div>
@endsection