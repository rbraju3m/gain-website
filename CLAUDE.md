# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

NGO website on Laravel 11 (PHP `^8.2`, dev box runs 8.4). `APP_NAME=Gain`. Backend ports the most relevant ideas from the predecessor project at `/var/www/html/web-workforce` (Laravel 8 BSSF jobs/workforce + sports federation site) but design and scope are rebuilt from scratch — do not copy `web-workforce` Blade/CSS or assume its admin/data shape carries over. The homepage is fully data-driven via a custom admin panel; new sections get a `Model::forHomepage()` accessor and a CRUD page in `/admin`.

## Stack

- Laravel 11.31, Breeze (Blade): Blade + Tailwind 3 + Alpine, Vite for assets.
- MySQL 8 database `gain_website` (`DB_USERNAME=root`, `DB_PASSWORD=rbs` locally — see "Database" below).
- Session, cache, queue drivers all `database` (Laravel 11 default) — `sessions`, `cache`, `jobs` tables migrated.
- **Spatie Media Library** (`spatie/laravel-medialibrary`) for image uploads on Programme, NewsArticle, Partner, Testimonial. Files land in `storage/app/public/...`; served via the `/storage` symlink (`php artisan storage:link` already run).

## Commands

```bash
# PHP / Laravel
composer install
php artisan migrate
php artisan db:seed                      # full reseed (idempotent — uses updateOrCreate)
php artisan db:seed --class=ProgrammesSeeder
php artisan serve                        # http://127.0.0.1:8000

# Frontend
npm install
npm run dev                              # HMR (Vite on :5173)
npm run build                            # production bundle

# Tests (Breeze ships feature tests for auth)
php artisan test
php artisan test --filter SomeTest

# Cache reset
php artisan optimize:clear               # views + config + route + app cache
php artisan cache:clear                  # just the homepage cache + Setting cache
```

There is no linter or static analysis configured.

## Auth model

Single `users` table with a `role` column (default `'user'`, indexed). This is the deliberate divergence from `web-workforce` (which had three guards / three user tables).

- `App\Models\User` exposes `hasRole(string|array $roles)` and `isAdmin()` helpers; `role` is in `$fillable`.
- Middleware alias `role` is registered in `bootstrap/app.php` → `App\Http\Middleware\EnsureUserHasRole`. Use as `Route::middleware(['auth','role:admin'])`. Multiple roles allowed as separate args: `role:admin,editor`.
- `database/seeders/AdminUserSeeder.php` seeds `admin@gain.local` / `password` via `updateOrCreate`. **Change before any non-local deployment.**
- Breeze's standard `/login`, `/register`, `/dashboard`, `/profile` routes are live in `routes/web.php` + `routes/auth.php` — keep using those, don't build a parallel auth flow.

## Routing

Laravel 11 layout: bootstrap config in `bootstrap/app.php` (`withRouting`, `withMiddleware`, `withExceptions`). No `App\Http\Kernel`, no `RouteServiceProvider`. Register middleware aliases / global middleware in `bootstrap/app.php`.

Route files:
- `routes/web.php` — public + admin (all admin routes live inside a single `prefix('admin')->name('admin.')` group with `['auth','role:admin']`).
- `routes/auth.php` — Breeze auth routes (included from `web.php`).
- `routes/console.php` — artisan closures.

Each admin section is a standard `Route::resource` (mostly `->except(['show'])`). Don't fan out into separate route files until something specific grows past ~50 routes.

## Admin panel (custom, NOT Filament)

The user chose to hand-build the admin instead of using Filament. **Don't suggest installing Filament/Nova/Voyager.** Pattern is:

- Layout: `resources/views/admin/layouts/admin.blade.php` (sidebar + topbar + flash + error banner). Sidebar entries are declared in a `$nav` array at the top of that file — keys are `label` / `route` / `icon` (24x24 stroke SVG path). Items whose route doesn't exist render greyed-out with a "soon" tag.
- Controllers: `App\Http\Controllers\Admin\*` (resource-style, `auth + role:admin` guarded by the route group).
- Form requests: `App\Http\Requests\{Section}\{Section}Request` per resource (one for store+update; bulk variants for special cases like districts). `authorize()` returns `true` because the route group already gated.
- Views: `resources/views/admin/{section}/index.blade.php` (table) + `create.blade.php` + `edit.blade.php` + a shared `_form.blade.php` partial. `index` pages avoid pagination unless the row count can exceed ~20.
- Shared icon dropdown: `resources/views/admin/_partials/icon-select.blade.php`, backed by `App\Support\Icons::options()`.
- Shared component for Settings tabs: `<x-admin.settings.field>` at `resources/views/components/admin/settings/field.blade.php`.

When adding a new section: scaffold (`make:migration`, `make:model`, `make:controller --resource`, `make:request {Folder}/{Name}Request`, `make:seeder`), follow the existing _form / index naming, register a `Route::resource(...)->except(['show'])` inside the admin group, and add a sidebar entry. Then wire the cache hooks (see "Homepage caching" below).

