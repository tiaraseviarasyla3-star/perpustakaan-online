<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use App\Notifications\LoanStatusNotification;
use App\Notifications\NewLoanNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;


class LoanController extends Controller
{
    public function index()
    {
        $loans = auth()->user()
            ->loans()
            ->with('book')
            ->latest()
            ->get();

        return view('user.loans.index', compact('loans'));
    }

    public function store(Request $request, Book $book)
    {
        // 1. Validasi input
        $request->validate([
    'due_date' => 'required|date|after_or_equal:today',
]);


        // 2. Validasi stok
        if ($book->stock < 1) {
            return back()->with('error', 'Stok buku habis');
        }

       // 2️⃣ Batas maksimal pinjam (contoh: 3 buku)
        $activeLoansCount = Loan::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($activeLoansCount >= 3) {
            return back()->with('error', 'Maksimal peminjaman 3 buku');
        }

        // 3️⃣ Cegah pinjam buku yang sama
        $alreadyBorrowed = Loan::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', 'Buku ini sudah kamu pinjam.');
        }

        // 4. Batasi maksimal hari pinjam (contoh: 14 hari)
        $maxDays = 14;
        $days = now()->diffInDays($request->due_date);

        if ($days > $maxDays) {
            return back()->with('error', 'Maksimal peminjaman adalah 14 hari');
        }

        // 5. Simpan peminjaman
        $loan = Loan::create([
            'user_id'   => Auth::id(),
            'book_id'   => $book->id,
            'loan_date' => now(),
            'due_date'  => $request->due_date,
            'status'    => 'pending',
        ]);

        // 🔔 KIRIM KE SEMUA ADMIN
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewLoanNotification($loan));

        return redirect()->route('books.index')
        ->with('success', 'Pengajuan pinjaman berhasil dikirim.');
    }

        public function userLoans()
        {
            $loans = Loan::with(['book', 'fine'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();


            return view('user.loans.index', compact('loans'));
        }

        public function create(Book $book)
        {
            return view('user.loans.create', compact('book'));
        }


    
        public function previewReceipt($id)
        {
            // 1. Ambil data loan beserta info user dan buku
            $loan = Loan::with(['user', 'book'])->findOrFail($id);
            
            // 2. KOREKSI LOGIKA KEAMANAN:
            // Izinkan jika: Dia adalah Admin ATAU Dia adalah pemilik data tersebut
            if (auth()->user()->role !== 'admin' && auth()->id() !== $loan->user_id) {
                abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
            }

            return view('user.loans.preview', compact('loan'));
        }
}
