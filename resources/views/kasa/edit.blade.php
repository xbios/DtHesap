@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Kasa Düzenle: {{ $kasa->ad }}</h2>
            <a href="{{ route('kasas.index') }}" class="text-gray-600 hover:text-gray-900">Geri Dön</a>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('kasas.update', $kasa) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kod" class="block text-sm font-medium text-gray-700">Kasa Kodu</label>
                        <input type="text" name="kod" id="kod" value="{{ old('kod', $kasa->kod) }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('kod') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="ad" class="block text-sm font-medium text-gray-700">Kasa Adı</label>
                        <input type="text" name="ad" id="ad" value="{{ old('ad', $kasa->ad) }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('ad') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="doviz_tip" class="block text-sm font-medium text-gray-700">Döviz Tipi</label>
                        <select name="doviz_tip" id="doviz_tip" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="TRY" {{ old('doviz_tip', $kasa->doviz_tip) == 'TRY' ? 'selected' : '' }}>TRY
                            </option>
                            <option value="USD" {{ old('doviz_tip', $kasa->doviz_tip) == 'USD' ? 'selected' : '' }}>USD
                            </option>
                            <option value="EUR" {{ old('doviz_tip', $kasa->doviz_tip) == 'EUR' ? 'selected' : '' }}>EUR
                            </option>
                            <option value="GBP" {{ old('doviz_tip', $kasa->doviz_tip) == 'GBP' ? 'selected' : '' }}>GBP
                            </option>
                        </select>
                        @error('doviz_tip') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700">Durum</label>
                        <select name="is_active" id="is_active"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1" {{ old('is_active', $kasa->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active', $kasa->is_active) == '0' ? 'selected' : '' }}>Pasif</option>
                        </select>
                        @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="aciklama" class="block text-sm font-medium text-gray-700">Açıklama</label>
                    <textarea name="aciklama" id="aciklama" rows="3"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('aciklama', $kasa->aciklama) }}</textarea>
                    @error('aciklama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-medium">
                        Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection