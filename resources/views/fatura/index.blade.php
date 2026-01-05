@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">Faturalar</h2>
        <a href="{{ route('faturas.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            + Yeni Fatura
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow">
        <form method="GET" action="{{ route('faturas.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Fatura No veya Cari..." 
                   class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            
            <select name="fatura_tip" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Tüm Tipler</option>
                <option value="alis" {{ request('fatura_tip') == 'alis' ? 'selected' : '' }}>Alış</option>
                <option value="satis" {{ request('fatura_tip') == 'satis' ? 'selected' : '' }}>Satış</option>
            </select>

            <select name="odeme_durum" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Tüm Durumlar</option>
                <option value="beklemede" {{ request('odeme_durum') == 'beklemede' ? 'selected' : '' }}>Beklemede</option>
                <option value="kismi" {{ request('odeme_durum') == 'kismi' ? 'selected' : '' }}>Kısmi Ödendi</option>
                <option value="tamamlandi" {{ request('odeme_durum') == 'tamamlandi' ? 'selected' : '' }}>Tamamlandı</option>
            </select>

            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm">
                Filtrele
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarih</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fatura No</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cari</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tip</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Toplam</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($faturalar as $fatura)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $fatura->tarih->format('d.m.Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $fatura->fatura_no }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $fatura->cari->unvan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $fatura->fatura_tip == 'alis' ? 'Alış' : 'Satış' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                        {{ number_format($fatura->genel_toplam, 2, ',', '.') }} {{ $fatura->doviz_tip }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @php
                            $statusClass = match($fatura->odeme_durum) {
                                'beklemede' => 'bg-yellow-100 text-yellow-800',
                                'kismi' => 'bg-blue-100 text-blue-800',
                                'tamamlandi' => 'bg-green-100 text-green-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                            $statusText = match($fatura->odeme_durum) {
                                'beklemede' => 'Beklemede',
                                'kismi' => 'Kısmi',
                                'tamamlandi' => 'Tamamlandı',
                                default => $fatura->odeme_durum
                            };
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs {{ $statusClass }}">{{ $statusText }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('faturas.show', $fatura) }}" class="text-indigo-600 hover:text-indigo-900">Görüntüle</a>
                        <form action="{{ route('faturas.destroy', $fatura) }}" method="POST" class="inline" 
                              onsubmit="return confirm('Faturayı silmek istediğinize emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Sil</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">Kayıt bulunamadı</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $faturalar->links() }}
    </div>
</div>
@endsection
