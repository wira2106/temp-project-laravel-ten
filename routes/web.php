<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonitoringCheckerMobileController;
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
    Route::get('home', [MonitoringCheckerMobileController::class, 'index']);
    Route::get('cetak', [LabelController::class, 'cetak']);
    Route::post('get-user', [HomeController::class, 'getUser']);
    Route::post('insert-user', [HomeController::class, 'insertUser']);


    Route::get('/api/tampil/data', [MonitoringCheckerMobileController::class, 'tampil']);
    Route::get('/api/selected/struk/data', [MonitoringCheckerMobileController::class, 'selected_struk']);
    Route::get('/api/selected/dv1/data', [MonitoringCheckerMobileController::class, 'selected_dv1']);
    Route::get('/api/diluar/struk/data', [MonitoringCheckerMobileController::class, 'tampil_diluar_struk']);
    
});
