<?php

use App\Http\Controllers\AlokasiController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonitoringController;
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
    Route::get('home', [AlokasiController::class, 'index']);
    Route::get('cetak', [LabelController::class, 'cetak']);
    Route::post('get-user', [HomeController::class, 'getUser']);
    Route::post('insert-user', [HomeController::class, 'insertUser']);
    
    Route::get('/home/alokasi/seasonal', [AlokasiController::class, 'index']);
    Route::get('/home/alokasi/khusus', [AlokasiController::class, 'index_khusus']);

    Route::get('/api/alokasi/seasonal/loadseasonal', [AlokasiController::class, 'alokasi_seasonal_load']);
    Route::get('/api/alokasi/seasonal/loadtoko', [AlokasiController::class, 'load_toko']);
    Route::get('/api/alokasi/seasonal/loadplu', [AlokasiController::class, 'load_plu']);
    
    Route::get('/api/alokasi/khusus/loadtoko', [AlokasiController::class, 'alokasi_khusus_load']);
    Route::get('/api/alokasi/khusus/loadplu', [AlokasiController::class, 'get_list_plu']);

    Route::get('/api/monitoring/toko/loadPeriodeToko', [MonitoringController::class, 'load_periode_toko']);
    Route::get('/api/monitoring/toko/loadData', [MonitoringController::class, 'load_data_by_toko']);

    Route::get('/api/monitoring/item/loadPeriodePlu', [MonitoringController::class, 'load_periode_plu']);
    Route::get('/api/monitoring/item/loadData', [MonitoringController::class, 'load_data_by_toko']);
    
    Route::get('/monitoring/bytoko', [MonitoringController::class, 'index']);
    Route::get('/monitoring/byitem', [MonitoringController::class, 'index_byitem']);
    Route::get('/email', [EmailController::class, 'index']);
    Route::get('/api/email/check', [EmailController::class, 'check_email']);
    
    Route::post('/api/alokasi/KirimPBSeasonal', [AlokasiController::class, 'kirim_pb_seasonal']);
    Route::post('/api/alokasi/KirimPBKhusus', [AlokasiController::class, 'kirim_pb_khusus']);
    Route::post('/api/email/edit', [EmailController::class, 'update']);
    Route::post('/api/email/add', [EmailController::class, 'store']);
});
