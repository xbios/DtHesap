# Laravel Kurulum Sorunu - Hızlı Çözüm

## Sorun
`php artisan` komutu çalışmıyor. Bootstrap hatası alınıyor.

## ✅ En Hızlı Çözüm

### 1. Yeni Bir Dizinde Temiz Laravel 10 Kur
```bash
cd c:\Repo2026\Web
composer create-project laravel/laravel:^10.0 DT_Hesap_Working
cd DT_Hesap_Working
```

### 2. Şu Dosyaları Kopyala

**Database (31 dosya):**
```
DT_Hesap\database\migrations\*.php  →  DT_Hesap_Working\database\migrations\
DT_Hesap\app\Models\*.php           →  DT_Hesap_Working\app\Models\
DT_Hesap\app\Models\Scopes\*.php    →  DT_Hesap_Working\app\Models\Scopes\
```

**Controllers (3 dosya):**
```
DT_Hesap\app\Http\Controllers\DashboardController.php  →  DT_Hesap_Working\app\Http\Controllers\
DT_Hesap\app\Http\Controllers\FirmaController.php      →  DT_Hesap_Working\app\Http\Controllers\
DT_Hesap\app\Http\Controllers\ProfileController.php    →  DT_Hesap_Working\app\Http\Controllers\
```

**Form Requests (3 dosya):**
```
DT_Hesap\app\Http\Requests\*.php  →  DT_Hesap_Working\app\Http\Requests\
```

**Middleware (1 dosya):**
```
DT_Hesap\app\Http\Middleware\SetCurrentFirma.php  →  DT_Hesap_Working\app\Http\Middleware\
```

**Observers (1 dosya):**
```
DT_Hesap\app\Observers\FirmaObserver.php  →  DT_Hesap_Working\app\Observers\
```

**Views (tüm klasör):**
```
DT_Hesap\resources\views\  →  DT_Hesap_Working\resources\views\
```

**Assets:**
```
DT_Hesap\resources\css\app.css      →  DT_Hesap_Working\resources\css\
DT_Hesap\resources\js\app.js        →  DT_Hesap_Working\resources\js\
DT_Hesap\resources\js\bootstrap.js  →  DT_Hesap_Working\resources\js\
```

**Config:**
```
DT_Hesap\tailwind.config.js   →  DT_Hesap_Working\
DT_Hesap\postcss.config.js    →  DT_Hesap_Working\
DT_Hesap\vite.config.js       →  DT_Hesap_Working\
DT_Hesap\package.json         →  DT_Hesap_Working\
```

**Routes:**
```
DT_Hesap\routes\web.php   →  DT_Hesap_Working\routes\
DT_Hesap\routes\auth.php  →  DT_Hesap_Working\routes\
```

### 3. AppServiceProvider'ı Güncelle

`DT_Hesap_Working\app\Providers\AppServiceProvider.php` dosyasını aç ve `boot()` metodunu güncelle:

```php
public function boot(): void
{
    // Register observers
    \App\Models\Stok::observe(\App\Observers\FirmaObserver::class);
    \App\Models\StokHareket::observe(\App\Observers\FirmaObserver::class);
    \App\Models\Fatura::observe(\App\Observers\FirmaObserver::class);
    \App\Models\Kasa::observe(\App\Observers\FirmaObserver::class);
    \App\Models\KasaHareket::observe(\App\Observers\FirmaObserver::class);
    \App\Models\Banka::observe(\App\Observers\FirmaObserver::class);
    \App\Models\BankaHareket::observe(\App\Observers\FirmaObserver::class);
    \App\Models\CekSenet::observe(\App\Observers\FirmaObserver::class);
    \App\Models\Siparis::observe(\App\Observers\FirmaObserver::class);
}
```

### 4. Http Kernel'a Middleware Ekle

`DT_Hesap_Working\app\Http\Kernel.php` dosyasında `web` middleware grubuna ekle:

```php
protected $middlewareGroups = [
    'web' => [
        // ... mevcut middleware'ler
        \App\Http\Middleware\SetCurrentFirma::class,  // ← EKLE
    ],
];
```

### 5. Kurulumu Tamamla

```bash
cd DT_Hesap_Working

# NPM paketlerini yükle
npm install

# .env dosyasını düzenle (veritabanı bilgileri)
# DB_DATABASE=dt_hesap
# DB_USERNAME=root
# DB_PASSWORD=

# Veritabanını oluştur
mysql -u root -e "CREATE DATABASE dt_hesap CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Migration'ları çalıştır
php artisan migrate

# Assets'leri build et
npm run dev
```

Yeni terminal:
```bash
php artisan serve
```

### 6. Tarayıcıda Aç
```
http://localhost:8000
```

---

## 📋 Kopyalanacak Dosya Listesi

**Toplam: ~70 dosya**

✅ 18 Migration
✅ 13 Model + 1 Scope
✅ 3 Controller
✅ 3 Form Request
✅ 1 Middleware
✅ 1 Observer
✅ 12 View dosyası
✅ 3 Asset dosyası
✅ 4 Config dosyası
✅ 2 Route dosyası

---

## 🎯 Sonuç

Bu yöntemle:
- ✅ Temiz, çalışan Laravel 10 kurulumu
- ✅ Tüm özel kodlarınız yerinde
- ✅ Artisan çalışır durumda
- ✅ Migration'lar hazır
- ✅ Frontend build edilebilir

**Süre:** ~10 dakika
**Sonuç:** Tam çalışır sistem!
