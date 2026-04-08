<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnController extends Controller
{
    /**
     * Tampilkan daftar buku yang sedang dipinjam (untuk dikembalikan)
     */
    public function index()
    {
        $loans = Loan::with(['user', 'book'])
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('admin.returns.index', compact('loans'));
    }

    /**
     * Proses pengembalian buku dengan pengecekan kondisi dan denda
     */
    public function process(Request $request, Loan $loan)
{
    // 1. Validasi
    $request->validate([
        'book_condition' => 'required|in:baik,rusak,hilang',
        'payment_method' => 'required|in:tunai,transfer,qris,dana',
        'damage_fee'     => 'nullable|numeric|min:0',
    ]);

    // 2. Update Loan (Simpan QRIS/DANA di sini)
    $loan->update([
        'status'         => 'returned',
        'return_date'    => now(),
        'book_condition' => $request->book_condition,
        'damage_fee'     => $request->damage_fee ?? 0,
        'payment_method' => $request->payment_method, // INI YANG PENTING
    ]);

    // 3. Update Stok
    if ($request->book_condition !== 'hilang') {
        $loan->book()->increment('stock');
    }

    // 4. Hitung Denda Keterlambatan
    $today = \Carbon\Carbon::today();
    $dueDate = \Carbon\Carbon::parse($loan->due_date);
    $daysLate = $today->gt($dueDate) ? $today->diffInDays($dueDate) : 0;
    $lateFee = $daysLate * 2000;
    $totalFine = $lateFee + ($request->damage_fee ?? 0);

    // 5. Simpan ke Tabel Fines (Denda)
    if ($totalFine > 0) {
        \App\Models\Fine::create([
            'user_id'   => $loan->user_id,
            'loan_id'   => $loan->id,
            'days_late' => $daysLate,
            'amount'    => $totalFine,
            'status'    => 'paid',
        ]);
    }

    return redirect()->route('admin.returns.index')->with('success', 'Buku kembali via ' . strtoupper($request->payment_method));
}
}