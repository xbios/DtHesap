@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900">Cariler</h2>
        <a href="{{ route('caris.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
            + Yeni Cari
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow">
        <form method="GET" action="{{ route('caris.index') }}" class="flex gap-4">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ara..." 
                   class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <select name="tip" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Tüm Tipler</option>
                <option value="musteri" {{ request('tip') == 'musteri' ? 'selected' : '' }}>Müşteri</option>
                <option value="tedarikci" {{ request('tip') == 'tedarikci' ? 'selected' : '' }}>Tedarikçi</option>
                <option value="her_ikisi" {{ request('tip') == 'her_ikisi' ? 'selected' : '' }}>Her İkisi</option>
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kod</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ünvan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tip</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bakiye</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($cariler as $cari)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $cari->kod }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cari->unvan }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @php
                            $tipClass = match($cari->tip) {
                                'musteri' => 'bg-blue-100 text-blue-800',
                                'tedarikci' => 'bg-green-100 text-green-800',
                                'her_ikisi' => 'bg-purple-100 text-purple-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                            $tipText = match($cari->tip) {
                                'musteri' => 'Müşteri',
                                'tedarikci' => 'Tedarikçi',
                                'her_ikisi' => 'Her İkisi',
                                default => $cari->tip
                            };
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs {{ $tipClass }}">{{ $tipText }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $cari->telefon ?: '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm {{ $cari->bakiye >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($cari->bakiye, 2, ',', '.') }} ₺
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                        <a href="{{ route('caris.show', $cari) }}" class="text-indigo-600 hover:text-indigo-900">Görüntüle</a>
                        <a href="{{ route('caris.edit', $cari) }}" class="text-blue-600 hover:text-blue-900">Düzenle</a>
                        <form action="{{ route('caris.destroy', $cari) }}" method="POST" class="inline" 
                              onsubmit="return confirm('{{ $cari->unvan }} carisini silmek istediğinize emin misiniz?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Sil</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Kayıt bulunamadı</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
        {{ $cariler->links() }}
    </div>
</div>
@endsection
