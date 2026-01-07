@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Kasa Detayı: {{ $kasa->ad }}</h2>
            <div class="space-x-2">
                <a href="{{ route('kasas.edit', $kasa) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">Düzenle</a>
                <a href="{{ route('kasas.index') }}" class="text-gray-600 hover:text-gray-900 border border-gray-300 px-4 py-2 rounded-md text-sm font-medium">Geri Dön</a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Info Card -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Genel Bilgiler</h3>
                <dl class="space-y-3">
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500">Kodu:</dt>
                        <dd class="text-sm text-gray-900">{{ $kasa->kod }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500">Döviz Tipi:</dt>
                        <dd class="text-sm text-gray-900">{{ $kasa->doviz_tip }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500">Durum:</dt>
                        <dd class="text-sm text-gray-900">
                            {{ $kasa->is_active ? 'Aktif' : 'Pasif' }}
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Balance Card -->
            <div class="bg-white shadow rounded-lg p-6 md:col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Grup/Bakiye Özeti</h3>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Güncel Bakiye</p>
                        <p class="text-3xl font-bold text-gray-900">
                            {{ number_format($kasa->bakiye, 2, ',', '.') }} {{ $kasa->doviz_tip }}
                        </p>
                    </div>
                </div>
                @if($kasa->aciklama)
                <div class="mt-4 pt-4 border-t">
                    <p class="text-sm font-medium text-gray-500">Açıklama</p>
                    <p class="text-sm text-gray-900 mt-1">{{ $kasa->aciklama }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Movements Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Son Hareketler</h3>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarih</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Açıklama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giriş</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Çıkış</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bakiye</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kasa->hareketler as $hareket)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $hareket->tarih->format('d.m.Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $hareket->aciklama }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">
                                {{ $hareket->islem_tip == 'giris' ? number_format($hareket->tutar, 2, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-medium">
                                {{ $hareket->islem_tip == 'cikis' ? number_format($hareket->tutar, 2, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                {{ number_format($hareket->bakiye, 2, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Henüz hareket bulunmuyor</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
