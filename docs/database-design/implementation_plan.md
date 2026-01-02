# Multi-Tenant ERP Database Schema - Implementation Plan

## Overview
Designing a comprehensive multi-tenant pre-accounting/ERP system with 9 core modules. Each user can belong to multiple firms, and all transactional data is isolated by `firma_id`.

## Database Architecture

### Multi-Tenancy Strategy
- **Shared Database, Shared Schema** approach
- All transactional tables include `firma_id` foreign key
- Global scopes on models to auto-filter by active firm
- Middleware to set current firm context
- Pivot table for user-firm relationships

---

## Core Tables

### 1. users
**Purpose**: System users (Laravel default + extensions)

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | User ID |
| name | string(255) | required | Full name |
| email | string(255) | unique, required | Email address |
| email_verified_at | timestamp | nullable | Email verification |
| password | string(255) | required | Hashed password |
| remember_token | string(100) | nullable | Remember token |
| current_firma_id | bigInteger | nullable, FK | Active firm |
| is_active | boolean | default true | Account status |
| last_login_at | timestamp | nullable | Last login time |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `users_email_unique`
- `users_current_firma_id_foreign`

**Relationships:**
- `belongsTo`: currentFirma (Firma)
- `belongsToMany`: firmas (through firma_user)
- `hasMany`: activities, logs

---

### 2. firmas
**Purpose**: Companies/Organizations

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | Firma ID |
| kod | string(50) | unique, required | Firma code |
| unvan | string(255) | required | Company name |
| vergi_dairesi | string(100) | nullable | Tax office |
| vergi_no | string(50) | nullable | Tax number |
| adres | text | nullable | Address |
| il | string(100) | nullable | City |
| ilce | string(100) | nullable | District |
| telefon | string(50) | nullable | Phone |
| email | string(255) | nullable | Email |
| website | string(255) | nullable | Website |
| logo_path | string(500) | nullable | Logo file path |
| is_active | boolean | default true | Active status |
| ayarlar | json | nullable | Settings (JSON) |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `firmas_kod_unique`
- `firmas_is_active_index`

**Relationships:**
- `belongsToMany`: users (through firma_user)
- `hasMany`: caris, stoks, faturas, kasas, bankas, ceks, siparisler

---

### 3. firma_user (Pivot)
**Purpose**: User-Firm relationship

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | ID |
| firma_id | bigInteger | FK, required | Firma ID |
| user_id | bigInteger | FK, required | User ID |
| rol | string(50) | nullable | Role in firm |
| yetki_seviyesi | tinyInteger | default 1 | Permission level |
| created_at | timestamp | | |
| updated_at | timestamp | | |

**Indexes:**
- `firma_user_firma_id_foreign`
- `firma_user_user_id_foreign`
- `firma_user_firma_id_user_id_unique` (composite unique)

---

## Cari Module

### 4. caris
**Purpose**: Customers and Suppliers

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | Cari ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| kod | string(50) | required | Cari code |
| unvan | string(255) | required | Name/Title |
| tip | enum | required | 'musteri', 'tedarikci', 'her_ikisi' |
| vergi_dairesi | string(100) | nullable | Tax office |
| vergi_no | string(50) | nullable | Tax number |
| tc_kimlik_no | string(11) | nullable | ID number |
| adres | text | nullable | Address |
| il | string(100) | nullable | City |
| ilce | string(100) | nullable | District |
| telefon | string(50) | nullable | Phone |
| email | string(255) | nullable | Email |
| yetkili_kisi | string(255) | nullable | Contact person |
| aciklama | text | nullable | Notes |
| borc_limiti | decimal(18,2) | default 0 | Credit limit |
| is_active | boolean | default true | Active status |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `caris_firma_id_foreign`
- `caris_firma_id_kod_unique` (composite)
- `caris_tip_index`
- `caris_is_active_index`

**Relationships:**
- `belongsTo`: firma
- `hasMany`: faturas, cari_hareketler, siparisler
- `morphMany`: adresler, iletisim_bilgileri

---

