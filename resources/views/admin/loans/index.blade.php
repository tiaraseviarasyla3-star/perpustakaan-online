@extends('layouts.admin')

@section('title', 'Manajemen Peminjaman')

@section('content')

{{-- HEADER & STATISTIK --}}
<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Peminjaman</h4>
            <p class="text-muted small mb-0">Kelola persetujuan dan pendataan pengembalian buku.</p>
        </div>
        
        {{-- Tombol Cetak Rekap (Hilang saat diprint) --}}
        <button onclick="window.print()" class="btn btn-dark btn-sm rounded-pill px-3 shadow-sm d-print-none">
            <i class="bi bi-printer me-1"></i> Cetak Laporan
        </button>
    </div>
</div>

{{-- NOTIFIKASI --}}
@if(session('success'))
<div class="alert alert-success border-0 shadow-sm d-print-none" style="border-radius: 10px;">
    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
</div>
@endif

{{-- TABLE CARD --}}
<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #0f172a; color: #ffffff;">
                    <tr>
                        <th class="px-4 py-3 border-0 small text-uppercase">Peminjam</th>
                        <th class="px-4 py-3 border-0 small text-uppercase">Judul Buku</th>
                        <th class="px-4 py-3 border-0 small text-uppercase text-center">Tgl Pinjam</th>
                        <th class="px-4 py-3 border-0 small text-uppercase text-center">Jatuh Tempo</th>
                        <th class="px-4 py-3 border-0 small text-uppercase text-center text-info">Tgl Kembali</th>
                        <th class="px-4 py-3 border-0 small text-uppercase text-center">Denda</th>
                        <th class="px-4 py-3 border-0 small text-uppercase text-center">Status</th>
                        <th class="px-4 py-3 border-0 small text-uppercase text-center d-print-none">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $loan)
                    <tr class="border-bottom">
                        {{-- USER --}}
                        <td class="px-4 py-3">
                            <div class="fw-bold text-dark">{{ $loan->user->name }}</div>
                            <div class="text-muted small">{{ $loan->user->email }}</div>
                        </td>
                        
                        {{-- BUKU --}}
                        <td class="px-4 py-3">
                            <span style="color: #1e3a8a;" class="fw-semibold">{{ $loan->book->title }}</span>
                        </td>
                        
                        {{-- TANGGAL PINJAM & TEMPO --}}
                        <td class="px-4 py-3 text-center small text-muted">
                            {{ $loan->loan_date->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-center small text-muted">
                            {{ $loan->due_date->format('d/m/Y') }}
                        </td>
                        
                        {{-- TANGGAL KEMBALI (DARI DATABASE) --}}
                        <td class="px-4 py-3 text-center small fw-bold">
                            @if($loan->return_date)
                                <span class="text-success">{{ $loan->return_date->format('d/m/Y') }}</span>
                            @else
                                <span class="text-muted opacity-50">-</span>
                            @endif
                        </td>

                        {{-- DENDA --}}
                        <td class="px-4 py-3 text-center fw-bold text-danger small">
                            @if($loan->fine)
                                Rp {{ number_format($loan->fine->amount) }}
                            @else
                                <span class="text-muted fw-normal">-</span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td class="px-4 py-3 text-center">
                            <span class="badge rounded-pill px-3 
                                @if($loan->status === 'pending') bg-warning text-dark
                                @elseif($loan->status === 'approved') bg-primary
                                @elseif($loan->status === 'returned') bg-success-subtle text-success border border-success-subtle
                                @else bg-danger-subtle text-danger border border-danger-subtle
                                @endif">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>

                        {{-- AKSI --}}
                        <td class="px-4 py-3 text-center d-print-none">
                            <div class="d-flex justify-content-center gap-2">
                                @if($loan->status === 'pending')
                                    <form action="{{ route('admin.loans.approve', $loan) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-success rounded-pill px-3 shadow-sm">Setuju</button>
                                    </form>
                                    <form action="{{ route('admin.loans.reject', $loan) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3">Tolak</button>
                                    </form>
                                @elseif($loan->status === 'approved')
                                    {{-- Tombol untuk memicu Modal --}}
                                    <button type="button" class="btn btn-sm btn-info text-white rounded-pill px-3 shadow-sm" 
                                            data-bs-toggle="modal" data-bs-target="#returnModal{{ $loan->id }}">
                                        <i class="bi bi-arrow-return-left me-1"></i> Kembalikan
                                    </button>
                                @else
                                    <span class="text-muted small italic">Selesai</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL FORM PENGEMBALIAN --}}
@foreach($loans as $loan)
<div class="modal fade d-print-none" id="returnModal{{ $loan->id }}" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title fw-bold" id="returnModalLabel"><i class="bi bi-journal-check me-2"></i>Konfirmasi Pengembalian</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold">Nama Peminjam</label>
                        <p class="fw-bold mb-0 text-dark">{{ $loan->user->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold">Judul Buku</label>
                        <p class="fw-bold mb-0 text-dark">{{ $loan->book->title }}</p>
                    </div>
                    <hr>
                    <div class="mb-0">
                        <label class="form-label fw-bold">Pilih Tanggal Kembali</label>
                        <input type="date" name="return_date" class="form-control form-control-lg border-primary" 
                               value="{{ date('Y-m-d') }}" required>
                        <div class="form-text mt-2 text-info">
                            <i class="bi bi-info-circle me-1"></i> Sesuaikan jika buku dikembalikan sebelum hari ini.
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- CSS KHUSUS PRINT --}}
<style>
    @media print {
        .sidebar, .top-navbar, .d-print-none, .btn, .alert, .modal { display: none !important; }
        .main-content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
        body { background-color: white !important; font-size: 12px; }
        table { width: 100% !important; border: 1px solid #000 !important; }
        th { background-color: #eee !important; color: black !important; border: 1px solid #000 !important; }
        td { border: 1px solid #000 !important; }
    }
</style>

@endsection