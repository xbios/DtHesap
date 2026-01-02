<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fatura extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

    protected $fillable = [
        'firma_id',
        'cari_id',
        'fatura_no',
        'fatura_tip',
        'tarih',
        'vade_tarih',
        'toplam_tutar',
        'kdv_tutar',
        'genel_toplam',
        'indirim_tutar',
        'doviz_tip',
        'doviz_kur',
        'odeme_durum',
        'aciklama',
        'created_by',
    ];

    protected $casts = [
        'tarih' => 'date',
        'vade_tarih' => 'date',
        'toplam_tutar' => 'decimal:2',
        'kdv_tutar' => 'decimal:2',
        'genel_toplam' => 'decimal:2',
        'indirim_tutar' => 'decimal:2',
        'doviz_kur' => 'decimal:4',
    ];

    public function cari()
    {
        return $this->belongsTo(Cari::class);
    }

    public function detaylar()
    {
        return $this->hasMany(FaturaDetay::class);
    }

    public function odemeHareketler()
    {
        return $this->hasMany(OdemeHareket::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cariHareketler()
    {
        return $this->morphMany(CariHareket::class, 'evrak');
    }

    public function stokHareketler()
    {
        return $this->morphMany(StokHareket::class, 'evrak');
    }
}
