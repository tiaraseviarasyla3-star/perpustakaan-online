@extends('layouts.admin')

@section('title', 'Laporan Periodik')

@section('content')
<div class="container-fluid">
    {{-- FORM FILTER - Sembunyi saat cetak --}}
    <div class="card border-0 shadow-sm mb-4 d-print-none">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Filter Periode Laporan</h5>
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
                    <button type="submit" class="btn btn-primary px-4">Filter</button>
                    @if($start_date && $end_date)
                        <button onclick="window.print()" class="btn btn-dark px-4">
                            <i class="bi bi-printer me-1"></i> Cetak PDF
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- KOP SURAT LAPORAN - Muncul hanya saat cetak --}}
    <div class="d-none d-print-block text-center mb-4">
        <h4>LAPORAN PEMINJAMAN PERPUSTAKAAN</h4>
        <p class="mb-0">Periode: {{ $start_date ? \Carbon\Carbon::parse($start_date)->format('d/m/Y') : 'Semua' }} 
           s/d {{ $end_date ? \Carbon\Carbon::parse($end_date)->format('d/m/Y') : 'Sekarang' }}</p>
        <hr style="border: 2px solid #000;">
    </div>

    {{-- TABEL DATA --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ $loan->book->title }}</td>
                        <td class="text-center">{{ $loan->loan_date->format('d/m/Y') }}</td>
                        <td class="text-center">{{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}</td>
                        <td class="text-end">Rp {{ number_format($loan->fine->amount ?? 0) }}</td>
                        <td class="text-center">{{ ucfirst($loan->status) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Tidak ada data ditemukan untuk periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .sidebar, .top-navbar, .d-print-none, .btn { display: none !important; }
        .main-content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
        body { background-color: white !important; padding: 20px; }
        table { font-size: 12px; width: 100% !important; }
    }
</style>
@endsection