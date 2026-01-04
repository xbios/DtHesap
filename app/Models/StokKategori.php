<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\HasFirmaScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StokKategori extends Model
{
    use HasFactory, SoftDeletes, HasFirmaScope;

    protected $table = 'stok_kategoriler';

    protected $fillable = [
        'firma_id',
        'parent_id',
        'ad',
        'kod',
        'sira',
    ];

    protected $casts = [
        'sira' => 'integer',
    ];

    // İlişkiler
    public function firma(): BelongsTo
    {
        return $this->belongsTo(Firma::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(StokKategori::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(StokKategori::class, 'parent_id')->orderBy('sira');
    }

    public function stoks(): HasMany
    {
        return $this->hasMany(Stok::class, 'kategori_id');
    }

    // Scopes
    public function scopeRootCategories($query)
    {
        return $query->whereNull('parent_id')->orderBy('sira');
    }

    // Metodlar
    public function getFullPath(): string
    {
        $path = [$this->ad];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->ad);
            $parent = $parent->parent;
        }

        return implode(' > ', $path);
    }
}
