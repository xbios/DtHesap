<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiparisDetay extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $table = 'siparis_detaylar';

    protected $fillable = [
        'firma_id',
        'siparis_id',
        'stok_id',
        'aciklama',
        'miktar',
        'teslim_miktar',
        'birim',
        'birim_fiyat',
        'kdv_oran',
        'toplam',
        'sira',
    ];

    protected $casts = [
        'miktar' => 'decimal:3',
        'teslim_miktar' => 'decimal:3',
        'birim_fiyat' => 'decimal:2',
        'kdv_oran' => 'decimal:2',
        'toplam' => 'decimal:2',
        'sira' => 'integer',
    ];

    // İlişkiler
    public function firma(): BelongsTo
    {
        return $this->belongsTo(Firma::class);
    }

    public function siparis(): BelongsTo
    {
        return $this->belongsTo(Siparis::class);
    }

    public function stok(): BelongsTo
    {
        return $this->belongsTo(Stok::class);
    }

    // Accessors
    public function getKalanMiktarAttribute(): float
    {
        return (float) ($this->miktar - $this->teslim_miktar);
    }

    // Metodlar
    public function calculateTotals(): void
    {
        $araToplam = $this->miktar * $this->birim_fiyat;
        $kdvTutar = $araToplam * ($this->kdv_oran / 100);
        $this->toplam = $araToplam + $kdvTutar;

        $this->save();
    }

    // Events
    protected static function booted()
    {
        static::saved(function ($detay) {
            $detay->siparis->calculateTotals();
        });

        static::deleted(function ($detay) {
            $detay->siparis->calculateTotals();
        });
    }
}
