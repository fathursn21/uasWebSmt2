<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KeranjangController;

use Illuminate\Support\Facades\Route;

Route::get('/', [ProdukController::class, 'guest'])->name('dashguest');

Route::get('/dashboard', [ProdukController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::resource('produk', ProdukController::class);

Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/cart/pelanggan', [ProdukController::class, 'cart'])->name('produk.cart');
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::get('/produk/{id}/destroy', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::resource('transaksi', TransaksiController::class);

    Route::get('/checkout', [KeranjangController::class, 'index'])->name('checkout.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/kurang/{id}', [KeranjangController::class, 'kurang'])->name('keranjang.kurang');
    Route::post('/checkout/proses', [KeranjangController::class, 'proses'])->name('checkout.proses');

    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/token', [KeranjangController::class, 'getSnapToken']);
    Route::post('/keranjang/checkout', [KeranjangController::class, 'checkout']);
    Route::post('/keranjang/kurang', [KeranjangController::class, 'kurang'])->name('keranjang.kurang');

    Route::get('/checkout/success', function () {
        session()->forget('keranjang');
        return view('checkout.success');

    });
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
});

require __DIR__ . '/auth.php';
