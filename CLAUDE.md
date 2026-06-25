# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

NGO website built on a fresh Laravel 11 install (PHP `^8.2`, currently running on 8.4). `APP_NAME=Gain`. Backend ports the most relevant features from the predecessor project at `/var/www/html/web-workforce` (Laravel 8 BSSF jobs/workforce + sports federation site), but design and scope are being rebuilt from scratch — do not copy `web-workforce` Blade/CSS or assume its admin features exist here yet. The user provides features and UI piece-by-piece (often via images), so only port what's been asked for.

## Stack

- Laravel 11.31, Breeze (Blade stack): Blade + Tailwind + Alpine, Vite for assets.
- MySQL 8 database `gain_website` (`DB_USERNAME=root`, `DB_PASSWORD=rbs` locally — see "Database" below; this is what works on the dev box despite the user saying "root").
- Session, cache, and queue drivers all default to `database` (Laravel 11 default) — `sessions`, `cache`, `jobs` tables are migrated.

## Commands

```bash
# PHP / Laravel
composer install
php artisan migrate
php artisan db:seed                      # re-seeds Gain Admin (admin@gain.local / password)
php artisan serve                        # http://127.0.0.1:8000

# Frontend (Vite)
npm install
npm run dev                              # dev server with HMR
npm run build                            # production build

# Tests (PHPUnit, Breeze ships with feature tests for auth)
php artisan test
php artisan test --filter SomeTest       # single test

# Cache reset
php artisan optimize:clear
```

There is no linter or static analysis configured yet.

## Auth model

Single `users` table with a `role` column (default `'user'`, indexed). This is the deliberate divergence from `web-workforce`, which had three guards (`web`/`company`/`admin`) and three user tables — that model was rejected for this project.

- `App\Models\User` has `hasRole(string|array $roles)` and `isAdmin()` helpers; `role` is in `$fillable`.
- Middleware alias `role` is registered in `bootstrap/app.php` and maps to `App\Http\Middleware\EnsureUserHasRole`. Usage: `Route::middleware(['auth', 'role:admin'])`. The middleware accepts multiple roles as separate args (`role:admin,editor`).
- Seeder `database/seeders/AdminUserSeeder.php` creates the initial admin (`admin@gain.local` / `password`) via `updateOrCreate`, so re-running `db:seed` is idempotent.
- Breeze's standard `/login`, `/register`, `/dashboard`, profile routes are all live in `routes/web.php` and `routes/auth.php` — keep using those rather than building parallel auth flows.

## Routing

Laravel 11 layout: bootstrap config lives in `bootstrap/app.php` (`withRouting`, `withMiddleware`, `withExceptions`) — there is no `App\Http\Kernel` or `RouteServiceProvider` anymore. Register middleware aliases / global middleware in `bootstrap/app.php`, not by creating a Kernel.

Route files:
- `routes/web.php` — public + dashboard
- `routes/auth.php` — Breeze auth routes (included from `web.php`)
- `routes/console.php` — artisan closures

When adding domain routes (e.g. `events`, `donations`, `news`), prefer grouping inside `web.php` with `Route::middleware('auth')` / `Route::middleware(['auth','role:admin'])->prefix('admin')`. Only split into separate route files (the `web-workforce` `include_once` pattern) if a single domain grows past ~50 routes — don't preemptively fan out.

## Frontend

- Tailwind 3 (`tailwind.config.js` scans `resources/views/**/*.blade.php` and `resources/js/**/*.js`).
- Entry points are `resources/css/app.css` and `resources/js/app.js`, compiled by Vite (`vite.config.js`).
- Blade layouts: `resources/views/layouts/{app,guest,navigation}.blade.php` (Breeze defaults). When the user provides a new design, replace/extend these rather than building a parallel layout tree.
- No Bootstrap, no jQuery, no Vue — different stack from `web-workforce`. If porting a `web-workforce` Blade view, expect to rewrite its markup for Tailwind.

## Database

- `.env` has `DB_USERNAME=root`, `DB_PASSWORD=rbs`. The user originally said the root password is `root`, but only `rbs` actually authenticates on this machine (same as `web-workforce/.env`). If they correct this later, update `.env` — don't assume.
- Database `gain_website` was created with `utf8mb4 / utf8mb4_unicode_ci`.
- Initial admin credentials: `admin@gain.local` / `password`. Change before any non-local deployment.

## Relationship to web-workforce

The legacy project at `/var/www/html/web-workforce` is the reference for backend features. When the user asks to "port the X feature", look there first for the controller/model/migration shape — but rewrite for Laravel 11 conventions:
- `App\Foo` flat namespace → `App\Models\Foo`.
- Custom `RedirectIfAuthenticated` per guard → use the single Breeze guard + `role:` middleware.
- `App\Helpers\ImageUploadingHelper` → use Laravel's `Storage` facade (`storage/app/public` with `php artisan storage:link`).
- `App\Providers\CustomConfigServiceProvider` overwriting `config()` from a `site_settings` row → don't replicate the hardcoded-row-1272 pattern; if site-wide settings are needed, build a proper `Setting` model with a cached accessor.
- `nwidart/laravel-modules` — not installed here. Don't add it unless the user asks; vanilla Laravel structure is fine for an NGO site.

## Things to keep in mind

- `.env` is currently committed to nothing (no git repo initialized in `gain-website` yet). If/when `git init` happens, make sure `.env` ends up in `.gitignore` (the default Laravel `.gitignore` already excludes it).
- `composer.lock` IS committed by default in Laravel 11 — keep it that way for reproducible installs (opposite of `web-workforce`, where it was gitignored).
- Features are being built incrementally based on user-supplied designs/images. Don't pre-build modules (events, donations, gallery, etc.) until the user requests them and provides the design.
