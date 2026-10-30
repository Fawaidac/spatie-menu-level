<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes — SIMRS RSUD Soe Bandi
|--------------------------------------------------------------------------
*/

// Auth Routes (Login & Register)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Root (/) → redirect ke halaman login
Route::get('/', fn () => redirect()->route('login'));

// ─── Protected Routes (harus login) ─────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // ─── Dashboard (Today) ───────────────────────────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');

    // ─── Pesan Masuk (Inbox) ─────────────────────────────────────────────────────
    Route::get('/inbox', [InboxController::class, 'index'])
        ->name('inbox.index');

    // ─── Pasien ──────────────────────────────────────────────────────────────────
    Route::resource('patients', PatientController::class)
        ->names([
            'index'   => 'patients.index',
            'create'  => 'patients.create',
            'store'   => 'patients.store',
            'show'    => 'patients.show',
            'edit'    => 'patients.edit',
            'update'  => 'patients.update',
            'destroy' => 'patients.destroy',
        ]);

    // ─── Jadwal ──────────────────────────────────────────────────────────────────
    Route::get('/schedule', [ScheduleController::class, 'index'])
        ->name('schedule.index');

    // ─── Kampanye ────────────────────────────────────────────────────────────────
    Route::get('/campaigns', [CampaignController::class, 'index'])
        ->name('campaigns.index');

    // ─── Laporan ─────────────────────────────────────────────────────────────────
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    // ─── Pengaturan ──────────────────────────────────────────────────────────────
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/',           [SettingController::class, 'index'])    ->name('index');
        Route::post('/',          [SettingController::class, 'update'])   ->name('update');
        Route::get('/whatsapp',   [SettingController::class, 'whatsapp'])->name('whatsapp');
    });

    // ─── Management User, Role, Role Permission ──────────────────────────────────
    Route::prefix('management')->name('management.')->group(function () {
        // Users CRUD
        Route::get('/users',              [\App\Http\Controllers\Management\UserController::class, 'index'])->name('users.index');
        Route::post('/users',             [\App\Http\Controllers\Management\UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}',       [\App\Http\Controllers\Management\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}',    [\App\Http\Controllers\Management\UserController::class, 'destroy'])->name('users.destroy');

        // Roles CRUD
        Route::get('/roles',             [\App\Http\Controllers\Management\RoleController::class, 'index'])->name('roles.index');
        Route::post('/roles',            [\App\Http\Controllers\Management\RoleController::class, 'store'])->name('roles.store');
        Route::put('/roles/{role}',      [\App\Http\Controllers\Management\RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}',   [\App\Http\Controllers\Management\RoleController::class, 'destroy'])->name('roles.destroy');

        // Role Permissions
        Route::get('/role-permissions',  [\App\Http\Controllers\Management\RolePermissionController::class, 'index'])->name('role-permissions.index');
        Route::post('/role-permissions', [\App\Http\Controllers\Management\RolePermissionController::class, 'update'])->name('role-permissions.update');

        // Permissions CRUD
        Route::post('/permissions',                 [\App\Http\Controllers\Management\PermissionController::class, 'store'])->name('permissions.store');
        Route::put('/permissions/{permission}',    [\App\Http\Controllers\Management\PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{permission}', [\App\Http\Controllers\Management\PermissionController::class, 'destroy'])->name('permissions.destroy');
    });

});

