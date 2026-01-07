@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Stok Kartı Düzenle</h2>
            <a href="{{ route('stoks.index') }}" class="text-gray-600 hover:text-gray-900">Vazgeç</a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('stoks.update', $stok) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kod -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stok Kodu</label>
                        <input type="text" name="kod" value="{{ old('kod', $stok->kod) }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('kod') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Ad -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stok Adı</label>
                        <input type="text" name="ad" value="{{ old('ad', $stok->ad) }}" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('ad') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="kategori_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Seçiniz...</option>
                            @foreach($kategoriler as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $stok->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->ad }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Birim -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Birim</label>
                        <select name="birim"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Adet" {{ old('birim', $stok->birim) == 'Adet' ? 'selected' : '' }}>Adet</option>
                            <option value="KG" {{ old('birim', $stok->birim) == 'KG' ? 'selected' : '' }}>Kilogram</option>
                            <option value="Litre" {{ old('birim', $stok->birim) == 'Litre' ? 'selected' : '' }}>Litre</option>
                            <option value="Metre" {{ old('birim', $stok->birim) == 'Metre' ? 'selected' : '' }}>Metre</option>
                            <option value="Kutu" {{ old('birim', $stok->birim) == 'Kutu' ? 'selected' : '' }}>Kutu</option>
                        </select>
                    </div>

                    <!-- Barkod -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Barkod</label>
                        <input type="text" name="barkod" value="{{ old('barkod', $stok->barkod) }}"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- KDV -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">KDV Oranı (%)</label>
                        <input type="number" name="kdv_oran" value="{{ old('kdv_oran', $stok->kdv_oran) }}" step="0.01"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Fiyatlar -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alış Fiyatı</label>
                        <input type="number" name="alis_fiyat" value="{{ old('alis_fiyat', $stok->alis_fiyat) }}"
                            step="0.01"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Satış Fiyatı</label>
                        <input type="number" name="satis_fiyat" value="{{ old('satis_fiyat', $stok->satis_fiyat) }}"
                            step="0.01"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Stok Limitleri -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Min. Stok</label>
                        <input type="number" name="min_stok" value="{{ old('min_stok', $stok->min_stok) }}" step="0.001"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Max. Stok</label>
                        <input type="number" name="max_stok" value="{{ old('max_stok', $stok->max_stok) }}" step="0.001"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Aciklama -->
                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700">Açıklama</label>
                    <textarea name="aciklama" rows="3"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('aciklama', $stok->aciklama) }}</textarea>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-medium shadow">
                        Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection