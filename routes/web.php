<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InitialSOController;
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
    Route::get('home', [InitialSOController::class, 'index']);
    Route::get('api/data/plu', [InitialSOController::class, 'get_plu']);
    Route::get('api/check/data', [InitialSOController::class, 'data_input']);
    Route::post('api/insert/byplu', [InitialSOController::class, 'store_plu']);
    Route::post('api/insert/byrak', [InitialSOController::class, 'store_rak']);
    Route::post('api/delete/byplu', [InitialSOController::class, 'delete_plu']);
    Route::post('api/delete/byrak', [InitialSOController::class, 'delete_rak']);
    // Route::get('cetak', [LabelController::class, 'cetak']);
    // Route::post('get-user', [HomeController::class, 'getUser']);
    // Route::post('insert-user', [HomeController::class, 'insertUser']);
    
});
