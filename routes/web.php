<?php
use App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DreController;
use App\Http\Controllers\DashboardController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/dre', [DreController::class, 'index'])->name('dre.index');
    Route::get('/dre/{id}/edit', [DreController::class, 'edit'])->name('dre.edit');
    Route::put('/dre/{id}', [DreController::class, 'update'])->name('dre.update');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/financeiro', [DashboardController::class, 'index'])->middleware('checkSector:financeiro');
Route::get('/assessoria', [DashboardController::class, 'index'])->middleware('checkSector:assessoria');
Route::get('/criacao', [DashboardController::class, 'index'])->middleware('checkSector:criacao');
Route::get('/vendas', [DashboardController::class, 'index'])->middleware('checkSector:vendas');
Route::get('/trafego_pago', [DashboardController::class, 'index'])->middleware('checkSector:trafego_pago');
Route::get('/rh', [DashboardController::class, 'index'])->middleware('checkSector:rh');
Route::get('/ti', [DashboardController::class, 'index'])->middleware('checkSector:ti');