# Simple-Project — Setup Log (from scratch)

Running log of every command run to build this project, in order. Keep this updated as we go.

## Tech Stack
- Laravel 13 (PHP 8.4) + React 19 + Inertia.js v3 (blank-react-starter-kit, no auth scaffold)
- MySQL 8.0
- Filament v5 (admin panel)
- Project location: `C:\Users\NHEI\Herd\simple-project` (inside Herd's parked folder — auto-served at `http://simple-project.test`)
- GitHub: https://github.com/dtaoOfficial/Simple-Project

---

## Phase 1 — Create Project

```bash
cd C:\Users\NHEI\Herd
laravel new
```
- Project name: `simple-project`
- Starter kit: `no`
- Frontend stack: `react` (installs `laravel/blank-react-starter-kit` — Inertia + React + Tailwind, no auth)
- Result: project created at `C:\Users\NHEI\Herd\simple-project`, served automatically by Herd at `http://simple-project.test`

## Phase 2 — Switch Database to MySQL

Edited `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simple_project
DB_USERNAME=root
DB_PASSWORD=123456789
```
(Removed the SQLite lines that were there by default.)

Created the database:
```sql
CREATE DATABASE simple_project;
```

Ran default migrations:
```bash
php artisan migrate
```

## Phase 3 — Connect to GitHub

```bash
git init
git add .
git commit -m "project fresh start"
git remote add origin https://github.com/dtaoOfficial/Simple-Project.git
git branch -M main
git push -u origin main
```

## Phase 4 — Customer CRUD (learning exercise)

Fields: `name`, `email` (unique), `gender`, `phone_number`

```bash
php artisan make:model Customer -m
```
- Added 4 columns to the migration
- `php artisan migrate`
- Added `$fillable` to `app/Models/Customer.php`

```bash
php artisan make:controller CustomerController --resource
```
- Filled in `index`, `create`, `store`, `edit`, `update`, `destroy` (Inertia::render + validation)
- Used route model binding (`Customer $customer` instead of `string $id`)

Routes (`routes/web.php`):
```php
Route::resource('customers', CustomerController::class)->except('show');
```

React pages created:
- `resources/js/pages/customers/index.tsx`
- `resources/js/pages/customers/create.tsx`
- `resources/js/pages/customers/edit.tsx`

Tested full CRUD at `http://simple-project.test/customers` — working ✅
Committed + pushed.

## Phase 5 — Programme CRUD (real project entity)

Fields: `name`, `description` (text), `schedule`, `activities` (text), `outcomes` (text)

Same exact pattern as Customer:
```bash
php artisan make:model Programme -m
php artisan migrate
php artisan make:controller ProgrammeController --resource
```
- `app/Models/Programme.php` — `$fillable` added
- Routes: `Route::resource('programmes', ProgrammeController::class)->except('show');`
- React pages: `resources/js/pages/programmes/{index,create,edit}.tsx` (textarea for long fields)

Tested full CRUD at `http://simple-project.test/programmes` — working ✅
Committed + pushed.

## Phase 6 — Filament v5 Admin Panel (in progress)

```bash
composer require filament/filament
php artisan filament:install --panels
```
- Panel ID: `admin` (default) → creates `app/Providers/Filament/AdminPanelProvider.php`
- Publishes Filament assets to `public/`
- Admin panel will be available at `http://simple-project.test/admin`

⚠️ Note: `php artisan boost:update` sometimes fails with "Access is denied" (Windows file lock issue with Laravel Boost's own doc cache) during composer scripts — harmless, unrelated to Filament, safe to ignore.

Created first admin user:
```bash
php artisan make:filament-user
```
- Name: `mahesh`, Email: `admin@gmail.com`
- Logged in successfully at `http://simple-project.test/admin` ✅

## Phase 7 — Filament Shield (Roles & Permissions)

```bash
composer require bezhansalleh/filament-shield
```
- Also pulls in `spatie/laravel-permission` automatically

```bash
php artisan vendor:publish --tag="filament-shield-config"
php artisan shield:install
php artisan shield:setup
```
- Panel: `admin`
- Multi-tenancy: `no`
- Publishes `create_permission_tables` migration (roles, permissions, model_has_roles, etc.)
- Adds `use Spatie\Permission\Traits\HasRoles;` + `HasRoles` trait to `app/Models/User.php` automatically

```bash
php artisan shield:generate --all
```
- Generated 3 policies (Customer, Programme, Role) + 36 permissions for existing resources

```bash
php artisan shield:super-admin --user=1
```
- Made `admin@gmail.com` (user id 1) a Super Admin — bypasses all permission checks

## Phase 7b — Auto-generate Filament Resources

```bash
php artisan make:filament-resource Customer --generate
php artisan make:filament-resource Programme --generate
php artisan make:filament-resource User --generate
```
- `--generate` auto-builds the form/table fields by reading the existing DB columns
- Title attribute: `name` for Customer/Programme, `name` for User
- Generated "read-only view page" too (yes) for each
- Result: `/admin` now has Customers, Programmes, Users nav items — full CRUD, no manual coding needed

**Note:** Refactored `ProgrammeController` to pull validation into its own `validation()` method, called via `$this->validation($request)` in `store()`/`update()` — reduces duplicate validation rules.

Verified both sides still work after all this:
- `/admin/programmes` (Filament) — create/view working ✅
- `/programmes` (our custom Inertia page) — still working ✅

## Phase 8 — Event Settings (singleton config table)

**Concept:** unlike Customers/Programmes (many rows), this table should only ever have ONE row (site-wide config: dates, fees, timings, phone, age range). Approach: normal table + a Seeder to create the single row + Filament Resource (kept simple for now — just don't add more than 1 row via admin).

```bash
php artisan make:model EventSetting -m
```
Migration columns added:
```php
$table->date('start_date');
$table->date('end_date');
$table->string('timings');
$table->decimal('fee', 8, 2);   // decimal for money, never float
$table->string('phone');
$table->unsignedInteger('min_age');
$table->unsignedInteger('max_age');
```
```bash
php artisan migrate
```

`app/Models/EventSetting.php` — added `$fillable` for all 7 fields.

**Seeder** (matches README's `EventSettingSeeder`):
```bash
php artisan make:seeder EventSettingSeeder
```
- Fills in one row of sample data via `EventSetting::create([...])`
- Registered in `DatabaseSeeder.php` via `$this->call([EventSettingSeeder::class]);`
```bash
php artisan db:seed --class=EventSettingSeeder
```
- Verified: `EventSetting::count()` → `1` row ✅

**Filament Resource:**
```bash
php artisan make:filament-resource EventSetting --generate
```
- Title attribute: `timings`
- Read-only view page: yes

**Next steps (not done yet):**
- [ ] Verify Event Settings shows correctly in `/admin`
- [ ] Build Registrations as a Filament Resource (linked to Programmes)
- [ ] Production prep (build, optimize) + server hosting (no Docker) + Nginx + SSL

---

## Common commands reference

| Purpose | Command |
|---|---|
| Start dev server (hot reload) | `npm run dev` |
| Run migrations | `php artisan migrate` |
| Undo last migration batch | `php artisan migrate:rollback` |
| List all routes | `php artisan route:list` |
| Make model + migration | `php artisan make:model Name -m` |
| Make resource controller | `php artisan make:controller NameController --resource` |
