<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterAlasanPBDaruratController;
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
    // return redirect()->route('login');


    return view('master-alasan-pb-darurat.home');
//     $host = '172.20.22.107';
// $port = '1521';
// $service_name = 'devdb';
// $username = 'igrmktho';
// $password = 'igrmktho';
//     $dsn = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SERVICE_NAME=$service_name)))";

//     $conn = oci_connect($username, $password, $dsn);

// if ($conn) {
//     echo "Connected to Oracle Database\n";
//     // Perform additional queries or operations if needed
//     oci_close($conn); // Close the connection when done
// } else {
//     $error = oci_error();
//     echo "Failed to connect to Oracle Database: " . $error['message'] . "\n";
// }
});
//LOGIN
Route::post('/login', [LoginController::class, 'login']);
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/logout', [LoginController::class, 'logout']);


Route::get('/api/get_list_alasan', [MasterAlasanPBDaruratController::class, 'get_list_alasan']);
Route::post('/api/add', [MasterAlasanPBDaruratController::class, 'add']);
Route::post('/api/update', [MasterAlasanPBDaruratController::class, 'update']);
Route::post('/api/delete', [MasterAlasanPBDaruratController::class, 'delete']);

Route::middleware(['mylogin'])->group(function () {
    //HOME
    Route::get('home', [LabelController::class, 'index']);
    Route::get('cetak', [LabelController::class, 'cetak']);
    Route::post('get-user', [HomeController::class, 'getUser']);
    Route::post('insert-user', [HomeController::class, 'insertUser']);
    
});
