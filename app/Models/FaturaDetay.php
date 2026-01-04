<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FaturaDetay extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $table = 'fatura_detaylar';

    protected $fillable = [
        'firma_id',
        'fatura_id',
        'stok_id',
        'aciklama',
        'miktar',
        'birim',
        'birim_fiyat',
        'kdv_oran',
        'kdv_tutar',
        'indirim_oran',
        'indirim_tutar',
        'toplam',
        'sira',
    ];

    protected $casts = [
        'miktar' => 'decimal:3',
        'birim_fiyat' => 'decimal:2',
        'kdv_oran' => 'decimal:2',
        'kdv_tutar' => 'decimal:2',
        'indirim_oran' => 'decimal:2',
        'indirim_tutar' => 'decimal:2',
        'toplam' => 'decimal:2',
        'sira' => 'integer',
    ];

    // İlişkiler
    public function firma(): BelongsTo
    {
        return $this->belongsTo(Firma::class);
    }

    public function fatura(): BelongsTo
    {
        return $this->belongsTo(Fatura::class);
    }

    public function stok(): BelongsTo
    {
        return $this->belongsTo(Stok::class);
    }

    // Metodlar
    public function calculateTotals(): void
    {
        // Ara toplam (miktar * birim fiyat)
        $araToplam = $this->miktar * $this->birim_fiyat;

        // İndirim tutarı hesapla
        if ($this->indirim_oran > 0) {
            $this->indirim_tutar = $araToplam * ($this->indirim_oran / 100);
        }

        // İndirimli tutar
        $indirimliFiyat = $araToplam - $this->indirim_tutar;

        // KDV tutarı hesapla
        $this->kdv_tutar = $indirimliFiyat * ($this->kdv_oran / 100);

        // Genel toplam
        $this->toplam = $indirimliFiyat + $this->kdv_tutar;

        $this->save();
    }

    // Events
    protected static function booted()
    {
        static::saved(function ($detay) {
            $detay->fatura->calculateTotals();
        });

        static::deleted(function ($detay) {
            $detay->fatura->calculateTotals();
        });
    }
}
