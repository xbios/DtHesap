<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Firma Yönetimi') }}
            </h2>
            <a href="{{ route('firmas.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gradient-primary border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:scale-105 active:scale-95 transition-all duration-200 shadow-lg shadow-primary-500/30">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Yeni Firma Ekle
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card overflow-hidden shadow-xl sm:rounded-2xl border border-white/20">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Logo</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Firma
                                    Kodu / Ünvan</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Vergi
                                    Bilgileri</th>
                                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500">Lokasyon
                                </th>
                                <th
                                    class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-gray-500 text-right">
                                    İşlemler</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @foreach($firmas as $firma)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-gradient-primary flex items-center justify-center text-white shadow-sm">
                                            @if($firma->logo_path)
                                                <img src="{{ asset('storage/' . $firma->logo_path) }}" alt="{{ $firma->unvan }}"
                                                    class="w-8 h-8 object-contain">
                                            @else
                                                <span class="text-sm font-bold">{{ substr($firma->kod, 0, 2) }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $firma->unvan }}</div>
                                        <div class="text-xs text-gray-500 tracking-wider uppercase mt-0.5">{{ $firma->kod }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-600">{{ $firma->vergi_no }}</div>
                                        <div class="text-xs text-gray-400 font-medium">{{ $firma->vergi_dairesi }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-600">{{ $firma->ilce }} / {{ $firma->il }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <div class="flex justify-end items-center space-x-3">
                                            <a href="{{ route('firmas.edit', $firma) }}"
                                                class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg transition-colors"
                                                title="Düzenle">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('firmas.destroy', $firma) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Bu firmayı silmek istediğinize emin misiniz?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-secondary-600 hover:bg-secondary-50 rounded-lg transition-colors"
                                                    title="Sil">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                            @if(auth()->user()->current_firma_id != $firma->id)
                                                <form action="{{ route('firmas.select.submit', $id = $firma->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1 text-xs font-bold text-primary-700 bg-primary-100 hover:bg-primary-200 rounded-full transition-colors">
                                                        Seç
                                                    </button>
                                                </form>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 text-xs font-bold text-green-700 bg-green-100 rounded-full">
                                                    Aktif
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination can be added here if needed -->
                @if($firmas->hasPages())
                    <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                        {{ $firmas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>