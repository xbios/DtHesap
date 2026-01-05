<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCariRequest extends FormRequest
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
            'kod' => 'required|string|max:50|unique:caris,kod',
            'unvan' => 'required|string|max:255',
            'tip' => 'required|in:musteri,tedarikci,her_ikisi',
            'vergi_dairesi' => 'nullable|string|max:100',
            'vergi_no' => 'nullable|string|max:20',
            'tc_kimlik_no' => 'nullable|string|max:11',
            'adres' => 'nullable|string',
            'il' => 'nullable|string|max:50',
            'ilce' => 'nullable|string|max:50',
            'telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'yetkili_kisi' => 'nullable|string|max:100',
            'aciklama' => 'nullable|string',
            'borc_limiti' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'kod.required' => 'Cari kodu zorunludur',
            'kod.unique' => 'Bu cari kodu zaten kullanılıyor',
            'unvan.required' => 'Cari ünvanı zorunludur',
            'tip.required' => 'Cari tipi zorunludur',
            'tip.in' => 'Geçersiz cari tipi',
            'email.email' => 'Geçerli bir e-posta adresi giriniz',
            'borc_limiti.numeric' => 'Borç limiti sayısal olmalıdır',
            'borc_limiti.min' => 'Borç limiti negatif olamaz',
        ];
    }
}
