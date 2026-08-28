@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Kerjasama</h1>
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.kerjasama.update', $kerjasama->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Judul Kerjasama</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $kerjasama->judul) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Mitra</label>
                    <input type="text" name="mitra" class="form-control" value="{{ old('mitra', $kerjasama->mitra) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $kerjasama->deskripsi) }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai', $kerjasama->tanggal_mulai) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai', $kerjasama->tanggal_selesai) }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="aktif" {{ $kerjasama->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ $kerjasama->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $kerjasama->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dokumen Baru (Opsional PDF)</label>
                    <input type="file" name="file_dokumen" class="form-control" accept=".pdf">
                    @if($kerjasama->file_dokumen)
                        <small class="text-muted">File saat ini: <a href="{{ asset('storage/' . $kerjasama->file_dokumen) }}" target="_blank">Lihat PDF</a></small>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="{{ route('admin.kerjasama.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection