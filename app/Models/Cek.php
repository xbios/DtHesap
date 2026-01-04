<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cek extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $fillable = [
        'firma_id',
        'cari_id',
        'cek_no',
        'banka_adi',
        'sube_adi',
        'hesap_no',
        'cek_sahibi',
        'tutar',
        'vade_tarih',
        'durum',
        'cek_tip',
        'asil_borclu',
        'ciro_edilen',
        'aciklama',
    ];

    protected $casts = [
        'vade_tarih' => 'date',
        'tutar' => 'decimal:2',
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

    public function hareketler(): HasMany
    {
        return $this->hasMany(CekHareket::class);
    }

    // Scopes
    public function scopeAlinan($query)
    {
        return $query->where('cek_tip', 'alinan');
    }

    public function scopeVerilen($query)
    {
        return $query->where('cek_tip', 'verilen');
    }

    public function scopePortfoyde($query)
    {
        return $query->where('durum', 'portfoyde');
    }

    public function scopeCiro($query)
    {
        return $query->where('durum', 'ciro');
    }

    public function scopeTahsil($query)
    {
        return $query->where('durum', 'tahsil');
    }

    public function scopeByDurum($query, string $durum)
    {
        return $query->where('durum', $durum);
    }

    // Accessors
    public function getDurumTextAttribute(): string
    {
        return match($this->durum) {
            'portfoyde' => 'Portföyde',
            'ciro' => 'Ciro Edildi',
            'tahsil' => 'Tahsil Edildi',
            'iade' => 'İade Edildi',
            'karsilksiz' => 'Karşılıksız',
            default => 'Bilinmiyor',
        };
    }
}
