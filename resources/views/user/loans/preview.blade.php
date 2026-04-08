@extends('layouts.user')

@section('title', 'Cetak Bukti Pinjam')

@section('content')
<div class="container py-4">
        {{-- Ganti tombol kembali Anda dengan ini agar Admin tidak Error --}}
        <div class="d-flex justify-content-between mb-4 d-print-none">
            <a href="javascript:history.back()" class="btn btn-outline-secondary shadow-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary shadow-sm">
                <i class="bi bi-printer me-2"></i> Cetak Bukti
            </button>
        </div>

    {{-- Kertas Bukti --}}
    <div class="card shadow border-0 mx-auto" style="max-width: 800px; background: white; border-radius: 0;">
        <div class="card-body p-5">
            {{-- Header/Kop --}}
            <div class="text-center mb-5 border-bottom pb-4">
                <h2 class="fw-bold text-primary mb-1">PERPUSTAKAAN DIGITAL MOJOKERTO</h2>
                <p class="text-muted mb-0">Jl. Raya Literasi No.- , Kota Mojokerto</p>
                <p class="small text-muted">Telp: (021) 888-999 | Email: library@digital.com</p>
            </div>

            {{-- Data Peminjam --}}
            <div class="row mb-4">
                <div class="col-6">
                    <p class="text-muted small mb-1 text-uppercase">Informasi Anggota:</p>
                    <h5 class="fw-bold mb-0">{{ $loan->user->name }}</h5>
                    <p class="text-muted small">{{ $loan->user->email }}</p>
                </div>
                <div class="col-6 text-end">
                    <p class="text-muted small mb-1 text-uppercase">Nomor Pinjam:</p>
                    <h5 class="fw-bold text-primary">#LN-{{ date('Y') }}-{{ str_pad($loan->id, 4, '0', STR_PAD_LEFT) }}</h5>
                </div>
            </div>

            {{-- Tabel Detail Buku --}}
            <div class="table-responsive mb-5">
                <table class="table table-bordered border-secondary">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Detail Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Kembali</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="fw-bold">{{ $loan->book->title }}</div>
                                <div class="small text-muted">Penulis: {{ $loan->book->author }}</div>
                            </td>
                            <td class="text-center align-middle">{{ $loan->loan_date->format('d/m/Y') }}</td>
                            <td class="text-center align-middle fw-bold text-danger">
                                {{ \Carbon\Carbon::parse($loan->due_date)->format('d/m/Y') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Catatan & Tanda Tangan --}}
            <div class="row mt-5">
                <div class="col-7">
                    <div class="p-3 bg-light rounded-3 small">
                        <strong>Perhatian:</strong>
                        <ul class="mb-0 ps-3 mt-1">
                            <li>Bawa bukti ini saat pengambilan buku fisik.</li>
                            <li>Keterlambatan akan dikenakan denda sesuai aturan.</li>
                            <li>Buku yang hilang/rusak wajib diganti.</li>
                        </ul>
                    </div>
                </div>
                <div class="col-5 text-center mt-4">
                    <p class="mb-5">Petugas Perpustakaan,</p>
                    <br><br>
                    <p class="fw-bold border-top pt-2">( ......................... )</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS MAGIC UNTUK PRINT */
    @media print {
        .d-print-none, .sidebar, .top-navbar, nav { display: none !important; }
        .main-content { margin-left: 0 !important; padding: 0 !important; }
        body { background: white !important; }
        .card { box-shadow: none !important; }
    }
</style>
@endsection