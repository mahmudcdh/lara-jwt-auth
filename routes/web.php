<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerifyMiddleware;
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
    return view('welcome');
});

// User Routes {Backend}
Route::post('/user-registration', [UserController::class, 'userRegistration']);
Route::post('/user-login', [UserController::class, 'userLogin']);
Route::get('/logout', [UserController::class, 'userLogout'])->middleware(TokenVerifyMiddleware::class)->name('logout');
Route::post('/send-otp', [UserController::class, 'sendOTP']);
Route::post('/verify-otp', [UserController::class, 'verifyOTP']);
Route::post('/reset-password', [UserController::class, 'resetPassword'])->middleware(TokenVerifyMiddleware::class);


// User Routes {Frontend}
Route::get('/login', [UserController::class, 'loginPage'])->name('login');
Route::get('/register', [UserController::class, 'registerPage'])->name('register');
Route::get('/reset-password', [UserController::class, 'resetPasswordPage'])->middleware(TokenVerifyMiddleware::class)->name('reset-password');
Route::get('/send-otp', [UserController::class, 'sendOtpPage'])->name('send-otp');
Route::get('/verify-otp', [UserController::class, 'verifyOtpPage'])->name('verify-otp');

// User Dashboard
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(TokenVerifyMiddleware::class)->name('dashboard');



// Add CORS
Route::match(['options'], '{any}', function () {
    return response('', 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->header('Access-Control-Allow-Credentials', 'true');
})->where('any', '.*');

