@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Yeni Banka Hesabı Oluştur</h2>
            <a href="{{ route('bankas.index') }}" class="text-gray-600 hover:text-gray-900">Geri Dön</a>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ route('bankas.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kod" class="block text-sm font-medium text-gray-700">Hesap Kodu</label>
                        <input type="text" name="kod" id="kod" value="{{ old('kod') }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('kod') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="banka_adi" class="block text-sm font-medium text-gray-700">Banka Adı</label>
                        <input type="text" name="banka_adi" id="banka_adi" value="{{ old('banka_adi') }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('banka_adi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="sube_adi" class="block text-sm font-medium text-gray-700">Şube Adı</label>
                        <input type="text" name="sube_adi" id="sube_adi" value="{{ old('sube_adi') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('sube_adi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="sube_kodu" class="block text-sm font-medium text-gray-700">Şube Kodu</label>
                        <input type="text" name="sube_kodu" id="sube_kodu" value="{{ old('sube_kodu') }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('sube_kodu') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="hesap_no" class="block text-sm font-medium text-gray-700">Hesap No</label>
                        <input type="text" name="hesap_no" id="hesap_no" value="{{ old('hesap_no') }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('hesap_no') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="iban" class="block text-sm font-medium text-gray-700">IBAN</label>
                        <input type="text" name="iban" id="iban" value="{{ old('iban') }}" placeholder="TR00..."
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('iban') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="doviz_tip" class="block text-sm font-medium text-gray-700">Döviz Tipi</label>
                        <select name="doviz_tip" id="doviz_tip" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="TRY" {{ old('doviz_tip') == 'TRY' ? 'selected' : '' }}>TRY</option>
                            <option value="USD" {{ old('doviz_tip') == 'USD' ? 'selected' : '' }}>USD</option>
                            <option value="EUR" {{ old('doviz_tip') == 'EUR' ? 'selected' : '' }}>EUR</option>
                            <option value="GBP" {{ old('doviz_tip') == 'GBP' ? 'selected' : '' }}>GBP</option>
                        </select>
                        @error('doviz_tip') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="is_active" class="block text-sm font-medium text-gray-700">Durum</label>
                        <select name="is_active" id="is_active"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Pasif</option>
                        </select>
                        @error('is_active') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="aciklama" class="block text-sm font-medium text-gray-700">Açıklama</label>
                    <textarea name="aciklama" id="aciklama" rows="3"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('aciklama') }}</textarea>
                    @error('aciklama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-medium">
                        Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection