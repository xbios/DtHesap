@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <h2 class="text-2xl font-bold text-gray-900">{{ $stok->ad }}</h2>
                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-sm font-medium">{{ $stok->kod }}</span>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('stoks.edit', $stok) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium"> Düzenle </a>
                <a href="{{ route('stoks.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-md text-sm font-medium"> Listeye
                    Dön </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Bilgiler -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Stok Bilgileri</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-gray-500 text-sm block">Kategori</span>
                            <span class="font-medium">{{ $stok->kategori?->ad ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm block">Birim</span>
                            <span class="font-medium">{{ $stok->birim }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm block">Barkod</span>
                            <span class="font-medium">{{ $stok->barkod ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm block">KDV Oranı</span>
                            <span class="font-medium">%{{ number_format($stok->kdv_oran, 2) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm block">Alış Fiyatı</span>
                            <span class="font-medium">{{ number_format($stok->alis_fiyat, 2, ',', '.') }} ₺</span>
                        </div>
                        <div>
                            <span class="text-gray-500 text-sm block">Satış Fiyatı</span>
                            <span class="font-medium">{{ number_format($stok->satis_fiyat, 2, ',', '.') }} ₺</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t">
                        <span class="text-gray-500 text-sm block">Açıklama</span>
                        <p class="mt-1 text-gray-700">{{ $stok->aciklama ?: 'Açıklama bulunmuyor.' }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <h3 class="text-lg font-semibold p-6 bg-gray-50 border-b">Son Hareketler</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tarih</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">İşlem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-right">Giriş
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-right">Çıkış
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase text-right">
                                    Bakiye</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($stok->hareketler as $hareket)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $hareket->tarih->format('d.m.Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $hareket->aciklama }}</td>
                                    <td class="px-6 py-4 text-sm text-green-600 text-right">
                                        {{ $hareket->giris > 0 ? number_format($hareket->giris, 2, ',', '.') : '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-red-600 text-right">
                                        {{ $hareket->cikis > 0 ? number_format($hareket->cikis, 2, ',', '.') : '-' }}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-right">
                                        {{ number_format($hareket->bakiye, 2, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Henüz hareket bulunmuyor.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Stok Özeti (Sağ Sütun) -->
            <div class="space-y-6">
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <span class="text-gray-500 text-sm block mb-1">Güncel Stok</span>
                    <span
                        class="text-4xl font-bold {{ $stok->guncel_stok <= $stok->min_stok ? 'text-red-600' : 'text-indigo-600' }}">
                        {{ number_format($stok->guncel_stok, 2, ',', '.') }}
                    </span>
                    <span class="text-gray-500 ml-1">{{ $stok->birim }}</span>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold mb-4">Stok Limitleri</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Minimum:</span>
                            <span class="font-medium">{{ number_format($stok->min_stok, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Maksimum:</span>
                            <span class="font-medium">{{ number_format($stok->max_stok, 2, ',', '.') }}</span>
                        </div>
                        @if($stok->guncel_stok <= $stok->min_stok)
                            <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded text-red-700 text-xs">
                                ⚠️ Stok miktarı minimum seviyenin altında!
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection