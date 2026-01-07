@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Kasa Hesapları</h2>
            <a href="{{ route('kasas.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                + Yeni Kasa
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow">
            <form method="GET" action="{{ route('kasas.index') }}" class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Kod veya Ad ile Ara..."
                    class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Döviz
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bakiye
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durum
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kasalar as $kasa)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $kasa->kod }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $kasa->ad }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $kasa->doviz_tip }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                {{ number_format($kasa->bakiye, 2, ',', '.') }} {{ $kasa->doviz_tip }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $kasa->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $kasa->is_active ? 'Aktif' : 'Pasif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('kasas.show', $kasa) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Detay</a>
                                <a href="{{ route('kasas.edit', $kasa) }}" class="text-blue-600 hover:text-blue-900">Düzenle</a>
                                <form action="{{ route('kasas.destroy', $kasa) }}" method="POST" class="inline"
                                    onsubmit="return confirm('{{ $kasa->ad }} kasasını silmek istediğinize emin misiniz?')">
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
            {{ $kasalar->links() }}
        </div>
    </div>
@endsection