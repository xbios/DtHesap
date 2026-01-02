# Multi-Tenant Pre-Accounting Database Schema

Comprehensive database design for a Laravel-based multi-tenant pre-accounting/ERP-lite system with support for firma (company), kullanıcı (user), cari (customer/supplier), stok (inventory), fatura (invoice), kasa (cash), banka (bank), çek/senet (check/promissory note), and sipariş (order) modules.

## User Review Required

> [!IMPORTANT]
> **Multi-Tenant Architecture Decision**
> - Using `firma_id` foreign key approach (shared database, row-level isolation)
> - Alternative: Separate databases per tenant (not recommended for this scale)
> - All transactional tables will include `firma_id` for data isolation

> [!IMPORTANT]
> **Cari (Customer/Supplier) Sharing**
> - Cari records can be shared across multiple firms via pivot table `cari_firma`
> - Each firm maintains its own balance and transaction history with the same cari
> - This allows companies to share customer/supplier data while keeping financials separate

> [!WARNING]
> **Decimal Precision**
> - Using `decimal(18,2)` for all monetary values
> - Consider if you need more decimal places for unit prices or foreign currencies
> - Can be adjusted during migration creation if needed

## Proposed Changes

### Core Multi-Tenant Structure

#### [NEW] [2024_01_01_000001_create_firmalar_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000001_create_firmalar_table.php)

**Table: `firmalar`** (Companies)
- `id` - bigIncrements
- `firma_adi` - string(255) - Company name
- `vergi_dairesi` - string(100) - nullable
- `vergi_no` - string(20) - nullable
- `adres` - text - nullable
- `telefon` - string(20) - nullable
- `email` - string(100) - nullable
- `yetkili_kisi` - string(100) - nullable
- `logo_path` - string(255) - nullable
- `aktif` - boolean - default(true)
- `ayarlar` - json - nullable (for company-specific settings)
- `timestamps`
- `softDeletes`

**Indexes:**
- Unique: `vergi_no` (where not null)
- Index: `aktif`

---

#### [NEW] [2024_01_01_000002_create_users_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000002_create_users_table.php)

**Table: `users`** (Users)
- `id` - bigIncrements
- `name` - string(255)
- `email` - string(255) - unique
- `email_verified_at` - timestamp - nullable
- `password` - string
- `telefon` - string(20) - nullable
- `aktif` - boolean - default(true)
- `son_giris` - timestamp - nullable
- `remember_token` - string(100) - nullable
- `timestamps`
- `softDeletes`

**Indexes:**
- Unique: `email`
- Index: `aktif`

---

#### [NEW] [2024_01_01_000003_create_firma_user_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000003_create_firma_user_table.php)

**Table: `firma_user`** (Pivot: User-Company relationship)
- `id` - bigIncrements
- `firma_id` - unsignedBigInteger
- `user_id` - unsignedBigInteger
- `rol` - enum('admin', 'muhasebeci', 'kullanici') - default('kullanici')
- `yetkiler` - json - nullable (permissions array)
- `varsayilan` - boolean - default(false) (default company for user)
- `timestamps`

**Foreign Keys:**
- `firma_id` → `firmalar.id` (onDelete: cascade)
- `user_id` → `users.id` (onDelete: cascade)

**Indexes:**
- Unique: `firma_id, user_id`
- Index: `user_id`

---

### Cari (Customer/Supplier) Module

#### [NEW] [2024_01_01_000010_create_cariler_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000010_create_cariler_table.php)

**Table: `cariler`** (Customers/Suppliers - Shared across firms)
- `id` - bigIncrements
- `cari_kodu` - string(50) - unique
- `cari_adi` - string(255)
- `cari_tipi` - enum('musteri', 'tedarikci', 'her_ikisi') - default('musteri')
- `vergi_dairesi` - string(100) - nullable
- `vergi_no` - string(20) - nullable
- `tc_kimlik_no` - string(11) - nullable
- `adres` - text - nullable
- `il` - string(50) - nullable
- `ilce` - string(50) - nullable
- `posta_kodu` - string(10) - nullable
- `telefon` - string(20) - nullable
- `telefon2` - string(20) - nullable
- `email` - string(100) - nullable
- `yetkili_kisi` - string(100) - nullable
- `aktif` - boolean - default(true)
- `notlar` - text - nullable
- `timestamps`
- `softDeletes`

**Indexes:**
- Unique: `cari_kodu`
- Index: `cari_tipi`, `aktif`
- Index: `vergi_no` (where not null)

---

#### [NEW] [2024_01_01_000011_create_cari_firma_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000011_create_cari_firma_table.php)

**Table: `cari_firma`** (Pivot: Cari-Company relationship with balances)
- `id` - bigIncrements
- `cari_id` - unsignedBigInteger
- `firma_id` - unsignedBigInteger
- `borc_bakiye` - decimal(18,2) - default(0) (debit balance)
- `alacak_bakiye` - decimal(18,2) - default(0) (credit balance)
- `risk_limiti` - decimal(18,2) - nullable
- `vade_gun` - integer - default(0)
- `iskonto_orani` - decimal(5,2) - default(0)
- `ozel_kod1` - string(50) - nullable
- `ozel_kod2` - string(50) - nullable
- `aktif` - boolean - default(true)
- `timestamps`

**Foreign Keys:**
- `cari_id` → `cariler.id` (onDelete: cascade)
- `firma_id` → `firmalar.id` (onDelete: cascade)

**Indexes:**
- Unique: `cari_id, firma_id`
- Index: `firma_id`

---

### Stok (Inventory) Module

#### [NEW] [2024_01_01_000020_create_stoklar_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000020_create_stoklar_table.php)

**Table: `stoklar`** (Inventory Items)
- `id` - bigIncrements
- `firma_id` - unsignedBigInteger
- `stok_kodu` - string(50)
- `stok_adi` - string(255)
- `barkod` - string(50) - nullable
- `birim` - string(20) - default('Adet')
- `stok_tipi` - enum('urun', 'hammadde', 'yari_mamul', 'hizmet') - default('urun')
- `kategori` - string(100) - nullable
- `marka` - string(100) - nullable
- `model` - string(100) - nullable
- `alis_fiyat` - decimal(18,2) - default(0)
- `satis_fiyat` - decimal(18,2) - default(0)
- `kdv_orani` - decimal(5,2) - default(20)
- `kritik_stok` - decimal(18,2) - default(0)
- `mevcut_stok` - decimal(18,2) - default(0)
- `aciklama` - text - nullable
- `resim_path` - string(255) - nullable
- `aktif` - boolean - default(true)
- `timestamps`
- `softDeletes`

**Foreign Keys:**
- `firma_id` → `firmalar.id` (onDelete: cascade)

**Indexes:**
- Unique: `firma_id, stok_kodu`
- Index: `firma_id, aktif`
- Index: `barkod` (where not null)

---

#### [NEW] [2024_01_01_000021_create_stok_hareketleri_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000021_create_stok_hareketleri_table.php)

**Table: `stok_hareketleri`** (Inventory Movements)
- `id` - bigIncrements
- `firma_id` - unsignedBigInteger
- `stok_id` - unsignedBigInteger
- `hareket_tipi` - enum('giris', 'cikis', 'devir', 'sayim') - Inventory movement type
- `miktar` - decimal(18,2)
- `birim_fiyat` - decimal(18,2) - default(0)
- `toplam_tutar` - decimal(18,2) - default(0)
- `tarih` - date
- `evrak_no` - string(50) - nullable
- `evrak_tipi` - string(50) - nullable (fatura, irsaliye, etc.)
- `evrak_id` - unsignedBigInteger - nullable (polymorphic reference)
- `aciklama` - text - nullable
- `timestamps`

**Foreign Keys:**
- `firma_id` → `firmalar.id` (onDelete: cascade)
- `stok_id` → `stoklar.id` (onDelete: cascade)

