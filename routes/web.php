<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SMSController;
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
    // dd(phpinfo());
    return view('member-ho.menu.member');
});

//LOGIN
Route::post('/login', [LoginController::class, 'login']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'logout']);
// Route::get('/member/data', [MemberController::class, 'index']);
Route::get('/api/member/data', [MemberController::class, 'view']);
Route::get('/api/select/data', [MemberController::class, 'get_data_select']);
Route::post('/api/member/edit', [MemberController::class, 'update']);
Route::post('/api/member/alokasi', [MemberController::class, 'alokasi']);
Route::get('/api/member/sms/data', [SMSController::class, 'view']);
Route::get('/api/member/sms/all', [SMSController::class, 'all_data_sms']);
Route::post('/api/proses/csv', [SMSController::class, 'proses_csv']);
Route::post('/api/add', [SMSController::class, 'add']);
Route::post('/api/update', [SMSController::class, 'update']);
Route::delete('/api/remove/{kode}', [SMSController::class, 'remove']);

Route::get('home', [MemberController::class, 'index']);
Route::get('sms', [SMSController::class, 'index']);
Route::get('download_csv', [SMSController::class, 'execute_download']);
Route::middleware(['mylogin'])->group(function () {
    //HOME
    Route::get('cetak', [LabelController::class, 'cetak']);
    Route::post('get-user', [HomeController::class, 'getUser']);
    Route::post('insert-user', [HomeController::class, 'insertUser']);
    
});
