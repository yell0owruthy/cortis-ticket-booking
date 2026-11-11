<?php

use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\BookingController as UserBookingController;
use App\Models\Ticket;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// 1. Halaman Utama
Route::get('/', function () {
    return view('welcome');
});

// 2. Pengalihan Otomatis Setelah Login Berdasarkan Role
Route::get('/dashboard', function (Request $request) {
    if ($request->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 3. Grup Route Khusus Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalKategori = Ticket::count();
        $totalTiketTerjual = Transaction::where('status', 'paid')->sum('jumlah_tiket');
        $totalPendapatan = Transaction::where('status', 'paid')->sum('total_harga');
        $transaksiPending = Transaction::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalKategori',
            'totalTiketTerjual',
            'totalPendapatan',
            'transaksiPending'
        ));
    })->name('dashboard');

    Route::resource('tickets', AdminTicketController::class)->except(['show']);

    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::patch('/transactions/{transaction}/status', [AdminTransactionController::class, 'updateStatus'])->name('transactions.updateStatus');
});

// 4. Grup Route Khusus User
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    // Katalog Tiket (Dashboard User)
    Route::get('/dashboard', [UserBookingController::class, 'index'])->name('dashboard');

    // Form & Proses Pembelian Tiket
    Route::get('/tickets/{ticket}/checkout', [UserBookingController::class, 'create'])->name('tickets.checkout');
    Route::post('/tickets/{ticket}/checkout', [UserBookingController::class, 'store'])->name('tickets.store');

    // Riwayat Tiket Saya
    Route::get('/my-tickets', [UserBookingController::class, 'history'])->name('transactions.index');
});

// 5. Route Profil Bawaan Breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';