@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Tambah Role Baru</h2>

        <form action="{{ route('admin.role.store') }}" method="POST">
            @csrf

            <!-- Input Nama Role -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Role</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Contoh: admin, editor, user"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Checklist Permissions -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Permission</label>
                <div class="space-y-4">
                    @foreach($tasks as $task)
                        <div class="border rounded-lg p-4 bg-gray-50/70">
                            <div class="flex justify-between items-center mb-3 border-b pb-2">
                                <h4 class="font-semibold text-gray-600 capitalize">{{ $task->name }}</h4>
                                <button type="button" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 select-all-btn">Pilih Semua</button>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-2">
                                @foreach($task->permissions as $permission)
                                    <label class="inline-flex items-center space-x-2">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                            class="rounded text-indigo-600 focus:ring-indigo-500" {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                        <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('permissions')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a href="{{ route('admin.role.index') }}" class="text-gray-600 hover:text-gray-800 text-sm font-semibold">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none transition duration-200">
                    Simpan Role
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.select-all-btn').forEach(button => {
            button.addEventListener('click', function () {
                const container = this.closest('.border');
                const checkboxes = container.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => checkbox.checked = true);
            });
        });
    });
</script>
@endpush