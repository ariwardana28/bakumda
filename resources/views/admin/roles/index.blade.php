@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Role</h2>
        <a href="{{ route('admin.role.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
            + Tambah Role
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200 text-gray-600 uppercase text-xs font-semibold tracking-wider">
                        <th class="py-3 px-4 text-left w-10">#</th>
                        <th class="py-3 px-4 text-left w-44">Nama Role</th>
                        <th class="py-3 px-4 text-left w-48 border-l border-gray-200">Modul / Fungsi</th>
                        <th class="py-3 px-4 text-left border-l border-gray-200">Anggota Permission</th>
                        <th class="py-3 px-4 text-center w-32 border-l border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-xs divide-y divide-gray-200">
                    @forelse($roles as $role)
                        @php
                            // Kelompokkan permission berdasarkan fungsi/modul
                            $groupedPermissions = $role->permissions->groupBy(function($perm) {
                                $parts = explode('-', $perm->name);
                                if (count($parts) > 1) {
                                    array_pop($parts);
                                    return implode('-', $parts);
                                }
                                return 'lainnya';
                            });

                            $totalGroups = max($groupedPermissions->count(), 1);
                        @endphp

                        @forelse($groupedPermissions as $group => $permissions)
                            <tr class="hover:bg-gray-50/80 align-top {{ !$loop->first ? 'border-t border-gray-100' : '' }}">
                                {{-- Kolom #, Role, dan Aksi hanya dirender sekali di baris pertama dengan Rowspan --}}
                                @if($loop->first)
                                    <td rowspan="{{ $totalGroups }}" class="py-3 px-4 text-left font-medium whitespace-nowrap bg-white border-b border-gray-200">
                                        {{ $loop->parent->iteration }}
                                    </td>
                                    <td rowspan="{{ $totalGroups }}" class="py-3 px-4 text-left font-bold text-gray-800 whitespace-nowrap bg-white border-b border-gray-200">
                                        {{ $role->name }}
                                    </td>
                                @endif

                                {{-- TD tersendiri untuk Nama Fungsi/Modul --}}
                                <td class="py-2 px-4 font-bold text-indigo-700 bg-gray-50/50 whitespace-nowrap border-l border-gray-200 uppercase text-[11px]">
                                    {{ str_replace('-', ' ', $group) }}
                                </td>

                                {{-- TD tersendiri untuk Anggota Permission --}}
                                <td class="py-2 px-4 border-l border-gray-200">
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($permissions as $perm)
                                            <span class="bg-blue-50 text-blue-700 border border-blue-100 text-[10px] px-2 py-0.5 rounded font-medium">
                                                {{ $perm->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>

                                @if($loop->first)
                                    <td rowspan="{{ $totalGroups }}" class="py-3 px-4 text-center bg-white border-l border-b border-gray-200 align-middle">
                                        <div class="flex justify-center gap-1.5">
                                            <a href="{{ route('admin.role.edit', $role->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white py-1 px-2.5 rounded text-[11px] font-semibold">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.role.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus role ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-2.5 rounded text-[11px] font-semibold">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            {{-- Jika Role belum memiliki permission sama sekali --}}
                            <tr class="hover:bg-gray-50/80 align-top">
                                <td class="py-3 px-4 text-left font-medium whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 text-left font-bold text-gray-800 whitespace-nowrap">{{ $role->name }}</td>
                                <td class="py-3 px-4 border-l border-gray-200 italic text-gray-400" colspan="2">Tidak ada permission assigned</td>
                                <td class="py-3 px-4 text-center border-l border-gray-200">
                                    <div class="flex justify-center gap-1.5">
                                        <a href="{{ route('admin.role.edit', $role->id) }}" class="bg-amber-500 hover:bg-amber-600 text-white py-1 px-2.5 rounded text-[11px] font-semibold">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.role.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus role ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-2.5 rounded text-[11px] font-semibold">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-400">Belum ada data role.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection