@extends('layouts.app')

@section('title', 'Manajemen Referral')

@section('content')
    <div class="px-3 md:px-8 py-4 md:py-6 space-y-6 md:space-y-8 max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-850 tracking-tight">Program Referral</h1>
                <p class="text-sm text-gray-500 mt-1">Pantau dan kelola aktivitas referral pengguna.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.referral.claims') }}"
                    class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 font-semibold px-4 py-2.5 rounded-xl text-sm transition-colors">
                    Lihat Klaim
                </a>
                <a href="#"
                    class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-lg shadow-orange-200 text-sm transition-colors">
                    Pengaturan
                </a>
            </div>
        </div>

        <!-- Session Alert -->
        @if (session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-400 text-emerald-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">Sukses</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-blue-50 rounded-xl text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Total Pengguna</p>
                    <p class="text-2xl font-bold text-gray-800">1,234</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Total Komisi</p>
                    <p class="text-2xl font-bold text-gray-800">Rp 12.5Jt</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Klaim Pending</p>
                    <p class="text-2xl font-bold text-gray-800">5</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="p-3 bg-red-50 rounded-xl text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase">Referral Rate</p>
                    <p class="text-2xl font-bold text-gray-800">10%</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <!-- Card Header -->
            <div class="p-5 md:p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-orange-50 rounded-xl text-orange-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Data Referral Pengguna</h2>
                        <p class="text-xs text-gray-400">Daftar pengguna dengan kode referral mereka.</p>
                    </div>
                </div>
                <form action="{{ route('admin.referral.index') }}" method="GET" class="w-full md:w-72">
                    <div class="relative">
                        <input type="text" name="search"
                            class="w-full px-4 py-2.5 pl-10 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 outline-none"
                            placeholder="Cari pengguna atau kode..." value="{{ request('search') }}">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/70 border-b border-gray-100 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-6">Pengguna</th>
                            <th class="py-3 px-6">Kode Referral</th>
                            <th class="py-3 px-6">Jumlah Referral</th>
                            <th class="py-3 px-6">Total Komisi</th>
                            <th class="py-3 px-6">Tanggal Bergabung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        {{-- @forelse($users as $user) --}}
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="py-4 px-6">
                                <div class="font-semibold text-gray-800">Contoh Pengguna</div>
                                <div class="text-xs text-gray-500">contoh@email.com</div>
                            </td>
                            <td class="py-4 px-6 font-mono text-gray-600 font-medium">CONTOH123</td>
                            <td class="py-4 px-6 font-medium text-gray-800">15</td>
                            <td class="py-4 px-6 font-semibold text-emerald-600">Rp 750.000</td>
                            <td class="py-4 px-6 text-gray-500">12 Jan 2024</td>
                        </tr>
                        {{-- @empty --}}
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-400 text-sm italic">
                                Tidak ada data referral untuk ditampilkan.
                            </td>
                        </tr>
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            {{-- @if ($users->hasPages()) --}}
                <div class="p-5 border-t border-gray-100">
                    {{-- {{ $users->links() }} --}}
                    <p class="text-sm text-gray-500">Menampilkan contoh data.</p>
                </div>
            {{-- @endif --}}
        </div>
    </div>
@endsection