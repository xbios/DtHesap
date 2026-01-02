<?php

namespace App\Models;

use App\Traits\BelongsToFirma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cari extends Model
{
    use HasFactory, SoftDeletes, BelongsToFirma;

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

    public function hareketler()
    {
        return $this->hasMany(CariHareket::class);
    }

    public function faturas()
    {
        return $this->hasMany(Fatura::class);
    }

    public function siparisler()
    {
        return $this->hasMany(Siparis::class);
    }
}
