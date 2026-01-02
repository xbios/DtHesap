<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Firma Seçimi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($firmas as $firma)
                    <div
                        class="glass-card overflow-hidden shadow-xl sm:rounded-2xl transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                        <div class="p-8">
                            <div class="flex items-center space-x-4 mb-6">
                                <div
                                    class="w-16 h-16 rounded-2xl bg-gradient-primary flex items-center justify-center text-white shadow-lg">
                                    @if($firma->logo_path)
                                        <img src="{{ asset('storage/' . $firma->logo_path) }}" alt="{{ $firma->unvan }}"
                                            class="w-12 h-12 object-contain">
                                    @else
                                        <span class="text-2xl font-bold">{{ substr($firma->kod, 0, 2) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $firma->unvan }}</h3>
                                    <p class="text-sm text-gray-500 font-medium tracking-wider uppercase">{{ $firma->kod }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-3 mb-8">
                                <div class="flex items-center text-gray-600 text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $firma->il ?? 'Adres Belirtilmemiş' }} / {{ $firma->ilce }}
                                </div>
                                <div class="flex items-center text-gray-600 text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $firma->telefon ?? 'Telefon Belirtilmemiş' }}
                                </div>
                            </div>

                            <form action="{{ route('firmas.select.submit', $firma->id) }}" method="POST">
                                @csrf
                                <x-primary-button class="w-full justify-center group">
                                    <span>Giriş Yap</span>
                                    <svg class="w-4 h-4 ml-2 transition-transform group-hover:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </x-primary-button>
                            </form>
                        </div>
                    </div>
                @endforeach

                <!-- Add New Firma Card (Optional) -->
                <a href="#" class="group">
                    <div
                        class="glass-card border-2 border-dashed border-gray-300 hover:border-primary-500 hover:bg-white/40 h-full flex flex-center transition-all duration-300">
                        <div class="p-8 text-center w-full flex flex-col items-center justify-center">
                            <div
                                class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-primary-100 group-hover:text-primary-600 transition-colors mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-500 group-hover:text-primary-600 transition-colors">
                                Yeni Firma Oluştur</h3>
                            <p class="text-sm text-gray-400 mt-2">Sisteme yeni bir şirket tanımlayın</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <style>
        .flex-center {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</x-app-layout>