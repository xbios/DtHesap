<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CariHareket extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $table = 'cari_hareketler';

    protected $fillable = [
        'firma_id',
        'cari_id',
        'evrak_tip',
        'evrak_id',
        'tarih',
        'aciklama',
        'borc',
        'alacak',
        'bakiye',
        'doviz_tip',
        'doviz_kur',
    ];

    protected $casts = [
        'tarih' => 'date',
        'borc' => 'decimal:2',
        'alacak' => 'decimal:2',
        'bakiye' => 'decimal:2',
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
    public function scopeByEvrakTip($query, string $tip)
    {
        return $query->where('evrak_tip', $tip);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tarih', [$startDate, $endDate]);
    }

    // Metodlar
    public function updateBakiye(): void
    {
        $oncekiHareket = static::where('cari_id', $this->cari_id)
            ->where('id', '<', $this->id)
            ->latest('id')
            ->first();

        $oncekiBakiye = $oncekiHareket ? $oncekiHareket->bakiye : 0;
        $this->bakiye = $oncekiBakiye + $this->borc - $this->alacak;
        $this->save();

        // Sonraki hareketlerin bakiyelerini güncelle
        $sonrakiHareketler = static::where('cari_id', $this->cari_id)
            ->where('id', '>', $this->id)
            ->orderBy('id')
            ->get();

        $guncelBakiye = $this->bakiye;
        foreach ($sonrakiHareketler as $hareket) {
            $guncelBakiye = $guncelBakiye + $hareket->borc - $hareket->alacak;
            $hareket->update(['bakiye' => $guncelBakiye]);
        }
    }
}
