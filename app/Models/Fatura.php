<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Fatura extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $fillable = [
        'firma_id',
        'cari_id',
        'fatura_no',
        'fatura_tip',
        'tarih',
        'vade_tarih',
        'toplam_tutar',
        'kdv_tutar',
        'genel_toplam',
        'indirim_tutar',
        'doviz_tip',
        'doviz_kur',
        'odeme_durum',
        'aciklama',
        'created_by',
    ];

    protected $casts = [
        'tarih' => 'date',
        'vade_tarih' => 'date',
        'toplam_tutar' => 'decimal:2',
        'kdv_tutar' => 'decimal:2',
        'genel_toplam' => 'decimal:2',
        'indirim_tutar' => 'decimal:2',
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
        return $this->hasMany(FaturaDetay::class)->orderBy('sira');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cariHareket(): MorphOne
    {
        return $this->morphOne(CariHareket::class, 'evrak', 'evrak_tip', 'evrak_id');
    }

    public function stokHareketler(): MorphMany
    {
        return $this->morphMany(StokHareket::class, 'evrak', 'evrak_tip', 'evrak_id');
    }

    // Scopes
    public function scopeAlis($query)
    {
        return $query->where('fatura_tip', 'alis');
    }

    public function scopeSatis($query)
    {
        return $query->where('fatura_tip', 'satis');
    }

    public function scopeBeklemede($query)
    {
        return $query->where('odeme_durum', 'beklemede');
    }

    public function scopeTamamlandi($query)
    {
        return $query->where('odeme_durum', 'tamamlandi');
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
            return $detay->miktar * $detay->birim_fiyat - $detay->indirim_tutar;
        });

        $this->kdv_tutar = $detaylar->sum('kdv_tutar');
        $this->indirim_tutar = $detaylar->sum('indirim_tutar');
        $this->genel_toplam = $this->toplam_tutar + $this->kdv_tutar;

        $this->save();
    }

    // NOT: createCariHareket() ve createStokHareketler() metodları
    // FaturaObserver'a taşındı. Observer otomatik olarak bu işlemleri yapıyor.
}
