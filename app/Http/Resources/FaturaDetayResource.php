<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaturaDetayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'aciklama' => $this->aciklama,
            'miktar' => (float) $this->miktar,
            'birim' => $this->birim,
            'birim_fiyat' => (float) $this->birim_fiyat,
            'kdv_oran' => (float) $this->kdv_oran,
            'kdv_tutar' => (float) $this->kdv_tutar,
            'indirim_oran' => (float) $this->indirim_oran,
            'indirim_tutar' => (float) $this->indirim_tutar,
            'toplam' => (float) $this->toplam,
            'sira' => $this->sira,
            
            // İlişkiler
            'stok' => $this->whenLoaded('stok', function() {
                return $this->stok ? [
                    'id' => $this->stok->id,
                    'kod' => $this->stok->kod,
                    'ad' => $this->stok->ad,
                    'birim' => $this->stok->birim,
                ] : null;
            }),
        ];
    }
}
