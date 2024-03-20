<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebAuthn\WebAuthnRegisterController;
use App\Http\Controllers\WebAuthn\WebAuthnLoginController;
use App\Http\Controllers\WebAuthn\AttestationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;
use Illuminate\Routing\Router; 





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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/complete', function () {
    return view('complete');
})->middleware(['auth', 'verified'])->name('register.complete');



Route::get('/fingerprint', function () {
    return view('fingerprint');
})->middleware(['auth', 'verified'])->name('fingerprint.page');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('web')->group(function () {
    Route::post('/webauthn/register/options', [WebAuthnRegisterController::class, 'options'])->name('webauthn.register.options');
    Route::post('/webauthn/register', [AttestationController::class, 'register'])->name('webauthn.register');
});

Route::middleware('web')->group(function () {
    Route::post('/webauthn/login/options', [WebAuthnLoginController::class, 'options'])->name('webauthn.login.options');
    Route::post('/webauthn/login', [WebAuthnLoginController::class, 'login'])->name('webauthn.login');
});




Route::resource('chirps', ChirpController::class)
->only(['index', 'store'])->middleware(['auth', 'verified']);        

  

require __DIR__.'/auth.php';
