@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">Firmayı Düzenle</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $firma->unvan }}</p>
            </div>
        </div>

        <form action="{{ route('firmas.update', $firma->id) }}" method="POST"
            class="bg-white shadow sm:rounded-lg overflow-hidden">
            @csrf
            @method('PUT')
            <div class="px-4 py-5 sm:p-6 space-y-6">
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-2">
                        <label for="kod" class="block text-sm font-medium text-gray-700">Firma Kodu</label>
                        <div class="mt-1">
                            <input type="text" name="kod" id="kod" value="{{ old('kod', $firma->kod) }}" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('kod') border-red-500 @enderror">
                            @error('kod') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="unvan" class="block text-sm font-medium text-gray-700">Firma Ünvanı</label>
                        <div class="mt-1">
                            <input type="text" name="unvan" id="unvan" value="{{ old('unvan', $firma->unvan) }}" required
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md @error('unvan') border-red-500 @enderror">
                            @error('unvan') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="vergi_dairesi" class="block text-sm font-medium text-gray-700">Vergi Dairesi</label>
                        <div class="mt-1">
                            <input type="text" name="vergi_dairesi" id="vergi_dairesi"
                                value="{{ old('vergi_dairesi', $firma->vergi_dairesi) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="vergi_no" class="block text-sm font-medium text-gray-700">Vergi No</label>
                        <div class="mt-1">
                            <input type="text" name="vergi_no" id="vergi_no" value="{{ old('vergi_no', $firma->vergi_no) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="email" class="block text-sm font-medium text-gray-700">E-posta</label>
                        <div class="mt-1">
                            <input type="email" name="email" id="email" value="{{ old('email', $firma->email) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="telefon" class="block text-sm font-medium text-gray-700">Telefon</label>
                        <div class="mt-1">
                            <input type="text" name="telefon" id="telefon" value="{{ old('telefon', $firma->telefon) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="adres" class="block text-sm font-medium text-gray-700">Adres</label>
                        <div class="mt-1">
                            <textarea name="adres" id="adres" rows="3"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border border-gray-300 rounded-md">{{ old('adres', $firma->adres) }}</textarea>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="il" class="block text-sm font-medium text-gray-700">İl</label>
                        <div class="mt-1">
                            <input type="text" name="il" id="il" value="{{ old('il', $firma->il) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="ilce" class="block text-sm font-medium text-gray-700">İlçe</label>
                        <div class="mt-1">
                            <input type="text" name="ilce" id="ilce" value="{{ old('ilce', $firma->ilce) }}"
                                class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input type="hidden" name="is_active" value="0">
                                <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $firma->is_active) ? 'checked' : '' }}
                                    class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="is_active" class="font-medium text-gray-700">Firma Aktif</label>
                                <p class="text-gray-500">Bu kapalıyken firma işlemlere kapalı olur.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a href="{{ route('firmas.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 mr-2">
                    İptal
                </a>
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Güncelle
                </button>
            </div>
        </form>
    </div>
@endsection