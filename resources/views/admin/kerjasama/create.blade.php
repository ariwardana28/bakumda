@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Kerjasama</h1>
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.kerjasama.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Judul Kerjasama</label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" required>
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Mitra</label>
                    <input type="text" name="mitra" class="form-control @error('mitra') is-invalid @enderror" value="{{ old('mitra') }}" required>
                    @error('mitra') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="aktif">Aktif</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dokumen (PDF)</label>
                    <input type="file" name="file_dokumen" class="form-control" accept=".pdf">
                </div>
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('admin.kerjasama.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection