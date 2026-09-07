<div x-show="cartOpen" x-cloak x-transition
    class="absolute right-0 mt-3 w-80 sm:w-96 rounded-2xl border border-slate-200 bg-white shadow-2xl z-50 overflow-hidden text-slate-800">
    <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
        <div><h3 class="text-sm font-black">Keranjang</h3><p class="text-[11px] text-slate-400">Pilih produk untuk checkout</p></div>
        <span class="rounded-full bg-orange-50 px-2 py-1 text-[10px] font-bold text-orange-600">{{ $cartItems->sum('jumlah') }} item</span>
    </div>
    @if ($cartItems->isNotEmpty())
        <form action="{{ route('pesanan.checkout') }}" method="POST">
            @csrf
            <div class="max-h-72 divide-y divide-slate-100 overflow-y-auto">
                @foreach ($cartItems as $item)
                    <label class="flex cursor-pointer gap-3 px-4 py-3 hover:bg-slate-50">
                        <input type="checkbox" name="item_ids[]" value="{{ $item->id }}" class="mt-1 rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-xs font-bold text-slate-800">{{ $item->produk->nama_produk }}</p>
                            <p class="mt-0.5 text-[11px] text-slate-500">{{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        </div>
                        <span class="text-[11px] font-extrabold text-slate-700">Rp {{ number_format($item->harga * $item->jumlah, 0, ',', '.') }}</span>
                    </label>
                @endforeach
            </div>
            <div class="flex items-center justify-between gap-3 border-t border-slate-100 p-4">
                <a href="{{ route('keranjang.index') }}" class="text-xs font-bold text-slate-500 hover:text-orange-600">Lihat semua</a>
                <button type="submit" class="rounded-xl bg-orange-600 px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-orange-700">Checkout Terpilih</button>
            </div>
        </form>
    @else
        <div class="px-4 py-10 text-center"><i class="fa-solid fa-cart-shopping text-2xl text-slate-300"></i><p class="mt-2 text-xs font-semibold text-slate-500">Keranjang masih kosong.</p></div>
    @endif
</div>
