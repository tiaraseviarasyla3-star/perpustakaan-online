
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Loan;
use App\Models\Fine;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Statistik Dasar
        $totalBooks = Book::count();
        $totalUsers = User::where('role', 'user')->count();
        $activeLoans = Loan::where('status', 'approved')->count();
        
        // 2. Ambil Data Pendapatan Denda per Bulan (Tahun Ini)
        // Kita join atau ambil langsung dari tabel fines
        $monthlyFines = Fine::select(
            DB::raw('SUM(amount) as total'),
            DB::raw('MONTH(created_at) as month')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->pluck('total', 'month')
        ->toArray();

        // 3. Susun Data untuk Grafik (Januari - Desember)
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            // Jika bulan tersebut tidak ada denda, isi 0
            $chartData[] = $monthlyFines[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalBooks', 
            'totalUsers', 
            'activeLoans', 
            'chartData'
        ));
    }
}
