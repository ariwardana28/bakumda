@extends('layouts.admin')

@section('page-title', 'Tambah Jenis Surat Baru')
@section('page-subtitle', 'Buat jenis surat baru untuk digunakan dalam sistem.')

@section('content')
<div class=" mx-auto">

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-600 dark:text-rose-400 text-xs font-medium space-y-1 shadow-xs">
            <div class="font-bold flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                <span>{{ __('Whoops! Ada beberapa kesalahan pada input Anda.') }}</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.surat-jenis.store') }}" method="POST" class="space-y-6">
        @include('admin.surat_jenis._form')
    </form>
</div>
@endsection