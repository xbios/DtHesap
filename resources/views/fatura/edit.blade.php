@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6" x-data="faturaForm({{ $fatura->detaylar->map(fn($d) => [
    'stok_id' => $d->stok_id,
    'aciklama' => $d->aciklama,
    'miktar' => (float) $d->miktar,
    'birim' => $d->birim,
    'birim_fiyat' => (float) $d->birim_fiyat,
    'kdv_oran' => (int) $d->kdv_oran,
    'total' => (float) ($d->miktar * $d->birim_fiyat)
])->toJson() }})">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Faturayı Düzenle: {{ $fatura->fatura_no }}</h2>
        <a href="{{ route('faturas.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Geri Dön</a>
    </div>

    <form action="{{ route('faturas.update', $fatura) }}" method="POST" @submit.prevent="submitForm">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sol Kolon: Fatura Bilgileri -->
            <div class="lg:col-span-3 space-y-6">
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Cari Seçimi -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Cari Hesap *</label>
                            <select name="cari_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Cari Seçiniz...</option>
                                @foreach($cariler as $cari)
                                    <option value="{{ $cari->id }}" {{ $fatura->cari_id == $cari->id ? 'selected' : '' }}>
                                        {{ $cari->unvan }} ({{ $cari->kod }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Fatura No -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fatura No *</label>
                            <input type="text" name="fatura_no" required value="{{ old('fatura_no', $fatura->fatura_no) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Tarih -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fatura Tarihi *</label>
                            <input type="date" name="tarih" required value="{{ old('tarih', $fatura->tarih->format('Y-m-d')) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Vade Tarihi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vade Tarihi</label>
                            <input type="date" name="vade_tarih" value="{{ old('vade_tarih', $fatura->vade_tarih ? $fatura->vade_tarih->format('Y-m-d') : '') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Fatura Tipi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fatura Tipi *</label>
                            <select name="fatura_tip" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="satis" {{ old('fatura_tip', $fatura->fatura_tip) == 'satis' ? 'selected' : '' }}>Satış Faturası</option>
                                <option value="alis" {{ old('fatura_tip', $fatura->fatura_tip) == 'alis' ? 'selected' : '' }}>Alış Faturası</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Fatura Kalemleri -->
                <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">Fatura Kalemleri</h3>
                        <button type="button" @click="addItem()" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                            + Satır Ekle
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok / Hizmet</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-24">Miktar</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-24">Birim</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-32">Birim Fiyat</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase w-24">KDV %</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase w-32">Toplam</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase w-16"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr>
                                        <td class="px-4 py-2">
                                            <select :name="`detaylar[${index}][stok_id]`" x-model="item.stok_id" @change="updateItemFromStok(index)"
                                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                <option value="">Seçiniz...</option>
                                                @foreach($stoklar as $stok)
                                                    <option value="{{ $stok->id }}" 
                                                            data-birim="{{ $stok->birim }}" 
                                                            data-fiyat="{{ $stok->satis_fiyat_kdv_haric ?? 0 }}"
                                                            data-ad="{{ $stok->ad }}">
                                                        {{ $stok->ad }} ({{ $stok->kod }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" :name="`detaylar[${index}][aciklama]`" x-model="item.aciklama">
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="number" step="0.01" :name="`detaylar[${index}][miktar]`" x-model.number="item.miktar" @input="calculateRow(index)"
                                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm text-center">
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="text" :name="`detaylar[${index}][birim]`" x-model="item.birim"
                                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm text-center">
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="number" step="0.01" :name="`detaylar[${index}][birim_fiyat]`" x-model.number="item.birim_fiyat" @input="calculateRow(index)"
                                                   class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm text-right">
                                        </td>
                                        <td class="px-4 py-2">
                                            <select :name="`detaylar[${index}][kdv_oran]`" x-model.number="item.kdv_oran" @change="calculateRow(index)"
                                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                            </select>
                                        </td>
                                        <td class="px-4 py-2 text-right text-sm font-medium text-gray-900">
                                            <span x-text="formatCurrency(item.total)"></span>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <button type="button" @click="removeItem(index)" class="text-red-400 hover:text-red-600">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Açıklama -->
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <label class="block text-sm font-medium text-gray-700">Fatura Açıklaması</label>
                    <textarea name="aciklama" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('aciklama', $fatura->aciklama) }}</textarea>
                </div>
            </div>

            <!-- Sağ Kolon: Özet Bilgiler ve Kaydet -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white shadow sm:rounded-lg p-6 space-y-4">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Fatura Özeti</h3>
                    
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Ara Toplam:</span>
                            <span class="font-medium" x-text="formatCurrency(totals.subtotal)"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">KDV Toplam:</span>
                            <span class="font-medium" x-text="formatCurrency(totals.kdv)"></span>
                        </div>
                        <div class="flex justify-between text-lg font-bold border-t pt-2 mt-2">
                            <span>Genel Toplam:</span>
                            <span class="text-indigo-600" x-text="formatCurrency(totals.grand_total)"></span>
                        </div>
                    </div>

                    <div class="pt-4 space-y-3">
                        <div class="flex items-center space-x-2">
                            <label class="text-sm text-gray-600">Döviz Durumu:</label>
                            <select name="doviz_tip" required class="text-xs border-gray-300 rounded-md focus:ring-indigo-500">
                                <option value="TRY" {{ $fatura->doviz_tip == 'TRY' ? 'selected' : '' }}>TRY (₺)</option>
                                <option value="USD" {{ $fatura->doviz_tip == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="EUR" {{ $fatura->doviz_tip == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                            </select>
                        </div>
                        <input type="hidden" name="doviz_kur" value="1">
                        <input type="hidden" name="odeme_durum" value="beklemede">

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-md font-bold text-lg shadow-sm transition">
                            Güncelle
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
function faturaForm(initialItems = null) {
    return {
        items: initialItems || [
            { stok_id: '', aciklama: '', miktar: 1, birim: 'Adet', birim_fiyat: 0, kdv_oran: 20, total: 0 }
        ],
        totals: {
            subtotal: 0,
            kdv: 0,
            grand_total: 0
        },
        init() {
            this.calculateAll();
        },
        addItem() {
            this.items.push({ stok_id: '', aciklama: '', miktar: 1, birim: 'Adet', birim_fiyat: 0, kdv_oran: 20, total: 0 });
        },
        removeItem(index) {
            if (this.items.length > 1) {
                this.items.splice(index, 1);
                this.calculateAll();
            }
        },
        updateItemFromStok(index) {
            const select = event.target;
            const option = select.options[select.selectedIndex];
            if (option.value) {
                this.items[index].birim = option.dataset.birim || 'Adet';
                this.items[index].birim_fiyat = parseFloat(option.dataset.fiyat) || 0;
                this.items[index].aciklama = option.dataset.ad || '';
                this.calculateRow(index);
            }
        },
        calculateRow(index) {
            const item = this.items[index];
            item.total = item.miktar * item.birim_fiyat;
            this.calculateAll();
        },
        calculateAll() {
            let subtotal = 0;
            let kdvTotal = 0;
            
            this.items.forEach(item => {
                const rowTotal = item.miktar * item.birim_fiyat;
                const rowKdv = rowTotal * (item.kdv_oran / 100);
                subtotal += rowTotal;
                kdvTotal += rowKdv;
            });
            
            this.totals.subtotal = subtotal;
            this.totals.kdv = kdvTotal;
            this.totals.grand_total = subtotal + kdvTotal;
        },
        formatCurrency(value) {
            return new Intl.NumberFormat('tr-TR', {
                style: 'currency',
                currency: 'TRY'
            }).format(value);
        },
        submitForm() {
            // Basit bir validasyon
            if (this.items.filter(i => i.stok_id).length === 0) {
                alert('En az bir kalem eklemelisiniz!');
                return;
            }
            event.target.submit();
        }
    }
}
</script>
@endsection