**Indexes:**
- Index: `firma_id, stok_id`
- Index: `tarih`
- Index: `evrak_tipi, evrak_id`

---

### Fatura (Invoice) Module

#### [NEW] [2024_01_01_000030_create_faturalar_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000030_create_faturalar_table.php)

**Table: `faturalar`** (Invoices - Purchase & Sales)
- `id` - bigIncrements
- `firma_id` - unsignedBigInteger
- `fatura_no` - string(50)
- `fatura_tipi` - enum('alis', 'satis')
- `cari_id` - unsignedBigInteger
- `tarih` - date
- `vade_tarihi` - date - nullable
- `ara_toplam` - decimal(18,2) - default(0)
- `iskonto_tutar` - decimal(18,2) - default(0)
- `kdv_tutar` - decimal(18,2) - default(0)
- `genel_toplam` - decimal(18,2) - default(0)
- `odenen_tutar` - decimal(18,2) - default(0)
- `kalan_tutar` - decimal(18,2) - default(0)
- `para_birimi` - string(3) - default('TRY')
- `kur` - decimal(10,4) - default(1)
- `durum` - enum('taslak', 'onaylandi', 'odendi', 'iptal') - default('taslak')
- `aciklama` - text - nullable
- `timestamps`
- `softDeletes`

**Foreign Keys:**
- `firma_id` → `firmalar.id` (onDelete: cascade)
- `cari_id` → `cariler.id` (onDelete: restrict)

**Indexes:**
- Unique: `firma_id, fatura_no, fatura_tipi`
- Index: `firma_id, fatura_tipi, durum`
- Index: `tarih`
- Index: `cari_id`

---

#### [NEW] [2024_01_01_000031_create_fatura_kalemleri_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000031_create_fatura_kalemleri_table.php)

**Table: `fatura_kalemleri`** (Invoice Line Items)
- `id` - bigIncrements
- `fatura_id` - unsignedBigInteger
- `stok_id` - unsignedBigInteger - nullable
- `aciklama` - string(255)
- `miktar` - decimal(18,2)
- `birim` - string(20)
- `birim_fiyat` - decimal(18,2)
- `iskonto_orani` - decimal(5,2) - default(0)
- `iskonto_tutar` - decimal(18,2) - default(0)
- `kdv_orani` - decimal(5,2) - default(20)
- `kdv_tutar` - decimal(18,2) - default(0)
- `toplam` - decimal(18,2)
- `sira` - integer - default(0)
- `timestamps`

**Foreign Keys:**
- `fatura_id` → `faturalar.id` (onDelete: cascade)
- `stok_id` → `stoklar.id` (onDelete: set null)

**Indexes:**
- Index: `fatura_id`
- Index: `stok_id`

---

### Kasa (Cash) Module

#### [NEW] [2024_01_01_000040_create_kasalar_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000040_create_kasalar_table.php)

**Table: `kasalar`** (Cash Registers)
- `id` - bigIncrements
- `firma_id` - unsignedBigInteger
- `kasa_adi` - string(100)
- `kasa_kodu` - string(50)
- `para_birimi` - string(3) - default('TRY')
- `bakiye` - decimal(18,2) - default(0)
- `aciklama` - text - nullable
- `aktif` - boolean - default(true)
- `timestamps`
- `softDeletes`

**Foreign Keys:**
- `firma_id` → `firmalar.id` (onDelete: cascade)

**Indexes:**
- Unique: `firma_id, kasa_kodu`
- Index: `firma_id, aktif`

---

#### [NEW] [2024_01_01_000041_create_kasa_hareketleri_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000041_create_kasa_hareketleri_table.php)

**Table: `kasa_hareketleri`** (Cash Movements)
- `id` - bigIncrements
- `firma_id` - unsignedBigInteger
- `kasa_id` - unsignedBigInteger
- `hareket_tipi` - enum('giris', 'cikis', 'devir')
- `tutar` - decimal(18,2)
- `tarih` - date
- `cari_id` - unsignedBigInteger - nullable
- `kategori` - string(100) - nullable (e.g., 'tahsilat', 'odeme', 'masraf')
- `aciklama` - text - nullable
- `evrak_no` - string(50) - nullable
- `evrak_tipi` - string(50) - nullable
- `evrak_id` - unsignedBigInteger - nullable
- `timestamps`

