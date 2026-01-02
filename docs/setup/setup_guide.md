# Laravel Kurulum Sorunu - Çözüm Rehberi

## Sorun
Composer, Laravel bağımlılıklarını yüklerken hata veriyor. Bu genellikle PHP versiyonu veya sistem yapılandırması ile ilgilidir.

## Kontrol Edilmesi Gerekenler

### 1. PHP Versiyonu
```bash
php -v
```
**Gereksinim:** PHP 8.1 veya üzeri

### 2. Composer Versiyonu
```bash
composer --version
```
**Gereksinim:** Composer 2.x

---

## Çözüm Seçenekleri

### ✅ Seçenek 1: Manuel Laravel Kurulumu (ÖNERİLEN)

```bash
# Yeni bir dizinde Laravel kur
cd c:\Repo2026\Web
composer create-project laravel/laravel DT_Hesap_Temp

# Oluşturduğum dosyaları kopyala
# (Ben size hangi dosyaların kopyalanacağını söyleyeceğim)
```

**Avantajları:**
- Temiz, çalışan bir Laravel kurulumu
- Tüm bağımlılıklar doğru yüklenir
- En güvenilir yöntem

---

### ✅ Seçenek 2: Mevcut Kurulumla Devam

Eğer dizinde zaten çalışan bir Laravel kurulumu varsa:

```bash
cd c:\Repo2026\Web\DT_Hesap

# Veritabanını oluştur
php artisan migrate

# Frontend bağımlılıklarını yükle
npm install
npm run dev

# Sunucuyu başlat
php artisan serve
```

---

### ✅ Seçenek 3: Laravel Sail (Docker)

```bash
cd c:\Repo2026\Web\DT_Hesap

# Sail'i yükle
composer require laravel/sail --dev

# Sail'i yapılandır
php artisan sail:install

# Docker container'ları başlat
./vendor/bin/sail up -d

# Migration'ları çalıştır
./vendor/bin/sail artisan migrate
```

---

## Hangi Dosyalar Oluşturuldu?

### ✅ Tamamlanan (52 dosya):
- Database: 18 migration + 13 model
- Controllers: DashboardController, FirmaController
- Views: Dashboard, Firma (index, create, edit)
- Layout: app.blade.php, sidebar, firma-selector
- Config: routes, middleware, observers
- Assets: Tailwind CSS, Alpine.js, custom CSS

### ⏳ Eksik (Opsiyonel):
- Kalan 7 modül için controller + views (Cari, Stok, Fatura, vb.)
- Bu modüller için Firma modülü pattern olarak kullanılabilir

---

## Önerilen Aksiyon

**En hızlı çözüm:**

1. Yeni bir dizinde temiz Laravel kur:
```bash
composer create-project laravel/laravel c:\Repo2026\Web\DT_Hesap_Clean
```

2. Bana "temiz kurulum tamamlandı" deyin

3. Ben oluşturduğum tüm dosyaları yeni projeye kopyalayacağım

4. Siz sadece şunları çalıştırın:
```bash
npm install
npm run dev
php artisan migrate
php artisan serve
```

---

## Alternatif: Sadece Veritabanı Kurulumu

Eğer frontend'e ihtiyacınız yoksa, sadece veritabanını kurmak için:

```bash
# .env dosyasını düzenle (veritabanı bilgileri)
# Sonra:
php artisan migrate
```

Bu size çalışan bir veritabanı yapısı verecektir.
