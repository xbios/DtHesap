<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CariHareketResource extends JsonResource
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
            'tarih' => $this->tarih?->format('Y-m-d'),
            'aciklama' => $this->aciklama,
            'borc' => (float) $this->borc,
            'alacak' => (float) $this->alacak,
            'bakiye' => (float) $this->bakiye,
            'doviz_tip' => $this->doviz_tip,
            'doviz_kur' => (float) $this->doviz_kur,
            'evrak_tip' => $this->evrak_tip,
            'evrak_tip_text' => $this->getEvrakTipText(),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }

    private function getEvrakTipText(): string
    {
        return match($this->evrak_tip) {
            'App\\Models\\Fatura' => 'Fatura',
            'App\\Models\\OdemeHareket' => 'Ödeme',
            default => 'Diğer',
        };
    }
}
