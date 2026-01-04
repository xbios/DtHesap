<?php

namespace App\Observers;

use App\Models\Siparis;

class SiparisObserver
{
    /**
     * Handle the Siparis "creating" event.
     */
    public function creating(Siparis $siparis): void
    {
        // Sipariş numarası otomatik oluştur (eğer yoksa)
        if (empty($siparis->siparis_no)) {
            $siparis->siparis_no = $this->generateSiparisNo($siparis);
        }
    }

    /**
     * Handle the Siparis "created" event.
     */
    public function created(Siparis $siparis): void
    {
        // Sipariş oluşturulduğunda yapılacak işlemler
        // Örneğin: bildirim gönderme, log kaydetme vb.
    }

    /**
     * Handle the Siparis "updated" event.
     */
    public function updated(Siparis $siparis): void
    {
        // Durum değişikliklerini kontrol et
        if ($siparis->isDirty('durum')) {
            $eskiDurum = $siparis->getOriginal('durum');
            $yeniDurum = $siparis->durum;
            
            // Durum değişikliği loglanabilir
            \Log::info("Sipariş #{$siparis->siparis_no} durumu değişti: {$eskiDurum} -> {$yeniDurum}");
        }
    }

    /**
     * Handle the Siparis "deleting" event.
     */
    public function deleting(Siparis $siparis): void
    {
        // Sipariş silinmeden önce kontroller
        // Örneğin: faturaya dönüştürülmüş siparişler silinemez
        if ($siparis->durum === 'tamamlandi') {
            throw new \Exception('Tamamlanmış sipariş silinemez!');
        }
    }

    /**
     * Sipariş numarası oluştur
     */
    protected function generateSiparisNo(Siparis $siparis): string
    {
        $prefix = $siparis->siparis_tip === 'alis' ? 'AS' : 'SS';
        $year = now()->year;
        
        // Aynı yıl içindeki son sipariş numarasını bul
        $lastSiparis = Siparis::where('firma_id', $siparis->firma_id)
            ->where('siparis_tip', $siparis->siparis_tip)
            ->whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastSiparis && preg_match('/-(\d+)$/', $lastSiparis->siparis_no, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        }

        return sprintf('%s-%d-%05d', $prefix, $year, $nextNumber);
    }
}