## Data model — the homepage is fully dynamic

Every visible piece of the homepage reads from the database. Each section has 1-2 models behind it:

| § on homepage              | Models                                | Notes                                                                |
|----------------------------|---------------------------------------|----------------------------------------------------------------------|
| Hero                       | `Setting`                             | All copy + hero image via `setting('hero.*')`. Single-row JSON store. |
| Impact stats (§2)          | `ImpactStat`                          | label / counter / suffix / tone (red/green/orange) / icon_key.       |
| About (§3)                 | `Setting`                             | `setting('about.*')` + uploaded `about.image_path`.                  |
| Mission/Vision/Values (§4) | `MvvCard`                             | title / body / tone / icon_key.                                      |
| Achievements (§5)          | `Achievement`                         | title + icon_key + `rows` JSON (up to 4 label/value/tone rows).      |
| Programmes (§6)            | `Programme`                           | 4-card grid; image via Spatie Media Library `image` collection.      |
| Stories (§7)               | `Testimonial`                         | author / role / quote / photo (`photo` collection).                  |
| Map (§8)                   | `Division` + `District`               | 8 divisions (key matches inline SVG `<g id>`); 64 districts w/ lat/lng + `is_active`. |
| News (§9)                  | `NewsArticle`                         | `published_at` gates visibility (null=draft, future=scheduled). Slug auto-generated. |
| Partners (§10)             | `Partner`                             | `group` enum strategic/implementing — strategic = row 1 grid, implementing = row 2 marquee. Logo via `logo` collection (accepts SVG). |
| CTA + Footer (§11)         | `Setting`                             | `setting('cta.*')` and `setting('footer.*')`; 3 donation tiers stored as JSON in `cta.tiers`. |

Conventions across all collection models:
- `is_published` (bool) and `sort_order` (int) columns where applicable; `published()` and `ordered()` scopes mirror them.
- Slug-bearing models (`NewsArticle`, `Partner`) have a static `generateSlug($name, $ignoreId = null)` collision helper.
- Media-bearing models implement `Spatie\MediaLibrary\HasMedia` and define a single-file collection in `registerMediaCollections()`. They expose an `imageUrl()` / `logoUrl()` / `photoUrl()` helper that returns `null` (not the empty string Spatie returns) when nothing has been uploaded.

`App\Support\Icons` is a tiny registry mapping `icon_key` strings to inline SVG markup. ImpactStat, Achievement and MvvCard all reference it. Adding an icon = one entry in `Icons::LIBRARY`; it then appears in every admin dropdown.

