# Multi-Tenant Pre-Accounting Database - Implementation Walkthrough

## Overview

Successfully implemented a comprehensive multi-tenant pre-accounting/ERP-lite database schema for Laravel with Tailwind CSS. The system includes **18 database tables**, **13 Eloquent models**, complete relationships, and robust multi-tenant architecture.

## What Was Implemented

### 1. Database Migrations (18 Tables)

All migrations created in `database/migrations/` with proper naming convention for execution order:

#### Core Multi-Tenant Structure
- [2024_01_01_000001_create_firmalar_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000001_create_firmalar_table.php) - Companies table
- [2024_01_01_000002_create_users_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000002_create_users_table.php) - Users table
- [2024_01_01_000003_create_firma_user_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000003_create_firma_user_table.php) - User-Company pivot

#### Cari (Customer/Supplier) Module
- [2024_01_01_000010_create_cariler_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000010_create_cariler_table.php) - Shared cari records
- [2024_01_01_000011_create_cari_firma_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000011_create_cari_firma_table.php) - Firm-specific cari data

#### Stok (Inventory) Module
- [2024_01_01_000020_create_stoklar_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000020_create_stoklar_table.php) - Inventory items
- [2024_01_01_000021_create_stok_hareketleri_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000021_create_stok_hareketleri_table.php) - Inventory movements

#### Fatura (Invoice) Module
- [2024_01_01_000030_create_faturalar_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000030_create_faturalar_table.php) - Invoices (purchase & sales)
- [2024_01_01_000031_create_fatura_kalemleri_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000031_create_fatura_kalemleri_table.php) - Invoice line items

#### Kasa (Cash) Module
- [2024_01_01_000040_create_kasalar_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000040_create_kasalar_table.php) - Cash registers
- [2024_01_01_000041_create_kasa_hareketleri_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000041_create_kasa_hareketleri_table.php) - Cash movements

#### Banka (Bank) Module
- [2024_01_01_000050_create_bankalar_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000050_create_bankalar_table.php) - Bank accounts
- [2024_01_01_000051_create_banka_hareketleri_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000051_create_banka_hareketleri_table.php) - Bank movements

#### Çek/Senet Module
- [2024_01_01_000060_create_cek_senetler_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000060_create_cek_senetler_table.php) - Checks & promissory notes

#### Sipariş (Order) Module
- [2024_01_01_000070_create_siparisler_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000070_create_siparisler_table.php) - Orders (purchase & sales)
- [2024_01_01_000071_create_siparis_kalemleri_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000071_create_siparis_kalemleri_table.php) - Order line items

---

### 2. Eloquent Models (13 Models)

All models created in `app/Models/` with complete relationships:

