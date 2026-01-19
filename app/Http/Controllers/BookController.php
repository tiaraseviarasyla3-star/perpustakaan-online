<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search   = $request->query('search');
        $category = $request->query('category');

        $books = Book::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->latest()
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('user.books.index', compact(
            'books',
            'categories',
            'search',
            'category'
        ));
    }

    public function show(Book $book)
    {
        $book->load('category');
        return view('user.books.show', compact('book'));
    }

    public function borrow(Book $book)
    {
        if ($book->stock < 1) {
            return back()->with('error', 'Stok buku habis.');
        }

        $user = auth()->user();

        $active = Loan::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($active >= 3) {
            return back()->with('error', 'Maksimal 3 buku.');
        }

        Loan::create([
            'user_id'   => $user->id,
            'book_id'   => $book->id,
            'loan_date' => now(),
            'due_date'  => now()->addDays(7),
            'status'    => 'pending',
        ]);

        return back()->with('success', 'Pengajuan peminjaman dikirim.');
    }
    
}
