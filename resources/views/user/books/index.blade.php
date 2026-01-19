@extends('layouts.user')

@section('title', 'Daftar Buku')

@section('content')

{{-- HEADER --}}
<div class="mb-4 p-4 rounded-4 text-white shadow-sm"
     style="background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
    <div class="d-flex align-items-center">
        <div class="me-3 fs-1">📚</div>
        <div>
            <h4 class="mb-0 fw-bold">Koleksi Perpustakaan</h4>
            <p class="mb-0 opacity-75">Cari buku, ajukan peminjaman, dan perluas wawasanmu.</p>
        </div>
    </div>
</div>

{{-- SEARCH & FILTER --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
    <div class="card-body p-3">
        <form method="GET" action="{{ route('books.index') }}" class="row g-2">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" value="{{ $search ?? '' }}" 
                           class="form-control border-start-0" placeholder="Cari judul atau penulis...">
                </div>
            </div>
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn text-white w-100 fw-bold" style="background-color: #1e3a8a;">
                    Filter
                </button>
            </div>
        </form>
    </div>
</div>

@if($books->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-book text-muted opacity-25" style="font-size: 5rem;"></i>
        <p class="mt-3 text-muted">Maaf, buku yang Anda cari tidak ditemukan.</p>
        <a href="{{ route('books.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua Buku</a>
    </div>
@else

{{-- GRID BUKU --}}
<div class="row g-4">
@foreach($books as $book)
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow-sm border-0 card-hover" style="border-radius: 15px; overflow: hidden;">

            {{-- COVER (LINK KE SHOW) --}}
            <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none">
                <div class="position-relative">
                    <div style="height: 250px; overflow: hidden;">
                        @if($book->cover_path)
                            <img src="{{ asset('storage/' . $book->cover_path) }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="h-100 d-flex align-items-center justify-content-center text-white" 
                                 style="background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                                <span class="small opacity-75">No Cover</span>
                            </div>
                        @endif
                    </div>
                    {{-- Badge Stok --}}
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge {{ $book->stock < 1 ? 'bg-danger' : 'bg-success' }} shadow-sm">
                            Stok: {{ $book->stock }}
                        </span>
                    </div>
                </div>
            </a>

            {{-- BODY --}}
            <div class="card-body d-flex flex-column p-3">
                {{-- JUDUL (LINK KE SHOW) --}}
                <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none">
                    <h6 class="fw-bold mb-1" style="color: #1e3a8a; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 40px; line-height: 1.4;">
                        {{ $book->title }}
                    </h6>
                </a>

                <p class="text-muted small mb-2 text-truncate">✍️ {{ $book->author }}</p>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge" style="background-color: #e0e7ff; color: #1e3a8a; font-weight: 500;">
                        {{ $book->category->name ?? 'Umum' }}
                    </span>
                    {{-- LINK DETAIL TEXT --}}
                    <a href="{{ route('books.show', $book->id) }}" class="small fw-bold text-primary text-decoration-none">
                        Detail <i class="bi bi-chevron-right"></i>
                    </a>
                </div>

                {{-- BUTTON AJUKAN PINJAM --}}
                <div class="mt-auto">
                    @if($book->stock > 0)
                        <a href="{{ route('loans.create', $book->id) }}"
                           class="btn btn-primary btn-sm w-100 rounded-pill shadow-sm py-2 fw-bold"
                           style="background-color: #1e3a8a; border-color: #1e3a8a;">
                           Ajukan Pinjam
                        </a>
                    @else
                        <button class="btn btn-secondary btn-sm w-100 rounded-pill opacity-50 cursor-not-allowed py-2" disabled>
                           Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>

@endif

<style>
    .card-hover { 
        transition: transform 0.3s ease, box-shadow 0.3s ease; 
    }
    .card-hover:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 12px 24px rgba(30, 58, 138, 0.15) !important; 
    }
    .w-fit { width: fit-content; }
</style>

@endsection