### 5. cari_hareketler
**Purpose**: Cari account movements

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| cari_id | bigInteger | FK, required | Cari ID |
| evrak_tip | string(50) | required | Document type |
| evrak_id | bigInteger | nullable | Document ID |
| tarih | date | required | Transaction date |
| aciklama | text | nullable | Description |
| borc | decimal(18,2) | default 0 | Debit |
| alacak | decimal(18,2) | default 0 | Credit |
| bakiye | decimal(18,2) | default 0 | Balance |
| doviz_tip | string(10) | default 'TRY' | Currency |
| doviz_kur | decimal(18,4) | default 1 | Exchange rate |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `cari_hareketler_firma_id_foreign`
- `cari_hareketler_cari_id_foreign`
- `cari_hareketler_tarih_index`
- `cari_hareketler_evrak_tip_evrak_id_index`

**Relationships:**
- `belongsTo`: firma, cari
- `morphTo`: evrak (polymorphic)

---

## Stok Module

### 6. stoks
**Purpose**: Inventory items

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | Stok ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| kod | string(50) | required | Stock code |
| ad | string(255) | required | Item name |
| kategori_id | bigInteger | FK, nullable | Category ID |
| birim | string(20) | default 'Adet' | Unit |
| barkod | string(100) | nullable | Barcode |
| kdv_oran | decimal(5,2) | default 20 | VAT rate |
| alis_fiyat | decimal(18,2) | default 0 | Purchase price |
| satis_fiyat | decimal(18,2) | default 0 | Sale price |
| min_stok | decimal(18,3) | default 0 | Min stock level |
| max_stok | decimal(18,3) | default 0 | Max stock level |
| aciklama | text | nullable | Description |
| resim_path | string(500) | nullable | Image path |
| is_active | boolean | default true | Active status |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `stoks_firma_id_foreign`
- `stoks_firma_id_kod_unique` (composite)
- `stoks_kategori_id_foreign`
- `stoks_barkod_index`

**Relationships:**
- `belongsTo`: firma, kategori
- `hasMany`: stok_hareketler, fatura_detaylar, siparis_detaylar

---

### 7. stok_kategoriler
**Purpose**: Stock categories

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| parent_id | bigInteger | FK, nullable | Parent category |
| ad | string(255) | required | Category name |
| kod | string(50) | nullable | Category code |
| sira | integer | default 0 | Sort order |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `stok_kategoriler_firma_id_foreign`
- `stok_kategoriler_parent_id_foreign`

**Relationships:**
- `belongsTo`: firma, parent
- `hasMany`: children, stoks

---

### 8. stok_hareketler
**Purpose**: Stock movements

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| stok_id | bigInteger | FK, required | Stock ID |
| evrak_tip | string(50) | required | Document type |
| evrak_id | bigInteger | nullable | Document ID |
| tarih | date | required | Movement date |
| giris | decimal(18,3) | default 0 | Incoming qty |
| cikis | decimal(18,3) | default 0 | Outgoing qty |
| bakiye | decimal(18,3) | default 0 | Balance |
| birim_fiyat | decimal(18,2) | default 0 | Unit price |
| aciklama | text | nullable | Description |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `stok_hareketler_firma_id_foreign`
- `stok_hareketler_stok_id_foreign`
- `stok_hareketler_tarih_index`
- `stok_hareketler_evrak_tip_evrak_id_index`

**Relationships:**
- `belongsTo`: firma, stok
- `morphTo`: evrak (polymorphic)

---

## Fatura Module

### 9. faturas
**Purpose**: Invoices (Purchase & Sales)

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | Fatura ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| cari_id | bigInteger | FK, required | Cari ID |
| fatura_no | string(50) | required | Invoice number |
| fatura_tip | enum | required | 'alis', 'satis' |
| tarih | date | required | Invoice date |
| vade_tarih | date | nullable | Due date |
| toplam_tutar | decimal(18,2) | default 0 | Subtotal |
| kdv_tutar | decimal(18,2) | default 0 | VAT amount |
| genel_toplam | decimal(18,2) | default 0 | Grand total |
| indirim_tutar | decimal(18,2) | default 0 | Discount |
| doviz_tip | string(10) | default 'TRY' | Currency |
| doviz_kur | decimal(18,4) | default 1 | Exchange rate |
| odeme_durum | enum | default 'beklemede' | 'beklemede', 'kısmi', 'tamamlandı' |
| aciklama | text | nullable | Notes |
| created_by | bigInteger | FK, nullable | Created by user |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `faturas_firma_id_foreign`
- `faturas_cari_id_foreign`
- `faturas_firma_id_fatura_no_unique` (composite)
- `faturas_tarih_index`
- `faturas_fatura_tip_index`
- `faturas_odeme_durum_index`

