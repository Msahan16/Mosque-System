<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Livewire\CustomLogin;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\Mosques as AdminMosques;
use App\Livewire\Mosque\Dashboard as MosqueDashboard;
use App\Livewire\Mosque\Families;
use App\Livewire\Mosque\Santhas;
use App\Livewire\Mosque\Donations;
use App\Livewire\Mosque\Settings;
use App\Livewire\Mosque\IslamicCalendar;

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

// Public routes
Route::get('/', CustomLogin::class)->name('home')->middleware('guest');

// Custom logout route
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Profile route - accessible to all authenticated users
    Route::get('/user/profile', function () {
        return view('profile.show');
    })->name('profile.show');

    // Generic dashboard route: redirect authenticated users to their role-specific dashboard
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('home');
        }

        // Check user role using the model methods
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isMosque()) {
            return redirect()->route('mosque.dashboard');
        }

        // Fallback: redirect to profile
        return redirect()->route('profile.show');
    })->name('dashboard');

    // !! Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
        Route::get('/mosques', AdminMosques::class)->name('mosques');
    });

    // !! Mosque routes
    Route::middleware('role:mosque')->prefix('mosque')->name('mosque.')->group(function () {
        Route::get('/dashboard', MosqueDashboard::class)->name('dashboard');
        Route::get('/families', Families::class)->name('families');
        Route::get('/santhas', Santhas::class)->name('santhas');
        Route::get('/donations', Donations::class)->name('donations');
        Route::get('/settings', Settings::class)->name('settings');
        Route::get('/islamic-calendar', IslamicCalendar::class)->name('islamic-calendar');
        Route::get('/madrasa', \App\Livewire\Mosque\Madrasa::class)->name('madrasa');
        Route::get('/imam-management', \App\Livewire\Mosque\ImamManagement::class)->name('imam-management');
        Route::get('/ramadan-porridge', \App\Livewire\Mosque\RamadanPorridge::class)->name('ramadan-porridge');
    });
});
