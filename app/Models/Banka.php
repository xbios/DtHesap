<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banka extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $fillable = [
        'firma_id',
        'kod',
        'banka_adi',
        'sube_adi',
        'sube_kodu',
        'hesap_no',
        'iban',
        'doviz_tip',
        'aciklama',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // İlişkiler
    public function firma(): BelongsTo
    {
        return $this->belongsTo(Firma::class);
    }

    public function hareketler(): HasMany
    {
        return $this->hasMany(BankaHareket::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getBakiyeAttribute(): float
    {
        $sonHareket = $this->hareketler()->latest('id')->first();
        return $sonHareket ? (float) $sonHareket->bakiye : 0;
    }
}
