@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Stok Kartları</h2>
            <a href="{{ route('stoks.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                + Yeni Stok
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow">
            <form method="GET" action="{{ route('stoks.index') }}" class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Kod, Ad veya Barkod ile Ara..."
                    class="flex-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <select name="kategori_id"
                    class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Tüm Kategoriler</option>
                    @foreach($kategoriler as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->ad }}
                        </option>
                    @endforeach
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Birim
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Guncel
                            Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($stoklar as $stok)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $stok->kod }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $stok->ad }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $stok->kategori?->ad ?: '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stok->birim }}</td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm {{ $stok->guncel_stok <= $stok->min_stok ? 'text-red-600 font-bold' : 'text-gray-900' }}">
                                {{ number_format($stok->guncel_stok, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('stoks.show', $stok) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Detay</a>
                                <a href="{{ route('stoks.edit', $stok) }}" class="text-blue-600 hover:text-blue-900">Düzenle</a>
                                <form action="{{ route('stoks.destroy', $stok) }}" method="POST" class="inline"
                                    onsubmit="return confirm('{{ $stok->ad }} stokunu silmek istediğinize emin misiniz?')">
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
            {{ $stoklar->links() }}
        </div>
    </div>
@endsection