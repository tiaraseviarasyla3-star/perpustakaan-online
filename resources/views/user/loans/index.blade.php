@extends('layouts.user')

@section('title', 'Riwayat Peminjaman')

@section('content')

{{-- HEADER --}}
<div class="mb-4 p-4 rounded-4 text-white shadow-sm"
     style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman Saya</h4>
            <p class="mb-0 opacity-75 small">
                Pantau daftar buku, jaminan yang Anda titipkan, dan status pengembalian.
            </p>
        </div>
        <i class="bi bi-journal-bookmark fs-1 opacity-25 d-none d-md-block"></i>
    </div>
</div>

{{-- TABLE CARD --}}
<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                {{-- Header --}}
                <thead style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="px-4 py-3 text-secondary small fw-bold text-uppercase">Buku & Jaminan</th>
                        <th class="px-4 py-3 text-secondary small fw-bold text-uppercase text-center">Tgl Pinjam</th>
                        <th class="px-4 py-3 text-secondary small fw-bold text-uppercase text-center">Jatuh Tempo</th>
                        <th class="px-4 py-3 text-secondary small fw-bold text-uppercase text-center">Denda</th>
                        <th class="px-4 py-3 text-secondary small fw-bold text-uppercase text-center">Status</th>
                        <th class="px-4 py-3 text-secondary small fw-bold text-uppercase text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($loans as $loan)
                    <tr class="border-bottom">
                        {{-- INFO BUKU & JAMINAN --}}
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <i class="bi bi-book-fill"></i>
                                </div>
                                <div>
                                    <div class="fw-bold" style="color: #1e3a8a;">{{ $loan->book->title }}</div>
                                    <div class="mt-1">
                                        {{-- Tampilan Jaminan --}}
                                        <span class="badge bg-light text-dark border fw-normal" style="font-size: 0.75rem;">
                                            <i class="bi bi-card-heading me-1 text-primary"></i> 
                                            Jaminan: <strong>{{ $loan->guarantee ?? 'Tidak ada' }}</strong>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-4 py-3 text-center text-muted small">
                            {{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-center text-muted small font-monospace">
                            {{ \Carbon\Carbon::parse($loan->due_date)->format('d/m/Y') }}
                        </td>

                        {{-- DENDA & METODE PEMBAYARAN --}}
                        <td class="px-4 py-3 text-center small">
                            @if($loan->fine && $loan->fine->amount > 0)
                                <div class="fw-bold text-danger">Rp {{ number_format($loan->fine->amount) }}</div>
                                @if($loan->payment_method)
                                    <div class="text-muted" style="font-size: 0.7rem;">
                                        via {{ strtoupper($loan->payment_method) }}
                                    </div>
                                @endif
                            @else
                                <span class="text-muted opacity-50">-</span>
                            @endif
                        </td>

                        {{-- STATUS & KONDISI BUKU --}}
                        <td class="px-4 py-3 text-center">
                            <span class="badge rounded-pill px-3 py-2 mb-1 
                                @if($loan->status === 'pending') bg-warning text-dark
                                @elseif($loan->status === 'approved') bg-primary
                                @elseif($loan->status === 'returned') bg-success-subtle text-success border border-success-subtle
                                @else bg-danger-subtle text-danger border border-danger-subtle
                                @endif
                            ">
                                {{ ucfirst($loan->status) }}
                            </span>
                            
                            {{-- Jika sudah kembali, tunjukkan kondisi bukunya --}}
                            @if($loan->status === 'returned')
                                <div class="text-muted italic" style="font-size: 0.7rem;">
                                    Kondisi: <span class="fw-bold text-dark">{{ ucfirst($loan->book_condition ?? 'baik') }}</span>
                                </div>
                            @endif
                        </td>

                        {{-- TOMBOL AKSI --}}
                        <td class="px-4 py-3 text-center">
                            @if($loan->status === 'returned')
                                <div class="btn-group">
                                    <a href="{{ route('loans.preview', $loan->id) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">
                                        <i class="bi bi-printer me-1"></i> Bukti
                                    </a>
                                </div>
                            @elseif($loan->status === 'approved')
                                <span class="text-primary small fw-bold"><i class="bi bi-info-circle me-1"></i>Bawa Buku</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted italic">
                            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                            Belum ada riwayat peminjaman buku.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- PESAN UNTUK USER JIKA BUKU SUDAH KEMBALI --}}
<div class="mt-4">
    <div class="alert alert-primary border-0 shadow-sm rounded-4 p-3 d-flex align-items-center">
        <i class="bi bi-info-circle-fill fs-4 me-3"></i>
        <div class="small">
            <strong>Catatan:</strong> Jika status buku sudah <span class="badge bg-success small">Returned</span>, silakan tunjukkan bukti pengembalian kepada petugas untuk mengambil kembali jaminan fisik Anda (jika ada).
        </div>
    </div>
</div>

@endsection