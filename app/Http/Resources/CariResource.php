<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CariResource extends JsonResource
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
            'kod' => $this->kod,
            'unvan' => $this->unvan,
            'tip' => $this->tip,
            'tip_text' => $this->getTipText(),
            'vergi_dairesi' => $this->vergi_dairesi,
            'vergi_no' => $this->vergi_no,
            'tc_kimlik_no' => $this->tc_kimlik_no,
            'adres' => $this->adres,
            'il' => $this->il,
            'ilce' => $this->ilce,
            'telefon' => $this->telefon,
            'email' => $this->email,
            'yetkili_kisi' => $this->yetkili_kisi,
            'aciklama' => $this->aciklama,
            'borc_limiti' => (float) $this->borc_limiti,
            'bakiye' => (float) $this->bakiye,
            'is_active' => (bool) $this->is_active,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            
            // İlişkiler (sadece yüklenmişse)
            'firma' => $this->whenLoaded('firma', function() {
                return [
                    'id' => $this->firma->id,
                    'unvan' => $this->firma->unvan,
                ];
            }),
            'hareketler' => CariHareketResource::collection($this->whenLoaded('hareketler')),
        ];
    }

    private function getTipText(): string
    {
        return match($this->tip) {
            'musteri' => 'Müşteri',
            'tedarikci' => 'Tedarikçi',
            'her_ikisi' => 'Müşteri & Tedarikçi',
            default => $this->tip,
        };
    }
}
