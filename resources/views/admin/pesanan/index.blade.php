@extends('layouts.admin')

@section('title', 'Pesanan Merchandise')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-black text-gray-800">Pesanan Merchandise</h1>
            <p class="mt-1 text-sm text-gray-500">Verifikasi pembayaran dan proses status pesanan.</p>
        </div>
        <div class="mb-6 flex gap-2 overflow-x-auto pb-2">
            @foreach (['' => 'Semua', 'Menunggu Pembayaran' => 'Belum Bayar', 'Menunggu Verifikasi' => 'Menunggu Proses', 'Diproses' => 'Diproses', 'Dikemas' => 'Dikemas', 'Dikirim' => 'Dikirim', 'Selesai' => 'Selesai', 'Batal' => 'Batal'] as $value => $label)
                <a href="{{ route('admin.pesanan.index', $value ? ['status' => $value] : []) }}"
                    class="shrink-0 rounded-full px-4 py-2 text-xs font-bold {{ $status === $value ? 'bg-blue-600 text-white' : 'bg-white text-gray-500 border border-gray-200 hover:border-blue-300' }}">{{ $label }}</a>
            @endforeach
        </div>
        @if (session('success'))
            <div class="mb-5 rounded-xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-700">{{ session('success') }}
            </div>
        @endif
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-6 py-4">Pesanan</th>
                            <th class="px-6 py-4">Pengguna</th>
                            <th class="px-6 py-4">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($pesanans as $pesanan)
                            <tr>
                                <td class="px-6 py-4 font-bold text-gray-800">#{{ $pesanan->id }}<span
                                        class="block text-xs font-normal text-gray-400">{{ $pesanan->items_count }} item ·
                                        {{ $pesanan->created_at->format('d M Y H:i') }}</span></td>
                                <td class="px-6 py-4">{{ $pesanan->user->name }}<span
                                        class="block text-xs text-gray-400">{{ $pesanan->user->email }}</span></td>
                                <td class="px-6 py-4 font-bold">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4"><span
                                        class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">{{ $pesanan->status }}</span>
                                </td>
                                <td class="px-6 py-4 text-center"><a href="{{ route('admin.pesanan.show', $pesanan) }}"
                                        class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-bold text-blue-700">Kelola</a>
                                </td>
                        </tr>@empty<tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">Belum ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6">{{ $pesanans->links() }}</div>
        </div>
    </div>
@endsection
