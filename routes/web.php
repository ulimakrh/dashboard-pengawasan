<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SatkerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Rute Public (Hanya bisa diakses jika belum login)
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect('/login');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


// Rute Protected (Hanya bisa diakses jika sudah login)
Route::middleware('auth')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard Satker
    Route::prefix('satker')->group(function () {
        Route::get('/', [SatkerController::class, 'index'])->name('satker.index');
        Route::post('/', [SatkerController::class, 'store']);
        Route::get('/create', [SatkerController::class, 'create']);
        Route::get('/{id}', [SatkerController::class, 'show'])->name('satker.show');
        Route::get('/{id}/pdf', [SatkerController::class, 'exportPdf'])->name('satker.pdf');
        Route::delete('/{id}', [SatkerController::class, 'destroy']);
        Route::patch('/{id}/assign', [SatkerController::class, 'assignItwil'])->name('satker.assign');
        Route::post('/claim', [SatkerController::class, 'claimSatker'])->name('satker.claim');
        
        // Isu & Tindak Lanjut
        Route::post('/{id}/issue', [SatkerController::class, 'storeIssue']);
    });

    // Profil & Update Data
    Route::get('/profile/edit/{satker_id}', [SatkerController::class, 'editProfile']);
    Route::post('/profile/update/{satker_id}', [SatkerController::class, 'updateProfile']);

    Route::patch('/issue/{id}', [SatkerController::class, 'updateIssue']);
    Route::patch('/issue/{id}/status', [SatkerController::class, 'updateIssueStatus']);

    // Manajemen User (Khusus Superadmin)
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::post('/', [UserController::class, 'store'])->name('users.store');
        Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});