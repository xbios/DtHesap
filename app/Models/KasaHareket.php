<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class KasaHareket extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $table = 'kasa_hareketler';

    protected $fillable = [
        'firma_id',
        'kasa_id',
        'evrak_tip',
        'evrak_id',
        'tarih',
        'islem_tip',
        'tutar',
        'bakiye',
        'doviz_tip',
        'doviz_kur',
        'aciklama',
    ];

    protected $casts = [
        'tarih' => 'date',
        'tutar' => 'decimal:2',
        'bakiye' => 'decimal:2',
        'doviz_kur' => 'decimal:4',
    ];

    // İlişkiler
    public function firma(): BelongsTo
    {
        return $this->belongsTo(Firma::class);
    }

    public function kasa(): BelongsTo
    {
        return $this->belongsTo(Kasa::class);
    }

    public function evrak(): MorphTo
    {
        return $this->morphTo('evrak', 'evrak_tip', 'evrak_id');
    }

    // Scopes
    public function scopeGiris($query)
    {
        return $query->where('islem_tip', 'giris');
    }

    public function scopeCikis($query)
    {
        return $query->where('islem_tip', 'cikis');
    }

    public function scopeByEvrakTip($query, string $tip)
    {
        return $query->where('evrak_tip', $tip);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tarih', [$startDate, $endDate]);
    }
}
