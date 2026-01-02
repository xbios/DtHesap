<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaturaDetay extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

    protected $table = 'fatura_detaylar';

    protected $fillable = [
        'firma_id',
        'fatura_id',
        'stok_id',
        'aciklama',
        'miktar',
        'birim',
        'birim_fiyat',
        'kdv_oran',
        'kdv_tutar',
        'indirim_oran',
        'indirim_tutar',
        'toplam',
        'sira',
    ];

    protected $casts = [
        'miktar' => 'decimal:3',
        'birim_fiyat' => 'decimal:2',
        'kdv_oran' => 'decimal:2',
        'kdv_tutar' => 'decimal:2',
        'indirim_oran' => 'decimal:2',
        'indirim_tutar' => 'decimal:2',
        'toplam' => 'decimal:2',
    ];

    public function fatura()
    {
        return $this->belongsTo(Fatura::class);
    }

    public function stok()
    {
        return $this->belongsTo(Stok::class);
    }
}
