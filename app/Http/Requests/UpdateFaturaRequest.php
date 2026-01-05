<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaturaRequest extends FormRequest
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
        $faturaId = $this->route('fatura')->id ?? $this->route('fatura');
        
        return [
            'cari_id' => 'sometimes|exists:caris,id',
            'fatura_no' => 'sometimes|string|max:50|unique:faturas,fatura_no,' . $faturaId,
            'fatura_tip' => 'sometimes|in:alis,satis',
            'tarih' => 'sometimes|date',
            'vade_tarih' => 'nullable|date|after_or_equal:tarih',
            'doviz_tip' => 'sometimes|string|max:3',
            'doviz_kur' => 'sometimes|numeric|min:0',
            'odeme_durum' => 'sometimes|in:beklemede,kismi,tamamlandi',
            'aciklama' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'cari_id.exists' => 'Seçilen cari bulunamadı',
            'fatura_no.unique' => 'Bu fatura numarası zaten kullanılıyor',
            'fatura_tip.in' => 'Geçersiz fatura tipi',
            'vade_tarih.after_or_equal' => 'Vade tarihi fatura tarihinden önce olamaz',
            'doviz_kur.min' => 'Döviz kuru negatif olamaz',
        ];
    }
}
