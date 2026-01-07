@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Banka Hesapları</h2>
            <a href="{{ route('bankas.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                + Yeni Banka Hesabı
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow">
            <form method="GET" action="{{ route('bankas.index') }}" class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Banka Adı, Hesap No veya IBAN ile Ara..."
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kod /
                            Banka</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hesap No
                            / IBAN</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Döviz
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bakiye
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">İşlemler
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bankalar as $banka)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $banka->kod }}</div>
                                <div class="text-sm text-gray-500">{{ $banka->banka_adi }} - {{ $banka->sube_adi }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $banka->hesap_no }}</div>
                                <div class="text-sm text-gray-500">{{ $banka->iban }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $banka->doviz_tip }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                {{ number_format($banka->bakiye, 2, ',', '.') }} {{ $banka->doviz_tip }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('bankas.show', $banka) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Detay</a>
                                <a href="{{ route('bankas.edit', $banka) }}"
                                    class="text-blue-600 hover:text-blue-900">Düzenle</a>
                                <form action="{{ route('bankas.destroy', $banka) }}" method="POST" class="inline"
                                    onsubmit="return confirm('{{ $banka->banka_adi }} hesabını silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Sil</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Kayıt bulunamadı</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $bankalar->links() }}
        </div>
    </div>
@endsection