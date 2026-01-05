@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Yeni Cari Oluştur</h2>
        <a href="{{ route('caris.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Geri Dön</a>
    </div>

    <div class="bg-white shadow sm:rounded-lg overflow-hidden">
        <form action="{{ route('caris.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kod -->
                <div>
                    <label for="kod" class="block text-sm font-medium text-gray-700">Cari Kodu *</label>
                    <input type="text" name="kod" id="kod" value="{{ old('kod') }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('kod') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Tip -->
                <div>
                    <label for="tip" class="block text-sm font-medium text-gray-700">Cari Tipi *</label>
                    <select name="tip" id="tip" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="musteri" {{ old('tip') == 'musteri' ? 'selected' : '' }}>Müşteri</option>
                        <option value="tedarikci" {{ old('tip') == 'tedarikci' ? 'selected' : '' }}>Tedarikçi</option>
                        <option value="her_ikisi" {{ old('tip') == 'her_ikisi' ? 'selected' : '' }}>Her İkisi</option>
                    </select>
                    @error('tip') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Unvan -->
                <div class="md:col-span-2">
                    <label for="unvan" class="block text-sm font-medium text-gray-700">Cari Ünvanı *</label>
                    <input type="text" name="unvan" id="unvan" value="{{ old('unvan') }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('unvan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Vergi Dairesi -->
                <div>
                    <label for="vergi_dairesi" class="block text-sm font-medium text-gray-700">Vergi Dairesi</label>
                    <input type="text" name="vergi_dairesi" id="vergi_dairesi" value="{{ old('vergi_dairesi') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <!-- Vergi No / TC -->
                <div>
                    <label for="vergi_no" class="block text-sm font-medium text-gray-700">Vergi No / T.C. Kimlik</label>
                    <input type="text" name="vergi_no" id="vergi_no" value="{{ old('vergi_no') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <!-- Telefon -->
                <div>
                    <label for="telefon" class="block text-sm font-medium text-gray-700">Telefon</label>
                    <input type="text" name="telefon" id="telefon" value="{{ old('telefon') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <!-- E-posta -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">E-posta</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <!-- Adres -->
                <div class="md:col-span-2">
                    <label for="adres" class="block text-sm font-medium text-gray-700">Adres</label>
                    <textarea name="adres" id="adres" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('adres') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-medium">
                    Kaydet
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
