# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**DtHesap** is a multi-tenant ERP/accounting system in Turkish. Stack: Laravel 12, Inertia.js 2, Alpine.js 3, Tailwind CSS 3, Vite 7. Database: MySQL (Docker) or SQLite (local dev).

## Commands

### Local Development
```bash
composer setup        # Initial setup: install, key generate, migrate, npm build
composer dev          # Run concurrently: artisan serve + queue:listen + pail + npm dev
composer test         # php artisan config:clear && php artisan test
```

### Docker Development
```bash
docker-compose up -d
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
# App: http://localhost:8080 | Vite: http://localhost:5173 | MySQL: localhost:3306
```

### Tests
```bash
php artisan test                     # All tests
php artisan test tests/Unit          # Unit tests only
php artisan test tests/Feature       # Feature tests only
php artisan test --coverage          # With coverage
```

### Linting
```bash
./vendor/bin/pint                    # Laravel Pint (PHP code style)
npm run build                        # Production asset build
```

## Architecture

### Multi-Tenancy
Every tenant-specific model uses the `HasFirmaScope` trait (`app/Models/Traits/HasFasFirmaScope.php`), which applies a `FirmaScope` global query scope that automatically filters queries by `firma_id` from the session. The `SetCurrentFirma` middleware sets the active company. Helper functions `current_firma_id()`, `current_firma()`, and `switch_firma()` are in `app/helpers.php`.

All tenant tables have a `firma_id` foreign key. When adding new tenant-aware models, apply `use HasFirmaScope;`.

### Module Structure
Each business module follows this pattern:
- `app/Models/` — Eloquent model with `HasFirmaScope`
- `app/Http/Controllers/` — CRUD controller
- `app/Http/Requests/` — Form request validation (Store/Update)
- `app/Http/Resources/` — API response formatting
- `app/Observers/` — Business logic triggered on model events
- `app/Policies/` — Authorization rules
- `resources/views/{module}/` — Blade templates

### Key Modules
| Module | Turkish | Purpose |
|--------|---------|---------|
| Cari | Cari | Customers/Suppliers |
| Fatura | Fatura | Invoices (sales/purchase) |
| Stok | Stok | Inventory/Stock items |
| Kasa | Kasa | Cash registers |
| Banka | Banka | Bank accounts |
| Cek | Çek | Cheques |
| Siparis | Siparis | Orders |
| Firma | Firma | Companies (tenant root) |

### Business Logic Pattern
Model observers (`app/Observers/`) handle side effects: stock movements on invoice save, activity logging, etc. The `ActivityLog` model tracks audit trail across all modules.

### Database
26+ migrations. All tenant tables follow: `id`, `firma_id` (FK), business columns, `created_at`, `updated_at`. Many use soft deletes. Key relationships: Fatura → FaturaDetay, Siparis → SiparisDetay, Cari → CariHareket.

### Frontend
Blade templates with Tailwind. Inertia.js is used for JS-heavy pages. Alpine.js handles interactivity. Custom Tailwind theme (colors: primary/secondary/accent/neutral) defined in `resources/js/design-config.js`. Forms styled via `@tailwindcss/forms`.

## Environment

- `.env` (local) uses SQLite by default
- `.env.docker` uses MySQL with service name `db`
- Session, queue, and cache all use the database driver
- Test environment (phpunit.xml): in-memory SQLite, synchronous queue, array mail/cache
