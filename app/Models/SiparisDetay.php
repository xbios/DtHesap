<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SiparisDetay extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

    protected $table = 'siparis_detaylar';

    protected $fillable = [
        'firma_id',
        'siparis_id',
        'stok_id',
        'aciklama',
        'miktar',
        'teslim_miktar',
        'birim',
        'birim_fiyat',
        'kdv_oran',
        'toplam',
        'sira',
    ];

    protected $casts = [
        'miktar' => 'decimal:3',
        'teslim_miktar' => 'decimal:3',
        'birim_fiyat' => 'decimal:2',
        'kdv_oran' => 'decimal:2',
        'toplam' => 'decimal:2',
    ];

    public function siparis()
    {
        return $this->belongsTo(Siparis::class);
    }

    public function stok()
    {
        return $this->belongsTo(Stok::class);
    }
}
