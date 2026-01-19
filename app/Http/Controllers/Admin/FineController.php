<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fine;


class FineController extends Controller
{
    public function index()
    {
        $fines = Fine::with('loan.book')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('fines.index', compact('fines'));
    }

    public function pay(Fine $fine)
    {
        if ($fine->status === 'paid') {
            return back()->with('error', 'Denda sudah dibayar');
        }

        $fine->update([
            'status'  => 'paid',
            'paid_at' => now()
        ]);

        return back()->with('success', 'Denda dibayar');
    }
}