**Foreign Keys:**
- `firma_id` → `firmalar.id` (onDelete: cascade)
- `kasa_id` → `kasalar.id` (onDelete: cascade)
- `cari_id` → `cariler.id` (onDelete: set null)

**Indexes:**
- Index: `firma_id, kasa_id`
- Index: `tarih`
- Index: `cari_id`

---

### Banka (Bank) Module

#### [NEW] [2024_01_01_000050_create_bankalar_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000050_create_bankalar_table.php)

**Table: `bankalar`** (Bank Accounts)
- `id` - bigIncrements
- `firma_id` - unsignedBigInteger
- `banka_adi` - string(100)
- `sube_adi` - string(100) - nullable
- `sube_kodu` - string(20) - nullable
- `hesap_no` - string(50)
- `iban` - string(34) - nullable
- `para_birimi` - string(3) - default('TRY')
- `bakiye` - decimal(18,2) - default(0)
- `aciklama` - text - nullable
- `aktif` - boolean - default(true)
- `timestamps`
- `softDeletes`

**Foreign Keys:**
- `firma_id` → `firmalar.id` (onDelete: cascade)

**Indexes:**
- Unique: `firma_id, hesap_no`
- Index: `firma_id, aktif`
- Index: `iban`

---

#### [NEW] [2024_01_01_000051_create_banka_hareketleri_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000051_create_banka_hareketleri_table.php)

**Table: `banka_hareketleri`** (Bank Movements)
- `id` - bigIncrements
- `firma_id` - unsignedBigInteger
- `banka_id` - unsignedBigInteger
- `hareket_tipi` - enum('giris', 'cikis', 'devir')
- `tutar` - decimal(18,2)
- `tarih` - date
- `valor_tarihi` - date - nullable
- `cari_id` - unsignedBigInteger - nullable
- `kategori` - string(100) - nullable
- `aciklama` - text - nullable
- `evrak_no` - string(50) - nullable
- `evrak_tipi` - string(50) - nullable
- `evrak_id` - unsignedBigInteger - nullable
- `timestamps`

**Foreign Keys:**
- `firma_id` → `firmalar.id` (onDelete: cascade)
- `banka_id` → `bankalar.id` (onDelete: cascade)
- `cari_id` → `cariler.id` (onDelete: set null)

**Indexes:**
- Index: `firma_id, banka_id`
- Index: `tarih`
- Index: `cari_id`

---

### Çek/Senet (Check/Promissory Note) Module

#### [NEW] [2024_01_01_000060_create_cek_senetler_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000060_create_cek_senetler_table.php)

**Table: `cek_senetler`** (Checks & Promissory Notes)
- `id` - bigIncrements
- `firma_id` - unsignedBigInteger
- `tip` - enum('cek', 'senet')
- `portfoy_tipi` - enum('musteri', 'firma') (received from customer or issued by company)
- `cari_id` - unsignedBigInteger
- `evrak_no` - string(50)
- `tutar` - decimal(18,2)
- `para_birimi` - string(3) - default('TRY')
- `vade_tarihi` - date
- `durum` - enum('portfoyde', 'bankaya_verildi', 'tahsil_edildi', 'iade', 'iptal') - default('portfoyde')
- `banka_adi` - string(100) - nullable
- `sube_adi` - string(100) - nullable
- `hesap_no` - string(50) - nullable
- `asil_borclu` - string(255) - nullable (for promissory notes)
- `ciro_eden` - string(255) - nullable
- `duzenlenme_tarihi` - date - nullable
- `tahsil_tarihi` - date - nullable
- `aciklama` - text - nullable
- `timestamps`
- `softDeletes`

