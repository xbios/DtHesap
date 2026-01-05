<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFaturaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cari_id' => 'required|exists:caris,id',
            'fatura_no' => 'required|string|max:50|unique:faturas,fatura_no',
            'fatura_tip' => 'required|in:alis,satis',
            'tarih' => 'required|date',
            'vade_tarih' => 'nullable|date|after_or_equal:tarih',
            'doviz_tip' => 'required|string|max:3',
            'doviz_kur' => 'required|numeric|min:0',
            'odeme_durum' => 'required|in:beklemede,kismi,tamamlandi',
            'aciklama' => 'nullable|string',
            'detaylar' => 'required|array|min:1',
            'detaylar.*.stok_id' => 'nullable|exists:stoks,id',
            'detaylar.*.aciklama' => 'required|string',
            'detaylar.*.miktar' => 'required|numeric|min:0.01',
            'detaylar.*.birim' => 'required|string|max:20',
            'detaylar.*.birim_fiyat' => 'required|numeric|min:0',
            'detaylar.*.kdv_oran' => 'required|numeric|min:0|max:100',
            'detaylar.*.indirim_oran' => 'nullable|numeric|min:0|max:100',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'cari_id.required' => 'Cari seçimi zorunludur',
            'cari_id.exists' => 'Seçilen cari bulunamadı',
            'fatura_no.required' => 'Fatura numarası zorunludur',
            'fatura_no.unique' => 'Bu fatura numarası zaten kullanılıyor',
            'fatura_tip.required' => 'Fatura tipi zorunludur',
            'fatura_tip.in' => 'Geçersiz fatura tipi',
            'tarih.required' => 'Fatura tarihi zorunludur',
            'vade_tarih.after_or_equal' => 'Vade tarihi fatura tarihinden önce olamaz',
            'doviz_kur.min' => 'Döviz kuru negatif olamaz',
            'detaylar.required' => 'En az bir detay eklemelisiniz',
            'detaylar.min' => 'En az bir detay eklemelisiniz',
            'detaylar.*.miktar.min' => 'Miktar sıfırdan büyük olmalıdır',
            'detaylar.*.birim_fiyat.min' => 'Birim fiyat negatif olamaz',
            'detaylar.*.kdv_oran.max' => 'KDV oranı %100\'den fazla olamaz',
        ];
    }
}
