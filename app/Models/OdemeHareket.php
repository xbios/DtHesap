<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class OdemeHareket extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $table = 'odeme_hareketler';

    protected $fillable = [
        'firma_id',
        'cari_id',
        'evrak_tip',
        'evrak_id',
        'tarih',
        'odeme_tip',
        'tutar',
        'doviz_tip',
        'doviz_kur',
        'aciklama',
    ];

    protected $casts = [
        'tarih' => 'date',
        'tutar' => 'decimal:2',
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

    public function evrak(): MorphTo
    {
        return $this->morphTo('evrak', 'evrak_tip', 'evrak_id');
    }

    // Scopes
    public function scopeByOdemeTip($query, string $tip)
    {
        return $query->where('odeme_tip', $tip);
    }

    public function scopeTahsilat($query)
    {
        return $query->where('odeme_tip', 'tahsilat');
    }

    public function scopeOdeme($query)
    {
        return $query->where('odeme_tip', 'odeme');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tarih', [$startDate, $endDate]);
    }

    // Metodlar
    public function createCariHareket(): void
    {
        $hareket = new CariHareket([
            'firma_id' => $this->firma_id,
            'cari_id' => $this->cari_id,
            'evrak_tip' => static::class,
            'evrak_id' => $this->id,
            'tarih' => $this->tarih,
            'aciklama' => $this->aciklama,
            'doviz_tip' => $this->doviz_tip,
            'doviz_kur' => $this->doviz_kur,
        ]);

        if ($this->odeme_tip === 'tahsilat') {
            $hareket->alacak = $this->tutar;
            $hareket->borc = 0;
        } else {
            $hareket->borc = $this->tutar;
            $hareket->alacak = 0;
        }

        $hareket->save();
        $hareket->updateBakiye();
    }
}
