# Frontend & Backend Implementation Plan

Complete implementation plan for building a modern, production-ready Laravel application with Tailwind CSS for the multi-tenant pre-accounting system.

## User Review Required

> [!IMPORTANT]
> **Technology Stack**
> - Backend: Laravel 11 with Eloquent ORM
> - Frontend: Blade templates + Tailwind CSS + Alpine.js
> - Authentication: Laravel Breeze (lightweight, Tailwind-based)
> - Icons: Heroicons
> - Charts: Chart.js for dashboard analytics

> [!NOTE]
> **Implementation Approach**
> - Start with authentication and base layout
> - Build dashboard with key metrics
> - Implement CRUD for each module progressively
> - Use consistent UI patterns across all modules
> - Mobile-responsive design throughout

## Proposed Changes

### Phase 1: Foundation & Authentication

#### [NEW] Install Laravel Breeze
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run dev
```

#### [MODIFY] Authentication Configuration
- Update User model (already done)
- Configure middleware in `bootstrap/app.php`
- Add SetCurrentFirma middleware to web routes

---

### Phase 2: Base Layout & Navigation

#### [NEW] [app.blade.php](file:///c:/Repo2026/Web/DT_Hesap/resources/views/layouts/app.blade.php)
Main application layout with:
- Responsive sidebar navigation
- Top header with firma selector and user menu
- Breadcrumbs
- Flash messages
- Mobile menu toggle

#### [NEW] [sidebar.blade.php](file:///c:/Repo2026/Web/DT_Hesap/resources/views/components/sidebar.blade.php)
Sidebar component with navigation items:
- Dashboard
- Cari Yönetimi
- Stok Yönetimi
- Fatura İşlemleri
- Kasa İşlemleri
- Banka İşlemleri
- Çek/Senet
- Sipariş Yönetimi
- Firma Ayarları

#### [NEW] [firma-selector.blade.php](file:///c:/Repo2026/Web/DT_Hesap/resources/views/components/firma-selector.blade.php)
Dropdown component for switching between companies

---

### Phase 3: Dashboard

#### [NEW] [DashboardController.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Controllers/DashboardController.php)
Dashboard controller with methods:
- `index()` - Display dashboard with key metrics
- Aggregate data: total sales, purchases, cash balance, bank balance
- Recent transactions
- Pending invoices
- Low stock alerts

#### [NEW] [dashboard.blade.php](file:///c:/Repo2026/Web/DT_Hesap/resources/views/dashboard.blade.php)
Dashboard view with:
- Summary cards (sales, purchases, profit, outstanding)
- Charts (monthly revenue, expense breakdown)
- Recent activity feed
- Quick actions

---

### Phase 4: Firma Management

#### [NEW] [FirmaController.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Controllers/FirmaController.php)
Resource controller with methods:
- `index()` - List all companies user has access to
- `create()` - Show create form
- `store()` - Save new company
- `edit()` - Show edit form
- `update()` - Update company
- `destroy()` - Soft delete company
- `switch()` - Switch current firma context

#### [NEW] Views for Firma
- `resources/views/firma/index.blade.php` - List view with table
- `resources/views/firma/create.blade.php` - Create form
- `resources/views/firma/edit.blade.php` - Edit form

#### [NEW] [StoreFirmaRequest.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Requests/StoreFirmaRequest.php)
Form validation for creating firma

#### [NEW] [UpdateFirmaRequest.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Requests/UpdateFirmaRequest.php)
Form validation for updating firma

---

### Phase 5: Cari Management

#### [NEW] [CariController.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Controllers/CariController.php)
Resource controller with methods:
- `index()` - List all cari for current firma
- `create()` - Show create form
- `store()` - Save new cari and attach to firma
- `show()` - Show cari details with balance and transactions
- `edit()` - Show edit form
- `update()` - Update cari
- `destroy()` - Soft delete cari
- `transactions()` - Get all transactions for cari

#### [NEW] Views for Cari
- `resources/views/cari/index.blade.php` - List with search/filter
- `resources/views/cari/create.blade.php` - Create form
- `resources/views/cari/show.blade.php` - Detail view with tabs (info, transactions, balance)
- `resources/views/cari/edit.blade.php` - Edit form

#### [NEW] Form Requests
- `StoreCariRequest.php`
- `UpdateCariRequest.php`

---

### Phase 6: Stok Management

#### [NEW] [StokController.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Controllers/StokController.php)
Resource controller with methods:
- `index()` - List all inventory items
- `create()` - Show create form
- `store()` - Save new item
- `show()` - Show item details with stock movements
- `edit()` - Show edit form
- `update()` - Update item
- `destroy()` - Soft delete item
- `lowStock()` - Get items below critical stock level

#### [NEW] [StokHareketController.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Controllers/StokHareketController.php)
Controller for stock movements:
- `index()` - List movements
- `create()` - Manual stock adjustment form
- `store()` - Record movement

#### [NEW] Views for Stok
- `resources/views/stok/index.blade.php` - List with stock levels
- `resources/views/stok/create.blade.php` - Create form
- `resources/views/stok/show.blade.php` - Detail with movement history
- `resources/views/stok/edit.blade.php` - Edit form
- `resources/views/stok/hareketler.blade.php` - Stock movements list

---

### Phase 7: Fatura Management

#### [NEW] [FaturaController.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Controllers/FaturaController.php)
Resource controller with methods:
- `index()` - List invoices with filters (type, status, date range)
- `create()` - Show create form with line items
- `store()` - Save invoice with line items and update stock
- `show()` - Show invoice details (printable)
- `edit()` - Show edit form
- `update()` - Update invoice
- `destroy()` - Soft delete invoice
- `approve()` - Change status to approved
- `print()` - Generate PDF

#### [NEW] Views for Fatura
- `resources/views/fatura/index.blade.php` - List with tabs (all, sales, purchase)
- `resources/views/fatura/create.blade.php` - Create form with dynamic line items
- `resources/views/fatura/show.blade.php` - Detail view (printable)
- `resources/views/fatura/edit.blade.php` - Edit form
- `resources/views/fatura/print.blade.php` - Print template

#### [NEW] Form Requests
- `StoreFaturaRequest.php` - Validates invoice and line items
- `UpdateFaturaRequest.php`

---

### Phase 8: Kasa Management

#### [NEW] [KasaController.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Controllers/KasaController.php)
Resource controller for cash registers

#### [NEW] [KasaHareketController.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Controllers/KasaHareketController.php)
Controller for cash movements:
- `index()` - List movements with filters
- `create()` - Create movement form
- `store()` - Record movement and update balance

#### [NEW] Views for Kasa
- `resources/views/kasa/index.blade.php` - List cash registers
- `resources/views/kasa/create.blade.php` - Create register
- `resources/views/kasa/show.blade.php` - Register details with movements
- `resources/views/kasa/hareketler/create.blade.php` - Movement form

---

### Phase 9: Banka Management

#### [NEW] [BankaController.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Controllers/BankaController.php)
Resource controller for bank accounts

#### [NEW] [BankaHareketController.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Controllers/BankaHareketController.php)
Controller for bank movements

#### [NEW] Views for Banka
- `resources/views/banka/index.blade.php` - List bank accounts
- `resources/views/banka/create.blade.php` - Create account
- `resources/views/banka/show.blade.php` - Account details with movements
- `resources/views/banka/hareketler/create.blade.php` - Movement form

---

### Phase 10: Çek/Senet Management

#### [NEW] [CekSenetController.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Controllers/CekSenetController.php)
Resource controller with methods:
- `index()` - List with filters (type, portfolio type, status)
- `create()` - Create form
- `store()` - Save check/note
- `show()` - Detail view
- `edit()` - Edit form
- `update()` - Update
- `updateStatus()` - Change status (to bank, collected, etc.)

#### [NEW] Views for Çek/Senet
- `resources/views/cek-senet/index.blade.php` - List with tabs
- `resources/views/cek-senet/create.blade.php` - Create form
- `resources/views/cek-senet/show.blade.php` - Detail view
- `resources/views/cek-senet/edit.blade.php` - Edit form

---

### Phase 11: Sipariş Management

#### [NEW] [SiparisController.php](file:///c:/Repo2026/Web/DT_Hesap/app/Http/Controllers/SiparisController.php)
Resource controller with methods:
- `index()` - List orders
- `create()` - Create form with line items
- `store()` - Save order
- `show()` - Detail view
- `edit()` - Edit form
- `update()` - Update order
- `convertToInvoice()` - Convert order to invoice

#### [NEW] Views for Sipariş
- `resources/views/siparis/index.blade.php` - List with status filters
- `resources/views/siparis/create.blade.php` - Create form
- `resources/views/siparis/show.blade.php` - Detail view
- `resources/views/siparis/edit.blade.php` - Edit form

---

### Phase 12: Shared Components

#### [NEW] Blade Components
- `resources/views/components/table.blade.php` - Reusable table component
- `resources/views/components/card.blade.php` - Card component
- `resources/views/components/stat-card.blade.php` - Dashboard stat card
- `resources/views/components/form/input.blade.php` - Form input
- `resources/views/components/form/select.blade.php` - Form select
- `resources/views/components/form/textarea.blade.php` - Form textarea
- `resources/views/components/badge.blade.php` - Status badge
- `resources/views/components/button.blade.php` - Button component
- `resources/views/components/alert.blade.php` - Alert/flash message

---

### Phase 13: Routes Configuration

#### [MODIFY] [web.php](file:///c:/Repo2026/Web/DT_Hesap/routes/web.php)
Define all routes with proper middleware:

```php
Route::middleware(['auth', SetCurrentFirma::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Firma routes
    Route::resource('firma', FirmaController::class);
    Route::post('/firma/switch/{firma}', [FirmaController::class, 'switch'])->name('firma.switch');
    
    // Cari routes
    Route::resource('cari', CariController::class);
    Route::get('/cari/{cari}/transactions', [CariController::class, 'transactions'])->name('cari.transactions');
    
    // Stok routes
    Route::resource('stok', StokController::class);
    Route::get('/stok/low-stock', [StokController::class, 'lowStock'])->name('stok.low-stock');
    Route::resource('stok.hareketler', StokHareketController::class)->shallow();
    
    // Fatura routes
    Route::resource('fatura', FaturaController::class);
    Route::post('/fatura/{fatura}/approve', [FaturaController::class, 'approve'])->name('fatura.approve');
    Route::get('/fatura/{fatura}/print', [FaturaController::class, 'print'])->name('fatura.print');
    
    // Kasa routes
    Route::resource('kasa', KasaController::class);
    Route::resource('kasa.hareketler', KasaHareketController::class)->shallow();
    
    // Banka routes
    Route::resource('banka', BankaController::class);
    Route::resource('banka.hareketler', BankaHareketController::class)->shallow();
    
    // Çek/Senet routes
    Route::resource('cek-senet', CekSenetController::class);
    Route::patch('/cek-senet/{cekSenet}/status', [CekSenetController::class, 'updateStatus'])->name('cek-senet.update-status');
    
    // Sipariş routes
    Route::resource('siparis', SiparisController::class);
    Route::post('/siparis/{siparis}/convert', [SiparisController::class, 'convertToInvoice'])->name('siparis.convert');
});
```

---

### Phase 14: Tailwind CSS Configuration

#### [MODIFY] [tailwind.config.js](file:///c:/Repo2026/Web/DT_Hesap/tailwind.config.js)
Custom configuration:
- Custom color palette for accounting theme
- Custom spacing for forms
- Typography plugin for content

#### [NEW] [app.css](file:///c:/Repo2026/Web/DT_Hesap/resources/css/app.css)
Custom CSS:
- Base styles
- Component styles
- Utility classes
- Print styles for invoices

---

### Phase 15: JavaScript Interactivity

#### [NEW] [app.js](file:///c:/Repo2026/Web/DT_Hesap/resources/js/app.js)
Alpine.js components:
- Dynamic invoice line items
- Auto-calculation (subtotal, tax, total)
- Search and filter functionality
- Modal dialogs
- Toast notifications

#### [NEW] JavaScript Modules
- `resources/js/invoice-calculator.js` - Invoice calculations
- `resources/js/stock-selector.js` - Stock item selector with autocomplete
- `resources/js/cari-selector.js` - Cari selector with autocomplete
- `resources/js/datepicker.js` - Date picker integration

---

## UI/UX Design Patterns

### Color Scheme
- Primary: Indigo (professional, trustworthy)
- Success: Green (positive actions, profit)
- Danger: Red (warnings, losses)
- Warning: Amber (pending items)
- Info: Blue (informational)

### Typography
- Headings: Inter font family
- Body: Inter font family
- Monospace: For numbers and codes

### Layout
- Sidebar: 256px width on desktop, collapsible on mobile
- Content area: Max width 1400px, centered
- Cards: White background, subtle shadow, rounded corners
- Tables: Striped rows, hover effects, sticky header

### Forms
- Consistent spacing (mb-4 between fields)
- Labels above inputs
- Validation errors below inputs in red
- Required fields marked with asterisk
- Submit buttons right-aligned

### Tables
- Responsive (horizontal scroll on mobile)
- Sortable columns
- Pagination
- Row actions (edit, delete) in last column
- Status badges for enum fields

---

## Verification Plan

### Functional Testing
- Test all CRUD operations for each module
- Verify multi-tenant isolation (users can only see their firma's data)
- Test firma switching functionality
- Verify calculations (invoice totals, balances)
- Test stock movements update inventory correctly

### UI/UX Testing
- Test responsive design on mobile, tablet, desktop
- Verify all forms validate correctly
- Test navigation and breadcrumbs
- Verify flash messages display correctly
- Test print layouts for invoices

### Performance Testing
- Test with large datasets (1000+ records)
- Verify pagination works correctly
- Test search and filter performance
- Verify eager loading prevents N+1 queries

---

## Implementation Order

1. ✅ Install Laravel Breeze
2. ✅ Configure middleware
3. ✅ Create base layout and navigation
4. ✅ Build dashboard
5. ✅ Implement Firma management
6. ✅ Implement Cari management
7. ✅ Implement Stok management
8. ✅ Implement Fatura management
9. ✅ Implement Kasa management
10. ✅ Implement Banka management
11. ✅ Implement Çek/Senet management
12. ✅ Implement Sipariş management
13. ✅ Add JavaScript interactivity
14. ✅ Polish UI/UX
15. ✅ Testing and bug fixes

---

## Files to Create

### Controllers (11 files)
- DashboardController.php
- FirmaController.php
- CariController.php
- StokController.php
- StokHareketController.php
- FaturaController.php
- KasaController.php
- KasaHareketController.php
- BankaController.php
- BankaHareketController.php
- CekSenetController.php
- SiparisController.php

### Form Requests (12 files)
- StoreFirmaRequest.php, UpdateFirmaRequest.php
- StoreCariRequest.php, UpdateCariRequest.php
- StoreStokRequest.php, UpdateStokRequest.php
- StoreFaturaRequest.php, UpdateFaturaRequest.php
- StoreKasaRequest.php, UpdateKasaRequest.php
- StoreBankaRequest.php, UpdateBankaRequest.php
- StoreCekSenetRequest.php, UpdateCekSenetRequest.php
- StoreSiparisRequest.php, UpdateSiparisRequest.php

### Views (40+ files)
- Layouts: app.blade.php, guest.blade.php
- Components: 10+ reusable components
- Dashboard: 1 file
- Each module: 3-5 views (index, create, edit, show)

### JavaScript (5 files)
- app.js
- invoice-calculator.js
- stock-selector.js
- cari-selector.js
- datepicker.js

**Total: ~80 files to create**
