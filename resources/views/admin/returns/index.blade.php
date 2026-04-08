@extends('layouts.admin')

@section('title', 'Proses Pengembalian')

@section('content')
<div class="container-fluid py-4">
    
    {{-- Header Halaman --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Menu Pengembalian Buku</h4>
            <p class="text-muted small mb-0">Kelola jaminan, cek kondisi buku, dan hitung denda kerusakan.</p>
        </div>
        <i class="bi bi-shield-check fs-2 text-primary opacity-25"></i>
    </div>

    {{-- Alert Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4" role="alert" style="border-radius: 12px;">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- Tabel Card --}}
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #0f172a; color: #ffffff;">
                        <tr>
                            <th class="px-4 py-3 border-0 small text-uppercase text-center">No</th>
                            <th class="px-4 py-3 border-0 small text-uppercase">Peminjam & Jaminan</th>
                            <th class="px-4 py-3 border-0 small text-uppercase">Buku</th>
                            <th class="px-4 py-3 border-0 small text-uppercase text-center">Jatuh Tempo</th>
                            <th class="px-4 py-3 border-0 small text-uppercase text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($loans as $index => $loan)
                            <tr class="border-bottom">
                                <td class="px-4 py-3 text-center text-muted small">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="fw-bold text-dark">{{ $loan->user->name }}</div>
                                    {{-- JAMINAN DITAMPILKAN DI SINI --}}
                                    <span class="badge {{ $loan->guarantee ? 'bg-primary-subtle text-primary border-primary-subtle' : 'bg-light text-muted border' }} small fw-normal">
                                        <i class="bi bi-card-heading me-1"></i> Jaminan: <strong>{{ $loan->guarantee ?? 'Tidak ada' }}</strong>
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="text-dark fw-semibold">{{ $loan->book->title }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="small fw-bold {{ \Carbon\Carbon::parse($loan->due_date)->isPast() ? 'text-danger' : 'text-success' }}">
                                        {{ \Carbon\Carbon::parse($loan->due_date)->format('d/m/Y') }}
                                        @if(\Carbon\Carbon::parse($loan->due_date)->isPast())
                                            <br><span style="font-size: 0.7rem;" class="text-uppercase">(Terlambat)</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" 
                                            data-bs-toggle="modal" data-bs-target="#returnModal{{ $loan->id }}">
                                        Proses Kembali
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted italic">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                    Tidak ada buku yang sedang dipinjam.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($loans as $loan)
<div class="modal fade" id="returnModal{{ $loan->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-arrow-return-left me-2"></i>Konfirmasi Pengembalian</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="{{ route('admin.returns.process', $loan->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4 text-start">
                    
                    {{-- INFO JAMINAN YANG HARUS DIKEMBALIKAN --}}
                    <div class="p-3 mb-4 rounded-3 border-start border-4 border-warning bg-warning bg-opacity-10">
                        <label class="text-muted small fw-bold text-uppercase d-block mb-1">Peringatan Jaminan:</label>
                        <h6 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                            Kembalikan: <span class="text-primary">{{ $loan->guarantee ?? 'Tidak ada jaminan' }}</span>
                        </h6>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-secondary">KONDISI BUKU SAAT INI</label>
                        <select name="book_condition" class="form-select border-primary" required onchange="toggleDamageInput(this, {{ $loan->id }})">
                            <option value="baik">Baik / Normal</option>
                            <option value="rusak">Rusak (Dikenakan Denda)</option>
                            <option value="hilang">Hilang (Dikenakan Denda)</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="damageInputGroup{{ $loan->id }}">
                        <label class="form-label fw-bold small text-danger">BIAYA KERUSAKAN / GANTI RUGI (RP)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-danger text-white border-danger">Rp</span>
                            <input type="number" name="damage_fee" class="form-control border-danger" placeholder="Contoh: 50000">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold small text-secondary text-uppercase mb-2 d-block">Metode Pembayaran Denda</label>
                        <div class="row g-2">
                            @foreach(['tunai' => 'Cash', 'qris' => 'QRIS', 'dana' => 'DANA', 'transfer' => 'Bank'] as $key => $label)
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="payment_method" 
                                       value="{{ $key }}" 
                                       id="pay_{{ $key }}_{{ $loan->id }}" 
                                       {{ $key == 'tunai' ? 'checked' : '' }} 
                                       autocomplete="off" required>
                                
                                <label class="btn btn-outline-primary w-100 rounded-3 py-3 d-flex flex-column align-items-center" 
                                       for="pay_{{ $key }}_{{ $loan->id }}">
                                    
                                    @if($key == 'tunai') <i class="bi bi-cash-stack fs-4 mb-1"></i>
                                    @elseif($key == 'qris') <i class="bi bi-qr-code-scan fs-4 mb-1"></i>
                                    @elseif($key == 'dana') <i class="bi bi-wallet2 fs-4 mb-1"></i>
                                    @else <i class="bi bi-bank fs-4 mb-1"></i>
                                    @endif
                                    
                                    <span class="small fw-bold text-uppercase">{{ $label }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">Selesaikan & Kembalikan Jaminan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
    function toggleDamageInput(selectElement, loanId) {
        const inputGroup = document.getElementById('damageInputGroup' + loanId);
        if (selectElement.value === 'rusak' || selectElement.value === 'hilang') {
            inputGroup.classList.remove('d-none');
            inputGroup.querySelector('input').setAttribute('required', 'required');
        } else {
            inputGroup.classList.add('d-none');
            inputGroup.querySelector('input').removeAttribute('required');
        }
    }
</script>

<style>
    .table thead th { font-weight: 600; letter-spacing: 0.5px; }
    .btn-primary { background-color: #1e40af; border: none; }
    .card { border-radius: 12px; }
    .bg-primary-subtle { background-color: #e0e7ff !important; }

    /* Efek saat tombol metode pembayaran dipilih */
    .btn-check:checked + .btn-outline-primary {
        background-color: #0d6efd;
        color: white;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        border-color: #0d6efd;
    }

    .btn-outline-primary:hover {
        background-color: #f0f7ff;
        color: #0d6efd;
    }
</style>

@endsection