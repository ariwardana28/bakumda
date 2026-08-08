@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Permission</h2>
        <a href="{{ route('admin.permissions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
            + Tambah Permission
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="divide-y divide-gray-200">
            @forelse($tasks as $task)
                <div class="p-4 flex justify-between items-center">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        <span class="text-md font-medium text-gray-800 capitalize">{{ str_replace('-', ' ', $task->name) }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.permissions.editTask', ['task_name' => $task->name]) }}" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 text-xs font-semibold py-1 px-3 rounded-md flex items-center gap-1" title="Edit Task">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.5L14.732 3.732z"></path></svg>
                            <span>Edit</span>
                        </a>
                        <form action="{{ route('admin.permissions.destroyTask', ['task_name' => $task->name]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus task \'{{ $task->name }}\' beserta semua permission-nya? Aksi ini tidak dapat dibatalkan.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-100 hover:bg-red-200 text-red-800 text-xs font-semibold py-1 px-3 rounded-md flex items-center gap-1" title="Hapus Task">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                <span>Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <p class="text-gray-500">Belum ada data permission.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection