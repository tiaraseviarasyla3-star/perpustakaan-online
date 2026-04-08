<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// USER CONTROLLER
use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\LoanController as AdminLoanController;
use App\Http\Controllers\Admin\ReturnController ;

/*
|--------------------------------------------------------------------------
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('landing');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/'); 
})->name('logout');

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // USER BOOKS
    Route::get('/books', [BookController::class, 'index'])
        ->name('books.index');

    Route::get('/books/{book}', [BookController::class, 'show'])
        ->name('books.show');    

    Route::post('/books/{book}/borrow', [BookController::class, 'borrow'])
        ->name('books.borrow');    

    // form pengajuan
    Route::get('/loans/create/{book}', [LoanController::class, 'create'])
        ->name('loans.create');

    // simpan pengajuan
    Route::post('/loans/{book}', [LoanController::class, 'store'])
        ->name('loans.store');

    // USER LOANS (riwayat pinjaman)
    Route::get('/my-loans', [LoanController::class, 'index'])
        ->name('user.loans.index');

        Route::get('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAsRead');

    // User melihat daftar pinjamannya dan cetak bukti sendiri
    Route::get('/loans/{id}/preview', [LoanController::class, 'previewReceipt'])->name('loans.preview');
});



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('books', AdminBookController::class);
        Route::resource('categories', AdminCategoryController::class);

        Route::get('loans', [AdminLoanController::class, 'index'])
            ->name('loans.index');

        Route::post('/loans/{loan}/approve', [AdminLoanController::class, 'approve'])
            ->name('loans.approve');

        Route::post('/loans/{loan}/reject', [AdminLoanController::class, 'reject'])
            ->name('loans.reject');

        Route::post('/loans/{loan}/return', [AdminLoanController::class, 'return'])
        ->name('loans.return');

        // INI YANG MUNGKIN TERLEWAT:
         Route::get('/loans/{id}/preview', [LoanController::class, 'previewReceipt'])->name('loans.preview');

         // Route Laporan Periodik
         Route::get('/loans/report', [AdminLoanController::class, 'report'])->name('loans.report');

         Route::get('/fines', [FineController::class, 'index'])->name('fines.index');
        Route::post('/fines/{fine}/pay', [FineController::class, 'pay'])->name('fines.pay');

         Route::get('/returns', [ReturnController::class, 'index'])
        ->name('returns.index');

         Route::post('/returns/{loan}', [ReturnController::class, 'process'])
        ->name('returns.process');
});


    



// Include Breeze auth routes
require __DIR__.'/auth.php';
