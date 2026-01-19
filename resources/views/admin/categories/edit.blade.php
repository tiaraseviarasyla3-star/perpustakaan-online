@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        
        {{-- TOMBOL KEMBALI --}}
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary mb-3 border-0 shadow-sm bg-white">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white border-0 py-3" style="border-radius: 15px 15px 0 0;">
                <div class="d-flex align-items-center">
                    {{-- Ikon berwarna Kuning/Amber untuk menandakan mode Edit --}}
                    <div class="p-2 rounded-3 me-3" style="background-color: #fef3c7;">
                        <i class="bi bi-pencil-fill fs-4" style="color: #d97706;"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: #1e3a8a;">Edit Kategori</h5>
                        <small class="text-muted">Perbarui nama kategori buku.</small>
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

                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="form-label fw-semibold text-secondary small">Nama Kategori</label>
                        <input type="text"
                               name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Contoh: Teknologi Informasi"
                               value="{{ old('name', $category->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn text-white fw-bold py-2 shadow-sm" 
                                style="background-color: #1e3a8a; border-radius: 8px;">
                            <i class="bi bi-save me-1"></i> Update Perubahan
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