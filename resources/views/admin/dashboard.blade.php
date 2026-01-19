@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
{{-- WELCOME HEADER --}}
<div class="mb-4">
    <h4 class="fw-bold" style="color: #1e3a8a;">Ringkasan Data</h4>
    <p class="text-muted small">Pantau statistik utama perpustakaan Anda dalam satu layar.</p>
</div>

<div class="row g-4">
    {{-- Total Books Card --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2 small text-uppercase fw-bold">Total Koleksi Buku</h6>
                        <h2 class="fw-bold mb-0" style="color: #1e3a8a;">{{ \App\Models\Book::count() }}</h2>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-book fs-3 text-primary"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.books.index') }}" class="text-decoration-none small fw-semibold text-primary">
                        Lihat Detail <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Users Card --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2 small text-uppercase fw-bold">Total Pengguna</h6>
                        <h2 class="fw-bold mb-0" style="color: #1e3a8a;">{{ \App\Models\User::where('role', 'user')->count() }}</h2>
                    </div>
                    <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-people fs-3 text-info"></i>
                    </div>
                </div>
                <div class="mt-3 text-info small fw-semibold">
                    <i class="bi bi-check-circle-fill"></i> Anggota Aktif
                </div>
            </div>
        </div>
    </div>

    {{-- Total Loans Card --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2 small text-uppercase fw-bold">Peminjaman Aktif</h6>
                        <h2 class="fw-bold mb-0" style="color: #c2410c;">{{ \App\Models\Loan::where('status', 'approved')->count() }}</h2>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="bi bi-arrow-left-right fs-3 text-warning"></i>
                    </div>
                </div>
                <div class="mt-3 text-muted small fw-semibold">
                    <a href="{{ route('admin.loans.index') }}" class="text-decoration-none text-warning">
                        Kelola Transaksi <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BOTTOM ROW: QUICK ACTIONS --}}
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; background-color: #f8fafc;">
            <div class="card-body d-flex align-items-center justify-content-between py-3">
                <span class="small text-secondary fw-semibold">Punya koleksi baru? Tambahkan segera ke sistem.</span>
                <a href="{{ route('admin.books.create') }}" class="btn btn-sm text-white px-4" style="background-color: #1e3a8a; border-radius: 8px;">
                    <i class="bi bi-plus-lg"></i> Tambah Buku Baru
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
</style>
@endsection