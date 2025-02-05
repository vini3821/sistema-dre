<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Rotas de autenticação
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rota raiz
Route::get('/', function () {
    return redirect('/login');
});

// Rotas protegidas
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gastos
    Route::post('/gastos', [GastoController::class, 'store']);
    Route::get('/gastos/{mes}', [GastoController::class, 'index']);
    
    // Serviços
    Route::post('/servicos', [ServicoController::class, 'store']);
    Route::get('/servicos/{mes}', [ServicoController::class, 'index']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

Route::middleware(['auth'])->group(function () {
    Route::put('/gastos/{gasto}', [GastoController::class, 'update']);
    Route::delete('/gastos/{gasto}', [GastoController::class, 'destroy']);
    Route::put('/servicos/{servico}', [ServicoController::class, 'update']);
    Route::delete('/servicos/{servico}', [ServicoController::class, 'destroy']);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/update-profile-photo', [App\Http\Controllers\ProfileController::class, 'updateProfilePhoto'])
    ->name('profile.update-photo');