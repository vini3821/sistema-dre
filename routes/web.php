<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\ServicoController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/gastos/{mes}', [GastoController::class, 'index']);
    Route::post('/gastos', [GastoController::class, 'store']);
    Route::put('/gastos/{gasto}', [GastoController::class, 'update']);
    Route::delete('/gastos/{gasto}', [GastoController::class, 'destroy']);
    Route::get('/servicos/{mes}', [ServicoController::class, 'index']);
    Route::post('/servicos', [ServicoController::class, 'store']);
    Route::put('/servicos/{servico}', [ServicoController::class, 'update']);
    Route::delete('/servicos/{servico}', [ServicoController::class, 'destroy']);
});

require __DIR__.'/auth.php';
