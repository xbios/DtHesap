<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stok extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $fillable = [
        'firma_id',
        'kod',
        'ad',
        'kategori_id',
        'birim',
        'barkod',
        'kdv_oran',
        'alis_fiyat',
        'satis_fiyat',
        'min_stok',
        'max_stok',
        'aciklama',
        'resim_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'kdv_oran' => 'decimal:2',
        'alis_fiyat' => 'decimal:2',
        'satis_fiyat' => 'decimal:2',
        'min_stok' => 'decimal:3',
        'max_stok' => 'decimal:3',
    ];

    // İlişkiler
    public function firma(): BelongsTo
    {
        return $this->belongsTo(Firma::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(StokKategori::class, 'kategori_id');
    }

    public function hareketler(): HasMany
    {
        return $this->hasMany(StokHareket::class);
    }

    public function faturaDetaylar(): HasMany
    {
        return $this->hasMany(FaturaDetay::class);
    }

    public function siparisDetaylar(): HasMany
    {
        return $this->hasMany(SiparisDetay::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('(SELECT COALESCE(SUM(giris - cikis), 0) FROM stok_hareketler WHERE stok_id = stoks.id) < min_stok');
    }

    // Accessors
    public function getGuncelStokAttribute(): float
    {
        $sonHareket = $this->hareketler()->latest('id')->first();
        return $sonHareket ? (float) $sonHareket->bakiye : 0;
    }

    public function getResimUrlAttribute(): ?string
    {
        return $this->resim_path ? asset('storage/' . $this->resim_path) : null;
    }

    // Mutators
    public function setKodAttribute($value)
    {
        $this->attributes['kod'] = strtoupper($value);
    }
}
