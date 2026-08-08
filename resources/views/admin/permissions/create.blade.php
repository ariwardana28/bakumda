@extends('layouts.admin')

@section('title', 'Tambah Permission Baru')

@section('content')
<div class="max-w-xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Tambah Permission Baru</h2>
        <p class="text-sm text-gray-500 mb-6">Buat satu set permission untuk sebuah modul/task sekaligus dengan menambahkan aksi yang diinginkan.</p>

        <form action="{{ route('admin.permissions.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="task_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Modul / Task</label>
                <input type="text" name="task_name" id="task_name" value="{{ old('task_name') }}" placeholder="Gunakan huruf kecil tanpa spasi, cth: artikel, galeri-foto"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('task_name') border-red-500 @enderror" required>
                @error('task_name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Daftar Aksi Permission</label>
                
                <!-- Container untuk input aksi dinamis -->
                <div id="actions-container" class="space-y-3 mb-3">
                    @php
                        // Prioritaskan old input, atau default jika tidak ada
                        $currentActions = old('actions_list', ['view', 'create', 'edit', 'delete']);
                    @endphp
                    @forelse($currentActions as $index => $action)
                        <div class="flex items-center gap-2 action-item">
                            <input type="text" name="actions_list[]" value="{{ $action }}" placeholder="cth: view, create, approve"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <button type="button" class="remove-action bg-red-100 text-red-600 hover:bg-red-200 px-3 py-2 rounded font-semibold transition duration-200 {{ count($currentActions) <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ count($currentActions) <= 1 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    @empty
                        {{-- Jika tidak ada action (misal task baru dibuat tanpa action), tampilkan satu field kosong --}}
                        <div class="flex items-center gap-2 action-item">
                            <input type="text" name="actions_list[]" value="" placeholder="cth: view, create, approve"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <button type="button" class="remove-action bg-red-100 text-red-600 hover:bg-red-200 px-3 py-2 rounded font-semibold transition duration-200 opacity-50 cursor-not-allowed" disabled>
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    @endforelse
                </div>

                <!-- Tombol Tambah Aksi -->
                <button type="button" id="add-action-btn" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold py-2 px-3 rounded-lg border border-gray-300 transition duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Aksi Lain
                </button>

                @error('actions_list')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
                @error('actions_list.*')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.permissions.index') }}" class="text-gray-600 hover:text-gray-800 text-sm font-semibold">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none transition duration-200">
                    Simpan Permission
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('actions-container');
        const addButton = document.getElementById('add-action-btn');

        function updateRemoveButtons() {
            const items = container.querySelectorAll('.action-item');
            items.forEach(item => {
                const btn = item.querySelector('.remove-action');
                if (items.length <= 1) {
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                    btn.disabled = true;
                } else {
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    btn.disabled = false;
                }
            });
        }

        addButton.addEventListener('click', function () {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 action-item';
            div.innerHTML = `
                <input type="text" name="actions_list[]" placeholder="cth: approve, export"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <button type="button" class="remove-action bg-red-100 text-red-600 hover:bg-red-200 px-3 py-2 rounded font-semibold transition duration-200">
                    <i class="fa-solid fa-trash"></i>
                </button>
            `;
            container.appendChild(div);
            updateRemoveButtons();
        });

        container.addEventListener('click', function (e) {
            if (e.target.closest('.remove-action')) {
                const item = e.target.closest('.action-item');
                if (container.querySelectorAll('.action-item').length > 1) {
                    item.remove();
                    updateRemoveButtons();
                }
            }
        });
    });
</script>
@endpush
@endsection
