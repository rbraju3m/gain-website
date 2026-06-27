<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NewsArticleController as AdminNewsArticleController;
use App\Http\Controllers\Admin\AchievementController as AdminAchievementController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DistrictController as AdminDistrictController;
use App\Http\Controllers\Admin\DivisionController as AdminDivisionController;
use App\Http\Controllers\Admin\ImpactStatController as AdminImpactStatController;
use App\Http\Controllers\Admin\MvvCardController as AdminMvvCardController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\ProgrammeController as AdminProgrammeController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgrammeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/programmes/{programme:slug}', [ProgrammeController::class, 'show'])->name('programmes.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Admin ──────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('settings',    [AdminSettingsController::class, 'edit'])->name('settings.edit');
        Route::patch('settings',  [AdminSettingsController::class, 'update'])->name('settings.update');

        Route::resource('programmes', AdminProgrammeController::class)->except(['show']);
        Route::resource('news', AdminNewsArticleController::class)->except(['show']);
        Route::resource('partners', AdminPartnerController::class)->except(['show']);
        Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);
        Route::resource('impact', AdminImpactStatController::class)->except(['show']);
        Route::resource('achievements', AdminAchievementController::class)->except(['show']);
        Route::resource('mvv', AdminMvvCardController::class)->except(['show']);

        Route::resource('divisions', AdminDivisionController::class)->only(['index', 'edit', 'update']);

        Route::get('districts',    [AdminDistrictController::class, 'index'])->name('districts.index');
        Route::patch('districts',  [AdminDistrictController::class, 'updateActive'])->name('districts.update-active');

        Route::resource('contact', AdminContactMessageController::class)->only(['index', 'show', 'destroy']);
    });

require __DIR__.'/auth.php';
