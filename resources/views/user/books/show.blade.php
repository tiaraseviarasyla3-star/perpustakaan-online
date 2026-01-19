@extends('layouts.user')

@section('title', $book->title)

@section('content')

{{-- TOMBOL KEMBALI --}}
<a href="{{ route('books.index') }}" class="btn btn-outline-secondary mb-4 border-0 shadow-sm bg-white">
    <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
</a>

<div class="row g-4">
    {{-- COVER --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 20px;">
            @if($book->cover_path)
                <img src="{{ asset('storage/' . $book->cover_path) }}"
                     class="w-100"
                     style="height: 500px; object-fit: cover;">
            @else
                <div class="text-white text-center d-flex flex-column align-items-center justify-content-center" 
                     style="height: 500px; background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                    <i class="bi bi-image fs-1 opacity-50 mb-2"></i>
                    <span class="fw-bold">No Cover Available</span>
                </div>
            @endif
        </div>
    </div>

    {{-- DETAIL --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0 h-100" style="border-radius: 20px;">
            <div class="card-body p-4 p-lg-5">
                {{-- Judul & Kategori --}}
                <div class="mb-4">
                    <span class="badge mb-2 px-3 py-2" style="background-color: #e0e7ff; color: #1e3a8a; border-radius: 8px;">
                        {{ $book->category->name ?? 'Tanpa Kategori' }}
                    </span>
                    <h2 class="fw-bold" style="color: #1e3a8a; font-size: 2.5rem;">
                        {{ $book->title }}
                    </h2>
                    <h5 class="text-muted">
                        <i class="bi bi-person-circle me-1"></i> {{ $book->author }}
                    </h5>
                </div>

                <div class="d-flex align-items-center gap-4 mb-4">
                    <div class="p-3 rounded-4 bg-light text-center" style="min-width: 100px;">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Status</small>
                        <span class="{{ $book->stock < 1 ? 'text-danger' : 'text-success' }} fw-bold">
                            {{ $book->stock < 1 ? 'Habis' : 'Tersedia' }}
                        </span>
                    </div>
                    <div class="p-3 rounded-4 bg-light text-center" style="min-width: 100px;">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Stok</small>
                        <span class="fw-bold text-dark">{{ $book->stock }} Buku</span>
                    </div>
                </div>

                <hr class="my-4 opacity-10">

                <div class="mb-5">
                    <h6 class="fw-bold text-dark mb-3">Sinopsis / Deskripsi :</h6>
                    <p class="text-muted" style="line-height: 1.8; text-align: justify;">
                        {{ $book->description ?? 'Tidak ada deskripsi tersedia untuk buku ini.' }}
                    </p>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="d-flex gap-2">
                    @if($book->stock > 0)
                        <a href="{{ route('loans.create', $book->id) }}" 
                           class="btn btn-lg px-5 py-3 text-white shadow fw-bold d-flex align-items-center justify-content-center"
                           style="background-color: #1e3a8a; border-radius: 15px; flex: 1;">
                           <i class="bi bi-bookmark-plus-fill me-2"></i> Ajukan Peminjaman
                        </a>
                    @else
                        <button class="btn btn-lg btn-secondary px-5 py-3 shadow-sm fw-bold disabled w-100" 
                                style="border-radius: 15px; opacity: 0.6;">
                            <i class="bi bi-x-circle me-2"></i> Stok Sedang Kosong
                        </button>
                    @endif
                    
                    {{-- Tombol Share/Simpan (Opsional untuk estetika) --}}
                    <button class="btn btn-lg btn-outline-primary border-2 px-4" style="border-radius: 15px; color: #1e3a8a; border-color: #1e3a8a;">
                        <i class="bi bi-share"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Agar tampilan lebih cantik di mobile */
    @media (max-width: 768px) {
        h2 { font-size: 1.8rem !important; }
        img { height: 350px !important; }
    }
</style>

@endsection