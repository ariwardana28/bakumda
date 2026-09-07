@extends('layouts.admin')

@section('title', 'Keranjang Merchandise')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8"><h1 class="text-3xl font-black text-gray-800">Keranjang Merchandise</h1><p class="mt-1 text-sm text-gray-500">Pantau keranjang belanja seluruh pengguna.</p></div>
        @if (session('success')) <div class="mb-5 rounded-xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">{{ session('success') }}</div> @endif
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="overflow-x-auto"><table class="w-full text-left text-sm"><thead class="bg-gray-50 text-xs uppercase text-gray-500"><tr><th class="px-6 py-4">Pengguna</th><th class="px-6 py-4">Email</th><th class="px-6 py-4">Jumlah Item</th><th class="px-6 py-4">Dibuat</th><th class="px-6 py-4 text-center">Aksi</th></tr></thead>
            <tbody class="divide-y divide-gray-100">@forelse ($keranjangs as $keranjang)<tr><td class="px-6 py-4 font-semibold text-gray-800">{{ $keranjang->user->name }}</td><td class="px-6 py-4 text-gray-500">{{ $keranjang->user->email }}</td><td class="px-6 py-4">{{ $keranjang->items_count }}</td><td class="px-6 py-4 text-gray-500">{{ $keranjang->created_at->format('d M Y H:i') }}</td><td class="px-6 py-4 text-center"><a href="{{ route('admin.keranjang.show', $keranjang) }}" class="inline-flex rounded-lg bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700">Lihat Detail</a></td></tr>@empty<tr><td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada keranjang pengguna.</td></tr>@endforelse</tbody></table></div>
            <div class="p-6">{{ $keranjangs->links() }}</div>
        </div>
    </div>
@endsection
