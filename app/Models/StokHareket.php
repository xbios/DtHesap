<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StokHareket extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $table = 'stok_hareketler';

    protected $fillable = [
        'firma_id',
        'stok_id',
        'evrak_tip',
        'evrak_id',
        'tarih',
        'giris',
        'cikis',
        'bakiye',
        'birim_fiyat',
        'aciklama',
    ];

    protected $casts = [
        'tarih' => 'date',
        'giris' => 'decimal:3',
        'cikis' => 'decimal:3',
        'bakiye' => 'decimal:3',
        'birim_fiyat' => 'decimal:2',
    ];

    // İlişkiler
    public function firma(): BelongsTo
    {
        return $this->belongsTo(Firma::class);
    }

    public function stok(): BelongsTo
    {
        return $this->belongsTo(Stok::class);
    }

    public function evrak(): MorphTo
    {
        return $this->morphTo('evrak', 'evrak_tip', 'evrak_id');
    }

    // Scopes
    public function scopeGiris($query)
    {
        return $query->where('giris', '>', 0);
    }

    public function scopeCikis($query)
    {
        return $query->where('cikis', '>', 0);
    }

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
        $oncekiHareket = static::where('stok_id', $this->stok_id)
            ->where('id', '<', $this->id)
            ->latest('id')
            ->first();

        $oncekiBakiye = $oncekiHareket ? $oncekiHareket->bakiye : 0;
        $this->bakiye = $oncekiBakiye + $this->giris - $this->cikis;
        $this->save();

        // Sonraki hareketlerin bakiyelerini güncelle
        $sonrakiHareketler = static::where('stok_id', $this->stok_id)
            ->where('id', '>', $this->id)
            ->orderBy('id')
            ->get();

        $guncelBakiye = $this->bakiye;
        foreach ($sonrakiHareketler as $hareket) {
            $guncelBakiye = $guncelBakiye + $hareket->giris - $hareket->cikis;
            $hareket->update(['bakiye' => $guncelBakiye]);
        }
    }
}