**Foreign Keys:**
- `firma_id` → `firmalar.id` (onDelete: cascade)
- `cari_id` → `cariler.id` (onDelete: restrict)

**Indexes:**
- Index: `firma_id, tip, portfoy_tipi, durum`
- Index: `vade_tarihi`
- Index: `cari_id`
- Index: `evrak_no`

---

### Sipariş (Order) Module

#### [NEW] [2024_01_01_000070_create_siparisler_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000070_create_siparisler_table.php)

**Table: `siparisler`** (Orders - Purchase & Sales)
- `id` - bigIncrements
- `firma_id` - unsignedBigInteger
- `siparis_no` - string(50)
- `siparis_tipi` - enum('alis', 'satis')
- `cari_id` - unsignedBigInteger
- `tarih` - date
- `teslim_tarihi` - date - nullable
- `ara_toplam` - decimal(18,2) - default(0)
- `iskonto_tutar` - decimal(18,2) - default(0)
- `kdv_tutar` - decimal(18,2) - default(0)
- `genel_toplam` - decimal(18,2) - default(0)
- `para_birimi` - string(3) - default('TRY')
- `kur` - decimal(10,4) - default(1)
- `durum` - enum('beklemede', 'onaylandi', 'hazirlaniyor', 'tamamlandi', 'iptal') - default('beklemede')
- `teslimat_adresi` - text - nullable
- `aciklama` - text - nullable
- `timestamps`
- `softDeletes`

**Foreign Keys:**
- `firma_id` → `firmalar.id` (onDelete: cascade)
- `cari_id` → `cariler.id` (onDelete: restrict)

**Indexes:**
- Unique: `firma_id, siparis_no, siparis_tipi`
- Index: `firma_id, siparis_tipi, durum`
- Index: `tarih`
- Index: `cari_id`

---

#### [NEW] [2024_01_01_000071_create_siparis_kalemleri_table.php](file:///c:/Repo2026/Web/DT_Hesap/database/migrations/2024_01_01_000071_create_siparis_kalemleri_table.php)

**Table: `siparis_kalemleri`** (Order Line Items)
- `id` - bigIncrements
- `siparis_id` - unsignedBigInteger
- `stok_id` - unsignedBigInteger - nullable
- `aciklama` - string(255)
- `miktar` - decimal(18,2)
- `teslim_edilen_miktar` - decimal(18,2) - default(0)
- `birim` - string(20)
- `birim_fiyat` - decimal(18,2)
- `iskonto_orani` - decimal(5,2) - default(0)
- `iskonto_tutar` - decimal(18,2) - default(0)
- `kdv_orani` - decimal(5,2) - default(20)
- `kdv_tutar` - decimal(18,2) - default(0)
- `toplam` - decimal(18,2)
- `sira` - integer - default(0)
- `timestamps`

**Foreign Keys:**
- `siparis_id` → `siparisler.id` (onDelete: cascade)
- `stok_id` → `stoklar.id` (onDelete: set null)

**Indexes:**
- Index: `siparis_id`
- Index: `stok_id`

---

## Eloquent Model Relationships

### Firma Model
```php
// One-to-Many
hasMany(Stok::class)
hasMany(Fatura::class)
hasMany(Kasa::class)
hasMany(Banka::class)
hasMany(CekSenet::class)
hasMany(Siparis::class)

// Many-to-Many
belongsToMany(User::class)->withPivot('rol', 'yetkiler', 'varsayilan')->withTimestamps()
belongsToMany(Cari::class, 'cari_firma')->withPivot('borc_bakiye', 'alacak_bakiye', 'risk_limiti', 'vade_gun', 'iskonto_orani', 'aktif')->withTimestamps()
```

### User Model
```php
// Many-to-Many
belongsToMany(Firma::class)->withPivot('rol', 'yetkiler', 'varsayilan')->withTimestamps()
```

### Cari Model
```php
// Many-to-Many
belongsToMany(Firma::class, 'cari_firma')->withPivot('borc_bakiye', 'alacak_bakiye', 'risk_limiti', 'vade_gun', 'iskonto_orani', 'aktif')->withTimestamps()

// One-to-Many
hasMany(Fatura::class)
hasMany(KasaHareket::class)
hasMany(BankaHareket::class)
hasMany(CekSenet::class)
hasMany(Siparis::class)
```

### Stok Model
```php
// Belongs To
belongsTo(Firma::class)

// One-to-Many
hasMany(StokHareket::class)
hasMany(FaturaKalem::class)
hasMany(SiparisKalem::class)
```

### Fatura Model
```php
// Belongs To
belongsTo(Firma::class)
belongsTo(Cari::class)

// One-to-Many
hasMany(FaturaKalem::class)

// Polymorphic (as evrak)
morphMany(StokHareket::class, 'evrak')
morphMany(KasaHareket::class, 'evrak')
morphMany(BankaHareket::class, 'evrak')
```

### Kasa Model
```php
// Belongs To
belongsTo(Firma::class)

// One-to-Many
hasMany(KasaHareket::class)
```

### Banka Model
```php
// Belongs To
belongsTo(Firma::class)

// One-to-Many
hasMany(BankaHareket::class)
```

### CekSenet Model
```php
// Belongs To
belongsTo(Firma::class)
belongsTo(Cari::class)
```

### Siparis Model
```php
// Belongs To
belongsTo(Firma::class)
belongsTo(Cari::class)

// One-to-Many
hasMany(SiparisKalem::class)
```

---

## Multi-Tenant Implementation Guidelines

### 1. Global Scopes
Create a global scope for automatic `firma_id` filtering:

```php
// app/Models/Scopes/FirmaScope.php
protected static function booted()
{
    static::addGlobalScope(new FirmaScope);
}
```

### 2. Middleware for Firma Context
Create middleware to set current firma context from session/user preference:

```php
// Set current firma in session
session(['current_firma_id' => $firmaId]);
```

### 3. Model Observers
Use observers to automatically set `firma_id` on creation:

```php
// Automatically set firma_id from session
$model->firma_id = session('current_firma_id');
```

### 4. Query Optimization
- Always add `firma_id` to composite indexes
- Use eager loading to prevent N+1 queries
- Consider database partitioning for very large datasets

### 5. Data Isolation
- Never expose data across firms in queries
- Validate `firma_id` in form requests
- Use policies to enforce firma-level authorization

### 6. Cari Sharing Strategy
- Cari records are global (no `firma_id`)
- Use `cari_firma` pivot for firm-specific data
- Each firm maintains separate balances
- Transactions always reference both `cari_id` and `firma_id`

---

## Additional Recommendations

### 1. Audit Trail
Consider adding an audit table:
- `user_id` - who made the change
- `firma_id` - which company
- `auditable_type` - model class
- `auditable_id` - record id
- `event` - created/updated/deleted
- `old_values` - JSON
- `new_values` - JSON
- `ip_address`
- `user_agent`

### 2. Settings & Configuration
Use the `ayarlar` JSON column in `firmalar` for:
- Default tax rates
- Invoice numbering format
- Currency preferences
- Fiscal year settings
- Report preferences

### 3. Backup & Recovery
- Regular database backups
- Point-in-time recovery capability
- Firm-level data export functionality

### 4. Performance Indexes
All suggested indexes are included in table definitions above. Additional composite indexes may be needed based on actual query patterns.

### 5. Data Validation Rules
- Unique constraints respect `firma_id` where applicable
- Soft deletes enabled on all major tables
- Cascade deletes configured appropriately
- Restrict deletes on referenced records (e.g., cari in fatura)

---

## Verification Plan

### Schema Validation
- Review all table structures for completeness
- Verify foreign key relationships
- Confirm index coverage for common queries
- Validate multi-tenant isolation

### User Feedback
- Confirm decimal precision requirements
- Verify enum values match business processes
- Validate field names and Turkish terminology
- Confirm additional modules or fields needed

