<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes — SIMRS RSUD Soe Bandi
|--------------------------------------------------------------------------
*/

// Auth Routes — Login only (tidak ada register, sesuai sistem lama)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Root (/) → redirect ke dashboard jika sudah login, ke login jika belum
Route::get('/', function () {
    return Session::has('user_id') ? redirect()->route('dashboard.index') : redirect()->route('login');
});

// ─── Protected Routes (harus login) ─────────────────────────────────────────
Route::middleware('session.auth')->group(function () {
    // ─── Dashboard (Today) ───────────────────────────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // ─── Setting Level & Menu & API Key ──────────────────────────────────────────
    Route::prefix('setting')
        ->name('setting.')
        ->group(function () {
            Route::resource('level', \App\Http\Controllers\Setting\LevelController::class);
            Route::resource('menu', \App\Http\Controllers\Setting\MenuController::class)->only([
                'index',
                'store',
                'update',
                'destroy',
            ]);
            Route::get('/user', fn() => redirect()->route('management.users.index'))->name('user.index');
            Route::get('/api-key', [\App\Http\Controllers\Setting\ApiKeyController::class, 'index'])->name(
                'api-key.index',
            );
            Route::post('/api-key', [\App\Http\Controllers\Setting\ApiKeyController::class, 'update'])->name(
                'api-key.update',
            );
        });

    // ─── URL Alias sesuai Database Lama (ms_menu: msmenu, level, user, kode_api) ───
    Route::get('/msmenu', fn() => redirect()->route('setting.menu.index'))->name('msmenu');
    Route::get('/level', fn() => redirect()->route('setting.level.index'))->name('level');
    Route::get('/user', fn() => redirect()->route('management.users.index'))->name('user');
    Route::get('/kode_api', fn() => redirect()->route('setting.api-key.index'))->name('kode_api');
    Route::get('/api/token', fn() => redirect()->route('satusehat.token.index'));
    Route::get('/api/patient/patient', fn() => redirect()->route('satusehat.patient.index'));
    Route::get('/api/organization', fn() => redirect()->route('satusehat.organization.index'));
    Route::get('/api/location/location', fn() => redirect()->route('satusehat.location.index'));
    Route::get('/api/practitioner/practitioner', fn() => redirect()->route('satusehat.practitioner.index'));
    Route::get('/api/medication/medication', fn() => redirect()->route('satusehat.medication.index'));

    // ─── Management User ─────────────────────────────────────────────────────────
    Route::prefix('management')
        ->name('management.')
        ->group(function () {
            Route::get('/users', [\App\Http\Controllers\Management\UserController::class, 'index'])->name(
                'users.index',
            );
            Route::post('/users', [\App\Http\Controllers\Management\UserController::class, 'store'])->name(
                'users.store',
            );
            Route::put('/users/{user}', [\App\Http\Controllers\Management\UserController::class, 'update'])->name(
                'users.update',
            );
            Route::delete('/users/{user}', [\App\Http\Controllers\Management\UserController::class, 'destroy'])->name(
                'users.destroy',
            );
        });

    // ─── Encounter ───────────────────────────────────────────────────────────────
    Route::prefix('encounter')
        ->name('encounter.')
        ->group(function () {
            Route::get('/rawat-jalan', [
                \App\Http\Controllers\Encounter\EncounterController::class,
                'rawatJalan',
            ])->name('rawat-jalan');
            Route::get('/igd', [\App\Http\Controllers\Encounter\EncounterController::class, 'igd'])->name('igd');
            Route::get('/rawat-inap', [\App\Http\Controllers\Encounter\EncounterController::class, 'rawatInap'])->name(
                'rawat-inap',
            );
        });

    // ─── Satu Sehat REST API ──────────────────────────────────────────────────────
    Route::prefix('satusehat')
        ->name('satusehat.')
        ->group(function () {
            Route::get('/token', [\App\Http\Controllers\Satusehat\TokenController::class, 'index'])->name(
                'token.index',
            );
            Route::post('/token/generate', [\App\Http\Controllers\Satusehat\TokenController::class, 'generate'])->name(
                'token.generate',
            );
            Route::get('/patient', [\App\Http\Controllers\Satusehat\PatientController::class, 'index'])->name(
                'patient.index',
            );
            Route::get('/organization', [\App\Http\Controllers\Satusehat\OrganizationController::class, 'index'])->name(
                'organization.index',
            );
            Route::post('/organization/sync', [
                \App\Http\Controllers\Satusehat\OrganizationController::class,
                'sync',
            ])->name('organization.sync');
            Route::get('/location', [\App\Http\Controllers\Satusehat\LocationController::class, 'index'])->name(
                'location.index',
            );
            Route::get('/practitioner', [\App\Http\Controllers\Satusehat\PractitionerController::class, 'index'])->name(
                'practitioner.index',
            );
            Route::get('/medication', [\App\Http\Controllers\Satusehat\MedicationController::class, 'index'])->name(
                'medication.index',
            );
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
            if (!session_user()?->canMenu($menu->kode_menu, 'view')) {
                abort(403, 'Anda tidak memiliki hak akses untuk melihat menu ini.');
            }

            return view('dynamic.placeholder', compact('menu'));
        }

        abort(404);
    })
        ->where('any', '.*')
        ->name('dynamic.page');
});