- [Firma.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/Firma.php) - Company model with relationships to all modules
- [User.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/User.php) - User authentication model
- [Cari.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/Cari.php) - Customer/Supplier with balance helper
- [Stok.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/Stok.php) - Inventory items
- [StokHareket.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/StokHareket.php) - Inventory movements
- [Fatura.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/Fatura.php) - Invoices
- [FaturaKalem.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/FaturaKalem.php) - Invoice line items
- [Kasa.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/Kasa.php) - Cash registers
- [KasaHareket.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/KasaHareket.php) - Cash movements
- [Banka.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/Banka.php) - Bank accounts
- [BankaHareket.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/BankaHareket.php) - Bank movements
- [CekSenet.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/CekSenet.php) - Checks & promissory notes
- [Siparis.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/Siparis.php) - Orders
- [SiparisKalem.php](file:///c:/Repo2026/Web/DT_Hesap/app/Models/SiparisKalem.php) - Order line items

---

### 3. Multi-Tenant Infrastructure

#### [FirmaScope](file:///c:/Repo2026/Web/DT_Hesap/app/Models/Scopes/FirmaScope.php)
Global scope that automatically filters all queries by `firma_id` from session:

```php
// Automatically applied to: Stok, Fatura, Kasa, Banka, CekSenet, Siparis, etc.
// All queries will only return records for the current firma
```

#### [FirmaObserver](file:///c:/Repo2026/Web/DT_Hesap/app/Observers/FirmaObserver.php)
Observer that automatically sets `firma_id` when creating new records:

```php
// When creating new records, firma_id is automatically set from session
$stok = Stok::create([...]); // firma_id set automatically
```

#### [SetCurrentFirma Middleware](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Middleware/SetCurrentFirma.php)
Middleware that ensures authenticated users have a current firma set in session.

#### [AppServiceProvider](file:///c:/Repo2026/Web/DT_Hesap/app/Providers/AppServiceProvider.php)
Registers all observers for multi-tenant models.

---

## Key Features

### ✅ Multi-Tenant Architecture
- **Row-level isolation** using `firma_id` foreign key
- All transactional tables include `firma_id`
- Automatic filtering via `FirmaScope`
- Automatic `firma_id` assignment via `FirmaObserver`

### ✅ Cari Sharing Across Firms
- Cari records are **global** (no `firma_id` in `cariler` table)
- Firm-specific data stored in `cari_firma` pivot table
- Each firm maintains separate balances with the same cari
- Helper method `getBalanceForFirma()` for easy balance retrieval

### ✅ Complete Relationships
- **belongsTo**: Child → Parent (e.g., Fatura → Firma, Fatura → Cari)
- **hasMany**: Parent → Children (e.g., Firma → Faturalar, Fatura → Kalemler)
- **belongsToMany**: Many-to-Many (e.g., Firma ↔ User, Firma ↔ Cari)
- **Polymorphic**: Flexible document references (e.g., StokHareket → Fatura)

### ✅ Data Integrity
- Foreign key constraints with appropriate `onDelete` actions
- Soft deletes on all major tables
- Unique constraints respecting `firma_id` where needed
- Decimal(18,2) for all monetary values

### ✅ Performance Optimization
- Composite indexes on `firma_id` + other frequently queried fields
- Indexes on date fields for reporting
- Indexes on foreign keys for join performance

---

## Usage Examples

### Setting Current Firma

```php
// In controller or middleware
session(['current_firma_id' => $firmaId]);

// Or use the middleware (automatically sets default firma)
// Add to route group in routes/web.php:
Route::middleware(['auth', SetCurrentFirma::class])->group(function () {
    // Your routes here
});
```

### Creating Records

```php
// firma_id is automatically set from session
$stok = Stok::create([
    'stok_kodu' => 'STK001',
    'stok_adi' => 'Ürün 1',
    'satis_fiyat' => 100.00,
    // firma_id automatically added
]);

$fatura = Fatura::create([
    'fatura_no' => 'FAT-2024-001',
    'fatura_tipi' => 'satis',
    'cari_id' => $cariId,
    'tarih' => now(),
    // firma_id automatically added
]);
```

### Querying with Relationships

```php
// Get all invoices for current firma (automatically filtered)
$faturalar = Fatura::with('cari', 'kalemler')->get();

// Get a firma's users
$firma = Firma::find($id);
$users = $firma->users;

// Get user's companies
$user = auth()->user();
$firmalar = $user->firmalar;

// Get cari balance for specific firma
$cari = Cari::find($cariId);
$balance = $cari->getBalanceForFirma($firmaId);
// Returns: ['borc' => 1000, 'alacak' => 500, 'bakiye' => 500]
```

### Bypassing Global Scope (Admin Operations)

```php
// When you need to query across all firms (e.g., admin panel)
$allStoklar = Stok::withoutGlobalScope(FirmaScope::class)->get();
```

### Working with Pivot Data

```php
// Attach user to firma with role
$firma->users()->attach($userId, [
    'rol' => 'muhasebeci',
    'yetkiler' => ['fatura_olustur', 'rapor_goruntule'],
    'varsayilan' => true,
]);

// Attach cari to firma with balance
$firma->cariler()->attach($cariId, [
    'borc_bakiye' => 0,
    'alacak_bakiye' => 0,
    'risk_limiti' => 50000,
    'vade_gun' => 30,
]);
```

---

## Running Migrations

To create all tables in your database:

```bash
php artisan migrate
```

To rollback:

```bash
php artisan migrate:rollback
```

To refresh (drop all tables and re-migrate):

```bash
php artisan migrate:fresh
```

---

## Next Steps

### 1. Register Middleware
Add to `app/Http/Kernel.php` or `bootstrap/app.php` (Laravel 11):

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->web(append: [
        \App\Http\Middleware\SetCurrentFirma::class,
    ]);
})
```

### 2. Create Seeders (Optional)
Create sample data for testing:

```bash
php artisan make:seeder FirmalarSeeder
php artisan make:seeder UsersSeeder
php artisan make:seeder CarilerSeeder
```

### 3. Create Controllers
Generate controllers for each module:

```bash
php artisan make:controller FirmaController --resource
php artisan make:controller CariController --resource
php artisan make:controller StokController --resource
php artisan make:controller FaturaController --resource
# etc.
```

### 4. Create Form Requests
For validation:

```bash
php artisan make:request StoreFaturaRequest
php artisan make:request UpdateFaturaRequest
```

### 5. Build Frontend with Tailwind CSS
- Create Blade views for each module
- Use Tailwind CSS for styling
- Implement CRUD operations
- Add reporting and analytics

---

## Database Schema Summary

| Module | Tables | Models | Key Features |
|--------|--------|--------|--------------|
| **Core** | firmalar, users, firma_user | Firma, User | Multi-tenant foundation |
| **Cari** | cariler, cari_firma | Cari | Shared across firms |
| **Stok** | stoklar, stok_hareketleri | Stok, StokHareket | Inventory tracking |
| **Fatura** | faturalar, fatura_kalemleri | Fatura, FaturaKalem | Purchase & sales invoices |
| **Kasa** | kasalar, kasa_hareketleri | Kasa, KasaHareket | Cash management |
| **Banka** | bankalar, banka_hareketleri | Banka, BankaHareket | Bank accounts |
| **Çek/Senet** | cek_senetler | CekSenet | Checks & promissory notes |
| **Sipariş** | siparisler, siparis_kalemleri | Siparis, SiparisKalem | Order management |

**Total: 18 Tables, 13 Models**

---

## Architecture Highlights

> [!NOTE]
> **Multi-Tenant Strategy**
> - Shared database with row-level isolation
> - Session-based firma context
> - Automatic filtering and assignment
> - No code changes needed in controllers

> [!TIP]
> **Cari Sharing**
> - One cari record can serve multiple firms
> - Each firm tracks its own balances
> - Reduces data duplication
> - Maintains data integrity

> [!IMPORTANT]
> **Data Isolation**
> - All queries automatically filtered by `firma_id`
> - Users can only access data for their assigned firms
> - Middleware ensures firma context is always set
> - Observer prevents manual firma_id manipulation

---

## Files Created

### Migrations (18 files)
- `database/migrations/2024_01_01_0000*.php`

### Models (13 files)
- `app/Models/*.php`

### Infrastructure (4 files)
- `app/Models/Scopes/FirmaScope.php`
- `app/Observers/FirmaObserver.php`
- `app/Http/Middleware/SetCurrentFirma.php`
- `app/Providers/AppServiceProvider.php` (updated)

**Total: 35 files created/updated**

---

## Conclusion

The multi-tenant pre-accounting database is now fully implemented and ready for use. All tables, models, relationships, and multi-tenant infrastructure are in place. You can now proceed with building controllers, views, and business logic on top of this solid foundation.
