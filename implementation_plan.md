# Uygulama Planı - DtHesap (ERP Sistemi)

Bu belge, DtHesap adlı çoklu kiracılı (multi-tenant) ön muhasebe/ERP sisteminin geliştirme aşamalarını ve mimari kararlarını özetlemektedir.

## 1. Mimarlık ve Teknoloji Yığını
- **Framework:** Laravel 11.x
- **Frontend:** Inertia.js (Vue.js veya React - tercihe bağlı olarak Tailwind CSS ile)
- **Veritabanı:** MySQL/PostgreSQL
- **Multi-tenancy:** `firma_id` bazlı kapsamlı (scoped) mimari kullanılarak her kullanıcının sadece kendi firmasına ait verilere erişmesi sağlanır.

## 2. Temel Modüller
### 2.1 Multi-tenancy ve Firma Yönetimi
- [x] Firma (Tenant) modelinin oluşturulması.
- [x] Çoklu firma desteği (FirmaUser ilişkisi).
- [x] Firma bazlı veri izolasyonu için Global Scope (BelongsToFirma Trait) ve Middleware.
- [x] Firma değiştirme (Switching) mekanizması.

### 2.2 Cari Yönetimi
- [x] Müşteri ve Tedarikçi (Cari) kartlarının yönetimi.
- [x] Cari bakiye ve hareket takibi.
- [ ] Cari grup ve kategori yönetimi.

### 2.3 Fatura ve Finans
- [x] Satış ve Alış faturaları mimarisinin kurulması.
- [x] Fatura kalemleri (Detay) yönetimi.
- [ ] Stok entegrasyonu (Fatura kesildiğinde stoktan düşme).
- [ ] Kasa ve Banka modülleri ile entegrasyon.

### 2.4 Stok ve Depo Yönetimi
- [x] Stok kartları ve kategorileri.
- [x] Stok hareketleri (Giriş/Çıkış).
- [ ] Depo bazlı stok takibi.

### 2.5 Kasa ve Banka
- [x] Kasa ve Banka tanımları.
- [x] Nakit ve Banka hareketleri.
- [x] Ödeme ve Tahsilat işlemleri.

## 3. Gelecek Planları
- [ ] Raporlama modülü (Kar-Zarar, Bakiye Listeleri).
- [ ] Kullanıcı Rol ve Yetki yönetimi (Spatie Permission entegrasyonu).
- [ ] E-Fatura/E-Arşiv entegrasyonu (API bazlı).
- [ ] Dashboard görselleştirme (Charts.js).

## 4. Geliştirme Standartları
- Tüm modeller `BelongsToFirma` trait'ini kullanmalıdır.
- API response'ları standartlaştırılmalıdır.
- Test-Driven Development (TDD) ile kritik iş akışları (fatura kesme, bakiye hesaplama) test edilmelidir.
