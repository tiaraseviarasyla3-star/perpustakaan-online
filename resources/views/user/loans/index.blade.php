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
                Pantau daftar buku yang Anda pinjam dan cek status pengembalian.
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
                {{-- Header Deep Blue --}}
                <thead style="background-color: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <tr>
                        <th class="px-4 py-3 text-secondary small fw-bold text-uppercase">Buku</th>
                        <th class="px-4 py-3 text-secondary small fw-bold text-uppercase text-center">Tgl Pinjam</th>
                        <th class="px-4 py-3 text-secondary small fw-bold text-uppercase text-center">Jatuh Tempo</th>
                        <th class="px-4 py-3 text-secondary small fw-bold text-uppercase text-center">Denda</th>
                        <th class="px-4 py-3 text-secondary small fw-bold text-uppercase text-center">Status</th>
                        {{-- TAMBAHKAN KOLOM AKSI --}}
                        <th class="px-4 py-3 text-secondary small fw-bold text-uppercase text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($loans as $loan)
                    <tr class="border-bottom">
                        {{-- INFO BUKU --}}
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                    <i class="bi bi-book"></i>
                                </div>
                                <div>
                                    <div class="fw-bold" style="color: #1e3a8a;">{{ $loan->book->title }}</div>
                                    <div class="text-muted small">{{ $loan->book->author }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-4 py-3 text-center text-muted small">
                            {{ \Carbon\Carbon::parse($loan->loan_date)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-center text-muted small">
                            {{ \Carbon\Carbon::parse($loan->due_date)->format('d/m/Y') }}
                        </td>

                        {{-- DENDA --}}
                        <td class="px-4 py-3 text-center fw-bold {{ $loan->fine ? 'text-danger' : 'text-muted' }} small">
                            @if($loan->fine)
                                Rp {{ number_format($loan->fine->amount) }}
                            @else
                                <span class="opacity-50">-</span>
                            @endif
                        </td>

                        {{-- STATUS BADGE --}}
                        <td class="px-4 py-3 text-center">
                            <span class="badge rounded-pill px-3 py-2 
                                @if($loan->status === 'pending') bg-warning text-dark
                                @elseif($loan->status === 'approved') bg-primary
                                @elseif($loan->status === 'returned') bg-success-subtle text-success border border-success-subtle
                                @else bg-danger-subtle text-danger border border-danger-subtle
                                @endif
                            ">
                                @if($loan->status === 'approved') <i class="bi bi-book-half me-1"></i> @endif
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>

                        {{-- TOMBOL AKSI (CETAK BUKTI) --}}
                        <td class="px-4 py-3 text-center">
                            @if($loan->status !== 'rejected')
                                <a href="{{ route('loans.preview', $loan->id) }}" 
                                   class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">
                                    <i class="bi bi-printer me-1"></i> Bukti
                                </a>
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

@endsection