**Relationships:**
- `belongsTo`: firma, cari, creator (User)
- `hasMany`: fatura_detaylar, odeme_hareketler
- `morphMany`: cari_hareketler, stok_hareketler

---

### 10. fatura_detaylar
**Purpose**: Invoice line items

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| fatura_id | bigInteger | FK, required | Fatura ID |
| stok_id | bigInteger | FK, nullable | Stock ID |
| aciklama | string(500) | required | Description |
| miktar | decimal(18,3) | required | Quantity |
| birim | string(20) | default 'Adet' | Unit |
| birim_fiyat | decimal(18,2) | required | Unit price |
| kdv_oran | decimal(5,2) | default 20 | VAT rate |
| kdv_tutar | decimal(18,2) | default 0 | VAT amount |
| indirim_oran | decimal(5,2) | default 0 | Discount % |
| indirim_tutar | decimal(18,2) | default 0 | Discount amount |
| toplam | decimal(18,2) | default 0 | Line total |
| sira | integer | default 0 | Sort order |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `fatura_detaylar_firma_id_foreign`
- `fatura_detaylar_fatura_id_foreign`
- `fatura_detaylar_stok_id_foreign`

**Relationships:**
- `belongsTo`: firma, fatura, stok

---

## Kasa Module

### 11. kasas
**Purpose**: Cash registers

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | Kasa ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| kod | string(50) | required | Cash code |
| ad | string(255) | required | Cash name |
| doviz_tip | string(10) | default 'TRY' | Currency |
| acilis_bakiye | decimal(18,2) | default 0 | Opening balance |
| is_active | boolean | default true | Active status |
| aciklama | text | nullable | Description |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `kasas_firma_id_foreign`
- `kasas_firma_id_kod_unique` (composite)

**Relationships:**
- `belongsTo`: firma
- `hasMany`: kasa_hareketler

---

### 12. kasa_hareketler
**Purpose**: Cash movements

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| kasa_id | bigInteger | FK, required | Kasa ID |
| evrak_tip | string(50) | required | Document type |
| evrak_id | bigInteger | nullable | Document ID |
| tarih | date | required | Transaction date |
| islem_tip | enum | required | 'giris', 'cikis' |
| tutar | decimal(18,2) | required | Amount |
| doviz_tip | string(10) | default 'TRY' | Currency |
| doviz_kur | decimal(18,4) | default 1 | Exchange rate |
| aciklama | text | nullable | Description |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `kasa_hareketler_firma_id_foreign`
- `kasa_hareketler_kasa_id_foreign`
- `kasa_hareketler_tarih_index`
- `kasa_hareketler_evrak_tip_evrak_id_index`

**Relationships:**
- `belongsTo`: firma, kasa
- `morphTo`: evrak (polymorphic)

---

## Banka Module

### 13. bankas
**Purpose**: Bank accounts

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | Banka ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| kod | string(50) | required | Account code |
| banka_adi | string(255) | required | Bank name |
| sube_adi | string(255) | nullable | Branch name |
| hesap_no | string(100) | nullable | Account number |
| iban | string(50) | nullable | IBAN |
| doviz_tip | string(10) | default 'TRY' | Currency |
| acilis_bakiye | decimal(18,2) | default 0 | Opening balance |
| is_active | boolean | default true | Active status |
| aciklama | text | nullable | Description |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `bankas_firma_id_foreign`
- `bankas_firma_id_kod_unique` (composite)

**Relationships:**
- `belongsTo`: firma
- `hasMany`: banka_hareketler, ceks

---

