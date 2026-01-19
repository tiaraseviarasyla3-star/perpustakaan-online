@extends('layouts.user')

@section('title', 'Dashboard User')

@section('content')

{{-- HERO / WELCOME (Ukuran Ringkas) --}}
<div class="card border-0 text-white mb-4 shadow-sm" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 15px;">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="fw-bold mb-1">
                    Selamat Datang, {{ auth()->user()->name }} 👋
                </h3>
                <p class="mb-0 opacity-75 small">
                    Jelajahi koleksi buku terbaru dan kelola peminjamanmu dengan lebih mudah hari ini.
                </p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="bi bi-rocket-takeoff fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

{{-- STATISTIC CARDS --}}
<div class="row mb-4 g-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="card-body">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-book fs-4"></i>
                </div>
                <h6 class="text-muted small text-uppercase fw-bold">Total Buku</h6>
                <h3 class="fw-bold" style="color: #1e3a8a;">
                    {{ \App\Models\Book::count() }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="card-body">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-clock-history fs-4"></i>
                </div>
                <h6 class="text-muted small text-uppercase fw-bold">Sedang Dipinjam</h6>
                <h3 class="text-warning fw-bold">
                    {{-- Logika disesuaikan dengan status 'approved' --}}
                    {{ auth()->user()->loans()->where('status', 'approved')->count() }}
                </h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center p-3">
            <div class="card-body">
                <div class="bg-success bg-opacity-10 text-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                    <i class="bi bi-check2-all fs-4"></i>
                </div>
                <h6 class="text-muted small text-uppercase fw-bold">Riwayat Peminjaman</h6>
                <h3 class="text-success fw-bold">
                    {{ auth()->user()->loans()->count() }}
                </h3>
            </div>
        </div>
    </div>
</div>

{{-- QUICK ACTION & INFO --}}
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 text-dark">Aksi Cepat</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('books.index') }}" class="btn btn-primary w-100 py-3 rounded-3 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-search"></i> Cari Buku Baru
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('user.loans.index') }}" class="btn btn-outline-primary w-100 py-3 rounded-3 d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-journal-text"></i> Cek Riwayat Pinjam
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100" style="background-color: #eef2ff;">
            <div class="card-body p-4">
                <h6 class="fw-bold text-primary d-flex align-items-center mb-3">
                    <i class="bi bi-info-circle-fill me-2"></i> Ketentuan
                </h6>
                <ul class="small text-muted mb-0 ps-3">
                    <li class="mb-2">Maksimal peminjaman 7 hari kerja.</li>
                    <li class="mb-2">Denda berlaku untuk keterlambatan.</li>
                    <li>Kembalikan buku dalam kondisi baik.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection