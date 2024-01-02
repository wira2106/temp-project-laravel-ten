<?php

use App\Http\Controllers\CetakKoliController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LoginController;
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
    Route::get('home', [CetakKoliController::class, 'index']);
    Route::post('get-user', [HomeController::class, 'getUser']);
    Route::post('insert-user', [HomeController::class, 'insertUser']);
    
    // API
    
    Route::get('print/reprint_checker', [CetakKoliController::class, 'print_reprint_checker']);
    Route::get('print/obi', [CetakKoliController::class, 'print_obi']);
    Route::get('print/plu', [CetakKoliController::class, 'print_plu']);
    Route::get('print/koli', [CetakKoliController::class, 'print_koli']);
    Route::get('api/koli/get_set_koli_omi', [CetakKoliController::class, 'get_set_koli_omi']);
    Route::post('api/koli/cetak_koli', [CetakKoliController::class, 'cetak_koli']);
    Route::post('api/koli/cetak_koli_reprint', [CetakKoliController::class, 'cetak_koli_reprint']);
    Route::get('api/obi/get_last_row', [CetakKoliController::class, 'get_last_row']);
    Route::get('api/obi/check_plu', [CetakKoliController::class, 'check_plu']);
    Route::post('api/reprint/checker', [CetakKoliController::class, 'reprint_checker']);
    Route::post('api/cetak/plu', [CetakKoliController::class, 'cetak_plu']);
    Route::post('api/cetak/obi', [CetakKoliController::class, 'cetak_obi']);
    Route::post('api/cetak/obi/reprint', [CetakKoliController::class, 'cetak_obi_reprint']);
});
