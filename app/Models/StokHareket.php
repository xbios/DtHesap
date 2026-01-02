<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokHareket extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

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

    public function stok()
    {
        return $this->belongsTo(Stok::class);
    }

    public function evrak()
    {
        return $this->morphTo();
    }
}
