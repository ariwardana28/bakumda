@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Role</h2>
        <a href="{{ route('admin.role.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            + Tambah Role
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-100 border-b border-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">#</th>
                    <th class="py-3 px-6 text-left">Nama Role</th>
                    <th class="py-3 px-6 text-left">Permissions</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($roles as $role)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6 text-left font-semibold">{{ $role->name }}</td>
                        <td class="py-3 px-6 text-left">
                            <div class="flex flex-wrap gap-1">
                                @forelse($role->permissions as $perm)
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded">
                                        {{ $perm->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 italic">Tidak ada permission</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="py-3 px-6 text-center flex justify-center gap-2">
                            <a href="{{ route('admin.role.edit', $role->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-3 rounded text-xs">
                                Edit
                            </a>
                            <form action="{{ route('admin.role.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus role ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded text-xs">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">Belum ada data role.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection