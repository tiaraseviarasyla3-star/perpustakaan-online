<h1>Peminjaman Saya</h1>

@if ($myLoans->isEmpty())
    <p>Belum ada peminjaman</p>
@endif

<ul>
@foreach ($myLoans as $loan)
    <li>
        <strong>{{ $loan->book->title }}</strong> <br>
        Tanggal pinjam: {{ $loan->loan_date }} <br>
        Jatuh tempo: {{ $loan->due_date }} <br>
        Status: {{ $loan->status }}

        {{-- TAMPILKAN DENDA JIKA ADA --}}
        @if ($loan->fine)
            <br>
            <span style="color:red">
                Denda: Rp {{ number_format($loan->fine->amount) }}
                ({{ $loan->fine->status }})
            </span>
        @endif

        {{-- tombol kembalikan --}}
        @if ($loan->status === 'borrowed')
            <form action="{{ route('loans.return', $loan) }}" method="POST">
                @csrf
                <button type="submit">Kembalikan</button>
            </form>
        @endif
    </li>
    <hr>
@endforeach
</ul>
