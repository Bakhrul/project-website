<?php

use Illuminate\Support\Facades\Route;

// admin controller
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\Master\SatuanController;
use App\Http\Controllers\Admin\Master\ItemController;
use App\Http\Controllers\Admin\Master\PenggunaController;
use App\Http\Controllers\Admin\Master\BanksController;
use App\Http\Controllers\Admin\Master\SaldoController;

use App\Http\Controllers\Admin\KonfirmasiSaldoController;

//auth controller
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\LoginController;


//pengguna controller
use App\Http\Controllers\Pengguna\HomeController;
use App\Http\Controllers\Pengguna\Saldo\HistorySaldoController;
use App\Http\Controllers\Pengguna\Saldo\PembelianSaldoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['auth']], function () {
    Route::prefix('admin-panel')->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('index');

        // master data
        Route::prefix('master')->name('master.')->group(function () {

            //master satuan
            Route::prefix('satuan')->name('satuan.')->group(function () {
                Route::get('/', [SatuanController::class, 'index'])->name('index');

                Route::post('datatable', [SatuanController::class, 'datatable'])->name('datatable');
                Route::post('store', [SatuanController::class, 'store'])->name('store');
                Route::get('show/{id}', [SatuanController::class, 'show'])->name('show');
                Route::post('update/{id}', [SatuanController::class, 'update'])->name('update');
                Route::post('delete/{id}', [SatuanController::class, 'delete'])->name('delete');
            });

            //master item
            Route::prefix('item')->name('item.')->group(function () {
                Route::get('/', [ItemController::class, 'index'])->name('index');

                Route::post('datatable', [ItemController::class, 'datatable'])->name('datatable');
                Route::post('store', [ItemController::class, 'store'])->name('store');
                Route::get('show/{id}', [ItemController::class, 'show'])->name('show');
                Route::post('update/{id}', [ItemController::class, 'update'])->name('update');
                Route::post('delete/{id}', [ItemController::class, 'delete'])->name('delete');

                Route::post('price/datatable', [ItemController::class, 'priceDatatable'])->name('price.datatable');
                Route::post('price/store', [ItemController::class, 'priceStore'])->name('price.store');
                Route::get('price/show/{id}', [ItemController::class, 'priceShow'])->name('price.show');
                Route::post('price/update/{id}', [ItemController::class, 'priceUpdate'])->name('price.update');

            });

            //master pengguna
            Route::prefix('pengguna')->name('pengguna.')->group(function () {
                Route::get('/', [PenggunaController::class, 'index'])->name('index');

                Route::post('datatable', [PenggunaController::class, 'datatable'])->name('datatable');
                Route::get('show/{id}', [PenggunaController::class, 'show'])->name('show');
                Route::post('delete/{id}', [PenggunaController::class, 'delete'])->name('delete');
            });

            //master banks
            Route::prefix('banks')->name('banks.')->group(function () {
                Route::get('/', [BanksController::class, 'index'])->name('index');

                Route::post('datatable', [BanksController::class, 'datatable'])->name('datatable');
                Route::post('store', [BanksController::class, 'store'])->name('store');
                Route::get('show/{id}', [BanksController::class, 'show'])->name('show');
                Route::post('update/{id}', [BanksController::class, 'update'])->name('update');
                Route::post('delete/{id}', [BanksController::class, 'delete'])->name('delete');
            });

            //master saldo
            Route::prefix('saldo')->name('saldo.')->group(function () {
                Route::get('/', [SaldoController::class, 'index'])->name('index');

                Route::post('datatable', [SaldoController::class, 'datatable'])->name('datatable');
                Route::post('store', [SaldoController::class, 'store'])->name('store');
                Route::get('show/{id}', [SaldoController::class, 'show'])->name('show');
                Route::post('update/{id}', [SaldoController::class, 'update'])->name('update');
                Route::post('delete/{id}', [SaldoController::class, 'delete'])->name('delete');
            });

        });

        Route::prefix('konfirmasi-saldo')->name('konfirmasi_saldo.')->group(function () {
            Route::get('/', [KonfirmasiSaldoController::class, 'index'])->name('index');

            Route::post('datatable', [KonfirmasiSaldoController::class, 'datatable'])->name('datatable');
            Route::post('konfirmasi/{id}', [KonfirmasiSaldoController::class, 'konfirmasi'])->name('konfirmasi');
        });
    });

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');

    Route::get('/history-pembelian-saldo',[HistorySaldoController::class,'index'])->name('history_saldo.index');

    Route::get('/pembelian-saldo',[PembelianSaldoController::class,'index'])->name('pembelian_saldo.index');
    Route::post('/pembelian-saldo/buy',[PembelianSaldoController::class,'buySaldo'])->name('pembelian_saldo.buy');

});






Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::post('/getDataTablePriceItem', [HomeController::class, 'getDataTable'])->name('home.getDataTablePriceItem');
Route::post('/getDataGrafikPriceItem', [HomeController::class, 'getGrafik'])->name('home.getDataGrafikPriceItem');

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login/process', [LoginController::class, 'login'])->name('login.process');

Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register/process', [RegisterController::class, 'register'])->name('register.process');
Route::get('/verification', [RegisterController::class, 'verifikasi'])->name('verifikasi.index');

Route::get('/forgot-password', [ResetPasswordController::class, 'index'])->name('lupa_password.index');
Route::post('/forgot-password/process', [ResetPasswordController::class, 'lupaPassword'])->name('lupa_password.process');
Route::get('/reset-password', [ResetPasswordController::class, 'resetPassword'])->name('reset_password.index');
Route::post('/reset-password/process', [ResetPasswordController::class, 'resetPasswordProcess'])->name('reset_password.process');


