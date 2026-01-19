<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\LoanStatusNotification;
use App\Models\Loan;
use Carbon\Carbon;
use App\Models\Fine;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * Tampilkan semua data peminjaman
     */
    public function index()
    {
        $loans = Loan::with(['user', 'book', 'fine'])
            ->latest()
            ->get();

        return view('admin.loans.index', compact('loans'));
    }

    /**
     * Update status peminjaman (dikembalikan)
     */
    public function update(Loan $loan)
    {
        // Ubah status & tanggal kembali
        $loan->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        // Kembalikan stok buku
        $loan->book->increment('stock');

        return back()->with('success', 'Buku berhasil dikembalikan');
    }

    

    public function approve(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman tidak valid.');
        }

        if ($loan->book->stock < 1) {
            return back()->with('error', 'Stok buku habis.');
        }

        $loan->update([
            'status' => 'approved',
        ]);

        $loan->book()->decrement('stock');

        // 🔔 NOTIFIKASI KE USER
        $loan->user->notify(
            new LoanStatusNotification(
                "Pengajuan buku '{$loan->book->title}' disetujui. 
                Buku bisa diambil di perpustakaan."
            )
        );

        return back()->with('success', 'Peminjaman disetujui.');
    }


    public function reject(Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman sudah diproses.');
        }

        $loan->update(['status' => 'rejected']);

        $loan->user->notify(
        new LoanStatusNotification(
            "Pengajuan pinjaman buku '{$loan->book->title}' DITOLAK."
        )
    );

        return back()->with('success', 'Peminjaman ditolak.');
    }

public function return(Loan $loan)
{
    // Cegah double return
    if ($loan->status === 'returned') {
        return back()->with('error', 'Buku sudah dikembalikan.');
    }

    $today   = Carbon::today();
    $dueDate = Carbon::parse($loan->due_date)->startOfDay();

    // Hitung keterlambatan (TIDAK bisa minus)
    $daysLate = $today->greaterThan($dueDate)
        ? $today->diffInDays($dueDate)
        : 0;

    // 🔁 Update loan (SELALU dikembalikan)
    $loan->update([
        'status'       => 'returned',
        'return_date'  => now(),
    ]);

    // 📦 Kembalikan stok buku
    $loan->book()->increment('stock');

    // 💸 Jika telat → buat denda
    if ($daysLate > 0) {

        $amountPerDay = 2000; // Rp 2.000 / hari
        $totalAmount = $daysLate * $amountPerDay;

        Fine::create([
            'user_id'   => $loan->user_id,
            'loan_id'   => $loan->id,
            'days_late' => $daysLate,
            'amount'    => $totalAmount,
            'status'    => 'unpaid',
        ]);

        return back()->with(
            'warning',
            "Buku dikembalikan dengan denda Rp " . number_format($totalAmount)
        );
    }

    return back()->with('success', 'Buku berhasil dikembalikan.');
}


        
    public function previewReceipt($id) {
    // Admin bebas ambil data loan mana saja
    $loan = Loan::with(['user', 'book'])->findOrFail($id);
    return view('user.loans.preview', compact('loan'));
    }

    // TARUH DI SINI (Pastikan di dalam kurung kurawal class)
    public function report(Request $request)
    {
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $query = Loan::with(['user', 'book', 'fine']);

        if ($start_date && $end_date) {
            $query->whereBetween('loan_date', [$start_date, $end_date]);
        }

        $loans = $query->latest()->get();

        return view('admin.loans.report', compact('loans', 'start_date', 'end_date'));
    }
    
       
    

}
