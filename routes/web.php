<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChirpController;




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


//Route::view('welcome');

// WebAuthn Routes
//WebAuthnRoutes::register();

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

Route::middleware('web')
            ->group(static function (): void {
                Route::controller(\App\Http\Controllers\WebAuthn\WebAuthnRegisterController::class)
                    ->group(static function (): void {
                        Route::post('webauthn/register/options', 'options')->name('webauthn.register.options');
                        Route::post('webauthn/register', 'register')->name('webauthn.register');
                    });

                Route::controller(\App\Http\Controllers\WebAuthn\WebAuthnLoginController::class)
                    ->group(static function (): void {
                        Route::post('webauthn/login/options', 'options')->name('webauthn.login.options');
                        Route::post('webauthn/login', 'login')->name('webauthn.login');
                    });
           });

Route::resource('chirps', ChirpController::class)
->only(['index', 'store'])->middleware(['auth', 'verified']);        

  

require __DIR__.'/auth.php';
