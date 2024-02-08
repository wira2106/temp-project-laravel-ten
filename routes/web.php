<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UploadPBIDMController;
use App\Http\Controllers\UploadVoucherController;
use App\Http\Controllers\ZonaMajalahController;
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
    Route::get('home', [UploadPBIDMController::class, 'index']);
    Route::get('zona', [ZonaMajalahController::class, 'index']);
    Route::get('voucher', [UploadVoucherController::class, 'index']);
    Route::post('get-user', [HomeController::class, 'getUser']);
    Route::post('insert-user', [HomeController::class, 'insertUser']);
    
    
    Route::get('api/get_data_toko', [ZonaMajalahController::class, 'get_data_toko']);
    Route::get('api/get_data_zona', [ZonaMajalahController::class, 'get_data_zona']);
    Route::post('api/save/zona', [ZonaMajalahController::class, 'save']);
    Route::post('api/upload/voucher', [UploadVoucherController::class, 'insert']);
    Route::post('api/tarik/data', [UploadPBIDMController::class, 'tarik_data_csv']);
    
});
