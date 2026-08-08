@extends('layouts.admin')

@section('title', 'Detail User: ' . $user->name)

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 tracking-tight">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 mt-1">Detail informasi dan role untuk pengguna.</p>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.users.edit', $user) }}" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl shadow-lg shadow-amber-200 transition duration-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Kelola Role
        </a>
    </div>

    {{-- User Details Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Detail Item: Nama --}}
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Lengkap</span>
                    <span class="text-base text-gray-800 font-medium mt-1">{{ $user->name }}</span>
                </div>

                {{-- Detail Item: Email --}}
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Alamat Email</span>
                    <span class="text-base text-gray-800 font-medium mt-1">{{ $user->email }}</span>
                </div>

                {{-- Detail Item: Terdaftar Sejak --}}
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Terdaftar Sejak</span>
                    <span class="text-base text-gray-800 font-medium mt-1">{{ $user->created_at->isoFormat('D MMMM YYYY') }}</span>
                </div>
            </div>
        </div>
        <div class="bg-gray-50/70 border-t border-gray-100 px-6 sm:px-8 py-4">
            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Role yang Dimiliki</h3>
            <div class="flex flex-wrap gap-2 mt-3">
                @forelse($user->roles as $role)
                    <span class="bg-indigo-100 text-indigo-800 text-sm font-medium px-4 py-1.5 rounded-full">
                        {{ $role->name }}
                    </span>
                @empty
                    <span class="text-sm text-gray-500 italic">Pengguna ini belum memiliki role.</span>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection