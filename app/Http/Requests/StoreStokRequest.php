<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStokRequest extends FormRequest
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
            'kod' => 'required|string|max:50',
            'ad' => 'required|string|max:255',
            'kategori_id' => 'nullable|exists:stok_kategoriler,id',
            'birim' => 'required|string|max:20',
            'barkod' => 'nullable|string|max:50',
            'kdv_oran' => 'nullable|numeric|min:0|max:100',
            'alis_fiyat' => 'nullable|numeric|min:0',
            'satis_fiyat' => 'nullable|numeric|min:0',
            'min_stok' => 'nullable|numeric|min:0',
            'max_stok' => 'nullable|numeric|min:0',
            'aciklama' => 'nullable|string',
            'is_active' => 'boolean',
        ];
    }
}
