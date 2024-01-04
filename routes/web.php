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
Route::get('/member/data', function () {
    // dd(Session::get('token'));
    return view('member-ho.menu.member');
});
Route::get('/member/sms', function () {
    // dd(Session::get('token'));
    return view('member-ho.menu.sms');
});

Route::get('/member/data', [MemberController::class, 'index']);
Route::get('/api/member/data', [MemberController::class, 'view']);
Route::get('/api/member/sms/data', [SMSController::class, 'view']);
//LOGIN
Route::post('/login', [LoginController::class, 'login']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'logout']);

Route::middleware(['mylogin'])->group(function () {
    //HOME
    Route::get('home', [LabelController::class, 'index']);
    Route::get('cetak', [LabelController::class, 'cetak']);
    Route::post('get-user', [HomeController::class, 'getUser']);
    Route::post('insert-user', [HomeController::class, 'insertUser']);
    
});
