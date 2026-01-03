<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('firmas.index') }}" class="p-2 text-gray-400 hover:text-primary-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Yeni Firma Ekle') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card shadow-xl sm:rounded-2xl border border-white/20">
                <div class="p-8">
                    <form method="POST" action="{{ route('firmas.store') }}" class="space-y-8">
                        @csrf

                        <!-- Temel Bilgiler Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold text-gray-900 pb-2 border-b border-gray-100 flex items-center">
                                <span
                                    class="w-8 h-8 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </span>
                                Temel Firma Bilgileri
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="kod" :value="__('Firma Kodu')"
                                        class="font-bold text-gray-700" />
                                    <x-text-input id="kod" name="kod" type="text" class="mt-1 block w-full uppercase"
                                        :value="old('kod')" required autofocus placeholder="Örn: DEMO2026" />
                                    <x-input-error class="mt-2" :messages="$errors->get('kod')" />
                                    <p class="mt-1 text-xs text-gray-400 font-medium">Sistemde firmayı tanımlayacak kısa
                                        ve benzersiz kod.</p>
                                </div>

                                <div>
                                    <x-input-label for="unvan" :value="__('Firma Ünvanı')"
                                        class="font-bold text-gray-700" />
                                    <x-text-input id="unvan" name="unvan" type="text" class="mt-1 block w-full"
                                        :value="old('unvan')" required placeholder="Örn: Antigravity Teknoloji A.Ş." />
                                    <x-input-error class="mt-2" :messages="$errors->get('unvan')" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="vergi_dairesi" :value="__('Vergi Dairesi')" />
                                    <x-text-input id="vergi_dairesi" name="vergi_dairesi" type="text"
                                        class="mt-1 block w-full" :value="old('vergi_dairesi')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('vergi_dairesi')" />
                                </div>

                                <div>
                                    <x-input-label for="vergi_no" :value="__('Vergi No')" />
                                    <x-text-input id="vergi_no" name="vergi_no" type="text" class="mt-1 block w-full"
                                        :value="old('vergi_no')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('vergi_no')" />
                                </div>
                            </div>
                        </div>

                        <!-- Lokasyon ve İletişim Section -->
                        <div class="space-y-6 pt-4">
                            <h3 class="text-lg font-bold text-gray-900 pb-2 border-b border-gray-100 flex items-center">
                                <span
                                    class="w-8 h-8 bg-secondary-100 text-secondary-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </span>
                                İletişim Bilgileri
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="il" :value="__('İl')" />
                                    <x-text-input id="il" name="il" type="text" class="mt-1 block w-full"
                                        :value="old('il')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('il')" />
                                </div>

                                <div>
                                    <x-input-label for="ilce" :value="__('İlçe')" />
                                    <x-text-input id="ilce" name="ilce" type="text" class="mt-1 block w-full"
                                        :value="old('ilce')" />
                                    <x-input-error class="mt-2" :messages="$errors->get('ilce')" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="adres" :value="__('Tebligat Adresi')" />
                                <textarea id="adres" name="adres" rows="3"
                                    class="mt-1 block w-full border-2 border-neutral-100 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 rounded-xl transition-all duration-200 outline-none p-4">{{ old('adres') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('adres')" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="telefon" :value="__('Telefon')" />
                                    <x-text-input id="telefon" name="telefon" type="text" class="mt-1 block w-full"
                                        :value="old('telefon')" placeholder="+90" />
                                    <x-input-error class="mt-2" :messages="$errors->get('telefon')" />
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('E-posta')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                        :value="old('email')" placeholder="info@firma.com" />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-8 border-t border-gray-100">
                            <x-primary-button class="px-10 h-12 text-sm">
                                {{ __('Kaydet ve Tamamla') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>