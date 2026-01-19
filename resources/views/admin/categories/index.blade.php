@extends('layouts.admin')

@section('title', 'Kategori Buku')

@section('content')

{{-- HEADER --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-bold" style="color: #1e3a8a;">Kategori Buku</h4>
        <p class="text-muted small mb-0">Kelola kategori untuk mengelompokkan koleksi buku Anda.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn text-white px-4 shadow-sm" style="background-color: #1e3a8a; border-radius: 10px;">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
    </a>
</div>

{{-- NOTIFIKASI --}}
@if(session('success'))
<div class="alert alert-success border-0 shadow-sm mb-4 d-flex align-items-center">
    <i class="bi bi-check-circle-fill me-2"></i>
    {{ session('success') }}
</div>
@endif

{{-- TABEL KATEGORI --}}
<div class="card border-0 shadow-sm" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #f8fafc;">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase small fw-bold" style="color: #1e3a8a; width: 80px;">No</th>
                        <th class="py-3 text-uppercase small fw-bold" style="color: #1e3a8a;">Nama Kategori</th>
                        <th class="py-3 text-uppercase small fw-bold text-center" style="color: #1e3a8a;">Total Buku</th>
                        <th class="pe-4 py-3 text-uppercase small fw-bold text-end" style="color: #1e3a8a; width: 200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td class="ps-4 fw-bold text-muted">{{ $loop->iteration }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $category->name }}</div>
                        </td>
                        <td class="text-center">
    @if($category->books_count > 0)
        <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3">
            {{ $category->books_count }} Buku
        </span>
    @else
        <span class="badge rounded-pill bg-light text-muted border px-3">
            0 Buku
        </span>
    @endif
</td>
                        <td class="pe-4 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="btn btn-sm btn-outline-warning border-0 shadow-sm bg-white">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>

                                <form action="{{ route('admin.categories.destroy', $category) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger border-0 shadow-sm bg-white" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Buku dengan kategori ini mungkin akan kehilangan relasinya.')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-folder-x fs-1 opacity-25 d-block mb-2"></i>
                            Belum ada kategori yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .table thead th {
        border-bottom: 2px solid #eef2f7;
    }
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
    .btn-sm {
        padding: 0.4rem 0.8rem;
        border-radius: 8px;
    }
</style>

@endsection