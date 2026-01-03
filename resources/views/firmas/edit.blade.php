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
                {{ __('Firmayı Düzenle') }}: <span class="text-primary-600">{{ $firma->unvan }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-card shadow-xl sm:rounded-2xl border border-white/20">
                <div class="p-8">
                    <form method="POST" action="{{ route('firmas.update', $firma) }}" class="space-y-8">
                        @csrf
                        @method('PATCH')

                        <!-- Temel Bilgiler Section -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-bold text-gray-900 pb-2 border-b border-gray-100 flex items-center">
                                <span
                                    class="w-8 h-8 bg-primary-100 text-primary-600 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </span>
                                Firma Bilgilerini Güncelle
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="kod" :value="__('Firma Kodu')"
                                        class="font-bold text-gray-700" />
                                    <x-text-input id="kod" name="kod" type="text" class="mt-1 block w-full uppercase"
                                        :value="old('kod', $firma->kod)" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('kod')" />
                                </div>

                                <div>
                                    <x-input-label for="unvan" :value="__('Firma Ünvanı')"
                                        class="font-bold text-gray-700" />
                                    <x-text-input id="unvan" name="unvan" type="text" class="mt-1 block w-full"
                                        :value="old('unvan', $firma->unvan)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('unvan')" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="vergi_dairesi" :value="__('Vergi Dairesi')" />
                                    <x-text-input id="vergi_dairesi" name="vergi_dairesi" type="text"
                                        class="mt-1 block w-full" :value="old('vergi_dairesi', $firma->vergi_dairesi)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('vergi_dairesi')" />
                                </div>

                                <div>
                                    <x-input-label for="vergi_no" :value="__('Vergi No')" />
                                    <x-text-input id="vergi_no" name="vergi_no" type="text" class="mt-1 block w-full"
                                        :value="old('vergi_no', $firma->vergi_no)" />
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
                                    </svg>
                                </span>
                                İletişim ve Adres
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="il" :value="__('İl')" />
                                    <x-text-input id="il" name="il" type="text" class="mt-1 block w-full"
                                        :value="old('il', $firma->il)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('il')" />
                                </div>

                                <div>
                                    <x-input-label for="ilce" :value="__('İlçe')" />
                                    <x-text-input id="ilce" name="ilce" type="text" class="mt-1 block w-full"
                                        :value="old('ilce', $firma->ilce)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('ilce')" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="adres" :value="__('Adres')" />
                                <textarea id="adres" name="adres" rows="3"
                                    class="mt-1 block w-full border-2 border-neutral-100 focus:border-primary-500 focus:ring-4 focus:ring-primary-100 rounded-xl transition-all duration-200 outline-none p-4">{{ old('adres', $firma->adres) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('adres')" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="telefon" :value="__('Telefon')" />
                                    <x-text-input id="telefon" name="telefon" type="text" class="mt-1 block w-full"
                                        :value="old('telefon', $firma->telefon)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('telefon')" />
                                </div>

                                <div>
                                    <x-input-label for="email" :value="__('E-posta')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                        :value="old('email', $firma->email)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-8 border-t border-gray-100">
                            <x-primary-button class="px-10 h-12 text-sm shadow-glow">
                                {{ __('Değişiklikleri Kaydet') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>