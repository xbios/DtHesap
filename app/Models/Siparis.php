<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siparis extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $fillable = [
        'firma_id',
        'cari_id',
        'siparis_no',
        'siparis_tip',
        'tarih',
        'teslim_tarih',
        'durum',
        'toplam_tutar',
        'kdv_tutar',
        'genel_toplam',
        'doviz_tip',
        'doviz_kur',
        'aciklama',
        'created_by',
    ];

    protected $casts = [
        'tarih' => 'date',
        'teslim_tarih' => 'date',
        'toplam_tutar' => 'decimal:2',
        'kdv_tutar' => 'decimal:2',
        'genel_toplam' => 'decimal:2',
        'doviz_kur' => 'decimal:4',
    ];

    // İlişkiler
    public function firma(): BelongsTo
    {
        return $this->belongsTo(Firma::class);
    }

    public function cari(): BelongsTo
    {
        return $this->belongsTo(Cari::class);
    }

    public function detaylar(): HasMany
    {
        return $this->hasMany(SiparisDetay::class)->orderBy('sira');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeAlis($query)
    {
        return $query->where('siparis_tip', 'alis');
    }

    public function scopeSatis($query)
    {
        return $query->where('siparis_tip', 'satis');
    }

    public function scopeByDurum($query, string $durum)
    {
        return $query->where('durum', $durum);
    }

    public function scopeBeklemede($query)
    {
        return $query->where('durum', 'beklemede');
    }

    public function scopeTamamlandi($query)
    {
        return $query->where('durum', 'tamamlandi');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tarih', [$startDate, $endDate]);
    }

    // Metodlar
    public function calculateTotals(): void
    {
        $detaylar = $this->detaylar;

        $this->toplam_tutar = $detaylar->sum(function ($detay) {
            return $detay->miktar * $detay->birim_fiyat;
        });

        $this->kdv_tutar = $detaylar->sum(function ($detay) {
            $araToplam = $detay->miktar * $detay->birim_fiyat;
            return $araToplam * ($detay->kdv_oran / 100);
        });

        $this->genel_toplam = $this->toplam_tutar + $this->kdv_tutar;

        $this->save();
    }

    public function convertToFatura(): Fatura
    {
        $fatura = new Fatura([
            'firma_id' => $this->firma_id,
            'cari_id' => $this->cari_id,
            'fatura_tip' => $this->siparis_tip,
            'tarih' => now(),
            'doviz_tip' => $this->doviz_tip,
            'doviz_kur' => $this->doviz_kur,
            'aciklama' => "Sipariş No: {$this->siparis_no}",
            'created_by' => auth()->id(),
        ]);

        $fatura->save();

        // Sipariş detaylarını fatura detaylarına dönüştür
        foreach ($this->detaylar as $siparisDetay) {
            $faturaDetay = new FaturaDetay([
                'firma_id' => $this->firma_id,
                'fatura_id' => $fatura->id,
                'stok_id' => $siparisDetay->stok_id,
                'aciklama' => $siparisDetay->aciklama,
                'miktar' => $siparisDetay->miktar,
                'birim' => $siparisDetay->birim,
                'birim_fiyat' => $siparisDetay->birim_fiyat,
                'kdv_oran' => $siparisDetay->kdv_oran,
                'sira' => $siparisDetay->sira,
            ]);

            $faturaDetay->save();
            $faturaDetay->calculateTotals();
        }

        $fatura->calculateTotals();
        // NOT: Observer otomatik olarak cari ve stok hareketlerini oluşturacak

        return $fatura;
    }
}
