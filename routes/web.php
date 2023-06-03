<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BankSekolahController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BerandaWaliController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\BerandaOperatorController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\KartuSppController;
use App\Http\Controllers\KwitansiPembayaranController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\WaliMuridPembayaranController;
use App\Http\Controllers\WaliMuridSiswaController;
use App\Http\Controllers\WaliMuridTagihanController;
use App\Http\Controllers\WaliSiswaController;
use App\Http\Middleware\Wali;
use Illuminate\Http\Request;
use App\Models\User;

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

//tes untuk generate url
// Route::get('tes', function () {
//     echo $url = URL::temporarySignedRoute(
//         'login.url',
//         now()->addDays(10),
//         [
//             'pembayaran_id' => 1,
//             'user_id' => 1,
//             'url' => route('pembayaran.show', 1)
//         ]
//     );
// });

Route::get('login/login-url', [LoginController::class, 'loginUrl'])->name('login.url');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Auth::routes();
Route::prefix('operator')->middleware(['auth', 'auth.operator'])->group(function () {
    //ini route khusus untuk operator
    Route::get('beranda', [BerandaOperatorController::class, 'index'])->name('operator.beranda');
    Route::resource('user', UserController::class);
    Route::resource('banksekolah', BankSekolahController::class);
    Route::resource('wali', WaliController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('walisiswa', WaliSiswaController::class);
    Route::resource('biaya', BiayaController::class);
    Route::resource('tagihan', TagihanController::class);
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('kwitansi-pembayaran/{id}', [KwitansiPembayaranController::class, 'show'])->name('kwitansipembayaran.show');
    Route::get('kartuspp', [KartuSppController::class, 'index'])->name('kartuspp.index');
});

Route::get('login-wali', [LoginController::class, 'showLoginFormWali'])->name('login.wali');

Route::prefix('walimurid')->middleware(['auth', 'auth.wali'])->name('wali.')->group(function () {
    //ini route khusus untuk wali-murid
    Route::get('beranda', [BerandaWaliController::class, 'index'])->name('beranda');
    Route::resource('siswa', WaliMuridSiswaController::class);
    Route::resource('tagihan', WaliMuridTagihanController::class);
    Route::resource('pembayaran', WaliMuridPembayaranController::class);
});

Route::prefix('admin')->middleware(['auth', 'auth.admin'])->group(function () {
    //ini route khusus untuk admin
});
Route::get('logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');

// Route::get('/search-student', function (Request $request) {
//     $studentId = $request->input('student_id');
//     $student = User::find($studentId);

//     // Mengembalikan hasil pencarian dalam bentuk view
//     return view('student-info', ['student' => $student]);
// });