`App\Models\Setting` is a key/value store keyed by dot-notation strings (`hero.badge`, `cta.tiers`, …) with a JSON `value` column. Read via the global `setting($key, $default)` helper (autoloaded via `composer.json`'s `autoload.files`).

## Homepage caching (`App\Support\HasHomepageCache` trait)

Every public-side model uses the `HasHomepageCache` trait. The trait registers `saved` + `deleted` listeners that `Cache::forget()` each key declared in `homepageCacheKeys()` (one method per model). Each model also has a `forHomepage()` (or `forHomepageStrategic()` / `forHomepageImplementing()`) static method that wraps its query in `Cache::rememberForever()` under that key, and eager-loads `media` where relevant.

Cache keys currently used:
```
homepage:programmes
homepage:news
homepage:partners.strategic
homepage:partners.implementing
homepage:testimonials
homepage:impact
homepage:achievements
homepage:mvv
homepage:map               (Division + District share this one — District::homepageCacheKeys() returns Division::CACHE_KEY)
site_settings_all          (Setting; has its own flush() that also clears a per-request static memo)
```

**Two important gotchas:**

1. **Query-builder updates don't fire Eloquent events.** `DistrictController::updateActive()` does a bulk `whereIn()->update()` for performance over 64 rows, so it must call `Cache::forget(Division::CACHE_KEY)` by hand. Same applies anywhere else you use raw query-builder `update()` / `delete()` on a model with `HasHomepageCache` — events won't fire, so the cache won't bust.

2. **`Setting::all_cached()` has a per-request static memo.** Without it, every `setting('hero.badge')` / `setting('hero.line1')` / etc. in a partial hits the cache store (one SELECT per call with the database driver). The memo collapses ~30 cache reads into 1. If you ever load Setting in a long-running queue worker, call `Setting::flush()` between jobs.

When adding a new dynamic section:
1. Use `HasHomepageCache` trait on the model.
2. Override `homepageCacheKeys(): array` to return your key(s).
3. Add a `forHomepage()` static method (`Cache::rememberForever(self::CACHE_KEY, fn () => …)`).
4. Read from `Model::forHomepage()` in the partial, not the query builder.

## Frontend

- Tailwind 3 with a brand palette in `tailwind.config.js`:
  - `brand-red-*` (burgundy, primary; sampled `#9C2245` from the designs)
  - `brand-green-*` (vibrant `#87B558`)
  - `brand-orange-*` (peach `#FFA268`)
  - `brand-cream` (`#FAF1ED`) and `brand-ink` / `brand-muted`
  - Custom utilities: `bg-section-cream`, `bg-section-cream-alt`, `bg-section-white`, `bg-blueprint` (faint grid for the map), `bg-dots`, `bg-hero-wash`, `bg-cta-burgundy`, plus shadows `shadow-pill` / `shadow-card` / `shadow-soft`.
- Entry points: `resources/css/app.css` (Fraunces + Figtree via Bunny CDN, then `@tailwind base/components/utilities`, then custom utility layers) and `resources/js/app.js`.
- Custom JS in `app.js`: `IntersectionObserver`-driven `.reveal` / `.is-visible` animation + counter-up on `[data-counter]` elements. Both respect `prefers-reduced-motion`.
- Section partials live in `resources/views/partials/home/*.blade.php` — one file per `@include('partials.home.X')` line in `resources/views/home.blade.php`. Site chrome: `partials/site-nav.blade.php` (sticky, has hover-friendly Programmes dropdown) + `partials/site-footer.blade.php` (dark burgundy).
- Layouts: `layouts/site.blade.php` (public site) and Breeze's `layouts/{app,guest,navigation}.blade.php` (dashboard + auth).
- No Bootstrap, no jQuery, no Vue — different stack from `web-workforce`.

## Map (§8) specifics

- Base SVG: `public/images/bangladesh-divisions.svg`, originally from Wikimedia; inlined into the partial so each `<g id="Rongpur|Rajshahi|…">` can be CSS-coloured per state (`.bd-div`, `.bd-div.is-active`).
- Districts are overlaid as a second SVG inside the same `.bd-map` container. `Division::forHomepage()` returns the projected `x,y` for each district (`viewBox 0 0 1550 2149`), so the partial does no math at request time.
- District list seeded from `storage/app/bd-districts.json` (committed; whitelisted in `storage/app/.gitignore`). 30 districts ship as `is_active` to match what the original hardcoded partial showed.
- The SVG file uses the old spelling "Rongpur" for the northern division; everywhere user-facing displays "Rangpur".

## Database

- `.env` has `DB_USERNAME=root`, `DB_PASSWORD=rbs`. The user originally said the root password is `root`, but `rbs` is what authenticates on this dev box (same as `web-workforce/.env`). If they ever set a real root password, update `.env`; don't assume.
- Database `gain_website` was created with `utf8mb4 / utf8mb4_unicode_ci`.
- Admin credentials: `admin@gain.local` / `password`. Change before any non-local deployment.
- Migration order matters for FK: `divisions` must migrate before `districts`. The current timestamp prefixes already enforce this.

## Git remote

`origin` is `git@github.com:rbraju3m/gain-website.git`. SSH auth (rbraju3m). Branch `main` tracks `origin/main`. The user prefers per-phase commits; don't squash unless asked.

## Relationship to web-workforce

`/var/www/html/web-workforce` is the reference for backend feature ideas. When asked to "port X", look there first for shape — but rewrite for Laravel 11 conventions:
- `App\Foo` flat namespace → `App\Models\Foo`.
- Custom `RedirectIfAuthenticated` per guard → single Breeze guard + `role:` middleware.
- `App\Helpers\ImageUploadingHelper` → Spatie Media Library (already used by Programme/News/Partner/Testimonial). Don't introduce a parallel uploader.
- `CustomConfigServiceProvider` overwriting `config()` from a `site_settings` row → use the existing `Setting` model + `setting()` helper. Don't replicate the hardcoded row-1272 pattern.
- `nwidart/laravel-modules` is **not** installed; vanilla Laravel structure is enough.

## Things to keep in mind

- `.env` is gitignored. `composer.lock` IS committed (opposite of `web-workforce`).
- `.claude/`, `.idea/`, `public/build/`, `public/hot`, `public/vendor/` are gitignored. `storage/app/bd-districts.json` is **whitelisted** in `storage/app/.gitignore` because it's data, not user uploads.
- `composer.json` autoloads `app/Helpers/settings.php` via the `files` array. If you add another global helper, do it the same way and `composer dump-autoload`.
- Image fallbacks are layered: most public partials show `Model->imageUrl() ?: ($fallbacks[$name] ?? UnsplashURL)`. Real photos drop in at `public/images/...` or via the admin upload form — both routes work without code changes.
- Features are built incrementally based on user-supplied designs/images. Don't pre-build modules (events, donations, gallery, etc.) until the user asks and provides the design.
- The user has explicitly chosen **custom admin over Filament**, **Spatie Media Library over plain Storage for images**, and **one commit per phase**. Honour those defaults.
