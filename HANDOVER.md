You're picking up the **Gain Foundation NGO website** project at `/var/www/html/gain-website`.
Read `CLAUDE.md` in the repo root first — it's the canonical reference. This message is
a quick boot-up summary on top of that.

## Where we are

- Laravel 11 + Breeze (Blade + Tailwind + Alpine), Spatie Media Library for uploads.
- Single users table; admin gated by `role:admin` middleware. Seeded admin:
  `admin@gain.local` / `password`.
- The full homepage (11 sections) is dynamic — every section reads from the DB and
  is editable via the custom admin at `/admin`.
- Cache layer in place: each model uses `App\Support\HasHomepageCache` trait and
  exposes a `forHomepage()` accessor. Saves auto-bust the cache. Cold ~39 q,
  warm ~11 q on the homepage.
- 9 phases shipped, all on `origin/main` (`git@github.com:rbraju3m/gain-website.git`).
  No work in progress; tree is clean.

## User's standing decisions (don't reopen)

- **Custom admin, NOT Filament** — the user explicitly chose to hand-build. Don't
  suggest installing Filament/Nova/Voyager.
- **Spatie Media Library** for any model that holds images (Programme / NewsArticle /
  Partner / Testimonial). Don't introduce a parallel uploader or use plain Storage
  for new media fields.
- **One commit per phase / per feature**, and **don't push until the user says "push"**.
  The user previews each phase in the browser before approving.
- **Brand palette is locked**: burgundy red `#9C2245`, green `#87B558`, peach `#FFA268`,
  cream `#FAF1ED`. Tailwind tokens are `brand-red-*` / `brand-green-*` / `brand-orange-*`.

## How to verify everything still works

```bash
cd /var/www/html/gain-website
php artisan migrate --force          # nothing to migrate if state is fresh
php artisan db:seed --force          # idempotent
php artisan serve                    # http://127.0.0.1:8000
npm run dev                          # Vite on :5173

# Quick sanity check
curl -s -o /dev/null -w "HTTP %{http_code}\n" http://127.0.0.1:8000/
# Then log in at http://127.0.0.1:8000/login (admin@gain.local / password)
# and click around /admin — sidebar lists every editable section.
```

DB on this box: `gain_website`, user `root`, password `rbs` (yes, `rbs` — see
CLAUDE.md > Database for context).

## Adding a new dynamic section — the canonical pattern

This is the recipe followed by every existing section. If the user says
"add a Volunteers / Events / Reports section", reach for these eight steps,
not a new architecture.

1. `php artisan make:migration create_<name>_table` — include `sort_order` +
   `is_published` if it's a collection; include a `slug` (unique) if it has
   public per-item URLs.
2. `php artisan make:model <Name>`. If it has images, implement
   `Spatie\MediaLibrary\HasMedia` + `InteractsWithMedia`, define a single-file
   collection in `registerMediaCollections()`, add an `<x>Url()` helper that
   returns `null` (not `""`) when empty.
3. Add the `HasHomepageCache` trait, override `homepageCacheKeys()`, add a
   `forHomepage()` static method wrapping `Cache::rememberForever(self::CACHE_KEY,
   fn () => self::published()->ordered()->with('media')->get())`.
4. `php artisan make:request <Name>/<Name>Request` — `authorize()` returns `true`
   (route group is already gated). Use `mimes:` rules instead of `image:` if you
   want SVG uploads.
5. `php artisan make:controller Admin/<Name>Controller --resource` — copy the
   shape of `ProgrammeController` or `NewsArticleController`. Always
   `->except(['show'])` on the route.
6. `php artisan make:seeder <Name>sSeeder` + register in `DatabaseSeeder::run()`.
   Use `updateOrCreate` so reruns are safe.
7. Build views under `resources/views/admin/<name>/` — `index.blade.php` (table),
   `_form.blade.php` (shared), `create.blade.php` + `edit.blade.php` (thin extends
   that `@include` the form).
8. Add `Route::resource('<name>', AdminXController::class)->except(['show']);` to
   `routes/web.php` inside the admin group, then add a sidebar entry in
   `resources/views/admin/layouts/admin.blade.php` (`$nav` array).

Finally swap the public partial to `<Model>::forHomepage()`. Verify in the browser,
then a single commit per the user's per-phase preference.

## Gotchas worth knowing in advance

- Query-builder `whereIn()->update()` does NOT fire Eloquent events, so the cache
  won't bust. If you write a bulk update, call `Cache::forget(<key>)` by hand —
  see `DistrictController::updateActive()` for the existing example.
- `Setting::all_cached()` has a per-request static memo. Don't remove it; without
  it every `setting(...)` call hits the cache store.
- Map: the inline divisions SVG (`public/images/bangladesh-divisions.svg`) uses
  the older spelling **"Rongpur"** for the northern division. User-facing strings
  say "Rangpur". The mapping lives in `DistrictsSeeder` + `Division.key`.
- `setting()` is a global helper autoloaded via `composer.json`'s `autoload.files`.
  If you add another helper, do the same and run `composer dump-autoload`.

## What the user might ask next (educated guesses)

- A blog/articles single page (right now news has DB + admin but no per-article
  public route).
- Pagination + filtering for the public news listing.
- A "Donate" flow (Stripe/SSLCommerz are likely candidates — ask, don't assume).
- Multi-language (Bengali ↔ English). If raised, the per-field `_bn` column
  pattern + a locale middleware is the leanest path.
- Page-builder / additional pages (about-us full page, contact form). The
  Setting model + section partials already give you a head start.

Before any of those: ask the user to share a design image, like they did for the
homepage. They build piece by piece.

---

That's it. Read `CLAUDE.md` for everything else.
