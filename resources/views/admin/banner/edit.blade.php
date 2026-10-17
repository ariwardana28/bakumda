@extends('layouts.admin')

@section('content')
    <div class="container mx-auto max-w-3xl space-y-6">
        <div>
            <a href="{{ route('admin.banner.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">&larr; Kembali ke Banner</a>
            <h1 class="mt-3 text-2xl font-bold text-gray-900">Edit Banner</h1>
        </div>

        <form action="{{ route('admin.banner.update', $banner) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-7">
            @method('PUT')
            @include('admin.banner._form')
        </form>
    </div>
@endsection