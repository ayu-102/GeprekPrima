<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Artisan;



/*
| 1. HALAMAN UTAMA & AUTH
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/', [AuthController::class, 'showLogin']);

Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

/*
2. ROUTE UNTUK KASIR (ADMIN) - Mengelola Data & Pesanan Masuk
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [KasirController::class, 'index'])->name('dashboard');
    Route::get('/pesanan', [KasirController::class, 'pesanan'])->name('pesanan.index');
    Route::get('/riwayat', [KasirController::class, 'riwayat'])->name('riwayat.index');
    Route::get('/keuangan', [KasirController::class, 'keuangan'])->name('keuangan.index');
    Route::get('/pengaturan', [KasirController::class, 'pengaturan'])->name('pengaturan.index');
    Route::put('/pengaturan/update', [KasirController::class, 'updateProfil'])->name('pengaturan.update');
    Route::get('/menu', [KasirController::class, 'menu'])->name('menu.index');
    Route::post('/menu', [KasirController::class, 'store'])->name('menu.store');
    Route::put('/menu/{id}', [KasirController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{id}', [KasirController::class, 'destroy'])->name('menu.destroy');
    Route::post('/kasir/selesai/{id}', [KasirController::class, 'selesaikanPesanan'])->name('kasir.selesai');
    Route::get('/kasir/pesanan/{id}', [KasirController::class, 'showDetail'])->name('kasir.pesanan.detail');
    Route::get('/fetch-pesanan', [KasirController::class, 'fetchPesanan'])->name('pesanan.fetch');
    Route::post('/kasir/batal/{id}', [KasirController::class, 'batalkanPesanan'])->name('orders.cancel');
});


/*
| 3. ROUTE UNTUK USER (PELANGGAN) - Memesan Menu
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/order', [UserOrderController::class, 'index'])->name('menu-user.index');
    Route::get('/order/detail/{id}', [UserOrderController::class, 'detail'])->name('menu-user.detail');
    Route::post('/cart/add/{id}', [UserOrderController::class, 'addToCart'])->name('cart.add');
    Route::get('/checkout', [UserOrderController::class, 'checkout'])->name('cart.checkout');
    Route::post('/order/process', [UserOrderController::class, 'processOrder'])->name('order.process');
    Route::put('/order/{id}/update-status', [KasirController::class, 'updateStatus'])->name('order.update-status');
    Route::get('/kasir/print/{id}', [KasirController::class, 'printStruk'])->name('pesanan.struk');
    Route::get('/order/receipt/{id}', [UserOrderController::class, 'receipt'])->name('order.receipt');
});



Route::get('/link', function () {
    Artisan::call('storage:link');
    return "Jembatan Storage Berhasil Dibuat!";
});
