<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cari extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $fillable = [
        'firma_id',
        'kod',
        'unvan',
        'tip',
        'vergi_dairesi',
        'vergi_no',
        'tc_kimlik_no',
        'adres',
        'il',
        'ilce',
        'telefon',
        'email',
        'yetkili_kisi',
        'aciklama',
        'borc_limiti',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'borc_limiti' => 'decimal:2',
    ];

    // İlişkiler
    public function firma(): BelongsTo
    {
        return $this->belongsTo(Firma::class);
    }

    public function hareketler(): HasMany
    {
        return $this->hasMany(CariHareket::class);
    }

    public function faturas(): HasMany
    {
        return $this->hasMany(Fatura::class);
    }

    public function siparisler(): HasMany
    {
        return $this->hasMany(Siparis::class);
    }

    public function cekler(): HasMany
    {
        return $this->hasMany(Cek::class);
    }

    public function odemeHareketler(): HasMany
    {
        return $this->hasMany(OdemeHareket::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMusteri($query)
    {
        return $query->whereIn('tip', ['musteri', 'her_ikisi']);
    }

    public function scopeTedarikci($query)
    {
        return $query->whereIn('tip', ['tedarikci', 'her_ikisi']);
    }

    public function scopeByTip($query, string $tip)
    {
        return $query->where('tip', $tip);
    }

    // Accessors
    public function getBakiyeAttribute(): float
    {
        $sonHareket = $this->hareketler()->latest('id')->first();
        return $sonHareket ? (float) $sonHareket->bakiye : 0;
    }

    // Mutators
    public function setKodAttribute($value)
    {
        $this->attributes['kod'] = strtoupper($value);
    }
}
