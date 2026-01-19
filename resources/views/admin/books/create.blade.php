@extends('layouts.admin')

@section('title', 'Tambah Buku')

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
                    <div class="p-2 rounded-3 me-3" style="background-color: #e0e7ff;">
                        <i class="bi bi-book-half fs-4" style="color: #1e3a8a;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: #1e3a8a;">Form Tambah Buku</h5>
                        <small class="text-muted">Lengkapi data di bawah untuk menambah koleksi perpustakaan.</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.books.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        {{-- KOLOM KIRI --}}
                        <div class="col-md-6">
                            {{-- Judul --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Judul Buku</label>
                                <input type="text" name="title" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="Contoh: Pemrograman Laravel Dasar" 
                                       value="{{ old('title') }}">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Penulis --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Penulis</label>
                                <input type="text" name="author" 
                                       class="form-control @error('author') is-invalid @enderror" 
                                       placeholder="Contoh: Budi Santoso" 
                                       value="{{ old('author') }}">
                                @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Kategori & Stok --}}
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary small">Kategori</label>
                                    <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                        <option value="">-- Pilih --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold text-secondary small">Stok</label>
                                    <input type="number" name="stock" 
                                           class="form-control @error('stock') is-invalid @enderror" 
                                           placeholder="Jumlah" 
                                           value="{{ old('stock') }}">
                                    @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN --}}
                        <div class="col-md-6">
                            {{-- Deskripsi --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Deskripsi Buku</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                          rows="5" placeholder="Ringkasan singkat isi buku...">{{ old('description') }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Cover --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Cover Buku</label>
                                <input type="file" name="cover" class="form-control @error('cover') is-invalid @enderror">
                                <div class="form-text mt-1 italic">Format: JPG/PNG, maks 2MB</div>
                                @error('cover') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4 opacity-10">

                    {{-- TOMBOL AKSI --}}
                    <div class="d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-light px-4 fw-semibold text-secondary">Reset</button>
                        <button type="submit" class="btn px-5 text-white fw-bold shadow-sm" style="background-color: #1e3a8a; border-radius: 8px;">
                            <i class="bi bi-cloud-upload me-2"></i> Simpan Buku
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