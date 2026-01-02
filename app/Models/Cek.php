<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cek extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

    protected $table = 'ceks';

    protected $fillable = [
        'firma_id',
        'cari_id',
        'banka_id',
        'cek_tip',
        'portfoy_tip',
        'cek_no',
        'tutar',
        'vade_tarih',
        'durum',
        'banka_adi',
        'sube_adi',
        'hesap_no',
        'keside_yeri',
        'keside_tarih',
        'aciklama',
    ];

    protected $casts = [
        'vade_tarih' => 'date',
        'keside_tarih' => 'date',
        'tutar' => 'decimal:2',
    ];

    public function cari()
    {
        return $this->belongsTo(Cari::class);
    }

    public function banka()
    {
        return $this->belongsTo(Banka::class);
    }

    public function hareketler()
    {
        return $this->hasMany(CekHareket::class);
    }
}
