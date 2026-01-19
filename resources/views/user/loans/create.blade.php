@extends('layouts.user')

@section('title', 'Konfirmasi Peminjaman')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        {{-- BACK BUTTON --}}
        <a href="{{ route('books.index') }}" class="btn btn-link text-decoration-none text-secondary mb-3 p-0">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Buku
        </a>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="row g-0">
                {{-- INFO BUKU (KIRI) --}}
                <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4">
                    <div class="text-center">
                        @if($book->cover_path)
                            <img src="{{ asset('storage/' . $book->cover_path) }}" 
                                 class="img-fluid rounded-3 shadow-sm mb-3" 
                                 style="max-height: 280px; object-fit: cover;">
                        @else
                            <div class="rounded-3 shadow-sm mb-3 d-flex align-items-center justify-content-center text-white" 
                                 style="width: 180px; height: 260px; background: linear-gradient(135deg, #1e3a8a, #3b82f6);">
                                <span>No Cover</span>
                            </div>
                        @endif
                        <h6 class="fw-bold mb-0" style="color: #1e3a8a;">{{ $book->title }}</h6>
                        <small class="text-muted">{{ $book->author }}</small>
                    </div>
                </div>

                {{-- FORM (KANAN) --}}
                <div class="col-md-7">
                    <div class="card-body p-4 p-lg-5">
                        <h4 class="fw-bold mb-4" style="color: #1e3a8a;">Detail Peminjaman</h4>
                        
                        <form action="{{ route('loans.store', $book->id) }}" method="POST">
                            @csrf

                            {{-- INFO BOX --}}
                            <div class="alert border-0 bg-primary bg-opacity-10 mb-4 px-3 py-2" style="border-radius: 10px;">
                                <small class="text-primary fw-semibold">
                                    <i class="bi bi-info-circle-fill me-1"></i> 
                                    Peminjaman akan diproses oleh Admin.
                                </small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary">TANGGAL PENGEMBALIAN</label>
                                <input type="date" 
                                       name="due_date" 
                                       class="form-control form-control-lg border-2 @error('due_date') is-invalid @enderror" 
                                       style="border-radius: 12px;"
                                      
                                       required>
                                <div class="form-text small italic text-muted mt-2">
                                    Pilih tanggal kapan Anda berencana mengembalikan buku ini.
                                </div>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-lg text-white shadow-sm fw-bold" 
                                        style="background-color: #1e3a8a; border-radius: 12px; transition: all 0.3s;">
                                    Ajukan Pinjaman Sekarang
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- SYARAT KETENTUAN SINGKAT --}}
        <div class="mt-4 px-2">
            <h6 class="small fw-bold text-secondary">Catatan Penting:</h6>
            <ul class="text-muted small ps-3">
                <li>Pastikan stok buku tersedia saat pengambilan fisik.</li>
                <li>Keterlambatan pengembalian dapat dikenakan denda sesuai aturan.</li>
                <li>Harap membawa kartu identitas/kartu anggota saat verifikasi di Admin.</li>
            </ul>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #1e3a8a;
        box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.1);
    }
    .btn:hover {
        background-color: #1a347a !important;
        transform: scale(1.02);
    }
</style>
@endsection