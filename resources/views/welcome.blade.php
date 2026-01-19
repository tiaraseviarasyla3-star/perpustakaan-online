@extends('layouts.app')

@section('content')

{{-- 1. HERO SECTION --}}
<section class="py-5" style="background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%); min-height: 80vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="badge px-3 py-2 mb-3 text-primary bg-white shadow-sm fw-bold" style="border-radius: 50px;">
                    🚀 Literasi Tanpa Batas
                </span>
                <h1 class="display-3 fw-bold mb-4" style="color: #1e3a8a; line-height: 1.2;">
                    Akses Ribuan Buku <br> <span style="color: #3b82f6;">Hanya Sekali Klik.</span>
                </h1>
                <p class="lead text-muted mb-5">Sistem Perpustakaan Digital modern yang memudahkan Anda dalam mencari dan meminjam koleksi buku favorit.</p>
                <div class="d-flex gap-3">
                    <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg px-4 py-3 shadow border-0" style="background-color: #1e3a8a; border-radius: 12px;">
                        Mulai Membaca
                    </a>
                </div>
            </div>
            {{-- Bagian Hero Image --}}
<div class="col-lg-6 text-center">
    <div class="position-relative">
        {{-- Lingkaran Dekorasi di Belakang Gambar --}}
        <div class="bg-primary rounded-circle position-absolute top-50 start-50 translate-middle opacity-10 d-none d-lg-block" 
             style="width: 450px; height: 450px;"></div>
        
        {{-- Pastikan URL ini benar atau ganti dengan gambar lokal --}}
        {{-- Menggunakan ilustrasi dari ManyPixels atau Kimbos --}}
        <img src="https://img.freepik.com/free-vector/hand-drawn-flat-design-stack-books-illustration_23-2149341898.jpg" 
     class="img-fluid position-relative" 
     alt="Hero Image" 
     style="max-height: 450px; border-radius: 20px; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));">
    </div>
</div>
        </div>
    </div>
</section>

{{-- 2. FEATURES SECTION --}}
<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5">
            <h6 class="text-primary fw-bold text-uppercase small">Mengapa Kami?</h6>
            <h2 class="fw-bold" style="color: #1e3a8a;">Fitur Unggulan Kami</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 h-100 card-hover" style="border-radius: 20px;">
                    <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-4 w-fit mb-3"><i class="bi bi-search fs-3"></i></div>
                    <h5 class="fw-bold">Pencarian Cerdas</h5>
                    <p class="text-muted small mb-0">Temukan buku berdasarkan judul, penulis, atau kategori dengan instan.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 h-100 card-hover" style="border-radius: 20px;">
                    <div class="p-3 bg-success bg-opacity-10 text-success rounded-4 w-fit mb-3"><i class="bi bi-lightning-charge fs-3"></i></div>
                    <h5 class="fw-bold">Pinjam Cepat</h5>
                    <p class="text-muted small mb-0">Proses peminjaman yang simpel langsung melalui dashboard Anda.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 h-100 card-hover" style="border-radius: 20px;">
                    <div class="p-3 bg-warning bg-opacity-10 text-warning rounded-4 w-fit mb-3"><i class="bi bi-shield-check fs-3"></i></div>
                    <h5 class="fw-bold">Aman & Terpercaya</h5>
                    <p class="text-muted small mb-0">Data peminjaman Anda tersimpan dengan aman dan terorganisir.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 3. BOOKS PREVIEW SECTION (BARU) --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-0" style="color: #1e3a8a;">Koleksi Terbaru</h2>
                <p class="text-muted mb-0">Jelajahi buku-buku terbaru yang baru saja masuk.</p>
            </div>
            <a href="{{ route('books.index') }}" class="btn btn-outline-primary fw-bold px-4 border-2" style="border-radius: 10px;">Lihat Semua</a>
        </div>
        <div class="row g-4">
            @php $latestBooks = \App\Models\Book::latest()->take(4)->get(); @endphp
            @foreach($latestBooks as $book)
            <div class="col-lg-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm overflow-hidden card-hover" style="border-radius: 18px;">
                    <div style="height: 250px; overflow: hidden;">
                        @if($book->cover_path)
                            <img src="{{ asset('storage/' . $book->cover_path) }}" class="w-100 h-100" style="object-fit: cover;">
                        @else
                            <div class="h-100 d-flex align-items-center justify-content-center text-white" style="background: #1e3a8a;">No Cover</div>
                        @endif
                    </div>
                    <div class="card-body p-3">
                        <h6 class="fw-bold mb-1 text-truncate">{{ $book->title }}</h6>
                        <p class="text-muted small mb-3">✍️ {{ $book->author }}</p>
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm w-100 text-white" style="background: #1e3a8a; border-radius: 8px;">Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 4. CTA SECTION --}}
<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="p-5 rounded-5 text-white shadow-lg text-center" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
            <h2 class="fw-bold mb-3">Siap Untuk Membaca?</h2>
            <p class="mb-4 opacity-75">Bergabunglah dengan ribuan pembaca lainnya sekarang juga.</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 py-3 fw-bold text-primary" style="border-radius: 12px;">Daftar Sekarang</a>
        </div>
    </div>
</section>

{{-- 5. FOOTER (BARU) --}}
<footer class="py-5" style="background-color: #0f172a; color: #94a3b8;">
    <div class="container">
        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <h5 class="text-white fw-bold mb-3">Perpus<span class="text-primary">Digital</span></h5>
                <p class="small">Platform perpustakaan modern yang menyediakan akses literasi berkualitas bagi masyarakat luas secara digital dan efisien.</p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-sm btn-outline-light border-0"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light border-0"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light border-0"><i class="bi bi-twitter"></i></a>
                </div>
            </div>
            <div class="col-lg-2 offset-lg-1">
                <h6 class="text-white fw-bold mb-3">Navigasi</h6>
                <ul class="list-unstyled small d-grid gap-2">
                    <li><a href="#" class="text-decoration-none text-reset">Home</a></li>
                    <li><a href="{{ route('books.index') }}" class="text-decoration-none text-reset">Katalog Buku</a></li>
                    <li><a href="#" class="text-decoration-none text-reset">Kategori</a></li>
                </ul>
            </div>
            <div class="col-lg-2">
                <h6 class="text-white fw-bold mb-3">Bantuan</h6>
                <ul class="list-unstyled small d-grid gap-2">
                    <li><a href="#" class="text-decoration-none text-reset">Cara Pinjam</a></li>
                    <li><a href="#" class="text-decoration-none text-reset">Ketentuan</a></li>
                    <li><a href="#" class="text-decoration-none text-reset">Kontak Kami</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="text-white fw-bold mb-3">Kontak</h6>
                <p class="small mb-2"><i class="bi bi-geo-alt me-2"></i> Jl. Pendidikan No. 123, Indonesia</p>
                <p class="small mb-2"><i class="bi bi-envelope me-2"></i> info@perpusdigital.com</p>
                <p class="small"><i class="bi bi-telephone me-2"></i> +62 812 3456 7890</p>
            </div>
        </div>
        <hr class="opacity-10 border-light">
        <div class="text-center small">
            &copy; {{ date('Y') }} PerpusDigital. TIARA RPL 1.
        </div>
    </div>
</footer>

<style>
    .w-fit { width: fit-content; }
    .card-hover { transition: 0.3s; }
    .card-hover:hover { transform: translateY(-10px); }
</style>

@endsection