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

// Root (/) → redirect ke dashboard jika sudah login, ke login jika belum
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard.index')
        : redirect()->route('login');
});

// ─── Protected Routes (harus login) ─────────────────────────────────────────
Route::middleware('auth')->group(function () {
    // ─── Dashboard (Today) ───────────────────────────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // ─── Pesan Masuk (Inbox) ─────────────────────────────────────────────────────
    Route::get('/inbox', [InboxController::class, 'index'])->name('inbox.index');

    // ─── Pasien ──────────────────────────────────────────────────────────────────
    Route::resource('patients', PatientController::class)->names([
        'index' => 'patients.index',
        'create' => 'patients.create',
        'store' => 'patients.store',
        'show' => 'patients.show',
        'edit' => 'patients.edit',
        'update' => 'patients.update',
        'destroy' => 'patients.destroy',
    ]);

    // ─── Jadwal ──────────────────────────────────────────────────────────────────
    Route::get('/schedule', [ScheduleController::class, 'index'])->name('schedule.index');

    // ─── Kampanye ────────────────────────────────────────────────────────────────
    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');

    // ─── Laporan ─────────────────────────────────────────────────────────────────
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // ─── Pengaturan ──────────────────────────────────────────────────────────────
    Route::prefix('settings')
        ->name('settings.')
        ->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('/', [SettingController::class, 'update'])->name('update');
            Route::get('/whatsapp', [SettingController::class, 'whatsapp'])->name('whatsapp');
        });

    // ─── Setting Level & Menu & API Key ──────────────────────────────────────────
    Route::prefix('setting')->name('setting.')->group(function () {
        Route::resource('level', \App\Http\Controllers\Setting\LevelController::class);
        Route::resource('menu', \App\Http\Controllers\Setting\MenuController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::get('/user', fn() => redirect()->route('management.users.index'))->name('user.index');
        Route::get('/api-key', [\App\Http\Controllers\Setting\ApiKeyController::class, 'index'])->name('api-key.index');
        Route::post('/api-key', [\App\Http\Controllers\Setting\ApiKeyController::class, 'update'])->name('api-key.update');
    });

    // ─── Management User ─────────────────────────────────────────────────────────
    Route::prefix('management')->name('management.')->group(function () {
        Route::get('/users',           [\App\Http\Controllers\Management\UserController::class, 'index'])->name('users.index');
        Route::post('/users',          [\App\Http\Controllers\Management\UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}',    [\App\Http\Controllers\Management\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\Management\UserController::class, 'destroy'])->name('users.destroy');
    });

    // ─── Satu Sehat REST API ──────────────────────────────────────────────────────
    Route::prefix('satusehat')->name('satusehat.')->group(function () {
        Route::get('/token', [\App\Http\Controllers\Satusehat\TokenController::class, 'index'])->name('token.index');
        Route::post('/token/generate', [\App\Http\Controllers\Satusehat\TokenController::class, 'generate'])->name('token.generate');
    });

    // ─── Dynamic Menu Fallback ───────────────────────────────────────────────────
    // Otomatis menampilkan halaman placeholder untuk menu dinamis dari database
    // yang belum memiliki controller/view khusus (seperti /testing, dsb)
    Route::get('/{any}', function ($any) {
        $cleanPath = trim($any, '/');

        $menu = \App\Models\Menu::where(function ($q) use ($cleanPath, $any) {
            $q->where('url', $cleanPath)
              ->orWhere('url', '/' . $cleanPath)
              ->orWhere('url', $any);
        })->first();

        if ($menu) {
            if (!auth()->user()->canMenu($menu->kode_menu, 'view')) {
                abort(403, 'Anda tidak memiliki hak akses untuk melihat menu ini.');
            }

            return view('dynamic.placeholder', compact('menu'));
        }

        abort(404);
    })->where('any', '.*')->name('dynamic.page');
});