### 14. banka_hareketler
**Purpose**: Bank account movements

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| banka_id | bigInteger | FK, required | Banka ID |
| evrak_tip | string(50) | required | Document type |
| evrak_id | bigInteger | nullable | Document ID |
| tarih | date | required | Transaction date |
| islem_tip | enum | required | 'giris', 'cikis' |
| tutar | decimal(18,2) | required | Amount |
| doviz_tip | string(10) | default 'TRY' | Currency |
| doviz_kur | decimal(18,4) | default 1 | Exchange rate |
| aciklama | text | nullable | Description |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `banka_hareketler_firma_id_foreign`
- `banka_hareketler_banka_id_foreign`
- `banka_hareketler_tarih_index`
- `banka_hareketler_evrak_tip_evrak_id_index`

**Relationships:**
- `belongsTo`: firma, banka
- `morphTo`: evrak (polymorphic)

---

## Çek/Senet Module

### 15. ceks
**Purpose**: Checks and Promissory Notes

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | Çek ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| cari_id | bigInteger | FK, nullable | Cari ID |
| banka_id | bigInteger | FK, nullable | Banka ID |
| cek_tip | enum | required | 'musteri_ceki', 'kendi_cekimiz', 'senet' |
| portfoy_tip | enum | required | 'alacak', 'borc' |
| cek_no | string(100) | required | Check/Note number |
| tutar | decimal(18,2) | required | Amount |
| vade_tarih | date | required | Due date |
| durum | enum | default 'portfoyde' | 'portfoyde', 'bankaya_verildi', 'tahsil_edildi', 'odendi', 'iade' |
| banka_adi | string(255) | nullable | Bank name |
| sube_adi | string(255) | nullable | Branch name |
| hesap_no | string(100) | nullable | Account number |
| keside_yeri | string(255) | nullable | Place of issue |
| keside_tarih | date | nullable | Issue date |
| aciklama | text | nullable | Description |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `ceks_firma_id_foreign`
- `ceks_cari_id_foreign`
- `ceks_banka_id_foreign`
- `ceks_vade_tarih_index`
- `ceks_durum_index`
- `ceks_cek_tip_index`

**Relationships:**
- `belongsTo`: firma, cari, banka
- `hasMany`: cek_hareketler

---

### 16. cek_hareketler
**Purpose**: Check/Note movements

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| cek_id | bigInteger | FK, required | Çek ID |
| tarih | date | required | Transaction date |
| islem_tip | enum | required | 'giris', 'cikis', 'tahsil', 'odeme', 'iade' |
| aciklama | text | nullable | Description |
| created_by | bigInteger | FK, nullable | Created by user |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `cek_hareketler_firma_id_foreign`
- `cek_hareketler_cek_id_foreign`
- `cek_hareketler_tarih_index`

**Relationships:**
- `belongsTo`: firma, cek, creator (User)

---

## Sipariş Module

### 17. siparisler
**Purpose**: Orders (Purchase & Sales)

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | Sipariş ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| cari_id | bigInteger | FK, required | Cari ID |
| siparis_no | string(50) | required | Order number |
| siparis_tip | enum | required | 'alis', 'satis' |
| tarih | date | required | Order date |
| teslim_tarih | date | nullable | Delivery date |
| durum | enum | default 'beklemede' | 'beklemede', 'onaylandi', 'hazirlaniyor', 'tamamlandi', 'iptal' |
| toplam_tutar | decimal(18,2) | default 0 | Subtotal |
| kdv_tutar | decimal(18,2) | default 0 | VAT amount |
| genel_toplam | decimal(18,2) | default 0 | Grand total |
| doviz_tip | string(10) | default 'TRY' | Currency |
| doviz_kur | decimal(18,4) | default 1 | Exchange rate |
| aciklama | text | nullable | Notes |
| created_by | bigInteger | FK, nullable | Created by user |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `siparisler_firma_id_foreign`
- `siparisler_cari_id_foreign`
- `siparisler_firma_id_siparis_no_unique` (composite)
- `siparisler_tarih_index`
- `siparisler_durum_index`

**Relationships:**
- `belongsTo`: firma, cari, creator (User)
- `hasMany`: siparis_detaylar

---

### 18. siparis_detaylar
**Purpose**: Order line items

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| siparis_id | bigInteger | FK, required | Sipariş ID |
| stok_id | bigInteger | FK, nullable | Stock ID |
| aciklama | string(500) | required | Description |
| miktar | decimal(18,3) | required | Quantity |
| teslim_miktar | decimal(18,3) | default 0 | Delivered qty |
| birim | string(20) | default 'Adet' | Unit |
| birim_fiyat | decimal(18,2) | required | Unit price |
| kdv_oran | decimal(5,2) | default 20 | VAT rate |
| toplam | decimal(18,2) | default 0 | Line total |
| sira | integer | default 0 | Sort order |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `siparis_detaylar_firma_id_foreign`
- `siparis_detaylar_siparis_id_foreign`
- `siparis_detaylar_stok_id_foreign`

**Relationships:**
- `belongsTo`: firma, siparis, stok

---

## Supporting Tables

### 19. odeme_hareketler
**Purpose**: Payment transactions

| Column | Type | Attributes | Description |
|--------|------|------------|-------------|
| id | bigInteger | PK, auto | ID |
| firma_id | bigInteger | FK, required | **Firma ID** |
| fatura_id | bigInteger | FK, nullable | Fatura ID |
| tarih | date | required | Payment date |
| tutar | decimal(18,2) | required | Amount |
| odeme_tip | enum | required | 'nakit', 'banka', 'cek', 'senet', 'kredi_karti' |
| kasa_id | bigInteger | FK, nullable | Kasa ID |
| banka_id | bigInteger | FK, nullable | Banka ID |
| cek_id | bigInteger | FK, nullable | Çek ID |
| aciklama | text | nullable | Description |
| created_at | timestamp | | |
| updated_at | timestamp | | |
| deleted_at | timestamp | nullable | Soft delete |

**Indexes:**
- `odeme_hareketler_firma_id_foreign`
- `odeme_hareketler_fatura_id_foreign`
- `odeme_hareketler_tarih_index`

**Relationships:**
- `belongsTo`: firma, fatura, kasa, banka, cek

---

## Multi-Tenant Implementation Guidelines

### 1. Global Scopes
Create a `FirmaScope` trait to automatically filter queries:

```php
protected static function booted()
{
    static::addGlobalScope('firma', function (Builder $query) {
        if (auth()->check() && auth()->user()->current_firma_id) {
            $query->where('firma_id', auth()->user()->current_firma_id);
        }
    });
}
```

### 2. Observers
Create observers to auto-set `firma_id` on creation:

```php
public function creating(Model $model)
{
    if (auth()->check() && !$model->firma_id) {
        $model->firma_id = auth()->user()->current_firma_id;
    }
}
```

### 3. Middleware
Create middleware to ensure user has access to current firma:

```php
public function handle($request, Closure $next)
{
    $user = auth()->user();
    if (!$user->firmas->contains($user->current_firma_id)) {
        abort(403, 'Unauthorized firma access');
    }
    return $next($request);
}
```

### 4. Model Relationships
Always include firma_id in relationship queries:

```php
public function caris()
{
    return $this->hasMany(Cari::class)->where('firma_id', $this->id);
}
```

### 5. Validation Rules
Include firma_id in unique validation:

```php
Rule::unique('caris', 'kod')->where('firma_id', auth()->user()->current_firma_id)
```

---

## Security Considerations

> [!CAUTION]
> **Critical Security Requirements**
> - NEVER allow cross-firma data access
> - Always validate firma_id in controllers
> - Use database transactions for multi-table operations
> - Implement row-level security checks
> - Log all firma context switches

---

## Migration Order

1. users (modify existing)
2. firmas
3. firma_user
4. stok_kategoriler
5. caris
6. stoks
7. kasas
8. bankas
9. faturas
10. fatura_detaylar
11. siparisler
12. siparis_detaylar
13. ceks
14. cek_hareketler
15. cari_hareketler
16. stok_hareketler
17. kasa_hareketler
18. banka_hareketler
19. odeme_hareketler

---

## Next Steps

1. Create all migrations in order
2. Create Eloquent models with relationships
3. Implement global scopes and observers
4. Create middleware for firma context
5. Build CRUD controllers for each module
6. Create frontend views using modern design system
