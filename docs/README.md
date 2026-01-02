# DtHesap - Proje Dokümantasyonu

Bu dizin, DtHesap (Multi-Tenant ERP) projesinin geliştirme sürecinde oluşturulan tüm planlama, görev takibi ve tamamlanan işlerin dokümantasyonunu içerir.

## 📁 Dizin Yapısı

### 🗄️ Database Design
Veritabanı tasarımı ve implementasyonu ile ilgili dokümantasyon.

- [task.md](database-design/task.md) - Veritabanı tasarımı görev listesi ve ilerleme durumu
- [implementation_plan.md](database-design/implementation_plan.md) - Veritabanı implementasyon planı
- [walkthrough.md](database-design/walkthrough.md) - Tamamlanan veritabanı işlerinin özeti

### 🎨 Frontend
Frontend geliştirme ile ilgili dokümantasyon.

- [task.md](frontend/task.md) - Frontend görev listesi ve ilerleme durumu
- [implementation_plan.md](frontend/implementation_plan.md) - Backend implementasyon planı
- [frontend_implementation_plan.md](frontend/frontend_implementation_plan.md) - Frontend implementasyon planı
- [walkthrough.md](frontend/walkthrough.md) - Tamamlanan frontend işlerinin özeti
- [completion_summary.md](frontend/completion_summary.md) - Genel tamamlanma özeti

### ⚙️ Setup
Kurulum ve yapılandırma kılavuzları.

- [setup_guide.md](setup/setup_guide.md) - Proje kurulum kılavuzu
- [final_setup.md](setup/final_setup.md) - Son kurulum adımları
- [quick_fix.md](setup/quick_fix.md) - Hızlı düzeltmeler ve çözümler

## 📊 Proje Genel Bakış

**DtHesap**, Laravel tabanlı, çok kiracılı (multi-tenant) bir ön muhasebe/ERP-lite sistemidir. Proje şu ana modülleri içerir:

- 👥 Firma Yönetimi
- 🔐 Kullanıcı Yönetimi
- 📇 Cari Hesap Yönetimi
- 📦 Stok Yönetimi
- 🧾 Fatura Yönetimi
- 💰 Kasa Yönetimi
- 🏦 Banka Yönetimi
- 📝 Çek/Senet Yönetimi
- 🛒 Sipariş Yönetimi

## 🚀 Geliştirme Süreci

1. **Veritabanı Tasarımı** - Tüm modüller için kapsamlı veritabanı şeması tasarımı
2. **Backend Implementasyonu** - Laravel migrations, models, relationships, scopes ve observers
3. **Frontend Geliştirme** - Tailwind CSS ile modern, responsive kullanıcı arayüzü
4. **Test ve Doğrulama** - Tüm özelliklerin test edilmesi ve doğrulanması

## 📝 Notlar

- Tüm transaksiyonel tablolar `firma_id` içerir (multi-tenancy)
- Soft deletes tüm tablolarda aktif
- Foreign key constraints ve indexler tanımlanmış
- Eloquent relationships tam olarak yapılandırılmış
- Global scopes ile multi-tenant izolasyon sağlanmış

---

**Son Güncelleme:** 2026-01-03
