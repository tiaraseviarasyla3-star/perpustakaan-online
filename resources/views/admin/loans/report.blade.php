@extends('layouts.admin')

@section('title', 'Laporan Periodik')

@section('content')
<div class="container-fluid py-4">
    {{-- FORM FILTER - Sembunyi saat cetak --}}
    <div class="card border-0 shadow-sm mb-4 d-print-none">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3 text-dark">Filter Periode Laporan</h5>
            <form action="{{ route('admin.loans.report') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $start_date }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Tanggal Selesai</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $end_date }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    @if($loans->count() > 0)
                        <button onclick="window.print()" class="btn btn-dark px-4 shadow-sm">
                            <i class="bi bi-printer me-1"></i> Cetak PDF
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- KOP SURAT LAPORAN - Muncul hanya saat cetak --}}
    <div class="d-none d-print-block text-center mb-5">
        <h3 class="fw-bold text-uppercase">Laporan Rekapitulasi Perpustakaan</h3>
        <h5 class="mb-2">Kabupaten Mojokerto</h5>
        <p class="mb-0">Periode: {{ $start_date ? \Carbon\Carbon::parse($start_date)->format('d/m/Y') : 'Semua' }} 
           s/d {{ $end_date ? \Carbon\Carbon::parse($end_date)->format('d/m/Y') : 'Sekarang' }}</p>
        <hr style="border: 2px solid #000; opacity: 1;">
    </div>

    {{-- TABEL DATA --}}
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0 align-middle">
                    <thead class="table-light">
                        <tr class="text-center small text-uppercase fw-bold">
                            <th style="width: 50px;">No</th>
                            <th>Peminjam</th>
                            <th>Buku</th>
                            <th>Tgl Kembali</th>
                            <th>Kondisi</th>
                            <th>Denda</th>
                            <th>Metode</th>
                            <th class="d-print-none text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalPemasukan = 0; @endphp
                        @forelse($loans as $loan)
                        @php $totalPemasukan += $loan->fine->amount ?? 0; @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="fw-semibold text-dark">{{ $loan->user->name }}</td>
                            <td class="text-primary">{{ $loan->book->title }}</td>
                            <td class="text-center">{{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}</td>
                            
                            {{-- Kondisi Buku --}}
                            <td class="text-center">
                                @if($loan->book_condition == 'baik')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2">Baik</span>
                                @elseif($loan->book_condition == 'rusak')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2">Rusak</span>
                                @elseif($loan->book_condition == 'hilang')
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2">Hilang</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            {{-- Nominal Denda --}}
                            <td class="text-end fw-bold">
                                Rp {{ number_format($loan->fine->amount ?? 0) }}
                            </td>

                            {{-- Metode Pembayaran --}}
                            <td class="text-center">
                                @if($loan->payment_method == 'qris')
                                    <span class="small fw-bold text-danger"><i class="bi bi-qr-code"></i> QRIS</span>
                                @elseif($loan->payment_method == 'dana')
                                    <span class="small fw-bold text-info"><i class="bi bi-wallet2"></i> DANA</span>
                                @elseif($loan->payment_method == 'tunai')
                                    <span class="small fw-bold text-success"><i class="bi bi-cash-stack"></i> TUNAI</span>
                                @elseif($loan->payment_method == 'transfer')
                                    <span class="small fw-bold text-primary"><i class="bi bi-bank"></i> BANK</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            
                            <td class="text-center d-print-none">
                                <span class="badge rounded-pill {{ $loan->status == 'returned' ? 'bg-success' : 'bg-primary' }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block opacity-25"></i>
                                Tidak ada data untuk periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($loans->count() > 0)
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="5" class="text-end py-3">TOTAL PEMASUKAN DENDA :</td>
                            <td class="text-end py-3 text-primary" style="font-size: 1.1rem;">
                                Rp {{ number_format($totalPemasukan) }}
                            </td>
                            <td colspan="2" class="d-print-none"></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    {{-- TANDA TANGAN --}}
    <div class="d-none d-print-block mt-5">
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p>Mojokerto, {{ date('d F Y') }}</p>
                <p class="mb-5">Petugas Perpustakaan,</p>
                <br><br>
                <p class="fw-bold">( ____________________ )</p>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .sidebar, .top-navbar, .d-print-none, .btn { display: none !important; }
        .main-content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
        body { background-color: white !important; font-family: 'Times New Roman', serif; }
        .card { border: none !important; box-shadow: none !important; }
        .table th, .table td { border: 1px solid #000 !important; padding: 5px !important; color: black !important; }
        .badge { background: transparent !important; color: black !important; border: none !important; font-weight: bold; }
    }
</style>
@endsection