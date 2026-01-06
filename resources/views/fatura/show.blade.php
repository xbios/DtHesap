@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Actions -->
    <div class="flex items-center justify-between no-print">
        <h2 class="text-2xl font-bold text-gray-900">Fatura Detayı</h2>
        <div class="flex space-x-3">
            <button onclick="window.print()" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-50">
                <svg class="h-4 w-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Yazdır
            </button>
            <a href="{{ route('faturas.edit', $fatura) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                Düzenle
            </a>
            <a href="{{ route('faturas.index') }}" class="text-sm text-gray-600 hover:text-gray-900 self-center">← Listeye Dön</a>
        </div>
    </div>

    <!-- Invoice Card -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden invoice-container">
        <!-- Professional Header -->
        <div class="bg-indigo-600 p-8 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-extrabold uppercase tracking-widest">FATURA</h1>
                    <p class="mt-2 text-indigo-100">{{ $fatura->fatura_tip == 'alis' ? 'Alış Faturası' : 'Satış Faturası' }}</p>
                </div>
                <div class="text-right">
                    <div class="text-xl font-bold">DtHesap ERP</div>
                    <div class="text-sm text-indigo-100 mt-1">
                        {{ $fatura->firma->unvan ?? 'DtHesap Yazılım A.Ş.' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8">
            <!-- Info Grid -->
            <div class="grid grid-cols-2 gap-12 border-b border-gray-100 pb-8">
                <!-- Customer/Supplier Info -->
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Müşteri / Cari Bilgileri</h3>
                    <div class="text-lg font-bold text-gray-900">{{ $fatura->cari->unvan }}</div>
                    <div class="text-sm text-gray-600 mt-1 space-y-1">
                        <p>{{ $fatura->cari->adres ?: 'Adres belirtilmemiş' }}</p>
                        <p><strong>Vergi Dairesi:</strong> {{ $fatura->cari->vergi_dairesi ?: '-' }}</p>
                        <p><strong>Vergi No / TC:</strong> {{ $fatura->cari->vergi_no ?: '-' }}</p>
                        <p><strong>Telefon:</strong> {{ $fatura->cari->telefon ?: '-' }}</p>
                    </div>
                </div>

                <!-- Invoice Meta -->
                <div class="text-right space-y-4">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Fatura No</span>
                        <span class="text-xl font-mono font-bold text-gray-900">{{ $fatura->fatura_no }}</span>
                    </div>
                    <div class="flex justify-end gap-8">
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Fatura Tarihi</span>
                            <p class="text-sm font-medium">{{ $fatura->tarih->format('d.m.Y') }}</p>
                        </div>
                        @if($fatura->vade_tarih)
                        <div>
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Vade Tarihi</span>
                            <p class="text-sm font-medium">{{ $fatura->vade_tarih->format('d.m.Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="mt-8">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Açıklama / Stok</th>
                            <th class="px-3 py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Miktar</th>
                            <th class="px-3 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Birim Fiyat</th>
                            <th class="px-3 py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">KDV %</th>
                            <th class="px-3 py-3 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Toplam</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($fatura->detaylar as $detay)
                        <tr>
                            <td class="px-3 py-4 text-sm font-medium text-gray-900">
                                {{ $detay->stok ? $detay->stok->ad : $detay->aciklama }}
                                @if($detay->stok)
                                    <span class="block text-xs text-gray-500 font-normal">{{ $detay->stok->kod }}</span>
                                @endif
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-600 text-center">
                                {{ number_format($detay->miktar, 2, ',', '.') }} {{ $detay->birim }}
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-600 text-right">
                                {{ number_format($detay->birim_fiyat, 2, ',', '.') }} {{ $fatura->doviz_tip }}
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-600 text-center">
                                %{{ (int) $detay->kdv_oran }}
                            </td>
                            <td class="px-3 py-4 text-sm font-bold text-gray-900 text-right">
                                {{ number_format($detay->miktar * $detay->birim_fiyat, 2, ',', '.') }} {{ $fatura->doviz_tip }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="mt-12 flex justify-end">
                <div class="w-64 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-medium">Ara Toplam:</span>
                        <span class="text-gray-900">{{ number_format($fatura->toplam_tutar, 2, ',', '.') }} {{ $fatura->doviz_tip }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 font-medium">KDV Toplam:</span>
                        <span class="text-gray-900">{{ number_format($fatura->kdv_tutar, 2, ',', '.') }} {{ $fatura->doviz_tip }}</span>
                    </div>
                    @if($fatura->indirim_tutar > 0)
                    <div class="flex justify-between text-sm text-red-600 font-medium">
                        <span>İndirim:</span>
                        <span>-{{ number_format($fatura->indirim_tutar, 2, ',', '.') }} {{ $fatura->doviz_tip }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center border-t border-gray-200 pt-3">
                        <span class="text-base font-extrabold text-gray-900">GENEL TOPLAM:</span>
                        <span class="text-xl font-extrabold text-indigo-600">{{ number_format($fatura->genel_toplam, 2, ',', '.') }} {{ $fatura->doviz_tip }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Notes -->
            <div class="mt-16 border-t border-gray-100 pt-8 text-xs text-gray-400 italic">
                <p>Not: Bu belge DtHesap ERP sistemi tarafından elektronik olarak oluşturulmuştur.</p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
    body { background-color: white !important; }
    .max-w-4xl { max-width: 100% !important; margin: 0 !important; width: 100% !important; }
    .shadow-lg { shadow: none !important; border: none !important; }
    .invoice-container { margin: 0 !important; padding: 0 !important; }
}
</style>
@endsection
