<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kasa extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $fillable = [
        'firma_id',
        'kod',
        'ad',
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
        return $this->hasMany(KasaHareket::class);
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
