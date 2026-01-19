@extends('layouts.admin')

@section('title', 'Edit Buku: ' . $book->title)

@section('content')

<div class="row justify-content-center">
    <div class="col-md-10">
        {{-- TOMBOL KEMBALI --}}
        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary mb-3 border-0 shadow-sm bg-white">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>

        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            {{-- HEADER KARTU --}}
            <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="p-2 rounded-3 me-3" style="background-color: #fef3c7;">
                        <i class="bi bi-pencil-square fs-4" style="color: #92400e;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: #1e3a8a;">Edit Data Buku</h5>
                        <small class="text-muted">Perbarui informasi buku secara berkala untuk akurasi data.</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.books.update', $book) }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- KOLOM KIRI: INFO UTAMA --}}
                        <div class="col-md-7">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Judul Buku</label>
                                <input name="title" value="{{ old('title', $book->title) }}" 
                                       class="form-control @error('title') is-invalid @enderror">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Penulis</label>
                                <input name="author" value="{{ old('author', $book->author) }}" 
                                       class="form-control @error('author') is-invalid @enderror">
                                @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary small">Kategori</label>
                                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary small">Stok</label>
                                    <input type="number" name="stock" value="{{ old('stock', $book->stock) }}" 
                                           class="form-control @error('stock') is-invalid @enderror">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Deskripsi</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                          rows="5">{{ old('description', $book->description) }}</textarea>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: COVER --}}
                        <div class="col-md-5">
                            <label class="form-label fw-semibold text-secondary small d-block">Cover Buku</label>
                            
                            {{-- Pratinjau Cover Lama --}}
                            <div class="mb-3 p-2 border rounded-3 bg-light text-center">
                                @if($book->cover_path)
                                    <img src="{{ asset('storage/' . $book->cover_path) }}" 
                                         class="img-fluid rounded shadow-sm" 
                                         style="max-height: 250px; object-fit: cover;">
                                    <p class="mt-2 mb-0 small text-muted">Cover Saat Ini</p>
                                @else
                                    <div class="py-5 text-muted italic">Tidak ada cover lama</div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Ganti Cover Baru</label>
                                <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror">
                                <small class="text-muted italic d-block mt-1">Biarkan kosong jika tidak ingin mengganti cover.</small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-10">

                    {{-- TOMBOL AKSI --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.books.index') }}" class="btn btn-light px-4 fw-semibold text-secondary">Batal</a>
                        <button type="submit" class="btn px-5 text-white fw-bold shadow-sm" 
                                style="background-color: #1e3a8a; border-radius: 8px;">
                            <i class="bi bi-save me-2"></i> Update Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 0.75rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #1e3a8a;
        box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.15);
    }
</style>

@endsection