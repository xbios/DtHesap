<?php

namespace App\Observers;

use App\Models\Fatura;
use App\Models\CariHareket;
use App\Models\StokHareket;
use App\Models\ActivityLog;

class FaturaObserver
{
    /**
     * Handle the Fatura "created" event.
     */
    public function created(Fatura $fatura): void
    {
        // Detaylar henüz eklenmemiş olabilir, bu yüzden sadece cari hareket oluştur
        $this->createCariHareket($fatura);

        ActivityLog::log(
            'Fatura',
            'created',
            "Yeni fatura oluşturuldu: {$fatura->fatura_no} (" . ($fatura->fatura_tip == 'satis' ? 'Satış' : 'Alış') . ")",
            ['fatura_id' => $fatura->id, 'toplam' => $fatura->genel_toplam]
        );
    }

    /**
     * Handle the Fatura "updated" event.
     */
    public function updated(Fatura $fatura): void
    {
        // Fatura güncellendiğinde hareketleri yeniden oluştur
        $this->recreateHareketler($fatura);

        ActivityLog::log(
            'Fatura',
            'updated',
            "Fatura güncellendi: {$fatura->fatura_no}",
            ['fatura_id' => $fatura->id, 'changes' => $fatura->getChanges()]
        );
    }

    /**
     * Handle the Fatura "deleting" event.
     */
    public function deleting(Fatura $fatura): void
    {
        // Fatura silinmeden önce ilgili hareketleri sil
        $fatura->cariHareket()?->delete();
        $fatura->stokHareketler()->delete();

        ActivityLog::log(
            'Fatura',
            'deleted',
            "Fatura silindi: {$fatura->fatura_no}",
            ['fatura_id' => $fatura->id, 'no' => $fatura->fatura_no]
        );
    }

    /**
     * Cari hareket oluştur
     */
    protected function createCariHareket(Fatura $fatura): void
    {
        // Toplam sıfırsa hareket oluşturma
        if ($fatura->genel_toplam <= 0) {
            return;
        }

        // Mevcut cari hareketi varsa sil
        $fatura->cariHareket()?->delete();

        $hareket = new CariHareket([
            'firma_id' => $fatura->firma_id,
            'cari_id' => $fatura->cari_id,
            'evrak_tip' => Fatura::class,
            'evrak_id' => $fatura->id,
            'tarih' => $fatura->tarih,
            'aciklama' => "Fatura No: {$fatura->fatura_no}",
            'doviz_tip' => $fatura->doviz_tip,
            'doviz_kur' => $fatura->doviz_kur,
        ]);

        if ($fatura->fatura_tip === 'alis') {
            // Alış faturası: Tedarikçiye borçlanıyoruz (alacak)
            $hareket->alacak = $fatura->genel_toplam;
            $hareket->borc = 0.00;
        } else {
            // Satış faturası: Müşteriden alacaklıyız (borç)
            $hareket->borc = $fatura->genel_toplam;
            $hareket->alacak = 0.00;
        }

        $hareket->save();
        $hareket->updateBakiye();
    }

    /**
     * Stok hareketleri oluştur
     */
    protected function createStokHareketler(Fatura $fatura): void
    {
        // Mevcut stok hareketlerini sil
        $fatura->stokHareketler()->delete();

        foreach ($fatura->detaylar as $detay) {
            if (!$detay->stok_id) {
                continue;
            }

            $hareket = new StokHareket([
                'firma_id' => $fatura->firma_id,
                'stok_id' => $detay->stok_id,
                'evrak_tip' => Fatura::class,
                'evrak_id' => $fatura->id,
                'tarih' => $fatura->tarih,
                'birim_fiyat' => $detay->birim_fiyat,
                'aciklama' => "Fatura No: {$fatura->fatura_no}",
            ]);

            if ($fatura->fatura_tip === 'alis') {
                // Alış faturası: Stok girişi
                $hareket->giris = $detay->miktar;
                $hareket->cikis = 0.00;
            } else {
                // Satış faturası: Stok çıkışı
                $hareket->giris = 0.00;
                $hareket->cikis = $detay->miktar;
            }

            $hareket->save();
            $hareket->updateBakiye();
        }
    }

    /**
     * Hareketleri yeniden oluştur
     */
    protected function recreateHareketler(Fatura $fatura): void
    {
        $this->createCariHareket($fatura);
        $this->createStokHareketler($fatura);
    }
}
