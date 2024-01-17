<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PromosiController;
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
Route::get('/', function () {
    // dd(Session::get('token'));
    return redirect()->route('login');
});
//LOGIN
Route::post('/login', [LoginController::class, 'login']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'logout']);

Route::middleware(['mylogin'])->group(function () {
    //HOME
    Route::get('home', [LabelController::class, 'index']);
    Route::get('promo', [PromosiController::class, 'index']);
    Route::get('cetak', [LabelController::class, 'cetak']);
    Route::post('get-user', [HomeController::class, 'getUser']);
    Route::post('insert-user', [HomeController::class, 'insertUser']);

    Route::get('api/label/data/produk', [LabelController::class, 'data_master']);
    Route::get('api/label/data/label', [LabelController::class, 'data_master_label']);
    Route::get('api/label/data/sub_rak', [LabelController::class, 'data_subrak']);
    Route::get('api/label/data/tipe_rak', [LabelController::class, 'data_tiperak']);
    Route::get('api/label/data/shelving_rak', [LabelController::class, 'data_shelvingrak']);
    Route::get('api/label/data/divisi', [LabelController::class, 'data_div']);
    Route::get('api/label/data/dept', [LabelController::class, 'data_dept']);
    Route::get('api/label/data/katb', [LabelController::class, 'data_katb']);
    Route::post('api/label/delete', [LabelController::class, 'cek_delete_data_label']);
    Route::get('api/promo/data/promo', [PromosiController::class, 'data_promo']);
    Route::post('api/promo/check_prdcd', [PromosiController::class, 'check_prdcd']);

    Route::post('api/insert/byplu', [LabelController::class, 'insert_to_database']);
    Route::post('api/insert/byrak', [LabelController::class, 'insert_to_database_by_rak']);
    Route::post('api/insert/bydiv', [LabelController::class, 'insert_to_database_by_div']);
    Route::post('api/insert/bytanggal', [LabelController::class, 'insert_to_database_by_tanggal']);
    Route::post('api/insert/bysetting', [LabelController::class, 'insert_to_database_by_setting']);
    Route::post('api/insert/byflag', [LabelController::class, 'insert_to_database_by_flag']);
    Route::post('api/insert/promo', [PromosiController::class, 'insert_to_database_promo']);
    
});
