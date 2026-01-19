@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6"> {{-- Membuat form lebih ramping di tengah --}}
        
        {{-- TOMBOL KEMBALI --}}
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mb-3 border-0 shadow-sm bg-white">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
                <div class="d-flex align-items-center">
                    <div class="p-2 rounded-3 me-3" style="background-color: #e0e7ff;">
                        <i class="bi bi-tag-fill fs-4" style="color: #1e3a8a;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: #1e3a8a;">Tambah Kategori</h5>
                        <small class="text-muted">Buat kategori baru untuk buku.</small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                {{-- ALERT ERROR --}}
                @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small">Nama Kategori</label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Contoh: Teknologi Informasi"
                               value="{{ old('name') }}"
                               autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid"> {{-- Tombol full-width untuk tampilan modern --}}
                        <button type="submit" class="btn text-white fw-bold py-2 shadow-sm" 
                                style="background-color: #1e3a8a; border-radius: 8px;">
                            <i class="bi bi-check-lg me-1"></i> Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 0.75rem;
    }
    .form-control:focus {
        border-color: #1e3a8a;
        box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.15);
    }
</style>

@endsection