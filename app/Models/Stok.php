<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stok extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

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

    public function kategori()
    {
        return $this->belongsTo(StokKategori::class, 'kategori_id');
    }

    public function hareketler()
    {
        return $this->hasMany(StokHareket::class);
    }

    public function faturaDetaylar()
    {
        return $this->hasMany(FaturaDetay::class);
    }

    public function siparisDetaylar()
    {
        return $this->hasMany(SiparisDetay::class);
    }
}
