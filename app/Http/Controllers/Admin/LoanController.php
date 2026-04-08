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

    

   public function approve(Request $request, Loan $loan) // Tambahkan Request $request
{
    if ($loan->status !== 'pending') {
        return back()->with('error', 'Peminjaman tidak valid.');
    }

    if ($loan->book->stock < 1) {
        return back()->with('error', 'Stok buku habis.');
    }

    // 1. UPDATE DATA (Tambahkan jaminan di sini)
    $loan->update([
        'status' => 'approved',
        'guarantee' => $request->guarantee, // AMBIL DATA JAMINAN DARI FORM
        'loan_date' => now(),
        'due_date' => now()->addDays(7), // Atur jatuh tempo otomatis
    ]);

    $loan->book()->decrement('stock');

    // 🔔 NOTIFIKASI KE USER
    $loan->user->notify(
        new LoanStatusNotification(
            "Pengajuan buku '{$loan->book->title}' disetujui. 
            Jaminan: {$request->guarantee}. Buku bisa diambil di perpustakaan."
        )
    );

    return back()->with('success', 'Peminjaman disetujui dengan jaminan ' . $request->guarantee);
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

    // Hitung keterlambatan (tidak bisa minus)
    $daysLate = 0;

    if ($today->gt($dueDate)) {
        $daysLate = $dueDate->diffInDays($today);
    }

    // Update status loan
    $loan->update([
        'status'      => 'returned',
        'return_date' => now(),
    ]);

    // Kembalikan stok buku
    $loan->book()->increment('stock');

    // Jika telat → buat denda
    if ($daysLate > 0) {

        $totalAmount = $daysLate * 2000;

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
