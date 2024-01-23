<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'guest'], function () {
    Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('loginPost');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::resource('/petugas', OfficerController::class)->middleware(['check-role:admin']);
    Route::resource('/barang', ProductController::class);
    Route::resource('/pelanggan', CustomerController::class);
    Route::resource('/transaksi', SaleController::class);
    Route::delete('/transaksi/{id}/batal', [SaleController::class,'cancel'])->name('transaksi.cancel');
    Route::post('/transaksi/{id}/selesai',[SaleController::class,'finish'])->name('transaksi.finish');

    Route::delete('/logout', [AuthController::class,'logout'])->name('logout');
});
