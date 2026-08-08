@extends('layouts.admin')

@section('title', 'Edit Task Permission')

@section('content')
<div class="max-w-xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Edit Task: <span class="capitalize font-mono">{{ str_replace('-', ' ', $taskName) }}</span></h2>
        <p class="text-sm text-gray-500 mb-6">Ubah, tambah, atau hapus daftar aksi untuk modul ini. Menyimpan perubahan akan menghapus semua permission lama untuk task ini dan membuat yang baru sesuai daftar di bawah.</p>

        <form action="{{ route('admin.permissions.updateTask', ['task_name' => $taskName]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Daftar Aksi Permission</label>
                
                <!-- Container untuk input aksi dinamis -->
                <div id="actions-container" class="space-y-3 mb-3">
                    @php
                        // Prioritaskan old input, lalu data dari controller
                        $currentActions = old('actions_list', $actions ?? []);
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
                        {{-- Jika tidak ada action, tampilkan satu field kosong --}}
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
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Script untuk menambah/menghapus field aksi (sama seperti di create.blade.php)
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('actions-container');
        const addButton = document.getElementById('add-action-btn');

        function updateRemoveButtons() {
            const items = container.querySelectorAll('.action-item');
            items.forEach(item => {
                const btn = item.querySelector('.remove-action');
                btn.disabled = items.length <= 1;
                btn.classList.toggle('opacity-50', items.length <= 1);
                btn.classList.toggle('cursor-not-allowed', items.length <= 1);
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
            const removeBtn = e.target.closest('.remove-action');
            if (removeBtn && !removeBtn.disabled) {
                removeBtn.closest('.action-item').remove();
                updateRemoveButtons();
            }
        });

        updateRemoveButtons(); // Initial check
    });
</script>
@endpush
@endsection