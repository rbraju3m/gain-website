<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GalleryImageController as AdminGalleryImageController;
use App\Http\Controllers\Admin\GalleryYearController as AdminGalleryYearController;
use App\Http\Controllers\Admin\HeroSlideController as AdminHeroSlideController;
use App\Http\Controllers\Admin\NewsArticleController as AdminNewsArticleController;
use App\Http\Controllers\Admin\AchievementController as AdminAchievementController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DistrictController as AdminDistrictController;
use App\Http\Controllers\Admin\DivisionController as AdminDivisionController;
use App\Http\Controllers\Admin\ImpactStatController as AdminImpactStatController;
use App\Http\Controllers\Admin\MvvCardController as AdminMvvCardController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Admin\ProgrammeController as AdminProgrammeController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NewsArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgrammeController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/programmes',                  [ProgrammeController::class, 'index'])->name('programmes.index');
Route::get('/programmes/{programme:slug}', [ProgrammeController::class, 'show'])->name('programmes.show');
Route::get('/services',                    [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}',     [ServiceController::class, 'show'])->name('services.show');
Route::get('/news',                        [NewsArticleController::class, 'index'])->name('news.index');
Route::get('/news/{article:slug}',         [NewsArticleController::class, 'show'])->name('news.show');
Route::get('/gallery',                     [GalleryController::class, 'index'])->name('gallery.index');

// Post-login landing. Kept under the name "dashboard" so all the Breeze
// redirects in app/Http/Controllers/Auth/* keep resolving — but admins go
// straight to /admin and non-admins bounce to the public homepage.
Route::get('/dashboard', function () {
    return auth()->user()?->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect('/');
})->middleware(['auth'])->name('dashboard');

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

        // Drag-and-drop sort endpoints (must be declared before the resource
        // routes so they don't collide with /{model} parameters).
        Route::post('hero-slides/sort',    [AdminHeroSlideController::class,     'sort'])->name('hero-slides.sort');
        Route::post('gallery-years/sort',  [AdminGalleryYearController::class,   'sort'])->name('gallery-years.sort');
        Route::post('gallery-images/sort', [AdminGalleryImageController::class,  'sort'])->name('gallery-images.sort');
        Route::post('programmes/sort',   [AdminProgrammeController::class,   'sort'])->name('programmes.sort');
        Route::post('services/sort',     [AdminServiceController::class,     'sort'])->name('services.sort');
        Route::post('partners/sort',     [AdminPartnerController::class,     'sort'])->name('partners.sort');
        Route::post('testimonials/sort', [AdminTestimonialController::class, 'sort'])->name('testimonials.sort');
        Route::post('impact/sort',       [AdminImpactStatController::class,  'sort'])->name('impact.sort');
        Route::post('achievements/sort', [AdminAchievementController::class, 'sort'])->name('achievements.sort');
        Route::post('mvv/sort',          [AdminMvvCardController::class,     'sort'])->name('mvv.sort');

        Route::resource('hero-slides', AdminHeroSlideController::class)->except(['show']);
        Route::resource('gallery-years',  AdminGalleryYearController::class)->except(['show']);
        Route::resource('gallery-images', AdminGalleryImageController::class)->except(['show']);
        Route::resource('programmes', AdminProgrammeController::class)->except(['show']);
        Route::resource('services', AdminServiceController::class)->except(['show']);
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

        Route::resource('users', AdminUserController::class)->except(['show']);
    });

require __DIR__.'/auth.php';
