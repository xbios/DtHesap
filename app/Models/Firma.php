<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Firma extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kod',
        'unvan',
        'vergi_dairesi',
        'vergi_no',
        'adres',
        'il',
        'ilce',
        'telefon',
        'email',
        'website',
        'logo_path',
        'is_active',
        'ayarlar',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'ayarlar' => 'array',
    ];

    // İlişkiler
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'firma_user')
            ->withPivot('rol', 'yetki_seviyesi')
            ->withTimestamps();
    }

    public function caris(): HasMany
    {
        return $this->hasMany(Cari::class);
    }

    public function stoks(): HasMany
    {
        return $this->hasMany(Stok::class);
    }

    public function stokKategoriler(): HasMany
    {
        return $this->hasMany(StokKategori::class);
    }

    public function faturas(): HasMany
    {
        return $this->hasMany(Fatura::class);
    }

    public function kasas(): HasMany
    {
        return $this->hasMany(Kasa::class);
    }

    public function bankalar(): HasMany
    {
        return $this->hasMany(Banka::class);
    }

    public function cekler(): HasMany
    {
        return $this->hasMany(Cek::class);
    }

    public function siparisler(): HasMany
    {
        return $this->hasMany(Siparis::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo_path ? asset('storage/' . $this->logo_path) : null;
    }
}
