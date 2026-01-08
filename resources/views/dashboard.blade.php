@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header with Welcome Message -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Hoş Geldiniz, {{ auth()->user()->name }}</h1>
            <p class="text-sm text-gray-500">{{ current_firma()->unvan ?? '' }} için genel özet.</p>
        </div>
        <div class="flex items-center space-x-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                <span class="w-2 h-2 mr-2 bg-indigo-500 rounded-full animate-pulse"></span>
                Sistem Aktif
            </span>
            <div class="text-sm text-gray-500">
                {{ now()->translatedFormat('d F Y, l') }}
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('faturas.create', ['tip' => 'satis']) }}" class="group p-4 bg-white border border-gray-200 rounded-2xl hover:border-indigo-500 hover:shadow-md transition-all">
            <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center mb-3 group-hover:bg-indigo-500 transition-colors">
                <svg class="w-6 h-6 text-indigo-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <span class="block text-sm font-semibold text-gray-900">Satış Faturası</span>
            <span class="text-xs text-gray-500">Yeni fatura oluştur</span>
        </a>
        <a href="{{ route('caris.create') }}" class="group p-4 bg-white border border-gray-200 rounded-2xl hover:border-green-500 hover:shadow-md transition-all">
            <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mb-3 group-hover:bg-green-500 transition-colors">
                <svg class="w-6 h-6 text-green-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <span class="block text-sm font-semibold text-gray-900">Müşteri/Cari</span>
            <span class="text-xs text-gray-500">Yeni cari kart ekle</span>
        </a>
        <a href="{{ route('kasas.index') }}" class="group p-4 bg-white border border-gray-200 rounded-2xl hover:border-blue-500 hover:shadow-md transition-all">
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center mb-3 group-hover:bg-blue-500 transition-colors">
                <svg class="w-6 h-6 text-blue-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <span class="block text-sm font-semibold text-gray-900">Tahsilat/Ödeme</span>
            <span class="text-xs text-gray-500">Kasa-banka girişi</span>
        </a>
        <a href="{{ route('stoks.index') }}" class="group p-4 bg-white border border-gray-200 rounded-2xl hover:border-purple-500 hover:shadow-md transition-all">
            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mb-3 group-hover:bg-purple-500 transition-colors">
                <svg class="w-6 h-6 text-purple-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <span class="block text-sm font-semibold text-gray-900">Stok Kontrol</span>
            <span class="text-xs text-gray-500">Ürün mevcudu sorgula</span>
        </a>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Net Likidite -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">Vadesiz Nakit</span>
            </div>
            <h3 class="text-sm font-medium text-gray-500">Toplam Nakit</h3>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($netLikidite, 2, ',', '.') }} ₺</p>
        </div>

        <!-- Alacaklar -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded">Devreden</span>
            </div>
            <h3 class="text-sm font-medium text-gray-500">Toplam Alacak</h3>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($toplamAlacak, 2, ',', '.') }} ₺</p>
        </div>

        <!-- Borçlar -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-rose-600 bg-rose-50 px-2 py-1 rounded">Ödemeler</span>
            </div>
            <h3 class="text-sm font-medium text-gray-500">Toplam Borç</h3>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($toplamBorc, 2, ',', '.') }} ₺</p>
        </div>

        <!-- Aylık Kar/Ciro -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2 py-1 rounded">Bu Ay</span>
            </div>
            <h3 class="text-sm font-medium text-gray-500">Aylık Satış</h3>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($buAySatis, 2, ',', '.') }} ₺</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Chart Section -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Performans Analizi (Son 6 Ay)</h3>
            <div class="h-80">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>

        <!-- Latest Transactions -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-gray-900">Son Para Hareketleri</h3>
                <a href="{{ route('kasas.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Tümü</a>
            </div>
            <div class="space-y-4">
                @forelse($sonHareketler as $hareket)
                <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $hareket['islem_tip'] == 'giris' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' }}">
                        @if($hareket['islem_tip'] == 'giris')
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $hareket['tur'] }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $hareket['aciklama'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold {{ $hareket['islem_tip'] == 'giris' ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format($hareket['tutar'], 2, ',', '.') }} ₺
                        </p>
                        <p class="text-[10px] text-gray-400">{{ $hareket['tarih']->format('d.m.Y') }}</p>
                    </div>
                </div>
                @empty
                    <p class="text-sm text-gray-500 text-center py-4">Henüz hareket bulunmuyor.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Bottom Lists Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Latest Invoices -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Son Faturalar</h3>
                <a href="{{ route('faturas.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Tümü</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Fatura No</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Cari</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase text-right">Tutar</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase">Durum</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($sonFaturalar as $fatura)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $fatura->fatura_no }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 truncate max-w-[150px]">{{ $fatura->cari->unvan }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900 text-right">{{ number_format($fatura->genel_toplam, 2, ',', '.') }} ₺</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-[10px] font-bold rounded-full {{ $fatura->odeme_durum == 'tamamlandi' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ strtoupper($fatura->odeme_durum) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-sm text-gray-500 text-center">Fatura bulunamadı.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Alerts -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Kritik Stok Uyarıları</h3>
                <a href="{{ route('stoks.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">Tümü</a>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($kritikStoklar as $stok)
                    <div class="flex items-center justify-between p-3 bg-rose-50 rounded-xl border border-rose-100">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-rose-600 shadow-sm font-bold">
                                {{ $stok->birim }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $stok->ad }}</p>
                                <p class="text-xs text-rose-600 font-medium">Kritik Seviye: {{ $stok->min_stok }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-black text-rose-700">{{ $stok->guncel_stok }}</p>
                            <p class="text-[10px] text-rose-500 uppercase font-bold text-nowrap">Mevcut Miktar</p>
                        </div>
                    </div>
                    @empty
                        <div class="text-center py-10">
                            <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <p class="text-sm text-gray-500 font-medium">Tüm stoklar güvenli seviyede.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('performanceChart').getContext('2d');
        const data = @json($grafikVerileri);
        
        const labels = data.map(item => item.ay);
        const satisData = data.map(item => item.satis);
        const alisData = data.map(item => item.alis);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Satışlar',
                        data: satisData,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#6366f1',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    },
                    {
                        label: 'Alımlar',
                        data: alisData,
                        borderColor: '#f43f5e',
                        backgroundColor: 'rgba(244, 63, 94, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#f43f5e',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            font: { size: 12, weight: '600' }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5] },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('tr-TR') + ' ₺';
                            }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection