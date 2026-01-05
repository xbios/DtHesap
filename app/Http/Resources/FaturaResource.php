<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaturaResource extends JsonResource
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
            'fatura_no' => $this->fatura_no,
            'fatura_tip' => $this->fatura_tip,
            'fatura_tip_text' => $this->fatura_tip === 'alis' ? 'Alış' : 'Satış',
            'tarih' => $this->tarih?->format('Y-m-d'),
            'vade_tarih' => $this->vade_tarih?->format('Y-m-d'),
            'toplam_tutar' => (float) $this->toplam_tutar,
            'kdv_tutar' => (float) $this->kdv_tutar,
            'genel_toplam' => (float) $this->genel_toplam,
            'indirim_tutar' => (float) $this->indirim_tutar,
            'doviz_tip' => $this->doviz_tip,
            'doviz_kur' => (float) $this->doviz_kur,
            'odeme_durum' => $this->odeme_durum,
            'odeme_durum_text' => $this->getOdemeDurumText(),
            'aciklama' => $this->aciklama,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            
            // İlişkiler
            'cari' => $this->whenLoaded('cari', function() {
                return [
                    'id' => $this->cari->id,
                    'kod' => $this->cari->kod,
                    'unvan' => $this->cari->unvan,
                ];
            }),
            'detaylar' => FaturaDetayResource::collection($this->whenLoaded('detaylar')),
            'creator' => $this->whenLoaded('creator', function() {
                return [
                    'id' => $this->creator->id,
                    'name' => $this->creator->name,
                ];
            }),
        ];
    }

    private function getOdemeDurumText(): string
    {
        return match($this->odeme_durum) {
            'beklemede' => 'Beklemede',
            'kismi' => 'Kısmi Ödendi',
            'tamamlandi' => 'Tamamlandı',
            default => $this->odeme_durum,
        };
    }
}
