@extends('layouts.admin')

@section('title', 'Manajemen Peminjaman')

@section('content')

{{-- HEADER & STATISTIK --}}
<div class="row mb-4">
    <div class="col-md-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Peminjaman</h4>
            <p class="text-muted small mb-0">Kelola persetujuan, jaminan, dan pendataan pengembalian buku.</p>
        </div>
        
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
                        <th class="px-4 py-3 border-0 small text-uppercase">Buku & Jaminan</th>
                        <th class="px-4 py-3 border-0 small text-uppercase text-center">Tgl Pinjam</th>
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
                        
                        {{-- BUKU & JAMINAN --}}
                        <td class="px-4 py-3">
                            <span style="color: #1e3a8a;" class="fw-semibold d-block">{{ $loan->book->title }}</span>
                            @if($loan->guarantee)
                                <span class="badge bg-light text-dark border fw-normal mt-1" style="font-size: 0.7rem;">
                                    <i class="bi bi-card-heading text-primary me-1"></i> Jaminan: {{ $loan->guarantee }}
                                </span>
                            @endif
                        </td>
                        
                        {{-- TANGGAL PINJAM & TEMPO --}}
                        <td class="px-4 py-3 text-center small text-muted">
                            <div class="fw-bold text-dark">{{ $loan->loan_date->format('d/m/Y') }}</div>
                            <div style="font-size: 0.7rem;">Tempo: {{ $loan->due_date->format('d/m/Y') }}</div>
                        </td>
                        
                        {{-- TANGGAL KEMBALI --}}
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
                                @if($loan->payment_method)
                                    <div class="text-muted fw-normal" style="font-size: 0.65rem;">via {{ strtoupper($loan->payment_method) }}</div>
                                @endif
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
                                    {{-- Tombol Buka Modal Jaminan --}}
                                    <button type="button" class="btn btn-sm btn-success rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#approveModal{{ $loan->id }}">
                                        Setuju
                                    </button>

                                    <form action="{{ route('admin.loans.reject', $loan) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3">Tolak</button>
                                    </form>

                                @elseif($loan->status === 'approved')
                                    <a href="{{ route('admin.returns.index') }}" class="btn btn-sm btn-light border rounded-pill px-3 shadow-sm">
                                        <i class="bi bi-arrow-right-short"></i> Proses Kembali
                                    </a>
                                @else
                                    <span class="text-muted small">Selesai</span>
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

{{-- MODAL APPROVAL (INPUT JAMINAN) --}}
@foreach($loans as $loan)
    @if($loan->status === 'pending')
    <div class="modal fade d-print-none" id="approveModal{{ $loan->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-check-circle me-2"></i>Persetujuan Pinjam</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.loans.approve', $loan->id) }}" method="POST">
                    @csrf
                    <div class="modal-body p-4 text-start">
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold">Peminjam</label>
                            <p class="fw-bold mb-0 text-dark">{{ $loan->user->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small text-uppercase fw-bold">Buku</label>
                            <p class="fw-bold mb-0 text-dark">{{ $loan->book->title }}</p>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Input Jaminan Fisik</label>
                            <select name="guarantee" class="form-select border-success" required>
                                <option value="" disabled selected>-- Pilih Jaminan --</option>
                                <option value="KTP">KTP</option>
                                <option value="Kartu Pelajar">Kartu Pelajar / Mahasiswa</option>
                                <option value="SIM">SIM</option>
                                <option value="Kartu Perpustakaan">Kartu Perpustakaan</option>
                                <option value="Uang Jaminan">Uang Jaminan (Cash)</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <div class="form-text mt-2 small">
                                <i class="bi bi-info-circle me-1"></i> Admin harus menerima jaminan fisik sebelum menyetujui.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-3">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">Setujui & Pinjamkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach

{{-- CSS KHUSUS PRINT --}}
<style>
    @media print {
        .sidebar, .top-navbar, .d-print-none, .btn, .alert, .modal { display: none !important; }
        .main-content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
        .card { border: none !important; box-shadow: none !important; }
        body { background-color: white !important; font-size: 10pt; }
        table { width: 100% !important; border: 1px solid #ddd !important; }
        th { background-color: #f2f2f2 !important; color: black !important; border: 1px solid #ddd !important; }
        td { border: 1px solid #ddd !important; }
    }
</style>

@endsection