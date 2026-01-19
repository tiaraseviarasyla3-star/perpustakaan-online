@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold" style="color: #1e3a8a;">Manajemen Koleksi Buku</h4>
        <p class="text-muted small mb-0">Kelola daftar buku, stok, dan kategori perpustakaan Anda.</p>
    </div>
    <a href="{{ route('admin.books.create') }}" class="btn text-white px-4 shadow-sm" style="background-color: #1e3a8a; border-radius: 10px;">
        <i class="bi bi-plus-lg me-1"></i> Tambah Buku
    </a>
</div>

{{-- NOTIFIKASI --}}
@if(session('success'))
<div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center">
    <i class="bi bi-check-circle-fill me-2"></i>
    {{ session('success') }}
</div>
@endif

{{-- TABEL KARTU --}}
<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #f8fafc;">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold" style="color: #1e3a8a;">Judul Buku</th>
                        <th class="py-3 text-uppercase small fw-bold" style="color: #1e3a8a;">Penulis</th>
                        <th class="py-3 text-uppercase small fw-bold" style="color: #1e3a8a;">Kategori</th>
                        <th class="py-3 text-uppercase small fw-bold text-center" style="color: #1e3a8a;">Stok</th>
                        <th class="pe-4 py-3 text-uppercase small fw-bold text-end" style="color: #1e3a8a;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $book->title }}</div>
                        </td>
                        <td class="text-muted">{{ $book->author }}</td>
                        <td>
                            <span class="badge px-3 py-2" style="background-color: #e0e7ff; color: #1e3a8a; font-weight: 500;">
                                {{ $book->category->name ?? '-' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($book->stock <= 0)
                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3">Habis</span>
                            @elseif($book->stock <= 5)
                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3">{{ $book->stock }} (Menipis)</span>
                            @else
                                <span class="badge bg-success-subtle text-success rounded-pill px-3">{{ $book->stock }}</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning btn-sm border-0 text-dark">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                {{-- Tombol Hapus (Opsional - Jika Anda memiliki route destroy) --}}
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm border-0">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- INFO FOOTER --}}
<div class="mt-3 text-muted small px-2">
    Menampilkan total <strong>{{ $books->count() }}</strong> buku dalam database.
</div>

<style>
    /* Styling untuk memperhalus tampilan tabel */
    .table thead th {
        border-bottom: 2px solid #eef2f7;
    }
    .table tbody tr {
        transition: all 0.2s ease;
    }
    .table tbody tr:hover {
        background-color: #f1f5f9;
    }
    .badge {
        letter-spacing: 0.3px;
    }
</style>

@endsection